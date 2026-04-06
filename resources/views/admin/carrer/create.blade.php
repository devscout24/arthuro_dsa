@extends('backend.app')

@section('title', 'Add Carrer')

@section('content')
    <div class="container-fluid mt-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Add Career</h4>
                <a href="{{ route('admin.carrer.index') }}" class="btn btn-primary btn-sm">
                    Career List
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.carrer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="numbers" class="form-label">Numbers</label>
                            <input type="text" class="form-control" name="numbers" id="numbers"
                                value="{{ old('numbers') }}">
                            @error('numbers')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input type="text" class="form-control" name="tagline" id="tagline"
                                value="{{ old('tagline') }}">
                            @error('tagline')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ old('title') }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control summernote" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="question" class="form-label">Question</label>
                            <textarea class="form-control" name="question" id="question" rows="3">{{ old('question') }}</textarea>
                            @error('question')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" class="form-control" name="link" id="link"
                                value="{{ old('link') }}" placeholder="https://...">
                            @error('link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                Save
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
