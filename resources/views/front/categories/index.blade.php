@extends('layouts.app')

@section('title','Categories')
@section('hero_title','Browse Categories')
@section('hero_subtitle','Choose a category to explore our collection')

@section('content')
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h3 class="m-0 fw-bold text-dark">Categories</h3>
    <a class="btn btn-outline-dark pill px-4" href="{{ url('/') }}">
      <i class="bi bi-house me-1"></i> Back to Home
    </a>
  </div>

  <div class="row g-3 g-lg-4">
    @forelse($categories as $c)
      <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ url('/category/'.$c->id.'/products') }}" class="category-link text-decoration-none">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden text-center transition-card">
            
            {{-- Fixed 4:3 Aspect Ratio Image --}}
            <div class="ratio ratio-4x3 bg-light">
              @if($c->CategoryImage)
                <img src="{{ asset('img/product/'.$c->CategoryImage) }}" 
                     class="card-img-top object-fit-cover" 
                     alt="{{ $c->CategoryName }}">
              @else
                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                  <i class="bi bi-image fs-2"></i>
                  <span class="small mt-1">No Image</span>
                </div>
              @endif
            </div>

            <div class="card-body p-3 bg-white">
              <h6 class="card-title fw-bold text-dark text-truncate mb-1">{{ $c->CategoryName }}</h6>
              <p class="text-muted small mb-3">View Products</p>
              <div class="btn btn-sm btn-outline-warning pill w-100 fw-bold">Explore</div>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12 text-center py-5">
        <div class="bg-white p-5 rounded-4 shadow-sm border border-dashed">
          <i class="bi bi-search display-4 text-muted"></i>
          <h5 class="mt-3 fw-bold">No categories available yet.</h5>
        </div>
      </div>
    @endforelse
  </div>

<style>
.transition-card {
    transition: all 0.3s ease;
    border: 1px solid transparent !important;
}

.category-link:hover .transition-card {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    border-color: #f4b400 !important;
}

.category-link:hover .btn-outline-warning {
    background-color: #f4b400;
    color: #fff;
}

.object-fit-cover {
    object-fit: cover;
}

.border-dashed { border-style: dashed !important; }
</style>
@endsection