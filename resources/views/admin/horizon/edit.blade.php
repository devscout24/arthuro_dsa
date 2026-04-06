@extends('backend.app')

@section('title', 'Edit Horizon')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm border-0 rounded-3">

        {{-- Card Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Horizon</h4>
            <a href="{{ route('admin.horizon.index') }}" class="btn btn-light btn-sm">Back</a>
        </div>

        <div class="card-body">

            {{-- Validation Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.horizon.update', $horizon->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $horizon->title) }}"
                        required>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>

                    <textarea
                        name="description"
                        class="form-control summernote"
                        rows="5">{{ old('description', $horizon->description) }}</textarea>
                </div>

                {{-- Image --}}
                <div class="mb-3">
                    <label class="form-label">Image</label>

                    <input type="file" name="image" class="form-control">

                    @if($horizon->image)
                        <div class="mt-2">
                            <img
                                src="{{ asset('images/'.$horizon->image) }}"
                                width="120"
                                class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Tagline (Only One Time)</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $horizon->tagline) }}">
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">
                    Update Horizon
                </button>

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
        $(document).ready(function(){
            $('.summernote').summernote({
                height:200,
                placeholder:'Write description here...',
                toolbar:[
                    ['style',['style']],
                    ['font',['bold','italic','underline']],
                    ['para',['ul','ol','paragraph']],
                    ['insert',['link']],
                    ['view',['fullscreen','codeview']]
                ]
            });
        });
    </script>
@endpush