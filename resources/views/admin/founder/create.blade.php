@extends('backend.app')

@section('title', 'Add Founder')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="mb-0">Add Founder</h4>
            <a href="{{ route('admin.founder.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        {{-- Card Body --}}
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

            {{-- Form --}}
            <form action="{{ route('admin.founder.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Designation</label>
                    <textarea name="designation" class="form-control summernote" rows="4">{{ old('designation') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control summernote" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 200,
        placeholder: 'Write designation or description here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline']],
            ['para', ['ul','ol','paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen','codeview']]
        ]
    });
});
</script>
@endpush