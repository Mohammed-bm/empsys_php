<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PaySlipController;
use App\Http\Controllers\FieldPayController;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('employees', EmployeeController::class)->except(['create', 'edit']);
    Route::resource('leaves', LeaveController::class)->except(['create', 'edit', 'destroy', 'show']);

    Route::get('/payslips', [LeaveController::class, 'index'])->name('payslips.index');

    Route::prefix('field-pay')->name('field-pay.')->group(function () {
        Route::get('/', [FieldPayController::class, 'index'])->name('index');
        Route::post('/', [FieldPayController::class, 'store'])->name('store');
        Route::put('/{id}', [FieldPayController::class, 'update'])->name('update');
        Route::patch('/{id}/status', [FieldPayController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [FieldPayController::class, 'destroy'])->name('destroy');
    });
});


require __DIR__ . '/auth.php';
