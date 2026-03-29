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