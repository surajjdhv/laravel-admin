@extends('layouts.app', ['title' => 'Users'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $user->name }}</strong>
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

        <form name="editUserForm" id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td><input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}"></td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>
                        @can('users.roles.assign')
                            <select class="form-control select2" name="roles[]" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if(collect(old('roles', $user->roles->pluck('id')->all()))->contains($role->id)) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="text-muted">{{ $user->roles->pluck('name')->implode(', ') }}</span>
                        @endcan
                    </td>
                </tr>
                <tr>
                    <th>Active</th>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="isActiveYes" value="1" @if(old('is_active', $user->is_active) == 1) checked @endif>
                            <label class="form-check-label" for="isActiveYes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="isActiveNo" value="0" @if(old('is_active', $user->is_active) == 0) checked @endif>
                            <label class="form-check-label" for="isActiveNo">
                                No
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
	</div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#editUserForm').submit();">Save</button>
    </div>
</div>
@endsection
