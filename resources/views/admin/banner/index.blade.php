@extends('backend.app')

@section('title', 'Banner List')

@section('content')
    <div class="container-fluid mt-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Banner List</h4>
                <a href="{{ route('admin.banner.create') }}" class="btn btn-primary btn-sm">Add New Banner</a>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped text-center" id="bannerTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icons</th>
                            <th>Features</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            let table = $('#bannerTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.banner.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return data;
                        }
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
                        data: 'icons',
                        name: 'icons',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'features',
                        name: 'features',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return data;
                        }
                    },
                ]
            });

            // DELETE Banner
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                if (confirm("Are you sure to delete this banner?")) {
                    let deleteUrl = "{{ route('admin.banner.destroy', ':id') }}".replace(':id', id);
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            table.ajax.reload();
                        }
                    });
                }
            });

        });
    </script>
@endpush
