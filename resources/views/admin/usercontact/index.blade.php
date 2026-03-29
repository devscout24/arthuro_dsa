@extends('backend.app')

@section('title', 'User Contacts')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">User Contacts</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle" id="userContactTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
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
            var table = $('#userContactTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.usercontact.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'message',
                        name: 'message'
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
                var url = "/admin/usercontact/destroy/" + id;

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
                                Swal.fire('Deleted!', 'User contact deleted successfully',
                                    'success');
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