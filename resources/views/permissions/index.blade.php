@extends('layouts.app', ['title' => 'Permissions'])

@section('actions')
@can('permissions.create')
    <a class="btn btn-primary btn-sm" href="{{ route('permissions.create') }}">
        <i class="cil-plus"></i>
        Add Permission
    </a>
@endcan
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Permissions</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->roles_count }}</td>
                            <td>
                                @can('permissions.update')
                                    <a class="btn btn-outline-info btn-sm" href="{{ route('permissions.edit', $permission) }}" title="Edit">
                                        <i class="cil-pen"></i>
                                    </a>
                                @endcan
                                @can('permissions.delete')
                                    <form class="d-inline" method="POST" action="{{ route('permissions.delete', $permission) }}">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No permissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
