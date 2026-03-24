@extends('layouts.admin')
@section('title','Edit Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Edit Category</h4>
    <a href="{{ route('category.list') }}" class="btn btn-outline-dark btn-sm">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Update Category</strong>
        <div class="text-muted small">Change name and (optional) replace image</div>
    </div>

    <div class="card-body">
        <form action="/categoryEdit" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $Category->id }}">
            <input type="hidden" name="oldCategoryImage" value="{{ $Category->CategoryImage }}">

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="categoryName" value="{{ $Category->CategoryName }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div>
                    @if($Category->CategoryImage)
                        <img src="{{ asset('img/product/'.$Category->CategoryImage) }}" class="rounded border" width="140">
                    @else
                        <span class="badge text-bg-secondary">No Image</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image (optional)</label>
                <input type="file" name="fileCategoryImage" class="form-control" accept="image/*" onchange="previewImg(event,'catEditPreview')">
                <div class="mt-2">
                    <img id="catEditPreview" src="" class="rounded border d-none" style="width:140px; height:auto;">
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

