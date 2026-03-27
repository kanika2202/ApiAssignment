@extends('layouts.app')
@section('title', 'Special Promotions - Miss Sunflower')

@section('content')

<div class="text-center mb-5">
    <h2 class="fw-bold text-warning">🌻 Special Offers 🌻</h2>
    <p class="text-muted">Grab your favorite blooms at the best prices!</p>
</div>

<div class="row g-4">

    @forelse($products as $product)
    <div class="col-md-4 col-lg-3">
        <div class="card h-100 border-0 shadow-sm position-relative overflow-hidden">

            {{-- Discount Badge --}}
            @if($product->discount_percent > 0)
            <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 fw-bold"
                 style="z-index: 10; border-bottom-right-radius: 15px;">
                -{{ $product->discount_percent }}% OFF
            </div>
            @endif

            {{-- Product Image --}}
            <div class="text-center p-3">
                @if($product->ProductImage)
                    <img src="{{ asset('img/product/' . $product->ProductImage) }}"
                         class="img-fluid rounded"
                         style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('img/default-flower.jpg') }}"
                         class="img-fluid rounded"
                         style="height: 200px; object-fit: cover;">
                @endif
            </div>

            <div class="card-body text-left pt-0">
               {{-- Product Name --}}
                <h5 class="card-title fw-bold">
                    {{ $product->ProductName }}
                </h5>
                {{-- Category --}}
                <small class="text-muted text-uppercase mb-1 d-block">
                    category: {{ $product->category->CategoryName ?? 'Flowers' }}
                </small>

               

                {{-- Price Calculation --}}
                @php
                    $originalPrice = $product->Price;
                    $discount = $product->discount_percent;
                    $finalPrice = $originalPrice - ($originalPrice * $discount / 100);
                @endphp

                <div class="d-flex justify-content-between gap-2 mb-3 mt-2 align-items-center">

                    {{-- Old Price --}}
                    @if($discount > 0)
                    <span class="text-decoration-line-through  fs-6 text-danger">
                        ${{ number_format($originalPrice, 2) }}
                    </span>
                    @endif

                    {{-- New Price --}}
                    <span class="text-warning fw-bold fs-6">
                        ${{ number_format($finalPrice, 2) }}
                    </span>
                    <button class="btn btn-light rounded-circle shadow-sm">
                         ❤
                     </button>

                </div>

                {{-- Button --}}
                <a href="#" class="btn btn-warning w-100 rounded-pill fw-bold">
                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                </a>

            </div>
        </div>
    </div>
    @empty

    {{-- No Promotion --}}
    <div class="row g-4">

    @forelse($products as $product)
        <div class="col-md-4 col-lg-3">
            {{-- product card here --}}
        </div>

    @empty
    {{-- No Promotions Available --}}
        <div class="col-12">
            <div class="text-center py-5">
                <h5 class="text-muted">
                    No promotions available right now 🌼
                </h5>
            </div>
        </div>
    @endforelse

</div>

    @endforelse

</div>

{{-- Style --}}
<style>
    .card {
        transition: transform 0.3s ease;
        border-radius: 15px;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .btn-warning {
        background-color: #f4b400;
        border: none;
        color: white;
    }

    .btn-warning:hover {
        background-color: #d49d00;
        color: white;
    }
</style>

@endsection