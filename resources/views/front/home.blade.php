<style>
    /* តុបតែង Product Card ឱ្យមានចលនា (Hover Effect) */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #f0f0f0 !important;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    /* តុបតែងរូបភាពផលិតផលឱ្យមានផ្ទៃខាងក្រោយមូលស្អាត */
    .bg-light-custom {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    /* តុបតែងប៊ូតុង Pagination របស់ Bootstrap ឱ្យទៅជារាងមូល */
    .pagination {
        gap: 5px;
    }
    .pagination .page-item .page-link {
        border-radius: 50% !important;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        border: 1px solid #eee;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background-color: #000;
        border-color: #000;
        color: #fff;
    }
    
    /* Category Card Hover */
    .category-link .card {
        transition: 0.3s;
    }
    .category-link:hover .card {
        background-color: #000 !important;
        color: #fff !important;
    }
    .category-link:hover h6 {
        color: #fff !important;
    }
</style>
@extends('layouts.app')

@section('title','Home')

@section('content')

{{-- ================= HERO ================= --}}
<div class="p-5 mb-5 bg-white rounded-4 shadow-sm border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);">
    <div class="row align-items-center">
        <div class="col-md-6">
            <span class="badge bg-soft-dark text-dark mb-2 px-3 py-2 rounded-pill border">New Collection 2026</span>
            <h1 class="display-4 fw-bold mb-3">Glow Your Skin <br><span class="text-primary">Naturally</span></h1>
            <p class="text-muted fs-5 mb-4">Discover the best skincare products curated just for your unique beauty needs.</p>
            <a href="#" class="btn btn-dark rounded-pill px-5 py-3 shadow">Shop Now <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        <div class="col-md-6 text-center mt-4 mt-md-0">
            <img src="{{ asset('banner.png') }}" class="img-fluid rounded-4 shadow-lg">
        </div>
    </div>
</div>

{{-- ================= CATEGORIES ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Top Categories</h4>
    <a href="{{ route('front.categories.index') }}" class="text-decoration-none text-dark fw-bold small">View All <i class="bi bi-chevron-right"></i></a>
</div>

<div class="row g-3 mb-5">
    @foreach($categories as $c)
    <div class="col-6 col-md-3">
        <a href="{{ route('front.category.products', $c->id) }}" class="text-decoration-none text-dark category-link">
            <div class="card border-0 shadow-sm text-center p-3 rounded-4">

                <img src="{{ asset('img/product/'.$c->CategoryImage) }}" height="80" class="mb-2" style="object-fit: contain;">

                <h6>{{ $c->CategoryName }}</h6>

            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- ================= PRODUCTS ================= --}}
<h4 class="fw-bold mb-4">New Arrivals</h4>

<div class="row g-3 mb-4">
    @foreach($products as $p)
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden product-card bg-white">
            {{-- Image Section with Light Background --}}
            <div class="p-3 bg-light-custom text-center position-relative">
                <img src="{{ asset('img/product/'.$p->ProductImage) }}" 
                     style="height:180px; object-fit: contain;" 
                     class="img-fluid">
                <span class="position-absolute top-0 start-0 m-3 badge bg-white text-dark border shadow-sm rounded-pill">New</span>
            </div>

            <div class="card-body p-3 d-flex flex-column">
                <h6 class="fw-bold text-dark mb-1" style="height: 40px; overflow: hidden; font-size: 0.95rem;">
                    {{ $p->ProductName }}
                </h6>
                <p class="text-muted extra-small mb-2" style="font-size: 0.8rem;"><i class="bi bi-tag"></i> ID: {{ $p->CategoryID }}</p>

                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold text-danger fs-5">${{ number_format($p->Price, 2) }}</span>
                        <button class="btn btn-outline-secondary btn-sm rounded-circle border-0 bg-light shadow-sm text-dark">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="mt-auto d-flex gap-2 align-items-stretch">
                <a class="btn btn-dark pill flex-grow-1 btn-sm py-2"
                  >
                  Detail
                </a>

                {{-- AJAX button (no need form) --}}
                <button type="button"
                        class="btn btn-success pill btn-sm py-2 px-3 flex-shrink-0 js-add-to-cart"
                        
                        data-name="{{ $p->ProductName }}">
                  + Add
                </button>
              </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ================= PAGINATION LINKS ================= --}}
<div class="d-flex justify-content-center mt-5 mb-5">
    {{ $products->links() }}
</div>

{{-- ================= PROMOTION ================= --}}
<div class="p-5 bg-dark text-white rounded-4 text-center shadow-lg mb-5" style="background-image: url('https://www.transparenttextures.com/patterns/dark-matter.png');">
    <h2 class="fw-bold">Special Offer 🔥</h2>
    <p class="opacity-75 fs-5">Get up to <span class="text-warning fw-bold">20% off</span> for all premium skincare items.</p>
    <a href="#" class="btn btn-light rounded-pill px-5 py-2 fw-bold mt-2">Claim Coupon</a>
</div>

@endsection