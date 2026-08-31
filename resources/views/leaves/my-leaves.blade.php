@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if($salary)
        <div class="card border-0 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 20px;">
                    <i class='bx bx-calendar-event'></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">My Leave Balance</h4>
                    <span class="text-muted">{{ $salary->employee->emp_name ?? auth()->user()->name }} ({{ $salary->employee_number }})</span>
                </div>
            </div>
            <hr>
            <div class="row g-4 text-center">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <span class="text-muted d-block mb-1 fw-semibold">Casual Leave Count</span>
                        <h2 class="mb-0 text-primary fw-bold">{{ $salary->Leave_count }}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <span class="text-muted d-block mb-1 fw-semibold">Sick Leave Count</span>
                        <h2 class="mb-0 text-danger fw-bold">{{ $salary->Sick_Leave }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning border-0 shadow-sm text-center py-4">
            <h5>No Leave Data Found</h5>
            <p class="mb-0 text-muted">There are no leave records or balances linked to your employee account.</p>
        </div>
        @endif
    </div>
</div>
@endsection