@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if($employee)
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 20px;">
                    {{ strtoupper(substr($employee->emp_name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $employee->emp_name }}</h4>
                    <span class="text-muted">{{ $employee->designation }} — {{ $employee->function_name }}</span>
                </div>
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>Employee ID:</strong>
                    <p class="text-secondary mb-0">{{ $employee->employee_number }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong>
                    <p class="text-secondary mb-0">{{ $employee->email }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Phone:</strong>
                    <p class="text-secondary mb-0">{{ $employee->phone }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Joining Date:</strong>
                    <p class="text-secondary mb-0">{{ $employee->joining_date }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong>
                    <p class="text-secondary mb-0">{{ $employee->location }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Bank Details:</strong>
                    <p class="text-secondary mb-0">{{ $employee->bank_details }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Base Salary:</strong>
                    <p class="text-secondary mb-0">{{ $employee->base_salary }}</p>
                </div>
                <div class="col-md-6">
                    <strong>PAN Number:</strong>
                    <p class="text-secondary mb-0">{{ $employee->pan_number }}</p>
                </div>
                <div class="col-md-6">
                    <strong>UAN:</strong>
                    <p class="text-secondary mb-0">{{ $employee->uan }}</p>
                </div>
                <div class="col-md-6">
                    <strong>PF Account Number:</strong>
                    <p class="text-secondary mb-0">{{ $employee->pf_account_number }}</p>
                </div>
                <div class="col-md-6">
                    <strong>ESI Number:</strong>
                    <p class="text-secondary mb-0">{{ $employee->esi_number }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning border-0 shadow-sm text-center py-4">
            <h5>No Profile Linked</h5>
            <p class="mb-0 text-muted">Your logged-in user account is not currently linked to an active employee record.</p>
        </div>
        @endif
    </div>
</div>
@endsection