@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Employee System</h2>
    <button class="btn btn-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        ADD EMPLOYEE
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Joining Date</th>
                    <th>Designation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $emp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $emp->emp_name }}</td>
                    <td>{{ $emp->joining_date }}</td>
                    <td>{{ $emp->designation ?? 'N/A' }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $emp->id }}">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editEmployeeModal{{ $emp->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('employees.update', $emp->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Edit Employee Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Function *</label>
                                            <input type="text" name="function_name" value="{{ old('function_name', $emp->function_name) }}" class="form-control" maxlength="10" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">PAN *</label>
                                            <input type="text" name="pan_number" value="{{ old('pan_number', $emp->pan_number) }}" class="form-control" maxlength="10" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Designation *</label>
                                            <input type="text" name="designation" value="{{ old('designation', $emp->designation) }}" class="form-control" maxlength="25" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">UAN *</label>
                                            <input type="text" name="uan" value="{{ old('uan', $emp->uan) }}" class="form-control" maxlength="12" inputmode="numeric" pattern="[0-9]{1,12}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">PF Account Number (PRAN)</label>
                                            <input type="text" name="pf_account_number" value="{{ old('pf_account_number', $emp->pf_account_number) }}" maxlength="12" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Bank Details *</label>
                                            <input type="text" name="bank_details" value="{{ old('bank_details', $emp->bank_details) }}" class="form-control" maxlength="35" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ESI Number</label>
                                            <input type="text" name="esi_number" value="{{ old('esi_number', $emp->esi_number) }}" maxlength="25" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Joining Date *</label>
                                            <input type="date" name="joining_date" value="{{ old('joining_date', $emp->joining_date) }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location *</label>
                                            <input type="text" name="location" value="{{ old('location', $emp->location) }}" class="form-control" pattern="^[A-Za-z ]+,[A-Za-z ]+$" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone *</label>
                                            <input type="text" name="phone" value="{{ old('phone', $emp->phone) }}" class="form-control" maxlength="15" pattern="(\+|00)[0-9]{1,13}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Name *</label>
                                            <input type="text" name="emp_name" value="{{ old('emp_name', $emp->emp_name) }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email *</label>
                                            <input type="email" name="email" value="{{ old('email', $emp->email) }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Base Salary *</label>
                                            <input type="text" inputmode="numeric" name="base_salary" value="{{ old('base_salary', $emp->base_salary) }}" pattern="[0-9]{1,8}" class="form-control" maxlength="8" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Employee Number *</label>
                                            <input type="text" value="{{ $emp->employee_number }}" class="form-control bg-light" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pe-4 pb-4">
                                    <button type="button" class="btn btn-text text-secondary" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-primary px-4" style="background-color: #2b3e50;">UPDATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $employees->links() }}
</div>

<!-- Add Employee Modal (Matching UI Layout) -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="/employees" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Function *</label>
                            <input type="text" name="function_name" class="form-control" maxlength="10" title="Function must be 10 characters or less" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PAN *</label>
                            <input type="text" name="pan_number" class="form-control" maxlength="10" title="PAN must be 10 characters or less" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Designation *</label>
                            <input type="text" name="designation" class="form-control" title="Please enter a designation" maxlength="25" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">UAN *</label>
                            <input type="text" name="uan" class="form-control" maxlength="12" inputmode="numeric" pattern="[0-9]{1,12}" title="UAN must contain only numbers and be up to 12 digits" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PF Account Number (PRAN) *</label>
                            <input type="text" name="pf_account_number" maxlength="12" class="form-control" title="PF Account Number must be 12 characters or less">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bank Details *</label>
                            <input type="text" name="bank_details" class="form-control" maxlength="35" title="Bank details must be 25 characters or less" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ESI Number *</label>
                            <input type="text" name="esi_number" maxlength="25" class="form-control" title="ESI Number must be 25 characters or less">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Joining Date *</label>
                            <input type="date" name="joining_date" class="form-control" title="Please enter a valid joining date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control" pattern="^[A-Za-z ]+,[A-Za-z ]+$" title="Enter location with , in between" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" maxlength="15" pattern="(\+|00)[0-9]{1,13}" title="Phone must start with + or 00 and contain only numbers" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" name="emp_name" class="form-control" title="Please enter the employee name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" title="Please enter a valid email address" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Base Salary *</label>
                            <input inputmode="numeric" name="base_salary" pattern="[0-9]{1,8}" class="form-control" maxlength="8" title="Base salary must contain only numbers and be up to 8 digits" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Employee Number *</label>
                            <input type="text" name="employee_number" class="form-control" maxlength="5" inputmode="numeric" pattern="[0-9]{1,5}" title="Employee number must contain only numbers and be up to 5 digits" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pe-4 pb-4">
                    <button type="button" class="btn btn-text text-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary px-4" style="background-color: #2b3e50;">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection