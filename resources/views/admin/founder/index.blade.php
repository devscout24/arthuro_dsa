@extends('backend.app')

@section('title', 'Founder List')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 ">Founder List</h4>
            <a href="{{ route('admin.founder.create') }}" class="btn btn-secondary btn-sm">Add New Founder</a>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle" id="founderTables">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Designation</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th width="120">Action</th>
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
    var table = $('#founderTables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.founder.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'designation', name: 'designation' },
            { data: 'description', name: 'description' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Delete Founder
    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        var url = "/admin/founder/destroy/" + id;

        Swal.fire({
            title: 'Are you sure?',
            text: "This cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response){
                        table.ajax.reload();
                        Swal.fire('Deleted!', 'Founder deleted successfully', 'success');
                    },
                    error: function(xhr){
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
});
</script>
@endpush