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

<<<<<<< HEAD
    Mail::to('kanikatouch34@gmail.com')->send(new OrderMail($order));
=======
    Mail::to('sreynichhong90@gmail.com')->send(new OrderMail($order));
>>>>>>> ecb27bc7bfdeb0fe64954b1e0b74ad703628abe4

    return view('checkout.success', compact('order'));
}
}
