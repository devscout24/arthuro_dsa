@extends('backend.app')

@section('title', 'Add Work')

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Work</h4>
            <a href="{{ route('admin.work.index') }}" class="btn btn-primary btn-sm">Back</a>
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

            <form action="{{ route('admin.work.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control summernote">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tag Header</label>
                    <input type="text" name="tag_header" class="form-control" value="{{ old('tag_header') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tag Footer</label>
                    <input type="text" name="tag_footer" class="form-control" value="{{ old('tag_footer') }}">
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
            ['font', ['bold','underline','italic']],
            ['para', ['ul','ol','paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen','codeview']]
        ]
    });

});
</script>

@endpush