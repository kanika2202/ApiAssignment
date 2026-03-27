@extends('layouts.app')
@section('content')
<style>
/* ================= HERO ================= */
.hero-section {
    background: linear-gradient(135deg, #ffffff 0%, #fff3b0 100%);
    border-radius: 20px;
    border: 1px solid #f3e5ab;
}
/* ================= PRODUCT CARD ================= */
.product-card {
    transition: 0.3s;
    border: 1px solid #f3e5ab !important;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(244,180,0,0.25);
}

.bg-light-custom {
    background-color: #FFF9E6;
    border-bottom: 1px solid #f3e5ab;
}
</style>

{{-- ================= HERO ================= --}}
<div class="p-5 mb-5 hero-section shadow-sm">
    <div class="row align-items-center">
        <div class="col-md-6">
            <span class="badge bg-light text-dark mb-3">🌼 New 2026</span>
            <h1 class="fw-bold display-5">
                Glow Your Skin <br>
                <span style="color:#f4b400;">Naturally</span>
            </h1>
            <p class="text-muted">Fresh beauty with sunflower energy 🌻</p>
            <a href="#" class="btn btn-main px-4 py-2 rounded-pill">
                Shop Now →
            </a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('banner.png') }}" class="img-fluid rounded-4">
        </div>
    </div>
</div>

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
    @foreach($categories as $cat)
    <a href="{{ route('front.category.products', $cat->id) }}"
        class="btn {{ isset($category) && $category->id == $cat->id ? 'btn-dark' : 'btn-outline-dark' }} px-4 rounded-2">
        {{ $cat->CategoryName }}
    </a>
@endforeach

    {{-- ៣. បញ្ជីផលិតផល --}}
    <div class="row g-3">
        <h2 class="text-center fw-bold mb-4">List Product</h2>
        @foreach($products as $p)
        <div class="col-6 col-md-3">
            <div class="card product-card rounded-4 overflow-hidden h-100">

        <div class="bg-light-custom text-center p-3">
            <img src="{{ asset('img/product/'.$p->ProductImage) }}" style="height:150px; object-fit: contain;">
        </div>

        <div class="card-body">
            <h6>{{ $p->ProductName }}</h6>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="fw-bold text-warning">${{ $p->Price }}</span>

                <button class="btn btn-light rounded-circle shadow-sm">
                    ❤
                </button>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-main w-100">Detail</button>
                <button class="btn btn-warning">+</button>
            </div>
        </div>

    </div>
        </div>
        @endforeach
    </div>
</div>
@endsection