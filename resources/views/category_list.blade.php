@extends('layouts.admin')
@section('title','Category List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Category List</h4>
    <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">+ Add Category</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered m-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Category Name</th>
                    <th style="width:140px;" class="text-center">Image</th>
                    <th style="width:200px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td class="fw-semibold">{{ $c->CategoryName }}</td>
                        <td class="text-center">
                            @if($c->CategoryImage)
                                <img src="{{ asset('img/product/'.$c->CategoryImage) }}" class="rounded border" width="70">
                            @else
                                <span class="badge text-bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning"
                               href="{{ url('categoryEdit/'.$c->id) }}">Edit</a>

                            <a class="btn btn-sm btn-danger"
                               href="{{ url('categoryDelete/'.$c->id) }}"
                               onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted p-4">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
