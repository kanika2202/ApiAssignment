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
                <img src="{{ $product->ProductImage 
                    ? asset('img/product/' . $product->ProductImage) 
                    : asset('img/default-flower.jpg') }}"
                     class="img-fluid rounded"
                     style="height: 200px; object-fit: cover;">
            </div>

            <div class="card-body pt-0">
                <h5 class="fw-bold">{{ $product->ProductName }}</h5>

                <small class="text-muted d-block">
                    category: {{ $product->category->CategoryName ?? 'Flowers' }}
                </small>

                @php
                    $finalPrice = $product->Price - ($product->Price * $product->discount_percent / 100);
                @endphp

                <div class="d-flex justify-content-between mt-2">

                    @if($product->discount_percent > 0)
                    <span class="text-danger text-decoration-line-through">
                        ${{ number_format($product->Price, 2) }}
                    </span>
                    @endif

                    <span class="text-warning fw-bold">
                        ${{ number_format($finalPrice, 2) }}
                    </span>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-main w-100">Detail</button>

                    <button type="button" 
                        class="btn btn-warning js-add-to-cart"
                        data-url="{{ route('cart.add', $product->id) }}"
                        data-name="{{ $product->ProductName }}">
                        Add
                    </button>
                </div>

            </div>
        </div>
    </div>

    @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">No promotions available 🌼</h5>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.js-add-to-cart').on('click', function(e) {
        e.preventDefault();
        
        let url = $(this).data('url');
        let productName = $(this).data('name');
        let button = $(this);

        // បង្ហាញ Loading បន្តិចលើប៊ូតុង
        button.prop('disabled', true).html('...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // ចាំបាច់សម្រាប់ Laravel
                qty: 1
            },
            success: function(response) {
                if(response.ok) {
                    // បង្ហាញសេចក្តីជូនដំណឹងស្អាតៗប្រើ SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'ជោគជ័យ!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                    // បើអ្នកមានកន្លែងបង្ហាញលេខក្នុង Cart Icon អាច Update នៅទីនេះ
                    $('.cart-count-badge').text(response.cart_count);
                }
            },
            error: function(xhr) {
                alert('មានបញ្ហាអ្វីមួយ! សូមព្យាយាមម្តងទៀត។');
            },
            complete: function() {
                // ដាក់ប៊ូតុងឱ្យមកសភាពដើមវិញ
                button.prop('disabled', false).html('+ Add');
            }
        });
    });
});
</script>