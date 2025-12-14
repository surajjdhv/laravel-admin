@extends('layouts.app', ['title' => 'StoreRoleRequest'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $role->name }}</strong>
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

        <form name="editRoleForm" id="editRoleForm" action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $role->id }}">
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td><input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}"></td>
                </tr>
            </table>
        </form>
	</div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#editRoleForm').submit();">Save</button>
    </div>
</div>
@endsection