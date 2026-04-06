@extends('backend.app')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Banner</h4>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary btn-sm">Back</a>
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

            <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Coming Soon --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coming Soon</label>
                        <input type="text" name="comming_soon" class="form-control" value="{{ old('comming_soon', $banner->comming_soon) }}" placeholder="Coming soon text">
                    </div>

                    {{-- Title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
                    </div>

                    {{-- Tagline --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $banner->tagline) }}" placeholder="Short tagline">
                    </div>

                    {{-- Button --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button" class="form-control" value="{{ old('button', $banner->button) }}" placeholder="Button label">
                    </div>

                    {{-- Career --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Career</label>
                        <input type="text" name="career" class="form-control" value="{{ old('career', $banner->career) }}" placeholder="Career">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote">{{ old('description', $banner->description) }}</textarea>
                    </div>

                    {{-- Images --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Banner Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple onchange="previewImages(event)">
                        @error('images')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @error('images.*')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <div class="mt-3">
                            <div class="mb-2">Current Images</div>
                            @php
                                $bannerImages = $banner->image ?? [];
                                if (!is_array($bannerImages)) {
                                    $bannerImages = json_decode((string) $bannerImages, true) ?? [];
                                }
                                $bannerImages = array_values(array_filter(array_map('trim', $bannerImages), fn($v) => $v !== ''));
                            @endphp

                            @if(count($bannerImages))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($bannerImages as $img)
                                        <div class="border rounded p-2 text-center">
                                            <img src="{{ str_starts_with($img, 'http://') || str_starts_with($img, 'https://') || str_starts_with($img, '//') ? $img : asset('images/'.ltrim($img,'/')) }}" width="120" class="img-fluid rounded shadow-sm" alt="banner">
                                            <input type="hidden" name="existing_images[]" value="{{ $img }}">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-existing-image">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted">No Image</div>
                            @endif
                        </div>

                        <div class="mt-3" style="display:none" id="previewWrapper">
                            <div class="mb-2">New Images Preview</div>
                            <div class="d-flex flex-wrap gap-2" id="previewList"></div>
                        </div>
                    </div>

                    {{-- Icons --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icons</label>
                        <div id="icon-wrapper">
                            {{-- Existing icons --}}
                            @if($banner->icons)
                                @foreach($banner->icons as $icon)
                                @php
                                    $iconPath = trim((string) $icon);
                                    if ($iconPath === '') {
                                        $iconSrc = '';
                                    } elseif (str_starts_with($iconPath, 'http://') || str_starts_with($iconPath, 'https://') || str_starts_with($iconPath, '//')) {
                                        $iconSrc = $iconPath;
                                    } elseif (str_starts_with($iconPath, 'storage/') || str_starts_with($iconPath, 'images/')) {
                                        $iconSrc = asset($iconPath);
                                    } elseif (str_starts_with($iconPath, 'icons/')) {
                                        $iconSrc = asset('images/' . $iconPath);
                                    } else {
                                        $iconSrc = asset('images/icons/' . $iconPath);
                                    }
                                @endphp
                                <div class="input-group mb-2">
                                    @if($iconSrc)
                                        <img src="{{ $iconSrc }}" width="50" class="me-2" alt="icon">
                                    @endif
                                    <input type="hidden" name="existing_icons[]" value="{{ $icon }}">
                                    <button type="button" class="btn btn-danger remove-icon">Remove</button>
                                </div>
                                @endforeach
                            @endif

                            {{-- Add new icons --}}
                            <div class="input-group mb-2">
                                <input type="file" name="icons[]" class="form-control">
                                <button type="button" class="btn btn-success add-icon">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Features</label>
                        <div id="feature-wrapper">
                            @if($banner->features)
                                @foreach($banner->features as $feature)
                                <div class="input-group mb-2">
                                    <input type="text" name="features[]" class="form-control" value="{{ $feature }}">
                                    <button type="button" class="btn btn-danger remove-feature">-</button>
                                </div>
                                @endforeach
                            @endif

                            {{-- Add new feature --}}
                            <div class="input-group mb-2">
                                <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                                <button type="button" class="btn btn-success add-feature">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function(){

    // Summernote
    $('.summernote').summernote({ height: 150 });

    // Add new icon input
    $(document).on('click', '.add-icon', function(){
        $('#icon-wrapper').append(`
            <div class="input-group mb-2">
                <input type="file" name="icons[]" class="form-control">
                <button type="button" class="btn btn-danger remove-icon">-</button>
            </div>
        `);
    });

    // Remove icon input or existing icon
    $(document).on('click', '.remove-icon', function(){
        $(this).closest('.input-group').remove();
    });

    // Remove existing image (removes its hidden existing_images[] too)
    $(document).on('click', '.remove-existing-image', function(){
        $(this).closest('.border').remove();
    });

    // Add new feature input
    $(document).on('click', '.add-feature', function(){
        $('#feature-wrapper').append(`
            <div class="input-group mb-2">
                <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                <button type="button" class="btn btn-danger remove-feature">-</button>
            </div>
        `);
    });

    // Remove feature input
    $(document).on('click', '.remove-feature', function(){
        $(this).closest('.input-group').remove();
    });

});
</script>

<script>
function previewImages(event) {
    let files = event.target.files;
    let previewWrapper = document.getElementById('previewWrapper');
    let previewList = document.getElementById('previewList');

    previewList.innerHTML = '';

    if (!files || files.length === 0) {
        previewWrapper.style.display = 'none';
        return;
    }

    Array.from(files).forEach((file) => {
        let reader = new FileReader();
        reader.onload = function(){
            let img = document.createElement('img');
            img.src = reader.result;
            img.width = 120;
            img.className = 'img-fluid rounded shadow-sm';
            previewList.appendChild(img);
        };
        reader.readAsDataURL(file);
    });

    previewWrapper.style.display = 'block';
}
</script>
@endpush