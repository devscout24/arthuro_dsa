@extends('backend.app')

@section('title', 'Edit Family')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Edit Family</h4>

                <a href="{{ route('admin.family.index') }}" class="btn btn-primary btn-sm">
                    Family List
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">

                <form action="{{ route('admin.family.update', $family->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Title</label>

                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $family->title) }}">

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-12">
                            <label class="form-label">Description</label>

                            <textarea name="description" class="form-control summernote" rows="4">{{ old('description', $family->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-12">

                            <label class="form-label">Image</label>

                            <input type="file" name="image" class="form-control dropify">

                            <br>

                            @if ($family->image)
                                <img src="{{ asset('images/' . $family->image) }}" width="40">
                            @endif

                        </div>


                        <div class="col-12">
                            <button class="btn btn-success">
                                Update
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
@endpush


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.summernote').summernote({
                height: 200
            });

        });
    </script>
@endpush
