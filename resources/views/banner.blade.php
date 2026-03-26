@extends('layouts.admin')
@section('title','Create Banner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Create Banner</h4>
    <a href="{{ route('banner.list') }}" class="btn btn-outline-dark btn-sm">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Banner Form</strong>
        <div class="text-muted small">Create banner image for homepage</div>
    </div>

    <div class="card-body">
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="Title" class="form-control" value="{{ old('Title') }}" placeholder="Banner title (optional)">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link (optional)</label>
                    <input type="text" name="Link" class="form-control" value="{{ old('Link') }}" placeholder="https://...">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="SortOrder" class="form-control" value="{{ old('SortOrder',0) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Active</label>
                    <select name="IsActive" class="form-select">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Banner Image</label>
                <input type="file" name="BannerImage" class="form-control" accept="image/*" onchange="previewImg(event,'bannerPreview')">
                <div class="mt-2">
                    <img id="bannerPreview" src="" class="rounded border d-none" style="width:200px;height:auto;">
                </div>
            </div>

            <button class="btn btn-primary">Save Banner</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImg(event, id){
    const img = document.getElementById(id);
    const file = event.target.files?.[0];
    if(!file){ img.classList.add('d-none'); img.src=""; return; }
    img.src = URL.createObjectURL(file);
    img.classList.remove('d-none');
}
</script>
@endpush
