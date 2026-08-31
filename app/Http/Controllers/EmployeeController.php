<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    public function index()
    {
        // If regular employee without viewAny permission, redirect to their profile
        if (!auth()->user()->can('viewAny', Employee::class)) {
            return redirect()->route('employees.my-profile');
        }

        $employees = Employee::with('user.roles')->latest()->paginate(15);
        $roles = Role::all();

        return view('employees.index', compact('employees', 'roles'));
    }

    public function myProfile()
    {
        // Load personal employee profile via user relationship
        $employee = auth()->user()->employee;

        return view('employees.my-profile', compact('employee'));
    }

    // POST /employees
    public function store(Request $request)
    {
        Gate::authorize('create', Employee::class);

        $validated = $request->validate([
            'emp_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email|unique:employees,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|exists:roles,name',

            'employee_number' => 'required|unique:employees,employee_number',
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

        DB::transaction(function () use ($validated) {
            // Step A: Create User Account
            $user = User::create([
                'name'     => $validated['emp_name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($validated['role']);

            // Step C: Create Employee Profile linked via user_id
            $user->employee()->create([
                'employee_number'   => $validated['employee_number'],
                'email'             => $validated['email'],
                'emp_name'          => $validated['emp_name'],
                'phone'             => $validated['phone'],
                'base_salary'       => $validated['base_salary'],
                'function_name'     => $validated['function_name'],
                'designation'       => $validated['designation'],
                'pan_number'        => $validated['pan_number'],
                'uan'               => $validated['uan'],
                'bank_details'      => $validated['bank_details'],
                'joining_date'      => $validated['joining_date'],
                'location'          => $validated['location'],
                'pf_account_number' => $validated['pf_account_number'] ?? null,
                'esi_number'        => $validated['esi_number'] ?? null,
            ]);
        });

        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    // GET /employees/{id} (Sequelize findByPk equivalent)
    public function show(Employee $employee)
    {
        Gate::authorize('view', $employee);

        return view('employees.show', compact('employee'));
    }

    // PUT/PATCH /employees/{id} (Sequelize update equivalent)
    public function update(Request $request, Employee $employee)
    {
        Gate::authorize('update', $employee);

        $validated = $request->validate([
            'emp_name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
                Rule::unique('users', 'email')->ignore($employee->user_id),
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

        DB::transaction(function () use ($employee, $validated) {
            // Update associated User model credentials
            if ($employee->user) {
                $employee->user->update([
                    'name'  => $validated['emp_name'],
                    'email' => $validated['email'],
                ]);

                if (!empty($validated['role'])) {
                    $employee->user->syncRoles([$validated['role']]);
                }
            }

            // Update Employee profile record
            $employee->update($validated);
        });

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    // DELETE /employees/{id} (Sequelize destroy equivalent)
    public function destroy(Employee $employee)
    {
        Gate::authorize('delete', $employee);

        DB::transaction(function () use ($employee) {
            // Remove linked payroll data
            DB::table('employee_salary')->where('employee_number', $employee->employee_number)->delete();
            DB::table('employee_payslip')->where('employee_number', $employee->employee_number)->delete();

            // Delete User record if present
            if ($employee->user) {
                $employee->user->delete();
            }

            // Delete Employee record
            $employee->delete();
        });

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
