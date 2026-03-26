@extends('layouts.admin')
@section('title','Edit Banner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Edit Banner</h4>
    <a href="{{ route('banner.list') }}" class="btn btn-outline-dark btn-sm">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Update Banner</strong>
        <div class="text-muted small">Update info and replace image if needed</div>
    </div>

    <div class="card-body">
        <form action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $Banner->id }}">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="Title" class="form-control" value="{{ $Banner->Title }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link</label>
                    <input type="text" name="Link" class="form-control" value="{{ $Banner->Link }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="SortOrder" class="form-control" value="{{ $Banner->SortOrder }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Active</label>
                    <select name="IsActive" class="form-select">
                        <option value="1" {{ $Banner->IsActive ? 'selected':'' }}>Yes</option>
                        <option value="0" {{ !$Banner->IsActive ? 'selected':'' }}>No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div>
                    @if($Banner->BannerImage)
                        <img src="{{ asset('img/banner/'.$Banner->BannerImage) }}" class="rounded border" width="200">
                    @else
                        <span class="badge text-bg-secondary">No Image</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image (optional)</label>
                <input type="file" name="BannerImage" class="form-control" accept="image/*" onchange="previewImg(event,'bannerEditPreview')">
                <div class="mt-2">
                    <img id="bannerEditPreview" src="" class="rounded border d-none" style="width:200px;height:auto;">
                </div>
            </div>

            <button class="btn btn-primary">Save Changes</button>
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
