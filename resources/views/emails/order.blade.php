<h2>Order Invoice</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

    @foreach($order->items as $item)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->customer_name }}</td>
        <td>{{ $order->customer_phone }}</td>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->qty }}</td>
        <td>${{ $item->qty * $item->price }}</td>
    </tr>
    @endforeach
</table>


