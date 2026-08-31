<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Resource Action Permissions (Clean & Standardized)
        $permissions = [
            // Employee Management
            'employees.read',
            'employees.manage',
            'employees.create',
            'employees.update',
            'employees.delete',

            // Leave Management
            'leaves.read',
            'leaves.create',
            'leaves.update',
            'leaves.delete',

            // Payroll Management
            'payroll.read',
            'payroll.update',

            // Field Pay Management
            'field-pay.read',
            'field-pay.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Roles
        $roles = [
            'admin'      => Role::firstOrCreate(['name' => 'admin']),
            'hr_manager' => Role::firstOrCreate(['name' => 'hr_manager']),
            'employee'   => Role::firstOrCreate(['name' => 'employee']),
        ];

        // 3. Assign Permissions to Roles

        // Regular Employees get basic resource capabilities
        // Scope ("own vs all") will be evaluated dynamically by Policies
        $roles['employee']->syncPermissions([
            'employees.read',
            'leaves.read',
            'leaves.create',
        ]);

        // HR Managers get full resource capability across the app
        $roles['hr_manager']->syncPermissions([
            'employees.read',
            'employees.create',
            'employees.update',
            'employees.delete',
            'employees.manage',
            'leaves.read',
            'leaves.create',
            'leaves.update',
            'payroll.read',
            'payroll.update',
            'field-pay.read',
            'field-pay.update',
        ]);

        // Super Admin gets everything automatically
        $roles['admin']->syncPermissions(Permission::all());

        // 4. Seed Default HRM Users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@hrm.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr@hrm.com',
                'password' => 'password',
                'role' => 'hr_manager',
            ],
            [
                'name' => 'John Employee',
                'email' => 'employee@hrm.com',
                'password' => 'password',
                'role' => 'employee',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt($userData['password']),
                ]
            );

            $user->syncRoles([$roles[$userData['role']]]);
        }
    }
}