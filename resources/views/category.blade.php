@extends('layouts.admin')
@section('title','Create Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Create Category</h4>
    <a href="{{ route('category.list') }}" class="btn btn-outline-dark btn-sm">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Category Form</strong>
        <div class="text-muted small">Create new category with optional image</div>
    </div>

    <div class="card-body">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="CategoryName" class="form-control"
                       value="{{ old('CategoryName') }}" placeholder="Enter category name">
            </div>

            <div class="mb-3">
                <label class="form-label">Category Image (optional)</label>
                <input type="file" name="CategoryImage" class="form-control" accept="image/*" onchange="previewImg(event,'catPreview')">
                <div class="mt-2">
                    <img id="catPreview" src="" class="rounded border d-none" style="width:120px; height:auto;">
                </div>
            </div>

            <button class="btn btn-primary">
                Save Category
            </button>
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
