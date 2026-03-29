@extends('layouts.admin')

@section('content')

<h4>Order Detail</h4>

<p>Name: {{ $order->customer_name }}</p>
<p>Phone: {{ $order->customer_phone }}</p>
<p>Address: {{ $order->address_line }}</p>

<hr>

<table class="table">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

    @foreach($order->items as $item)
    <tr>
        <td>{{ $item->product_name }}</td>
        <td>${{ $item->price }}</td>
        <td>{{ $item->qty }}</td>
        <td>${{ $item->line_total }}</td>
    </tr>
    @endforeach

</table>

@endsection