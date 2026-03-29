@extends('backend.app')

@section('title', 'Add Explore')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Explore</h4>
            <a href="{{ route('admin.explore.index') }}" class="btn btn-primary btn-sm">Back</a>
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

            <form action="{{ route('admin.explore.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control"
                        value="{{ old('title') }}"
                        required>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea 
                        name="description" 
                        class="form-control summernote"
                        rows="5">{{ old('description') }}</textarea>
                </div>

                {{-- Image --}}
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input 
                        type="file" 
                        name="image" 
                        class="form-control"
                        accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Explore
                </button>

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