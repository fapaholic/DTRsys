<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function storeAttendance(Request $request)
    {
        $qrCode = $request->input('qrCode'); // Assume QR code contains the employee's ID

        // Find the employee using the ID from the QR code
        $employee = Employee::find($qrCode);

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Invalid QR code.']);
        }

        // Create an attendance record
        Attendance::create([
            'employee_id' => $employee->id,
            'time_in' => now(),
            'time_out' => null,
            'date' => now()->toDateString(),
            'status' => 'Present',
            'type' => $employee->position, // Example: Barista
        ]);

        return response()->json(['success' => true, 'name' => $employee->name]);
    }
}
