@extends('layouts.app', ['title' => 'Permissions'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>{{ $permission->name }}</strong>
    </div>
	<div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th>Name</th>
                <td>{{ $permission->name }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $permission->created_at->toDateTimeString() }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $permission->updated_at->toDateTimeString() }}</td>
            </tr>
        </table>
	</div>
</div>
@endsection

