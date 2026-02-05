@extends('layouts.app', ['title' => 'Edit Role'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Edit Role</strong>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editRoleForm" action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}" placeholder="Role name" required>
                    </td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        <select class="form-control select2" name="permissions[]" multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" @if(collect(old('permissions', $role->permissions->pluck('id')->all()))->contains($permission->id)) selected @endif>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#editRoleForm').submit();">Save</button>
    </div>
</div>
@endsection
