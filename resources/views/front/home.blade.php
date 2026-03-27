<style>
/* ================= GLOBAL ================= */
body {
    background-color: #FFF9E6;
}

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

/* ================= BUTTON ================= */
.btn-main {
    background: #f4b400;
    border: none;
    color: #000;
}

.btn-main:hover {
    background: #e0a800;
}

/* ================= CATEGORY ================= */
.category-link .card {
    background: #fffdf5;
    border: 1px solid #f3e5ab;
    transition: 0.3s;
}

.category-link:hover .card {
    background: #f4b400;
    color: #000;
}

/* ================= PAGINATION ================= */
.pagination .page-link {
    border-radius: 50% !important;
    width: 40px;
    height: 40px;
    background: #fff3cd;
    border: none;
    color: #000;
    font-weight: bold;
}

.pagination .active .page-link {
    background: #f4b400;
}

/* ================= PROMO ================= */
.promo {
    background: linear-gradient(135deg, #f4b400, #ffd54f);
    border-radius: 20px;
}
</style>

@extends('layouts.app')

@section('title','Home')

@section('content')
{{------------------------------slideshow---------------------------}}
<div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">

    {{-- Indicators --}}
    <div class="carousel-indicators">
        @foreach($banners as $key => $b)
            <button type="button"
                data-bs-target="#heroCarousel"
                data-bs-slide-to="{{ $key }}"
                class="{{ $key == 0 ? 'active' : '' }}">
            </button>
        @endforeach
    </div>

    {{-- Slides --}}
    <div class="carousel-inner rounded-4 shadow-sm hero-section">

        @foreach($banners as $key => $b)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <div class="p-5">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <h1 class="fw-bold">{{ $b->Title }}</h1>

                        @if($b->Link)
                            <a href="{{ $b->Link }}" class="btn btn-main rounded-pill px-4">
                                Shop Now
                            </a>
                        @endif
                    </div>

                    <div class="col-md-6 text-center">
                        <img src="{{ asset('img/banner/'.$b->BannerImage) }}"
                             class="img-fluid rounded-4">
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Controls --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>

{{-- ================= CATEGORY ================= --}}
<h4 class="fw-bold mb-4">🌻 Categories</h4>

<div class="row g-3 mb-5">
@foreach($categories as $c)
    <div class="col-6 col-md-3">
        <a href="{{ route('front.category.products', $c->id) }}" class="category-link text-decoration-none text-dark">
            <div class="card p-3 text-center rounded-4 shadow-sm">
                <img src="{{ asset('img/product/'.$c->CategoryImage) }}" height="80" style="object-fit: contain;">
                <h6 class="mt-2">{{ $c->CategoryName }}</h6>
            </div>
        </a>
    </div>
@endforeach
</div>
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

{{-- ================= PRODUCTS ================= --}}
<h4 class="fw-bold mb-4 mt-5">🌼 New Products</h4>

<div class="row g-3">
@foreach($products as $p)
<div class="col-6 col-md-3">
    <div class="card product-card rounded-4 overflow-hidden h-100">
        {{-- Discount Badge --}}
            @if($p->discount_percent > 0)
            <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 fw-bold"
                 style="z-index: 10; border-bottom-right-radius: 15px;">
                -{{ $p->discount_percent }}% OFF
            </div>
            @endif
        <div class="bg-light-custom text-center p-3">
            <img src="{{ asset('img/product/'.$p->ProductImage) }}" style="height:160px;">
        </div>

        <div class="card-body">
            <h6>{{ $p->ProductName }}</h6>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        @if($p->discount_percent > 0)
            <!-- Original Price (line-through) -->
            <span class="text-muted text-decoration-line-through">
                ${{ number_format($p->Price, 2) }}
            </span>

            <!-- Discount Price -->
            <span class="fw-bold text-warning ms-2">
                ${{ number_format($p->Price - ($p->Price * $p->discount_percent / 100), 2) }}
            </span>
        @else
            <!-- Normal Price -->
            <span class="fw-bold text-warning">
                ${{ number_format($p->Price, 2) }}
            </span>
        @endif
    </div>

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

{{-- ================= PAGINATION ================= --}}
<div class="mt-5 text-center">
    {{ $products->links() }}
</div>



@endsection