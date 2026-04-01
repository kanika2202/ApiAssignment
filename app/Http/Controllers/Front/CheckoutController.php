<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Qrcode;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;


class CheckoutController extends Controller
{
     public function index()
    {
        $cart = session()->get('cart', []);
        
        // ១. គណនា Total ឡើងវិញសម្រាប់បង្ហាញក្នុង Modal
        $total = 0;
        foreach ($cart as $it) {
            $total += ((float)$it['price']) * ((int)$it['qty']);
        }

        // ២. ទាញយក QR Code ដែលបាន Upload ចុងក្រោយគេ
        // យើងប្រើ latest()->first() ដើម្បីយកតែ ១ ដែលថ្មីជាងគេ
        $activeQR = Qrcode::latest()->first(); 

        // ៣. បញ្ជូន Variable 'total' និង 'activeQR' ទៅកាន់ View
        return view('front.checkout.index', compact('cart', 'total', 'activeQR'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('cart_toast', 'Cart is empty!');
        }

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'address_line'   => 'required|string|max:255',
            'city'           => 'nullable|string|max:255',
            'note'           => 'nullable|string|max:255',

            'payment_method' => 'required|in:cod,qr',
            'payment_ref'    => 'nullable|string|max:255',
            'receipt_image'  => 'nullable|image|max:4096', // 4MB
        ]);

        // calculate subtotal from session cart
        $subtotal = 0;
        foreach ($cart as $it) {
            $subtotal += ((float)$it['price']) * ((int)$it['qty']);
        }
        $shipping = 0;
        $total = $subtotal + $shipping;

        // store with transaction
        $order = DB::transaction(function () use ($request, $cart, $subtotal, $shipping, $total) {

            // upload receipt if provided
            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            }

            $paymentStatus = $request->payment_method === 'qr'
                ? 'pending'   // wait admin confirm
                : 'unpaid';   // COD unpaid until delivered

            $order = Order::create([
                'user_id' => auth()->id(),

                'customer_name' => $request->customer_name,
                'customer_phone'=> $request->customer_phone,
                'address_line'  => $request->address_line,
                'city'          => $request->city,
                'note'          => $request->note,

                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total'    => $total,

                'status'         => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'payment_ref'    => $request->payment_ref,
                'receipt_image'  => $receiptPath,
            ]);

            // create items
            foreach ($cart as $pid => $it) {
                $qty = (int)$it['qty'];

                // optional: verify product still exists
                $p = Product::find($pid);
                $name = $it['name'] ?? ($p?->ProductName ?? 'Unknown');
                $price = (float)$it['price'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $pid,
                    'product_name' => $name,
                    'price' => $price,
                    'qty' => $qty,
                    'line_total' => $price * $qty,
                ]);

                // optional: reduce stock if you have stock column
                // if ($p && isset($p->stock)) { $p->decrement('stock', $qty); }
            }

            return $order;
        });

        // --- បញ្ជូនសារទៅ Telegram ---
        try {
            $telegram = new TelegramService();
            $msg = "🛒 <b>ការកុម្ម៉ង់ថ្មី! (New Order)</b>\n\n"
                 . "🆔 លេខកុម្ម៉ង់: {$order->id}\n"                                           
                 . "👤 អតិថិជន: {$order->customer_name}\n"
                 . "📞 លេខទូរស័ព្ទ: {$order->customer_phone}\n"
                 . "💰 សរុប: <b>$" . number_format($order->total, 2) . "</b>\n"
                 . "💳 បង់ប្រាក់តាម: " . strtoupper($order->payment_method) . "\n"
                 . "📍 ទីតាំង: {$order->address_line}\n\n"
                 . "👉 សូមឆែកមើលក្នុង Admin Panel!";
            
            $telegram->send($msg);
        } catch (\Exception $e) {
            Log::error("Telegram Notification Failed: " . $e->getMessage());
        }
        // --- បញ្ជូនសារទៅ Gmail (បន្ថែមថ្មី) ---
        try {
            // ផ្ញើទៅ Admin ឬ ទៅកាន់អតិថិជន (ប្រសិនបើមាន Email អតិថិជន)
            Mail::to('karonasim98@gmail.com')->send(new OrderMail($order));
        } catch (\Exception $e) {
            Log::error("Gmail Error: " . $e->getMessage());
        }


        // clear cart after create order
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id)
            ->with('cart_toast', '✅ Order placed successfully!');
    }

    public function success(Order $order)
    {
        $order->load('items');
        return view('front.checkout.success', compact('order'));
    }

}
