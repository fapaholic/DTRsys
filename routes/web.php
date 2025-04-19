<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;



Route::group(['middleware' => 'auth'], function(){
    Route::get('logout', [AuthManager::class, 'logout'])->name('logout');
    Route::get('/', function () { return view('admin-dashboard');})->name('home');
    Route::get('/manage-employees', function () { return view('ManageEmployees');})->name('/manage-employees');
    Route::get('/attendance-logs', function () { return view('attendance-logs');})->name('/attendance-logs');
    Route::post('/employees/add', [EmployeeController::class, 'addEmployee']);
    Route::get('/employees', [EmployeeController::class, 'getEmployees']);
    Route::patch('/employees/{id}', [EmployeeController::class, 'updateEmployee']);
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/reports', function () { return view('reports');})->name('/reports');
    Route::get('/payroll', function () { return view('payroll');})->name('/payroll');
    Route::get('/e-dashboard', function () { return view('e-dashboard');})->name('/e-dashboard');
    Route::get('/e-payroll', function () { return view('e-payroll');})->name('/e-payroll');
    Route::get('/e-attendance', function () { return view('e-attendance');})->name('/e-attendance');
    
    

});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthManager::class, 'login'])->name('login');
    Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
    Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
    Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
    Route::post('/store-attendance', [AttendanceController::class, 'storeAttendance']);
});
