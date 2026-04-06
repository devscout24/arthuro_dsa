@extends('backend.app')

@section('title', 'Add Footer Down')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="mb-0" style="color: white">Add Footer Down</h4>
            <a href="{{ route('admin.footer-down.index') }}" class="btn btn-secondary btn-sm">Back</a>
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

            <form action="{{ route('admin.footer-down.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Privacy</label>
                    <input type="text" name="privacy" class="form-control" value="{{ old('privacy') }}" placeholder="Privacy link/text">
                </div>

                <div class="mb-3">
                    <label class="form-label">Terms</label>
                    <input type="text" name="terms" class="form-control" value="{{ old('terms') }}" placeholder="Terms link/text">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact') }}" placeholder="Contact link/text">
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
