<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Show all attendance logs
    public function showLogs()
    {
        $logs = DB::table('attendance')
            ->leftJoin('employees', 'attendance.employee_id', '=', 'employees.id')
            ->select(
                'attendance.*',
                'employees.name',
                'employees.position',
                'employees.type',
                'employees.salary'
            )
            ->orderBy('attendance.date', 'desc')
            ->get();

        return view('attendance-logs', compact('logs'));
    }

    // Store attendance (Time In / Time Out)
    public function store(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'qr' => 'required|string',
                'mode' => 'required|in:in,out',
            ]);

            Log::info('Attendance scan received', [
                'qr' => $request->qr,
                'mode' => $request->mode,
            ]);

            // Extract ID from QR code
            preg_match('/id\s*[:=]\s*(\d+)/i', $request->qr, $matches);
            $employeeId = $matches[1] ?? null;

            if (!$employeeId) {
                Log::warning('Invalid QR code: missing ID', ['qr' => $request->qr]);
                return response()->json([
                    'success' => false,
                    'message' => '❌ QR code does not contain a valid employee ID.',
                ], 400);
            }

            $employee = Employee::find($employeeId);

            if (!$employee) {
                Log::warning('Employee not found', ['employee_id' => $employeeId]);
                return response()->json([
                    'success' => false,
                    'message' => "❌ No employee found with ID: {$employeeId}",
                ], 404);
            }

            $today = Carbon::today()->toDateString();

            // Find today's attendance
            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            $now = Carbon::now();

            // Handle Time In
            if ($request->mode === 'in') {
                if ($attendance) {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ You have already timed in today.',
                    ]);
                }

                $cutoff = Carbon::today()->setTime(8, 15);
                $status = $now->gt($cutoff) ? 'Late' : 'On Time';

                Attendance::create([
                    'employee_id' => $employee->id,
                    'time_in' => $now,
                    'date' => $today,
                    'status' => $status,
                    'type' => $employee->type ?? 'regular',
                ]);

                Log::info('Time In recorded', [
                    'employee_id' => $employee->id,
                    'status' => $status,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "✅ Time In recorded successfully. Status: {$status}.",
                ]);
            }

            // Handle Time Out
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ You have not timed in today.',
                ]);
            }

            if ($attendance->time_out) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ You have already timed out today.',
                ]);
            }

            $attendance->update([
                'time_out' => $now,
            ]);

            Log::info('Time Out recorded', [
                'employee_id' => $employee->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Time Out recorded successfully.',
            ]);

        } catch (\Throwable $e) {
            Log::error('Attendance Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Server error occurred. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
