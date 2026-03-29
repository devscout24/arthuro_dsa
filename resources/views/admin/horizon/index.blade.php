@extends('backend.app')

@section('title', 'Horizon List')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Horizon List</h4>
                <a href="{{ route('admin.horizon.create') }}" class="btn btn-primary btn-sm">Add New Horizon</a>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped text-center" id="horizonTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
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

            var table = $('#horizonTables').DataTable({

                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.horizon.index') }}",

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
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
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
            $(document).on('click', '.delete', function() {

                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "/admin/horizon/destroy/" + id,
                            type: "DELETE",

                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function() {

                                $('#horizonTables').DataTable().ajax.reload();

                                Swal.fire('Deleted!', 'Horizon deleted successfully',
                                    'success');

                            }

                        });

                    }

                });

            });


        });
    </script>
@endpush
