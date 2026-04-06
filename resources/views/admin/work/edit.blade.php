@extends('backend.app')

@section('title', 'Edit Work')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Work</h4>
            <a href="{{ route('admin.work.index') }}" class="btn btn-primary btn-sm">
                Back
            </a>
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
            <form action="{{ route('admin.work.update', $work->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control"
                        value="{{ old('title', $work->title) }}"
                        required
                    >
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea 
                        name="description" 
                        class="form-control summernote"
                    >{{ old('description', $work->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tag Header</label>
                    <input 
                        type="text" 
                        name="tag_header" 
                        class="form-control"
                        value="{{ old('tag_header', $work->tag_header) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Tag Footer</label>
                    <input 
                        type="text" 
                        name="tag_footer" 
                        class="form-control"
                        value="{{ old('tag_footer', $work->tag_footer) }}"
                    >
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

            </form>

        </div>

    </div>

</div>

@endsection


{{-- Summernote CSS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
@endpush


{{-- Summernote JS --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
$(document).ready(function () {

    $('.summernote').summernote({
        height: 200,
        placeholder: "Write description here...",
        toolbar: [
            ['style', ['style']],
            ['font', ['bold','underline','italic','clear']],
            ['para', ['ul','ol','paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen','codeview']]
        ]
    });

});
</script>

@endpush