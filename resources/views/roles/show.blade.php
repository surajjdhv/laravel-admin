@extends('layouts.app', ['title' => 'Roles'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $role->name }}</strong>
    </div>
	<div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th>Name</th>
                <td>{{ $role->name }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $role->created_at->toDateTimeString() }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $role->updated_at->toDateTimeString() }}</td>
            </tr>
        </table>
	</div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Permissions</strong>
        @can('roles.edit')
        @if($availablePermissions->count() > 0)
        <button type="button" class="btn btn-primary btn-sm" data-coreui-toggle="modal" data-coreui-target="#attachPermissionModal">
            <i class="cil-plus"></i> Attach Permission
        </button>
        @endif
        @endcan
    </div>
    <div class="card-body">
        @if($role->permissions->count() > 0)
        <table class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    @can('roles.edit')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($role->permissions as $permission)
                <tr id="permission-row-{{ $permission->id }}">
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    @can('roles.edit')
                    <td>
                        <button class="btn btn-outline-danger btn-sm btn-detach" data-id="{{ $permission->id }}" title="Detach">
                            <i class="cil-x"></i>
                        </button>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-muted mb-0">No permissions attached to this role.</p>
        @endif
    </div>
</div>

@can('roles.edit')
<div class="modal fade" id="attachPermissionModal" tabindex="-1" aria-labelledby="attachPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('roles.permissions.attach', $role->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="attachPermissionModalLabel">Attach Permission</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="permission_id" class="form-label">Select Permission</label>
                        <select class="form-select" id="permission_id" name="permission_id" required>
                            <option value="">Choose a permission...</option>
                            @foreach($availablePermissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Attach</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.btn-detach').on('click', function (e) {
        var permissionId = $(this).data('id');
        var row = $('#permission-row-' + permissionId);
        
        swal({
            title: "Are you sure?",
            text: "This will detach the permission from this role!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDetach) => {
            if (willDetach) {
                var target = "{{ route('roles.permissions.detach', [$role->id, '#']) }}";

                $.post(target.replace('#', permissionId))
                    .done(function () {
                        row.fadeOut(300, function() { 
                            $(this).remove();
                            if ($('tbody tr').length === 0) {
                                location.reload();
                            }
                        });
                    });
            }
        });
    });
});
</script>
@endpush