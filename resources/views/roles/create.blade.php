@extends('layouts.app', ['title' => 'Create Role'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Create Role</strong>
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

        <form id="createRoleForm" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Role name" required>
                    </td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        <select class="form-control select2" name="permissions[]" multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" @if(collect(old('permissions', []))->contains($permission->id)) selected @endif>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#createRoleForm').submit();">Save</button>
    </div>
</div>
@endsection
