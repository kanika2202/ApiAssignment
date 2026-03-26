@extends('layouts.app')

@section('title','Categories')
@section('hero_title','Browse Categories')
@section('hero_subtitle','Choose a category to explore products')
@section('hero_action')
  <a class="btn btn-dark pill px-4" href="#">
    <i class="bi bi-lightning-charge me-1"></i> Shop Now
  </a>
@endsection

@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Categories</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
    <h3 class="m-0 fw-bold">Categories</h3>

    <div class="d-flex gap-2">
      <a class="btn btn-outline-dark pill px-3" href="#">
        <i class="bi bi-arrow-left me-1"></i> Back to Products
      </a>
    </div>
  </div>

  <div class="row g-3">
    @forelse($categories as $c)
      <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ url('/category/'.$c->id.'/products') }}" class="text-decoration-none text-dark">
          <div class="card soft-card h-100">
            @if($c->CategoryImage)
              <img src="{{ asset('img/product/'.$c->CategoryImage) }}" class="thumb" alt="Category">
            @else
              <div class="noimg">No Image</div>
            @endif

            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <h6 class="m-0 fw-bold line-clamp-2">{{ $c->CategoryName }}</h6>
                <span class="badge bg-light text-dark border pill">View</span>
              </div>
              <div class="text-muted small mt-2">Tap to see products</div>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-light border rounded-4 p-4">
          <div class="fw-bold">No categories found.</div>
          <div class="text-muted">Please add categories from admin panel.</div>
        </div>
      </div>
    @endforelse
  </div>
@endsection
