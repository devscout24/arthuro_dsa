@extends('backend.app')

@section('title', 'Add Contact Dynamic')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="mb-0" style="color: white">Add Contact Dynamic</h4>
            <a href="{{ route('admin.contact-dynamic.index') }}" class="btn btn-secondary btn-sm">Back</a>
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

            <form action="{{ route('admin.contact-dynamic.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button</label>
                        <input type="text" name="button" class="form-control" value="{{ old('button') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name Label</label>
                        <input type="text" name="name_label" class="form-control" value="{{ old('name_label') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name Placeholder</label>
                        <input type="text" name="name_placeholder" class="form-control" value="{{ old('name_placeholder') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Label</label>
                        <input type="text" name="email_label" class="form-control" value="{{ old('email_label') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Placeholder</label>
                        <input type="text" name="email_placeholder" class="form-control" value="{{ old('email_placeholder') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Label</label>
                        <input type="text" name="phone_label" class="form-control" value="{{ old('phone_label') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Placeholder</label>
                        <input type="text" name="phone_placeholder" class="form-control" value="{{ old('phone_placeholder') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Message Label</label>
                        <input type="text" name="message_label" class="form-control" value="{{ old('message_label') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Message Placeholder</label>
                        <input type="text" name="message_placeholder" class="form-control" value="{{ old('message_placeholder') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" rows="5">{{ old('description') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
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
