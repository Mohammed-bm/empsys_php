@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Leave Balances</h2>
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
                    <th>Employee No</th>
                    <th>Employee Name</th>
                    <th>Casual Leave Count</th>
                    <th>Sick Leave Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $index => $salary)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $salary->employee_number }}</td>
                    <td>{{ $salary->employee->emp_name ?? 'N/A' }}</td>
                    <td>{{ $salary->Leave_count }}</td>
                    <td>{{ $salary->Sick_Leave }}</td>
                </tr>

                <!-- Edit Leave Modal -->
                <div class="modal fade" id="editLeaveModal{{ $salary->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('leaves.update', $salary->employee_number) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Update Leave Balance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label">Employee Number</label>
                                        <input type="text" class="form-control bg-light" value="{{ $salary->employee_number }}" disabled readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Leave Count *</label>
                                        <input type="number" step="0.5" name="Leave_count" value="{{ old('Leave_count', $salary->Leave_count) }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sick Leave *</label>
                                        <input type="number" step="0.5" name="Sick_Leave" value="{{ old('Sick_Leave', $salary->Sick_Leave) }}" class="form-control" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No leave records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $salaries->links() }}
</div>
@endsection