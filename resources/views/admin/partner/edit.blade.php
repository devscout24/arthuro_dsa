@extends('backend.app')

@section('title', 'Edit Partner')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm border-0 rounded-3">

        {{-- Card Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Partner</h4>
            <a href="{{ route('admin.partner.index') }}" class="btn btn-light btn-sm">
                Back to List
            </a>
        </div>

        {{-- Card Body --}}
        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row justify-content-center">

                    <div class="col-md-6">

                        {{-- Upload New Image --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload New Image</label>
                            <input 
                                type="file" 
                                name="image" 
                                class="form-control form-control-lg"
                                onchange="previewImage(event)"
                            >
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            {{-- Preview --}}
                            <div class="mt-3 text-center">
                                <img id="preview" width="150" class="img-fluid rounded shadow-sm" style="display:none;">
                            </div>
                        </div>

                        {{-- Current Image --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current Image</label>
                            <div class="border rounded p-2 text-center bg-light">
                                @if($partner->image)
                                    <img src="{{ asset('images/'.$partner->image) }}" width="150" class="img-fluid rounded shadow-sm">
                                @else
                                    <p class="text-muted mb-0">No Image</p>
                                @endif
                            </div>
                        </div>

                        {{-- Update Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save me-1"></i> Update Partner
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function(){
        let output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush