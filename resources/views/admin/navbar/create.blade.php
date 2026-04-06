@extends('backend.app')

@section('title', 'Add Navbar')

@section('content')

    <div class="container-fluid mt-4">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Add Navbar</h4>
                <a href="{{ route('admin.navbar.index') }}" class="btn btn-secondary btn-sm">Back</a>
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

                <form action="{{ route('admin.navbar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control" onchange="previewLogo(event)">
                            @error('logo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="mt-3" style="display:none" id="logoPreviewWrapper">
                                <div class="mb-2">Logo Preview</div>
                                <img id="logoPreview" width="140" class="img-fluid rounded">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Home (Link Text)</label>
                            <input type="text" name="home" value="{{ old('home') }}" class="form-control" placeholder="Home">
                            @error('home')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">For (Link Text)</label>
                            <input type="text" name="for" value="{{ old('for') }}" class="form-control" placeholder="For Families">
                            @error('for')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Story (Link Text)</label>
                            <input type="text" name="story" value="{{ old('story') }}" class="form-control" placeholder="Our Story">
                            @error('story')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Waitlist Button (Text)</label>
                            <input type="text" name="waitlist" value="{{ old('waitlist') }}" class="form-control" placeholder="Join the Waitlist">
                            @error('waitlist')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
function previewLogo(event) {
    let file = event.target.files && event.target.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function() {
        document.getElementById('logoPreview').src = reader.result;
        document.getElementById('logoPreviewWrapper').style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
