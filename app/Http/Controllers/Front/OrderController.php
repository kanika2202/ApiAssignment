<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Models\Order;

class OrderController extends Controller
{
    public function placeOrder($id)
{
    $order = Order::with('items')->find($id);

    Mail::to('sreynichhong90@gmail.com')->send(new OrderMail($order));

    return view('checkout.success', compact('order'));
}
}
