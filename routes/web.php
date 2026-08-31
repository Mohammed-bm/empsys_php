<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\FieldPayController;
use App\Http\Controllers\UserController;

// 1. Root Route: Redirect to dashboard to prevent 403 on homepage for low-privilege users
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-profile', [EmployeeController::class, 'myProfile'])->name('employees.my-profile');

    // Leaves Management
    Route::get('/my-leaves', [LeaveController::class, 'myLeaves'])
        ->middleware('can:leaves.read')
        ->name('leaves.my-leaves');

    Route::resource('leaves', LeaveController::class)
        ->except(['create', 'edit', 'destroy', 'show'])
        ->middleware('can:leaves.read');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

    // Employee & User Creation / Mutation Actions
    Route::middleware(['can:employees.create'])->group(function () {
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

        // User Management Routes
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    // Update Actions (Protected by edit_employee permission)
    Route::middleware(['can:employees.update'])->group(function () {
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    });

    // Delete Actions (Protected by delete_employee permission)
    Route::middleware(['can:employees.delete'])->group(function () {
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // Payslips Module (Fixed: uses LeaveController)
    Route::middleware(['can:payroll.read'])->group(function () {
        Route::get('/payslips', [LeaveController::class, 'index'])->name('payslips.index');
    });

    // Field Pay Module
    Route::middleware(['can:field-pay.read'])->prefix('field-pay')->name('field-pay.')->group(function () {
        Route::get('/', [FieldPayController::class, 'index'])->name('index');

        Route::middleware(['can:field-pay.update'])->group(function () {
            Route::post('/', [FieldPayController::class, 'store'])->name('store');
            Route::put('/{id}', [FieldPayController::class, 'update'])->name('update');
            Route::patch('/{id}/status', [FieldPayController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{id}', [FieldPayController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__ . '/auth.php';
