@extends('backend.app')

@section('title', 'Here List')

@section('content')

    <div class="container-fluid mt-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Here List</h4>
                <a href="{{ route('admin.here.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle" id="hereTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Button</th>
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

            let table = $('#hereTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.here.index') }}",
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
                        data: 'button',
                        name: 'button'
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

                let url = "{{ route('admin.here.destroy', ':id') }}";
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
