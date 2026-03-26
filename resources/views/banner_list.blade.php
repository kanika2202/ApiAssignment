@extends('layouts.admin')
@section('title','Banner List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="m-0">Banner List</h4>
    <a href="{{ route('banner.create') }}" class="btn btn-primary btn-sm">+ Add Banner</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered m-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:70px;">ID</th>
                    <th>Title</th>
                    <th style="width:90px;">Order</th>
                    <th style="width:90px;">Active</th>
                    <th style="width:140px;" class="text-center">Image</th>
                    <th style="width:200px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($Banners as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td class="fw-semibold">
                        {{ $b->Title ?? '-' }}
                        @if($b->Link)
                            <div class="small text-muted">{{ $b->Link }}</div>
                        @endif
                    </td>
                    <td>{{ $b->SortOrder }}</td>
                    <td>
                        @if($b->IsActive)
                            <span class="badge text-bg-success">Yes</span>
                        @else
                            <span class="badge text-bg-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($b->BannerImage)
                            <img src="{{ asset('img/banner/'.$b->BannerImage) }}" class="rounded border" width="90">
                        @else
                            <span class="badge text-bg-secondary">No Image</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-warning" href="{{ route('banner.edit',$b->id) }}">Edit</a>
                        <a class="btn btn-sm btn-danger"
                           href="{{ route('banner.delete',$b->id) }}"
                           onclick="return confirm('Delete this banner?')">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted p-4">No banners found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
