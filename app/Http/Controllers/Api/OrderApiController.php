<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    public function placeOrder(Request $request)
    {
        // ១. បញ្ជាក់លក្ខខណ្ឌដែលចាំបាច់ (Validation)
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'address_line' => 'required',
        ]);

        $userId = 1; // ប្រើ ID លេខ 1 សិនសម្រាប់តេស្ត

        // ២. ទាញអីវ៉ាន់ពីកន្ត្រកមកឆែក
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'កន្ត្រកទំនិញទទេរ'], 400);
        }

        // ៣. គណនាតម្លៃ
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->Price * $item->quantity;
        });
        $shipping = 1.50; // ឧទាហរណ៍តម្លៃសេវាដឹក
        $total = $subtotal + $shipping;

        // ៤. ចាប់ផ្ដើមបញ្ចូលទៅ Database (ប្រើ Transaction ដើម្បីការពារ Error)
        return DB::transaction(function () use ($request, $userId, $subtotal, $shipping, $total, $cartItems) {
            
            // បង្កើត Order
            $order = Order::create([
                'user_id'         => $userId,
                'customer_name'   => $request->customer_name,
                'customer_phone'  => $request->customer_phone,
                'address_line'    => $request->address_line,
                'city'            => $request->city,
                'note'            => $request->note,
                'subtotal'        => $subtotal,
                'shipping'        => $shipping,
                'total'           => $total,
                'status'          => 'pending',
                'payment_method'  => $request->payment_method ?? 'cod',
            ]);

            // បង្កើត Order Items (Snapshot ទិន្នន័យពី Cart)
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->ProductName, // Snapshot ឈ្មោះ
                    'price'        => $item->product->Price,       // Snapshot តម្លៃ
                    'qty'          => $item->quantity,
                    'line_total'   => $item->product->Price * $item->quantity,
                ]);
            }

            // ៥. លុបអីវ៉ាន់ចេញពី Cart ក្រោយកុម្ម៉ង់រួច
            CartItem::where('user_id', $userId)->delete();

            return response()->json([
                'status' => true,
                'message' => '✅ ការបញ្ជាទិញទទួលបានជោគជ័យ!',
                'order_id' => $order->id
            ], 201);
        });
    }
}
