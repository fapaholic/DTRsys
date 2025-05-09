<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'qr' => 'required',
            'mode' => 'required|in:in,out',
        ]);

        // Assume QR value is employee email or ID
        $employee = Employee::where('email', $request->qr)->orWhere('id', $request->qr)->first();

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        $today = Carbon::today()->toDateString();

        // Check existing attendance for today
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if ($request->mode === 'in') {
            if ($attendance) {
                return response()->json(['success' => false, 'message' => 'Already timed in today.']);
            }

            Attendance::create([
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'time_in' => Carbon::now(),
                'date' => $today,
                'status' => 'present',
                'type' => 'regular', // Or pull from employee if dynamic
            ]);

            return response()->json(['success' => true, 'message' => 'Time In recorded successfully.']);
        }

        // Handle Time Out
        if ($attendance && !$attendance->time_out) {
            $attendance->update([
                'time_out' => Carbon::now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Time Out recorded successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'No Time In found or already timed out.']);
    }
}