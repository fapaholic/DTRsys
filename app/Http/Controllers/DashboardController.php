<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $today = Carbon::today();

        // Total employee count
        $employeeCount = Employee::count();

        // Count of present employees today
        $presentToday = Attendance::whereDate('time_in', $today)
            ->distinct('employee_id')
            ->count('employee_id');

        // Count of employees who are late today
        $lateToday = Attendance::whereDate('time_in', $today)
            ->whereTime('time_in', '>', '08:15:00')
            ->count();

        // Count of absent employees today
        $absentToday = $employeeCount - $presentToday;

        // Fetch attendance logs for the current day
        $attendanceLogs = DB::table('attendance')
            ->leftJoin('employees', 'attendance.employee_id', '=', 'employees.id')
            ->select(
                'attendance.*',
                'employees.name',
                'employees.position',
                'employees.type',
                'employees.salary'
            )
            ->whereDate('attendance.date', $today)
            ->orderBy('attendance.time_in')
            ->get();

        // Fetch recent activity for the current day
        $recentActivity = DB::table('attendance')
            ->leftJoin('employees', 'attendance.employee_id', '=', 'employees.id')
            ->select('attendance.date', 'employees.name', 'attendance.time_in', 'attendance.time_out', 'attendance.status')
            ->whereDate('attendance.date', $today)
            ->orderBy('attendance.time_in', 'desc')
            ->take(10)
            ->get();

        // Weekly data computation
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $employees = Employee::all();
        $totalEmployees = $employees->count();

        $weekDates = collect();
        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $weekDates->push($date->copy());
        }

        $labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $onTimeData = [];
        $lateData = [];
        $absentData = [];

        foreach ($weekDates as $date) {
            $dayOfWeek = $date->dayOfWeek; // Sunday=0, Saturday=6

            $attendance = Attendance::whereDate('date', $date)->get();

            $onTime = $attendance->where('status', 'On Time')->count();
            $late = $attendance->where('status', 'Late')->count();
            $presentIds = $attendance->pluck('employee_id')->unique();
            $absent = $totalEmployees - $presentIds->count();

            $onTimeData[$dayOfWeek] = $onTime;
            $lateData[$dayOfWeek] = $late;
            $absentData[$dayOfWeek] = $absent;
        }

        // Fill in zeros for missing days
        for ($i = 0; $i <= 6; $i++) {
            $onTimeData[$i] = $onTimeData[$i] ?? 0;
            $lateData[$i] = $lateData[$i] ?? 0;
            $absentData[$i] = $absentData[$i] ?? 0;
        }

        return view('admin-dashboard', compact(
            'employeeCount',
            'presentToday',
            'lateToday',
            'absentToday',
            'attendanceLogs',
            'recentActivity',
            'labels',
            'onTimeData',
            'lateData',
            'absentData'
        ));
    }
}
