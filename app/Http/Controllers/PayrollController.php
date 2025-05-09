<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('attendances')->get();
        $payrollData = [];

        foreach ($employees as $employee) {
            $totalWorkHours = 0;
            $totalOvertimeHours = 0;
            $totalDeductions = 0;
            $basicSalary = $employee->salary;
            $hourlyRate = $basicSalary; // Assuming 160 work hours/month

            foreach ($employee->attendances as $attendance) {
                if ($attendance->time_in && $attendance->time_out) {
                    $in = Carbon::parse($attendance->time_in);
                    $out = Carbon::parse($attendance->time_out);
                    $workedHours = $in->diffInMinutes($out) / 60;

                    $regularHours = min(8, $workedHours);
                    $overtimeHours = max(0, $workedHours - 8);
                    $totalWorkHours += $regularHours;
                    $totalOvertimeHours += $overtimeHours;

                    if ($attendance->status === 'Late') {
                        $minutesLate = Carbon::parse($attendance->time_in)->diffInMinutes(Carbon::parse('08:00:00'));
                        $deductionHours = floor($minutesLate / 15); // 15 minutes = 1 hour pay deduction
                        $totalDeductions += $deductionHours * $hourlyRate;
                    }
                }
            }

            $totalBasicSalary = $totalWorkHours * $hourlyRate;
            $totalOvertimePay = $totalOvertimeHours * ($hourlyRate * 1.25);
            $netSalary = $totalBasicSalary + $totalOvertimePay - $totalDeductions;

            $payrollData[] = [
                'id' => $employee->id,
                'name' => $employee->name,
                'position' => $employee->position,
                'type' => $employee->type,
                'basic_salary' => number_format($totalBasicSalary, 2),
                'overtime_pay' => number_format($totalOvertimePay, 2),
                'deductions' => number_format($totalDeductions, 2),
                'net_salary' => number_format($netSalary, 2),
            ];
        }

        return view('payroll', compact('payrollData'));
    }

    public function show($id)
    {
        $employee = Employee::with('attendances')->findOrFail($id);
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $attendances = $employee->attendances
            ->where('date', '>=', Carbon::create($year, $month, 1)->toDateString())
            ->where('date', '<=', Carbon::create($year, $month, 1)->endOfMonth()->toDateString());

        return view('payroll-detail', compact('employee', 'attendances'));
    }
}
