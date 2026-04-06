@extends('backend.app')

@section('title', 'Edit Carrer')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Career</h4>
            <a href="{{ route('admin.carrer.index') }}" class="btn btn-primary btn-sm">
                Career List
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.carrer.update', $carrer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="numbers" class="form-label">Numbers</label>
                        <input type="text" class="form-control" name="numbers" id="numbers"
                            value="{{ old('numbers', $carrer->numbers) }}">

                        @error('numbers')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="tagline" class="form-label">Tagline</label>
                        <input type="text" class="form-control" name="tagline" id="tagline"
                            value="{{ old('tagline', $carrer->tagline) }}">

                        @error('tagline')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $carrer->title) }}">

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control summernote" name="description" id="description" rows="4">
{{ old('description', $carrer->description) }}
</textarea>

                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" name="question" id="question" rows="3">{{ old('question', $carrer->question) }}</textarea>

                        @error('question')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" name="link" id="link"
                            value="{{ old('link', $carrer->link) }}" placeholder="https://...">

                        @error('link')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success">
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
                height: 200,
                placeholder: 'Write description here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic']],
                    ['fontname', ['fontname']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endpush