@extends('backend.app')

@section('title', 'Add Banner')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Banner</h4>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote"></textarea>
                    </div>

                    {{-- Icons --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icons</label>
                        <div id="icon-wrapper">
                            <div class="input-group mb-2">
                                <input type="file" name="icons[]" class="form-control">
                                <button type="button" class="btn btn-success add-icon">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Features</label>
                        <div id="feature-wrapper">
                            <div class="input-group mb-2">
                                <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                                <button type="button" class="btn btn-success add-feature">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Save Banner</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Summernote CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {

            // Initialize Summernote
            $('.summernote').summernote({
                height: 150
            });

            // Add new icon input
            $(document).on('click', '.add-icon', function() {
                $('#icon-wrapper').append(`
                    <div class="input-group mb-2">
                        <input type="file" name="icons[]" class="form-control">
                        <button type="button" class="btn btn-danger remove-icon">-</button>
                    </div>
                `);
            });

            // Remove icon input
            $(document).on('click', '.remove-icon', function() {
                $(this).closest('.input-group').remove();
            });

            // Add new feature input
            $(document).on('click', '.add-feature', function() {
                $('#feature-wrapper').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                        <button type="button" class="btn btn-danger remove-feature">-</button>
                    </div>
                `);
            });

            // Remove feature input
            $(document).on('click', '.remove-feature', function() {
                $(this).closest('.input-group').remove();
            });

        });
    </script>
@endpush