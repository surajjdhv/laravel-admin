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
@endsection