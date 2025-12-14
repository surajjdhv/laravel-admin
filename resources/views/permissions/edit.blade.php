@extends('layouts.app', ['title' => 'Edit Permission'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $permission->name }}</strong>
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

        <form name="editPermissionForm" id="editPermissionForm" action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $permission->id }}">
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td><input type="text" class="form-control" name="name" value="{{ old('name', $permission->name) }}"></td>
                </tr>
            </table>
        </form>
	</div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#editPermissionForm').submit();">Save</button>
    </div>
</div>
@endsection

