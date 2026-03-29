<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'pending')->latest()->get();
        return view('layouts.orders.index', compact('orders'));
    }

    public function history()
    {
        $orders = Order::where('status', '!=', 'pending')->latest()->get();
        return view('layouts.orders.history', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('layouts.orders.show', compact('order'));
    }

    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;

        if ($status == 'paid') {
            $order->payment_status = 'paid';
        }

        $order->save();

        return back()->with('success', 'Order updated');
    }
}