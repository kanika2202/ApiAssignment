@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="text-center fw-bold mb-4">ALL PRODUCTS</h2>

    {{-- ១. របារ Search និង Sort --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-8 text-end">
            <select class="form-select w-auto d-inline-block">
                <option>Name (A-Z)</option>
            </select>
        </div>
    </div>

    {{-- ២. ប៊ូតុង Category Filter (Horizontal Scroll) --}}
    <div class="d-flex overflow-auto gap-2 mb-4 pb-2" style="white-space: nowrap; scrollbar-width: none;">
        @foreach($categories as $cat)
            <a href="{{ route('front.category.products', $cat->id) }}" 
               class="btn {{ $category->id == $cat->id ? 'btn-dark' : 'btn-outline-dark' }} px-4 rounded-2">
                {{ $cat->CategoryName }}
            </a>
        @endforeach
    </div>

    {{-- ៣. បញ្ជីផលិតផល --}}
    <div class="row g-3">
        @foreach($products as $p)
        <div class="col-6 col-md-3">
            <div class="card border shadow-sm rounded-3 h-100">
                <div class="p-3 bg-light text-center">
                    <img src="{{ asset('img/product/'.$p->ProductImage) }}" style="height:150px; object-fit:contain;">
                </div>
                <div class="card-body p-2">
                    <h6 class="fw-bold small mb-1">{{ $p->ProductName }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-danger fw-bold">${{ number_format($p->Price, 2) }}</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-dark btn-sm p-1 px-2"><i class="bi bi-cart"></i></button>
                            <button class="btn btn-outline-dark btn-sm p-1 px-2"><i class="bi bi-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection