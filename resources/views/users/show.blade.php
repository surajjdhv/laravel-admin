@extends('layouts.app', ['title' => 'Users'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $user->name }}</strong>
    </div>
	<div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ ucwords($user->type) }}</td>
            </tr>
            <tr>
                <th>Active</th>
                <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{ $user->createdBy ? $user->createdBy->name : '' }}</td>
            </tr>
            <tr>
                <th>Updated By</th>
                <td>{{ $user->updated_by ? $user->updatedBy->name : '' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $user->created_at->toDateTimeString() }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $user->updated_at->toDateTimeString() }}</td>
            </tr>
        </table>
	</div>
</div>
@endsection