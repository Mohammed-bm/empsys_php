<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    // Display all employees
    public function index()
    {
        $employees = Employee::paginate(15);
        return view('employees.index', compact('employees'));
    }

    // POST /employees
    public function store(Request $request)
    {

            $validated = $request->validate([
                'emp_name' => 'required|string',
                'employee_number' => 'required|unique:employees,employee_number',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'required',
                'base_salary' => 'required|numeric',
                'function_name' => 'required|string',
                'pan_number' => 'required|string',
                'designation' => 'required|string',
                'uan' => 'required|string',
                'bank_details' => 'required|string',
                'joining_date' => 'required|date',
                'location' => 'required|string',
                'pf_account_number' => 'nullable|string',
                'esi_number' => 'nullable|string',
            ]);

            // 2. Attempt Database Save
            $employee = Employee::create($validated);

            return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    // GET /employees/{id} (Sequelize findByPk equivalent)
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    // PUT/PATCH /employees/{id} (Sequelize update equivalent)
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'emp_name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'phone' => 'required',
            'base_salary' => 'required|numeric',
            'function_name' => 'required|string',
            'pan_number' => 'required|string',
            'designation' => 'required|string',
            'uan' => 'required|string',
            'bank_details' => 'required|string',
            'joining_date' => 'required|date',
            'location' => 'required|string',
            'pf_account_number' => 'nullable|string',
            'esi_number' => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    // DELETE /employees/{id} (Sequelize destroy equivalent)
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        DB::table('employee_salary')->where('employee_number', $employee->employee_number)->delete();
        DB::table('employee_payslip')->where('employee_number', $employee->employee_number)->delete();

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
