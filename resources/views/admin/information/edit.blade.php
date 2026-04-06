@extends('backend.app')

@section('title', 'Edit Information')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="mb-0">Edit Information</h4>
            <a href="{{ route('admin.information.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.information.update', $information->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $information->title) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $information->tagline) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Label</label>
                        <input type="text" name="email_label" class="form-control" value="{{ old('email_label', $information->email_label) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Icon</label>
                        <input type="text" name="email_icon" class="form-control" value="{{ old('email_icon', $information->email_icon) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $information->email) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', $information->linkedin) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn Icon</label>
                        <input type="text" name="linkedin_icon" class="form-control" value="{{ old('linkedin_icon', $information->linkedin_icon) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $information->instagram) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram Icon</label>
                        <input type="text" name="instagram_icon" class="form-control" value="{{ old('instagram_icon', $information->instagram_icon) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" rows="5">{{ old('description', $information->description) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
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
