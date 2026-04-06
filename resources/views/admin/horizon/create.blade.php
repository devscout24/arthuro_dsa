@extends('backend.app')

@section('title', 'Add Horizon')

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Horizon</h4>
            <a href="{{ route('admin.horizon.index') }}" class="btn btn-primary btn-sm">Back</a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.horizon.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control summernote" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tagline (Only One Time)</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

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
$(document).ready(function () {
    $('.summernote').summernote({
        height: 200,
        placeholder: 'Write description here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
});
</script>
@endpush