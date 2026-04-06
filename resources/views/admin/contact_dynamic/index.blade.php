@extends('backend.app')

@section('title', 'Contact Dynamic')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Contact Dynamic</h4>
                <a href="{{ route('admin.contact-dynamic.create') }}" class="btn btn-primary btn-sm">Add New</a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped text-center align-middle" id="contactDynamicTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Button</th>
                            <th>Description</th>
                            <th>Name Label</th>
                            <th>Name Placeholder</th>
                            <th>Email Label</th>
                            <th>Email Placeholder</th>
                            <th>Phone Label</th>
                            <th>Phone Placeholder</th>
                            <th>Message Label</th>
                            <th>Message Placeholder</th>
                            <th>Button</th>
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
            var table = $('#contactDynamicTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.contact-dynamic.index') }}",
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
                        data: 'name_label',
                        name: 'name_label'
                    },
                    {
                        data: 'name_placeholder',
                        name: 'name_placeholder'
                    },
                    {
                        data: 'email_label',
                        name: 'email_label'
                    },
                    {
                        data: 'email_placeholder',
                        name: 'email_placeholder'
                    },
                    {
                        data: 'phone_label',
                        name: 'phone_label'
                    },
                    {
                        data: 'phone_placeholder',
                        name: 'phone_placeholder'
                    },
                    {
                        data: 'message_label',
                        name: 'message_label'
                    },
                    {
                        data: 'message_placeholder',
                        name: 'message_placeholder'
                    },
                    {
                        data: 'button',
                        name: 'button'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = "{{ url('/admin/contact-dynamic/destroy') }}/" + id;

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
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.message, 'success');
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
