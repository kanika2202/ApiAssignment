@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')

<div class="container">
    <h3 class="mb-4 fw-bold">Add New Product</h3>

    <form action="{{ url('/productStore') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="CategoryID" class="form-select" required>
    <option value="">-- Select Category --</option>
    @foreach($Categories as $cat)
        <option value="{{ $cat->id }}">
            {{ $cat->CategoryName }}
        </option>
    @endforeach
</select>
        </div>

        {{-- Product Name --}}
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="productName" class="form-control" required>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="productImage" class="form-control">
        </div>

        {{-- Discount --}}
        <div class="mb-3">
            <label class="form-label">Discount (%)</label>
            <input type="number" 
                   name="discount_percent" 
                   class="form-control" 
                   min="0" 
                   max="100" 
                   value="0">
        </div>

        {{-- Promotion Checkbox --}}
        <div class="form-check mb-3">
            <input type="checkbox" 
                   name="is_promo" 
                   class="form-check-input" 
                   id="promoCheck">
            <label class="form-check-label" for="promoCheck">
                Set as Promotion
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Save Product
        </button>

        <a href="{{ url('/productList') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</div>

@endsection