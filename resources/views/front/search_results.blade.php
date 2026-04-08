@extends('layouts.app')

@section('title', 'លទ្ធផលស្វែងរក: ' . $query)

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold">🔍 លទ្ធផលស្វែងរកសម្រាប់: <span class="text-warning">"{{ $query }}"</span></h4>
    
    @if($products->isEmpty())
        <div class="text-center py-5 shadow-sm rounded-4 bg-white">
            <i class="bi bi-search fs-1 text-muted"></i>
            <p class="mt-3 text-muted">មិនមានទិន្នន័យដែលអ្នកចង់រកឡើយ។</p>
            <a href="/" class="btn btn-warning rounded-pill px-4 fw-bold">ត្រឡប់ទៅដើមវិញ</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($products as $p)
                <div class="col-6 col-md-3">
                    <div class="card product-card rounded-4 overflow-hidden h-100 shadow-sm border-0">
                        {{-- Discount Badge --}}
                        @if($p->discount_percent > 0)
                            <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 fw-bold"
                                 style="z-index: 10; border-bottom-right-radius: 15px; font-size: 0.8rem;">
                                -{{ $p->discount_percent }}% OFF
                            </div>
                        @endif

                        <div class="bg-light-custom text-center p-3" style="background-color: #FFF9E6;">
                            <img src="{{ asset('img/product/'.$p->ProductImage) }}" style="height:160px; object-fit: contain;">
                        </div>

                        <div class="card-body">
                            <h6 class="fw-bold">{{ $p->ProductName }}</h6>
                            <p class="text-muted small mb-2">{{ $p->category->CategoryName ?? 'General' }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    @if($p->discount_percent > 0)
                                        <span class="text-muted text-decoration-line-through small">
                                            ${{ number_format($p->Price, 2) }}
                                        </span>
                                        <span class="fw-bold text-warning ms-1">
                                            ${{ number_format($p->Price - ($p->Price * $p->discount_percent / 100), 2) }}
                                        </span>
                                    @else
                                        <span class="fw-bold text-warning">
                                            ${{ number_format($p->Price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm">❤</button>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a class="btn btn-outline-warning btn-sm w-100 rounded-pill" href="{{ route('products.show', $p->id) }}">Detail</a>
                                <button type="button"
                                        class="btn btn-warning btn-sm rounded-pill px-3 flex-shrink-0 js-add-to-cart"
                                        data-url="{{ route('cart.add', $p->id) }}"
                                        data-name="{{ $p->ProductName }}">
                                  + Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->appends(['query' => $query])->links() }}
        </div>
    @endif
</div>

{{-- បន្ថែម Script ដើម្បីឱ្យប៊ូតុង Add to Cart ដើរក្នុងទំព័រ Search ដែរ --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.js-add-to-cart').on('click', function(e) {
        e.preventDefault();
        let url = $(this).data('url');
        let button = $(this);
        button.prop('disabled', true).html('...');

        $.ajax({
            url: url,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', qty: 1 },
            success: function(response) {
                if(response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ជោគជ័យ!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    $('.cart-count-badge').text(response.cart_count);
                }
            },
            complete: function() {
                button.prop('disabled', false).html('+ Add');
            }
        });
    });
});
</script>
@endpush
@endsection