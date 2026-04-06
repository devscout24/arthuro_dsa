@extends('backend.app')

@section('title', 'Carrer List')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Career List</h4>
                <a href="{{ route('admin.carrer.create') }}" class="btn btn-primary btn-sm">Add New Career</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center" id="carrerTables">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Numbers</th>
                            <th>Tagline</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Question</th>
                            <th>Link</th>
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

            let table = $('#carrerTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.carrer.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'numbers',
                        name: 'numbers'
                    },
                    {
                        data: 'tagline',
                        name: 'tagline'
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
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'link',
                        name: 'link'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // DELETE Carrer
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });

        });
    </script>
@endpush
