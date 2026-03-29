@extends('backend.app')

@section('title', 'Work List')

@section('content') 

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Work List</h4>
            <a href="{{ route('admin.work.create') }}" class="btn btn-primary btn-sm">Add New Work</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped text-center" id="workTables">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

@endsection


@push('scripts')

<script>
$(document).ready(function() {

let table = $('#workTables').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.work.index') }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
        { data: 'title', name: 'title' },
        { data: 'description', name: 'description' },
        { data: 'action', name: 'action', orderable:false, searchable:false }
    ]
});


// DELETE
$(document).on('click', '.delete', function(e) {

    e.preventDefault();
    let id = $(this).data('id');

    let url = `{{ route('admin.work.destroy', ':id') }}`;
    url = url.replace(':id', id);

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if (response.status == 'success') {
                        table.ajax.reload();
                        Swal.fire('Deleted!', response.message, 'success');
                    }

                }
            });

        }

    });

});

});
</script>

@endpush