@extends('backend.app')

@section('title', 'Add Team')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between">

                <h4>Add Team</h4>

                <a href="{{ route('admin.team.index') }}" class="btn btn-primary btn-sm">
                    Back
                </a>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Designation</label>
                        <textarea name="designation" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button class="btn btn-success">Save</button>

                </form>

            </div>
        </div>
    </div>

@endsection
