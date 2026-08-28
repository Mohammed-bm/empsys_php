<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\Employee;
use Illuminate\Http\Request;


class LeaveController extends Controller
{
    // GET /leaves
    public function index()
    {
        $salaries = EmployeeSalary::with('employee')->paginate(15);
        $employees = Employee::all(); // For dropdown selection in modal

        return view('leaves.index', compact('salaries', 'employees'));
    }

    // POST /leaves (Store or Update leave balances)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => 'required|exists:employees,employee_number',
            'Leave_count'     => 'required|numeric|min:0',
            'Sick_Leave'      => 'required|numeric|min:0',
        ]);

        EmployeeSalary::updateOrCreate(
            ['employee_number' => $validated['employee_number']],
            [
                'Leave_count' => $validated['Leave_count'],
                'Sick_Leave'  => $validated['Sick_Leave'],
            ]
        );

        return redirect()->route('leaves.index')->with('success', 'Leave balances updated successfully!');
    }

    // PUT /leaves/{employee_number}
    public function update(Request $request, $employee_number)
    {
        $validated = $request->validate([
            'Leave_count' => 'required|numeric|min:0',
            'Sick_Leave'  => 'required|numeric|min:0',
        ]);

        $salary = EmployeeSalary::where('employee_number', $employee_number)->firstOrFail();
        $salary->update($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave balances updated successfully!');
    }
}
