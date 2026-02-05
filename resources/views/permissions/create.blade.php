@extends('layouts.app', ['title' => 'Create Permission'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Create Permission</strong>
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

        <form id="createPermissionForm" action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Permission name" required>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#createPermissionForm').submit();">Save</button>
    </div>
</div>
@endsection
