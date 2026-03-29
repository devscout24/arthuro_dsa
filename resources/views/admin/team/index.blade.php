@extends('backend.app')

@section('title', 'Team List')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Team List</h4>

                <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
                    Add Team
                </a>
            </div>

            <div class="card-body">

                <table class="table table-bordered text-center" id="teamTable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Designation</th>
                            <th>Image</th>
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
        $(function() {

            $('#teamTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.team.index') }}",

                columns: [

                    {
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
                        data: 'designation',
                        name: 'designation'
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

        });


        $(document).on('click', '.delete', function() {

            var id = $(this).data('id');

            if (confirm("Delete this team?")) {

                $.ajax({

                    url: "/admin/team/destroy/" + id,

                    type: "DELETE",

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function() {

                        $('#teamTable').DataTable().ajax.reload();

                    }

                });

            }

        });
    </script>
@endpush
