@extends('layouts.app', ['title' => 'Permissions'])

@section('actions')
<a class="btn btn-primary btn-sm" href="{{ route('permissions.create') }}">
    <i class="cil-lock-unlocked"></i> 
    Add Permission
</a>
@endsection

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>Permissions</strong>
    </div>
	<div class="card-body">
        <table id="permissions" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
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
    var permissionsTable = $('#permissions').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('permissions.table') }}",
        columns: [
            { data: 'id', name: 'id'},
            { data: 'name', name: 'name'},
            {
                "render": function(data, type, row) {
                    return `
                        <div aria-label="tableActions">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('permissions.index') }}/` + row['id'] + `" title="View"><i class="cil-external-link"></i></a>
                            <a class="btn btn-outline-info btn-sm" href="{{ route('permissions.index') }}/` + row['id'] + `/edit" title="Edit"><i class="cil-pen"></i></a>
                            <a class="btn btn-outline-danger btn-sm btn-delete" href="#" data-id="` + row['id'] + `" title="Delete"><i class="cil-trash"></i></a>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#permissions').on('click', '.btn-delete', function (e) {
        swal({
            title: "Are you sure?",
            text: "This will delete the permission!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var target = "{{ route('permissions.delete', '#') }}";

                $.post(target.replace('#', $(this).data('id')))
                    .done(function () {
                        permissionsTable.ajax.reload();
                    });
            }
        });
    });
});
</script>
@endpush

