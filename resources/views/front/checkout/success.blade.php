@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="printable-area card border-0 shadow-sm p-5 rounded-4 mx-auto" style="max-width: 800px;">
        <div class="text-center d-print-none mb-4">
            <div class="display-1 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
            <h2 class="fw-bold">Order Success!</h2>
            <button onclick="window.print()" class="btn btn-outline-dark pill mt-3 px-4">
                <i class="bi bi-printer me-2"></i> Print Invoice
            </button>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">INVOICE</h4>
                <small class="text-muted">Order ID: #{{ $order->id }}</small>
            </div>
            <div class="text-end text-muted small">Date: {{ $order->created_at->format('d-M-Y') }}</div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <label class="small text-muted fw-bold">BILL TO:</label>
                <div class="fw-bold">{{ $order->customer_name }}</div>
                <div>{{ $order->customer_phone }}</div>
                <div class="small">{{ $order->address_line }}</div>
            </div>
            <div class="col-6 text-end">
                <label class="small text-muted fw-bold">PAYMENT:</label>
                <div class="fw-bold">{{ strtoupper($order->payment_method) }}</div>
                <div class="small text-success">{{ $order->payment_status }}</div>
            </div>
        </div>

        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>Product</th><th class="text-center">Qty</th><th class="text-end">Total</th></tr>
            </thead>
            <tbody>
                @foreach($order->items as $it)
                <tr>
                    <td>{{ $it->product_name }}</td>
                    <td class="text-center">{{ $it->qty }}</td>
                    <td class="text-end fw-bold">${{ number_format($it->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-end text-end mt-4">
            <div class="col-md-4">
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Subtotal:</span><span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="fw-bold fs-5">Total:</span><span class="fw-bold fs-5 text-primary">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .printable-area, .printable-area * { visibility: visible; }
        .printable-area { position: absolute; left: 0; top: 0; width: 100%; border: none; }
        .d-print-none { display: none !important; }
    }
</style>
@endsection