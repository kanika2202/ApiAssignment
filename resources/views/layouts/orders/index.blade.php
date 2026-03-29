@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>🛒 Customer Orders</h4>

    <a href="{{ route('admin.orders.history') }}" class="btn btn-dark">
        View History
    </a>
</div>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($orders as $o)
    <tr>
        <td>{{ $o->id }}</td>
        <td>{{ $o->customer_name }}</td>
        <td>{{ $o->customer_phone }}</td>
        <td>${{ $o->total }}</td>
        <td>{{ $o->status }}</td>

        <td>
            <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('admin.orders.updateStatus', [$o->id,'paid']) }}" class="btn btn-success btn-sm">Paid</a>
        </td>
    </tr>
    @endforeach

</table>

@endsection