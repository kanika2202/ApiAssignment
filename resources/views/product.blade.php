@extends('layouts.admin')
@section('title','Create Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Create Product</h4>
    <a href="{{ url('/productList') }}" class="btn btn-outline-dark btn-sm">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Product Form</strong>
        <div class="text-muted small">Create product with category + price + optional image</div>
    </div>

    <div class="card-body">
        <form action="{{ url('/productStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="CategoryID" class="form-select">
                    @foreach($Categories as $Category)
                        <option value="{{ $Category->id }}">{{ $Category->CategoryName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="productName" class="form-control" placeholder="Enter product name" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" placeholder="0.00" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image (optional)</label>
                <input type="file" name="productImage" class="form-control" accept="image/*" onchange="previewImg(event,'proPreview')">
                <div class="mt-2">
                    <img id="proPreview" src="" class="rounded border d-none" style="width:140px; height:auto;">
                </div>
            </div>

            <button class="btn btn-primary">Save Product</button>
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
