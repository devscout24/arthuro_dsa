@extends('backend.app')

@section('title', 'Edit Team')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between">

                <h4>Edit Team</h4>

                <a href="{{ route('admin.team.index') }}" class="btn btn-primary btn-sm">
                    Back
                </a>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $team->title }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Designation</label>
                        <textarea name="designation" class="form-control">{{ $team->designation }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">

                        @if ($team->image)
                            <br>
                            <img src="{{ asset('teams/' . $team->image) }}" width="80">
                        @endif
                    </div>

                    <button class="btn btn-success">Update</button>

                </form>

            </div>
        </div>
    </div>

@endsection
