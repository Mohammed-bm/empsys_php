@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">Field Pay</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #4e7e1e; color: #fff;">
        {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Form Section -->
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h5 class="fw-bold mb-3">Add Payslip Field</h5>
        <form action="{{ route('field-pay.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        <option value="0">AEF (Earning)</option>
                        <option value="1">ADF (Deduction)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Basic Pay, PF" maxlength="30" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Percentage (%)</label>
                    <input type="number" step="0.01" name="percentage" class="form-control" placeholder="0.00" min="0" max="100" oninput="if(parseFloat(this.value) > 100) this.value = 100; if(parseFloat(this.value) < 0) this.value = 0;" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 mt-4" style="background-color: #2b3e50;">SAVE</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Accordion Section -->
    <div class="accordion mb-3" id="fieldPayAccordion">
        <!-- Earnings -->
        <div class="accordion-item border-0 shadow-sm mb-3">
            <h2 class="accordion-header" id="headingEarning">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEarning" aria-expanded="true">
                    Earnings (AEF)
                </button>
            </h2>
            <div id="collapseEarning" class="accordion-collapse collapse show" data-bs-parent="#fieldPayAccordion">
                <div class="accordion-body p-0">
                    @include('field_pay.table', ['items' => $type0])
                </div>
            </div>
        </div>

        <!-- Deductions -->
        <div class="accordion-item border-0 shadow-sm">
            <h2 class="accordion-header" id="headingDeduction">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeduction">
                    Deductions (ADF)
                </button>
            </h2>
            <div id="collapseDeduction" class="accordion-collapse collapse" data-bs-parent="#fieldPayAccordion">
                <div class="accordion-body p-0">
                    @include('field_pay.table', ['items' => $type1])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection