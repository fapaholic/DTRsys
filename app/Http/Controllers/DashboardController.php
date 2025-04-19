<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $employeeCount = Employee::count(); // Fetch the total number of employees
        return view('/', compact('employeeCount')); // Pass the variable to the view
    }
}