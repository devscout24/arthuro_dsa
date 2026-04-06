@extends('backend.app')

@section('title', 'Team Paragraph List')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Team Paragraph List</h4>
                <a href="{{ route('admin.team_paragraph.create') }}" class="btn btn-primary btn-sm">Add New Team Paragraph</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle" id="teamParagraphTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Tagline</th>
                            <th>Description</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#teamParagraphTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.team_paragraph.index') }}",
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

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let url = `{{ route('admin.team_paragraph.destroy', ':id') }}`;
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
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.message ?? 'Deleted successfully', 'success');
                            },
                            error: function(xhr) {
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
