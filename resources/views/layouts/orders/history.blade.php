@extends('layouts.admin')

@section('content')

<h4>📦 Order History</h4>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Total</th>
        <th>Status</th>
    </tr>

    @foreach($orders as $o)
    <tr>
        <td>{{ $o->id }}</td>
        <td>{{ $o->customer_name }}</td>
        <td>${{ $o->total }}</td>
        <td>{{ $o->status }}</td>
    </tr>
    @endforeach

</table>

@endsection