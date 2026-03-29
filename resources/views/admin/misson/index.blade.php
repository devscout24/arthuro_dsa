@extends('backend.app')

@section('title', 'Mission List')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="mb-0 text-white">Mission List</h4>
            <a href="{{ route('admin.misson.create') }}" class="btn btn-secondary btn-sm">Add New Mission</a>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <table class="table table-bordered table-striped  text-center align-middle" id="missionTables">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
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
        var table = $('#missionTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.misson.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Delete Mission
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var url = "/admin/misson/destroy/" + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
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
                            Swal.fire('Deleted!', 'Mission deleted successfully', 'success');
                        },
                        error: function(xhr){
                            console.log(xhr.responseText);
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush