@extends('layouts.app', ['title' => 'Roles'])

@section('actions')
@can('roles.create')
    <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">
        <i class="cil-plus"></i>
        Add Role
    </a>
@endcan
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Roles</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Users</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permissions_count }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('roles.update')
                                        <a class="btn btn-outline-info btn-sm" href="{{ route('roles.edit', $role) }}" title="Edit">
                                            <i class="cil-pen"></i>
                                        </a>
                                    @endcan
                                    @can('roles.delete')
                                        <form class="d-inline" method="POST" action="{{ route('roles.delete', $role) }}">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete">
                                                <i class="cil-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
