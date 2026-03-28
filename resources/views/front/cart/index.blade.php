@extends('layouts.app')

@section('title','Your Cart')
@section('hero_title','Your Shopping Cart')
@section('hero_subtitle','Update quantities, remove items, and checkout')
@section('hero_action')
  <a class="btn btn-outline-dark pill px-4" href="{{ route('front.categories.index') }}">
    <i class="bi bi-grid me-1"></i> Continue Shopping
  </a>
@endsection

@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cart</li>
    </ol>
  </nav>
@endsection

@section('content')

@php
  $cartItems = $cart ?? [];
  $subtotal = 0;
  foreach($cartItems as $it){
    $subtotal += ((float)$it['price']) * ((int)$it['qty']);
  }
@endphp

@if(count($cartItems) === 0)
  <div class="alert alert-light border rounded-4 p-4">
    <div class="fw-bold">Your cart is empty.</div>
    <div class="text-muted">Add some products to cart then come back here.</div>
    <a href="{{ route('front.categories.index') }}" class="btn btn-dark pill mt-3">
      <i class="bi bi-bag-plus me-1"></i> Browse Products
    </a>
  </div>
{{--
  Tip: if you want, show featured products here
--}}
@else

  <div class="row g-3 g-lg-4">
    {{-- Cart items table --}}
    <div class="col-lg-8">
      <div class="card soft-card p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="fw-bold m-0">Items</h5>

          <form method="POST" action="{{ route('cart.clear') }}">
            @csrf
            <button class="btn btn-outline-dark pill btn-sm" type="submit">
              <i class="bi bi-trash3 me-1"></i> Clear Cart
            </button>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="text-muted small">
              <tr>
                <th style="min-width:280px;">Product</th>
                <th class="text-center">Price</th>
                <th style="width:170px;" class="text-center">Qty</th>
                <th class="text-end">Total</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach($cartItems as $pid => $it)
                @php
                  $img = !empty($it['image']) ? asset('img/product/'.$it['image']) : null;
                  $lineTotal = ((float)$it['price']) * ((int)$it['qty']);
                @endphp

                <tr id="row-{{ $pid }}">
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div class="rounded-4 overflow-hidden" style="width:72px;height:60px;box-shadow: 0 8px 18px rgba(0,0,0,.08);">
                        @if($img)
                          <img src="{{ $img }}" style="width:100%;height:100%;object-fit:cover;" alt="img">
                        @else
                          <div class="noimg" style="height:60px;">No Image</div>
                        @endif
                      </div>

                      <div>
                        <div class="fw-bold line-clamp-2">{{ $it['name'] }}</div>
                        <div class="text-muted small">Product ID: #{{ $pid }}</div>
                      </div>
                    </div>
                  </td>

                  <td class="text-center">
                    <div class="fw-semibold">${{ number_format($it['price'],2) }}</div>
                  </td>

                  <td class="text-center">
                    <div class="input-group justify-content-center" style="max-width:160px;margin:auto;">
                      <button class="btn btn-outline-dark pill js-qty-minus" type="button" data-id="{{ $pid }}">-</button>

                      <input class="form-control text-center pill js-qty"
                             type="number" min="1"
                             value="{{ (int)$it['qty'] }}"
                             data-id="{{ $pid }}">

                      <button class="btn btn-outline-dark pill js-qty-plus" type="button" data-id="{{ $pid }}">+</button>
                    </div>
                  </td>

                  <td class="text-end">
                    <div class="fw-bold">$<span class="js-line-total" data-id="{{ $pid }}">{{ number_format($lineTotal,2) }}</span></div>
                  </td>

                  <td class="text-end">
                    <button class="btn btn-outline-danger pill btn-sm js-remove" type="button"
                            data-id="{{ $pid }}"
                            data-url="{{ route('cart.remove',$pid) }}">
                      <i class="bi bi-x-lg me-1"></i> Remove
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>

          </table>
        </div>
      </div>
    </div>

    {{-- Summary --}}
    <div class="col-lg-4">
      <div class="card soft-card p-3 p-md-4">
        <h5 class="fw-bold mb-3">Order Summary</h5>

        <div class="d-flex justify-content-between text-muted">
          <span>Subtotal</span>
          <span>$<span id="subtotal">{{ number_format($subtotal,2) }}</span></span>
        </div>

        <div class="d-flex justify-content-between text-muted mt-2">
          <span>Shipping</span>
          <span>Free</span>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
          <span class="fw-bold">Total</span>
          <span class="fw-bold fs-5">$<span id="total">{{ number_format($subtotal,2) }}</span></span>
        </div>

        <a href="{{ url('/checkout') }}" class="btn btn-dark pill w-100 mt-3 py-2">
          <i class="bi bi-credit-card me-1"></i> Checkout
        </a>

        <div class="text-muted small mt-3">
          <i class="bi bi-shield-check me-1"></i> Secure payment • Easy returns
        </div>
      </div>

      <div class="card soft-card p-3 p-md-4 mt-3">
        <div class="fw-bold mb-2">Have a coupon?</div>
        <div class="input-group">
          <input class="form-control pill" placeholder="Enter code" />
          <button class="btn btn-outline-dark pill">Apply</button>
        </div>
        <div class="text-muted small mt-2">* Coupon module optional</div>
      </div>
    </div>
  </div>

@endif

@endsection

@push('scripts')
<script>
  async function updateQty(productId, qty){
    const url = `{{ url('/cart/update') }}/${productId}`;

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({ qty })
    });

    const data = await res.json().catch(()=> ({}));
    if(!res.ok || !data.ok) throw new Error(data.message || 'Update failed');
    return data;
  }

  // +/- buttons
  document.querySelectorAll('.js-qty-minus').forEach(btn=>{
    btn.addEventListener('click', async ()=>{
      const id = btn.dataset.id;
      const input = document.querySelector(`.js-qty[data-id="${id}"]`);
      const qty = Math.max(1, parseInt(input.value||1) - 1);
      input.value = qty;

      try{
        const data = await updateQty(id, qty);
        document.querySelector(`.js-line-total[data-id="${id}"]`).innerText = data.line_total;
        document.getElementById('subtotal').innerText = data.subtotal;
        document.getElementById('total').innerText = data.subtotal;
        showCartToast(data.message);
      }catch(e){
        showCartToast('⚠️ ' + e.message);
      }
    });
  });

  document.querySelectorAll('.js-qty-plus').forEach(btn=>{
    btn.addEventListener('click', async ()=>{
      const id = btn.dataset.id;
      const input = document.querySelector(`.js-qty[data-id="${id}"]`);
      const qty = Math.max(1, parseInt(input.value||1) + 1);
      input.value = qty;

      try{
        const data = await updateQty(id, qty);
        document.querySelector(`.js-line-total[data-id="${id}"]`).innerText = data.line_total;
        document.getElementById('subtotal').innerText = data.subtotal;
        document.getElementById('total').innerText = data.subtotal;
        showCartToast(data.message);
      }catch(e){
        showCartToast('⚠️ ' + e.message);
      }
    });
  });

  // input change (manual typing)
  document.querySelectorAll('.js-qty').forEach(input=>{
    input.addEventListener('change', async ()=>{
      const id = input.dataset.id;
      const qty = Math.max(1, parseInt(input.value||1));
      input.value = qty;

      try{
        const data = await updateQty(id, qty);
        document.querySelector(`.js-line-total[data-id="${id}"]`).innerText = data.line_total;
        document.getElementById('subtotal').innerText = data.subtotal;
        document.getElementById('total').innerText = data.subtotal;
        showCartToast(data.message);
      }catch(e){
        showCartToast('⚠️ ' + e.message);
      }
    });
  });

  // remove item
  document.querySelectorAll('.js-remove').forEach(btn=>{
    btn.addEventListener('click', async ()=>{
      const id = btn.dataset.id;
      const url = btn.dataset.url;

      if(!confirm('Remove this item?')) return;

      try{
        const res = await fetch(url, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          }
        });

        const data = await res.json().catch(()=> ({}));
        if(!res.ok || !data.ok) throw new Error(data.message || 'Remove failed');

        // remove row
        const row = document.getElementById(`row-${id}`);
        if(row) row.remove();

        // update totals
        document.getElementById('subtotal').innerText = data.subtotal;
        document.getElementById('total').innerText = data.subtotal;

        // if no more rows -> reload to show empty state
        if(document.querySelectorAll('tbody tr').length === 0){
          location.reload();
        }

        showCartToast(data.message);
      }catch(e){
        showCartToast('⚠️ ' + e.message);
      }
    });
  });
</script>
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // បង្កើត Function សម្រាប់ Update
    function updateCart(id, qty) {
        $.ajax({
            url: `{{ url('/cart/update') }}/${id}`,
            type: 'PATCH', // ត្រូវនឹង Route::patch ក្នុង web.php
            data: {
                _token: '{{ csrf_token() }}',
                qty: qty
            },
            success: function(response) {
                if (response.ok) {
                    // Update លេខនៅលើ Input
                    $(`.js-qty[data-id="${id}"]`).val(qty);
                    // Update តម្លៃ Line Total ($)
                    $(`.js-line-total[data-id="${id}"]`).text(response.line_total);
                    // Update Subtotal និង Total ខាងស្តាំ
                    $('#subtotal').text(response.subtotal);
                    $('#total').text(response.subtotal);
                    
                    console.log(response.message);
                }
            },
            error: function(xhr) {
                alert('Error updating cart');
            }
        });
    }

    // ចុចប៊ូតុង ដក (-)
    $('.js-qty-minus').on('click', function() {
        let id = $(this).data('id');
        let input = $(`.js-qty[data-id="${id}"]`);
        let currentQty = parseInt(input.value || input.val());
        if (currentQty > 1) {
            updateCart(id, currentQty - 1);
        }
    });

    // ចុចប៊ូតុង បូក (+)
    $('.js-qty-plus').on('click', function() {
        let id = $(this).data('id');
        let input = $(`.js-qty[data-id="${id}"]`);
        let currentQty = parseInt(input.value || input.val());
        updateCart(id, currentQty + 1);
    });

    // ប៊ូតុង លុប (Remove)
    $('.js-remove').on('click', function() {
        let id = $(this).data('id');
        let url = $(this).data('url');

        if (confirm('តើអ្នកពិតជាចង់លុបទំនិញនេះមែនទេ?')) {
            $.ajax({
                url: url,
                type: 'DELETE', // ត្រូវនឹង Route::delete ក្នុង web.php
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.ok) {
                        $(`#row-${id}`).remove(); // លុប Row ចេញពី Table
                        $('#subtotal').text(response.subtotal);
                        $('#total').text(response.subtotal);

                        // បើអស់ទំនិញ ឱ្យវា Reload ដើម្បីបង្ហាញថា Cart Empty
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    }
                }
            });
        }
    });
});
</script>