@extends('backend.app')

@section('title', 'Already')

@section('content')

<div class="container-fluid mt-4">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Already</h4>
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

            <form action="{{ route('admin.already.update', $already->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', optional($already)->title) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Tags (JSON Arrays)</label>

                        @php
                            $heads = old('tag_head', is_array(optional($already)->tag_head) ? optional($already)->tag_head : []);
                            $bodies = old('tag_body', is_array(optional($already)->tag_body) ? optional($already)->tag_body : []);
                            $numbers = old('tag_number', is_array(optional($already)->tag_number) ? optional($already)->tag_number : []);

                            $rowsCount = max(count($heads ?: []), count($bodies ?: []), count($numbers ?: []), 1);
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="alreadyTagsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30%">Tag Head</th>
                                        <th style="width: 45%">Tag Body</th>
                                        <th style="width: 20%">Tag Number</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < $rowsCount; $i++)
                                        <tr>
                                            <td>
                                                <input type="text" name="tag_head[]" class="form-control" value="{{ $heads[$i] ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text" name="tag_body[]" class="form-control" value="{{ $bodies[$i] ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text" name="tag_number[]" class="form-control" value="{{ $numbers[$i] ?? '' }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm already-remove-row" {{ $i === 0 ? 'disabled' : '' }}>
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm" id="alreadyAddRow">Add More</button>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" rows="6">{{ old('description', optional($already)->description) }}</textarea>
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </div>
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
$(document).ready(function () {
    $('.summernote').summernote({
        height: 240,
        placeholder: 'Write description here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold','underline','italic']],
            ['para', ['ul','ol','paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen','codeview']]
        ]
    });

    $('#alreadyAddRow').on('click', function () {
        $('#alreadyTagsTable tbody').append(`
            <tr>
                <td><input type="text" name="tag_head[]" class="form-control" value=""></td>
                <td><input type="text" name="tag_body[]" class="form-control" value=""></td>
                <td><input type="text" name="tag_number[]" class="form-control" value=""></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm already-remove-row">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `);
    });

    $('body').on('click', '.already-remove-row', function () {
        const row = $(this).closest('tr');
        const tbody = row.closest('tbody');

        row.remove();

        // Keep at least one row.
        if (tbody.find('tr').length === 0) {
            $('#alreadyAddRow').trigger('click');
            tbody.find('.already-remove-row').first().prop('disabled', true);
        } else {
            tbody.find('.already-remove-row').prop('disabled', false);
            tbody.find('.already-remove-row').first().prop('disabled', true);
        }
    });
});
</script>
@endpush
