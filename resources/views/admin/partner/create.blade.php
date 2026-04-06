@extends('backend.app')

@section('title', 'Add Partner')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Partner</h4>
            <a href="{{ route('admin.partner.index') }}" class="btn btn-primary btn-sm">
                Partner List
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

            <form action="{{ route('admin.partner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title (Only One Time)</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Images</label>

                            <input 
                                type="file" 
                                name="images[]" 
                                class="form-control"
                                multiple
                                required
                            >

                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('images.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Submit
                </button>

            </form>

        </div>

    </div>

</div>

@endsection