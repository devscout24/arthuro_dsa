@extends('backend.app')

@section('title', 'Anything List')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Anything List</h4>
                <a href="{{ route('admin.anything.create') }}" class="btn btn-primary btn-sm">
                    Add New Anything
                </a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle" id="anythingTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Tagline</th>
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
            var table = $('#anythingTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.anything.index') }}",
                order: [],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'tagline',
                        name: 'tagline'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = "/admin/anything/destroy/" + id; // must match your route

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
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.message ?? 'Anything deleted successfully',
                                    'success');
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText); // 🔹 check real error
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
