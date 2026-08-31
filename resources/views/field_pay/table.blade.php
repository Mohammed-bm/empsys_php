<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 40%;">Name</th>
                <th style="width: 25%;">Percentage</th>
                @canany(['edit field pay', 'delete field pay', 'toggle field pay status'])
                <th style="width: 25%;">Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->percentage }}%</td>

                @canany(['edit field pay', 'delete field pay', 'toggle field pay status'])
                <td>
                    <div class="d-flex gap-1">
                        @can('edit field pay')
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editFieldModal{{ $item->id }}">
                            Edit
                        </button>
                        @endcan

                        @can('delete field pay')
                        <form action="{{ route('field-pay.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                        @endcan


                        @can('toggle field pay status')
                        <form action="{{ route('field-pay.toggle-status', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                {{ $item->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
                @endcanany
            </tr>

            @can('edit field pay')
            <tr class="d-none">
                <td colspan="4">
                    <div class="modal fade" id="editFieldModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('field-pay.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Field</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label">Type *</label>
                                            <select name="type" class="form-select" required>
                                                <option value="0" {{ $item->type == 0 ? 'selected' : '' }}>AEF (Earning)</option>
                                                <option value="1" {{ $item->type == 1 ? 'selected' : '' }}>ADF (Deduction)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name *</label>
                                            <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Percentage (%) *</label>
                                            <input type="number" step="0.01" name="percentage" value="{{ old('percentage', $item->percentage) }}" class="form-control" required>
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
                </td>
            </tr>
            @endcan
            
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>