<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{

    

    public function updateEmployee(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'position' => 'required|string|max:255',
            'email' => 'required|email',
            'salary' => 'required|numeric',
        ]);
    
        $employee = Employee::findOrFail($id);
        $employee->update($validatedData);
    
        return response()->json(['success' => true, 'employee' => $employee]);
    }

    public function addEmployee(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'password' => 'required|string|min:8',
            'salary' => 'required|numeric',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $employee = Employee::create($validatedData);

        return response()->json(['success' => true, 'employee' => $employee], 201);
    } catch (Exception $e) {
        \Log::error('Error adding employee: '.$e->getMessage());
        return response()->json(['success' => false, 'error' => 'An error occurred.'], 500);
    }
}
public function getEmployees()
{
    $employees = Employee::all();

    // This is for demonstration purposes only.
    return response()->json($employees);
}
}

?>
