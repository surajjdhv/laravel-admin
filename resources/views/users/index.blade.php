@extends('layouts.app', ['title' => 'Users'])

@section('actions')
@can('users.create')
<a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">
    <i class="cil-user-plus"></i> 
    Add User
</a>
@endcan
@endsection

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>Users</strong>
    </div>
	<div class="card-body">
		<table id="users" class="table table-striped table-borderless">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Type</th>
					<th>Created By</th>
					<th>Action</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var canView = {{ auth()->user()->can('users.view') ? 'true' : 'false' }};
    var canEdit = {{ auth()->user()->can('users.edit') ? 'true' : 'false' }};
    var canDelete = {{ auth()->user()->can('users.delete') ? 'true' : 'false' }};

    var usersTable = $('#users').DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ route('users.table') }}",
		columns: [
            { data: 'id', name: 'id'},
            { data: 'name', name: 'name'},
            { data: 'email', name: 'email'},
            { data: 'type', name: 'type'},
            { data: 'created_by', name: 'created_by'},
			{
                "render": function(data, type, row) {
                    var actions = '<div aria-label="tableActions">';
                    if (canView) {
                        actions += '<a class="btn btn-outline-primary btn-sm" href="{{ route('users.index') }}/' + row['id'] + '" title="View"><i class="cil-external-link"></i></a> ';
                    }
                    if (canEdit) {
                        actions += '<a class="btn btn-outline-info btn-sm" href="{{ route('users.index') }}/' + row['id'] + '/edit" title="Edit"><i class="cil-pen"></i></a> ';
                    }
                    if (canDelete) {
                        actions += '<a class="btn btn-outline-danger btn-sm btn-delete" href="#" data-id="' + row['id'] + '" title="Delete"><i class="cil-trash"></i></a>';
                    }
                    actions += '</div>';
                    return actions;
                }
            }
        ]
	});

    $('#users').on('click', '.btn-delete', function (e) {
        swal({
            title: "Are you sure?",
            text: "This will delete the user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var target = "{{ route('users.delete', '#') }}";

                $.post(target.replace('#', $(this).data('id')))
                    .done(function () {
                        usersTable.ajax.reload();
                    });
            }
        });
    });
});
</script>
@endpush