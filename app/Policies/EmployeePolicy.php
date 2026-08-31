<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    /**
     * Determine whether the user can view any employee list (Admin/HR only).
     */
    public function viewAny(User $user): bool
    {
        return $user->can('employees.read') && ($user->hasRole('admin') || $user->hasRole('hr_manager'));
    }

    /**
     * Determine whether the user can view a specific employee's profile card.
     */
    public function view(User $user, Employee $employee): bool
    {
        if (!$user->can('employees.read')) {
            return false;
        }

        // Admin and HR can view anyone's details
        if ($user->hasRole('admin') || $user->hasRole('hr_manager')) {
            return true;
        }

        // Regular employees can ONLY view their own record
        return $employee->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('employees.create');
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->can('employees.update');
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->can('employees.delete');
    }
}