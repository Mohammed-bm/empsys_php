@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Employee System</h2>
    @can('employees.create')
    <button class="btn btn-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        ADD EMPLOYEE
    </button>
    @endcan
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <strong>There are validation errors:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card border-0 shadow-sm p-3 mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Employee Number</th>
                    <th>Joining Date</th>
                    <th>Designation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $emp)
                <tr>
                    <td>{{ $employees->firstItem() + $index }}</td>
                    <td>{{ $emp->emp_name }}</td>
                    <td>{{ $emp->employee_number }}</td>
                    <td>{{ $emp->joining_date }}</td>
                    <td>{{ $emp->designation ?? 'N/A' }}</td>
                    <td>
                        @can('update', $emp)
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $emp->id }}">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                        @endcan

                        @can('delete', $emp)
                        <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                <div class="modal fade" id="editEmployeeModal{{ $emp->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('employees.update', $emp) }}" method="POST">
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
                                    <button type="submit" class="btn btn-primary px-4">UPDATE</button>
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

{{-- Edit Modals --}}

{{-- ADD EMPLOYEE MODAL --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('employees.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addEmployeeModalLabel">Add New Employee & Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- --- USER ACCOUNT & ACCESS CONTROL --- --}}
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-0">Account Information</h6>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Assign Role *</label>
                            <select name="role" class="form-select text-capitalize @error('role') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" name="emp_name" value="{{ old('emp_name') }}" class="form-control @error('emp_name') is-invalid @enderror" required>
                            @error('emp_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <hr class="my-3 text-muted">

                        {{-- --- EMPLOYEE DETAILS --- --}}
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-0">Employee Profile Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Employee Number *</label>
                            <input type="text" name="employee_number" value="{{ old('employee_number') }}" class="form-control @error('employee_number') is-invalid @enderror" maxlength="5" inputmode="numeric" pattern="[0-9]{1,5}" required>
                            @error('employee_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" maxlength="15" pattern="(\+|00)[0-9]{1,13}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Designation *</label>
                            <input type="text" name="designation" value="{{ old('designation') }}" class="form-control @error('designation') is-invalid @enderror" maxlength="25" required>
                            @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Function *</label>
                            <input type="text" name="function_name" value="{{ old('function_name') }}" class="form-control @error('function_name') is-invalid @enderror" maxlength="10" required>
                            @error('function_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">PAN *</label>
                            <input type="text" name="pan_number" value="{{ old('pan_number') }}" class="form-control @error('pan_number') is-invalid @enderror" maxlength="10" required>
                            @error('pan_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">UAN *</label>
                            <input type="text" name="uan" value="{{ old('uan') }}" class="form-control @error('uan') is-invalid @enderror" maxlength="12" inputmode="numeric" pattern="[0-9]{1,12}" required>
                            @error('uan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">PF Account Number (PRAN)</label>
                            <input type="text" name="pf_account_number" value="{{ old('pf_account_number') }}" maxlength="12" class="form-control @error('pf_account_number') is-invalid @enderror">
                            @error('pf_account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ESI Number</label>
                            <input type="text" name="esi_number" value="{{ old('esi_number') }}" maxlength="25" class="form-control @error('esi_number') is-invalid @enderror">
                            @error('esi_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bank Details *</label>
                            <input type="text" name="bank_details" value="{{ old('bank_details') }}" class="form-control @error('bank_details') is-invalid @enderror" maxlength="35" required>
                            @error('bank_details')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Joining Date *</label>
                            <input type="date" name="joining_date" value="{{ old('joining_date') }}" class="form-control @error('joining_date') is-invalid @enderror" required>
                            @error('joining_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" pattern="^[A-Za-z ]+,[A-Za-z ]+$" required>
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Base Salary *</label>
                            <input type="text" inputmode="numeric" name="base_salary" value="{{ old('base_salary') }}" pattern="[0-9]{1,8}" class="form-control @error('base_salary') is-invalid @enderror" maxlength="8" required>
                            @error('base_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pe-4 pb-4">
                    <button type="button" class="btn btn-text text-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary px-4">SAVE EMPLOYEE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection