@extends('layouts.admin')
@section('title','Product List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Product List</h4>
    <a href="{{ url('/product') }}" class="btn btn-primary btn-sm">+ Add Product</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered m-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Product</th>
                    <th style="width:180px;">Category</th>
                    <th style="width:120px;">Price</th>
                    <th style="width:140px;" class="text-center">Image</th>
                    <th style="width:120px;" class="text-center">Discount</th>
                    <th style="width:200px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Products as $Product)
                    <tr>
                        <td>{{ $Product->id }}</td>
                        <td class="fw-semibold">{{ $Product->ProductName }}</td>

                        <td>
                            <span class="badge text-bg-info">
                                {{ $Product->category->CategoryName ?? 'N/A' }}
                            </span>
                        </td>

                        <td>${{ number_format($Product->Price,2) }}</td>

                        <td class="text-center">
                            @if(!empty($Product->ProductImage))
                                <img src="{{ asset('img/product/'.$Product->ProductImage) }}" width="70" class="rounded border">
                            @else
                                <span class="badge text-bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($Product->discount_percent > 0)
                                <span class="badge text-bg-success">
                                    {{ $Product->discount_percent }}% Off
                                </span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a class="btn btn-sm btn-warning" href="{{ url('productEdit/'.$Product->id) }}">Edit</a>
                            <a class="btn btn-sm btn-danger"
                               href="{{ url('productDelete/'.$Product->id) }}"
                               onclick="return confirm('Are you sure delete this product?')">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
