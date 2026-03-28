@extends('layouts.app')

@section('title', $product->ProductName)

@section('hero_title', $product->ProductName)
@section('hero_subtitle', 'Product details and quick add to cart')
@section('hero_action')
  <a class="btn btn-outline-dark pill px-4" href="{{ url()->previous() }}">
    <i class="bi bi-arrow-left me-1"></i> Back
  </a>
@endsection

@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('front.categories.index') }}" class="text-decoration-none">Categories</a></li>
      @if(isset($category))
        <li class="breadcrumb-item">
          <a href="{{ url('/category/'.$category->id.'/products') }}" class="text-decoration-none">
            {{ $category->CategoryName }}
          </a>
        </li>
      @endif
      <li class="breadcrumb-item active" aria-current="page">{{ $product->ProductName }}</li>
    </ol>
  </nav>
@endsection

@section('content')

  {{-- Top section: gallery + info --}}
  <div class="row g-3 g-lg-4">
    {{-- Gallery --}}
    <div class="col-lg-6">
      <div class="card soft-card p-3">
        {{-- Main image --}}
        <div class="rounded-4 overflow-hidden" style="box-shadow: var(--soft-shadow);">
          @php
            $mainImg = $product->ProductImage ? asset('img/product/'.$product->ProductImage) : null;
          @endphp

          @if($mainImg)
            <img id="mainImg" src="{{ $mainImg }}" class="w-100" style="height:420px;object-fit:cover;" alt="Product">
          @else
            <div class="noimg" style="height:420px;">No Image</div>
          @endif
        </div>

        {{-- Thumbnails (optional) --}}
        @php
          // Optional: if you have product_images table relation -> $images
          // else it will show only main image
          $thumbs = collect([]);
          if($product->ProductImage) $thumbs->push(asset('img/product/'.$product->ProductImage));
          if(isset($images) && $images) {
            foreach($images as $img){
              // support column name: image/filename/path (edit as needed)
              $path = $img->image ?? $img->filename ?? $img->path ?? null;
              if($path) $thumbs->push(asset('img/product/'.$path));
            }
          }
          $thumbs = $thumbs->unique()->values();
        @endphp

        @if($thumbs->count() > 0)
          <div class="d-flex gap-2 mt-3 flex-wrap">
            @foreach($thumbs as $t)
              <button type="button"
                      class="btn p-0 border-0 rounded-4 overflow-hidden thumb-btn"
                      data-img="{{ $t }}"
                      style="width:84px;height:70px;box-shadow: 0 8px 18px rgba(0,0,0,.08);">
                <img src="{{ $t }}" style="width:100%;height:100%;object-fit:cover;" alt="thumb">
              </button>
            @endforeach
          </div>
        @endif

      </div>
    </div>

    {{-- Product info --}}
    <div class="col-lg-6">
      <div class="card soft-card p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-start gap-2">
          <div>
            <h3 class="fw-bold mb-1">{{ $product->ProductName }}</h3>
            <div class="text-muted small">
              <i class="bi bi-check-circle me-1"></i> In stock • Fast delivery
            </div>
          </div>
          <span class="badge bg-light text-dark border pill">Best Seller</span>
        </div>

        <hr class="my-3">

        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small mb-1">Price</div>
            <div class="fs-3 fw-bold">${{ number_format($product->Price, 2) }}</div>
          </div>
          <div class="text-end">
            <div class="text-muted small mb-1">Rating</div>
            <div class="fw-semibold">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star text-warning"></i>
              <span class="text-muted small ms-1">(4.0)</span>
            </div>
          </div>
        </div>

        {{-- Short description (optional) --}}
        <div class="mt-3 text-muted">
          {{ $product->Description ?? 'High quality product with modern design. Perfect for daily use and easy to order.' }}
        </div>

        <hr class="my-3">

        {{-- Qty + Add to cart --}}
        <div class="row g-2 align-items-end">
          <div class="col-5 col-md-4">
            <label class="form-label small text-muted mb-1">Quantity</label>
            <div class="input-group">
              <button type="button" class="btn btn-outline-dark pill" id="qtyMinus">-</button>
              <input type="number" id="qty" class="form-control text-center pill" value="1" min="1">
              <button type="button" class="btn btn-outline-dark pill" id="qtyPlus">+</button>
            </div>
          </div>

          <div class="col-7 col-md-8 d-flex gap-2">
            <button type="button"
                    class="btn btn-success pill w-100 py-2 js-add-to-cart"
                    data-url="{{ route('cart.add',$product->id) }}"
                    data-name="{{ $product->ProductName }}">
              <i class="bi bi-cart-plus me-1"></i> Add to Cart
            </button>

            <a href="{{ url('/cart') }}" class="btn btn-dark pill w-100 py-2">
              <i class="bi bi-bag-check me-1"></i> View Cart
            </a>
          </div>
        </div>

        {{-- Extra badges --}}
        <div class="d-flex flex-wrap gap-2 mt-3">
          <span class="badge bg-light text-dark border pill"><i class="bi bi-truck me-1"></i> Free Delivery</span>
          <span class="badge bg-light text-dark border pill"><i class="bi bi-shield-check me-1"></i> Secure Payment</span>
          <span class="badge bg-light text-dark border pill"><i class="bi bi-arrow-repeat me-1"></i> 7 Days Return</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabs --}}
  <div class="card soft-card mt-3 mt-lg-4 p-3 p-md-4">
    <ul class="nav nav-pills gap-2" id="prodTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active pill" data-bs-toggle="tab" data-bs-target="#tabDesc" type="button">Description</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link pill" data-bs-toggle="tab" data-bs-target="#tabShip" type="button">Shipping</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link pill" data-bs-toggle="tab" data-bs-target="#tabReview" type="button">Reviews</button>
      </li>
    </ul>

    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="tabDesc">
        <div class="text-muted">
          {!! nl2br(e($product->Description ?? 'No description yet. You can add description column later.')) !!}
        </div>
      </div>

      <div class="tab-pane fade" id="tabShip">
        <div class="text-muted">
          <ul class="mb-0">
            <li>Phnom Penh: 1–2 days</li>
            <li>Province: 2–4 days</li>
            <li>Cash on delivery / QR payment supported</li>
          </ul>
        </div>
      </div>

      <div class="tab-pane fade" id="tabReview">
        <div class="text-muted">
          Reviews module can be added later (table: reviews).  
          For now, show static sample:
          <div class="mt-3 p-3 rounded-4 border bg-light">
            <div class="fw-semibold">Sokha</div>
            <div class="small text-muted">Great product, fast delivery.</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Related products (optional) --}}
  @if(isset($related) && $related->count())
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
      <h5 class="m-0 fw-bold">Related Products</h5>
      <a class="btn btn-outline-dark pill btn-sm" href="{{ route('front.categories.index') }}">More</a>
    </div>

    <div class="row g-3">
      @foreach($related as $rp)
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card soft-card h-100">
            @if($rp->ProductImage)
              <img src="{{ asset('img/product/'.$rp->ProductImage) }}" class="thumb" alt="Related">
            @else
              <div class="noimg"><span class="small">No Image</span></div>
            @endif

            <div class="card-body d-flex flex-column">
              <div class="fw-bold line-clamp-2">{{ $rp->ProductName }}</div>
              <div class="text-muted small mb-2">${{ number_format($rp->Price,2) }}</div>

              <div class="mt-auto d-flex gap-2">
                <a class="btn btn-dark pill w-100" href="{{ url('product',$rp->id) }}">Detail</a>
                <button type="button"
                        class="btn btn-success pill w-100 js-add-to-cart"
                        data-url="{{ route('cart.add',$rp->id) }}"
                        data-name="{{ $rp->ProductName }}">
                  + Add
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

@endsection

@push('scripts')
<script>
  // thumbnail click
  document.querySelectorAll('.thumb-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const main = document.getElementById('mainImg');
      if(!main) return;
      main.src = btn.dataset.img;
    });
  });

  // qty +/- buttons
  const qtyInput = document.getElementById('qty');
  const minus = document.getElementById('qtyMinus');
  const plus  = document.getElementById('qtyPlus');

  if(minus && plus && qtyInput){
    minus.addEventListener('click', ()=>{
      const v = Math.max(1, parseInt(qtyInput.value || 1) - 1);
      qtyInput.value = v;
    });
    plus.addEventListener('click', ()=>{
      const v = parseInt(qtyInput.value || 1) + 1;
      qtyInput.value = v;
    });
  }

  // AJAX Add to cart + Toast (use qty)
  document.querySelectorAll('.js-add-to-cart').forEach(btn => {
    btn.addEventListener('click', async () => {
      const url = btn.dataset.url;
      const name = btn.dataset.name || "Item";
      const qty = qtyInput ? (parseInt(qtyInput.value || 1)) : 1;

      btn.disabled = true;
      const oldHtml = btn.innerHTML;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Adding';

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ qty })
        });

        if (!res.ok) throw new Error('Request failed');
        showCartToast( ${name} (x${qty}) added to cart!);
      } catch (e) {
        showCartToast(' Cannot add to cart. Please try again.');
      } finally {
        btn.disabled = false;
        btn.innerHTML = oldHtml;
      }
    });
  });
</script>
@endpush
