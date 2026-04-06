@extends('backend.app')

@section('title', 'Negotiable List')

@section('content')

    <div class="container-fluid mt-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Negotiable List</h4>
                <a href="{{ route('admin.negotiable.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle" id="negotiableTables">
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

            let table = $('#negotiableTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.negotiable.index') }}",
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
                        name: 'tagline',
                        orderable: false,
                        searchable: false
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

            // DELETE
            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');

                let url = "{{ route('admin.negotiable.destroy', ':id') }}";
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
                                if (response.status === 'success') {
                                    table.ajax.reload();
                                    Swal.fire('Deleted!', response.message, 'success');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong!', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
