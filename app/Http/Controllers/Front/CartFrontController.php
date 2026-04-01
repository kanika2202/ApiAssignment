<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;

class CartFrontController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front.cart.index', compact('cart'));
    }

   public function add(Request $request, $product)
{
    $qty = max(1, (int) $request->input('qty', 1));
    $p = Product::findOrFail($product);

    // --- ចាប់ផ្ដើមគណនាតម្លៃ Promotion ---
    $finalPrice = (float) $p->Price;
    if ($p->discount_percent > 0) {
        // រកតម្លៃដែលត្រូវលក់ពិតប្រាកដ (តម្លៃដើម - ចំនួនដែលបញ្ចុះ)
        $finalPrice = $p->Price - ($p->Price * $p->discount_percent / 100);
    }
    // --- បញ្ចប់ការគណនា ---

    $cart = session()->get('cart', []);

    if (isset($cart[$p->id])) {
        $cart[$p->id]['qty'] += $qty;
    } else {
        $cart[$p->id] = [
            'id'    => $p->id,
            'name'  => $p->ProductName,
            'price' => $finalPrice, // ប្រើតម្លៃដែលគណនារួច (Promotion Price)
            'image' => $p->ProductImage,
            'qty'   => $qty,
        ];
    }

    session()->put('cart', $cart);
    // ... ផ្នែកផ្សេងទៀតរក្សាទុកដដែល

    if ($request->expectsJson()) {
        return response()->json([
            'ok' => true,
            'message' => "+ {$p->ProductName} (x{$qty}) added to cart!",
                'cart_count' => array_sum(array_column($cart, 'qty')),
                'subtotal' => number_format($this->subtotal($cart), 2),
            ]);
        }

        return back()->with('cart_toast', "+ {$p->ProductName} (x{$qty}) added to cart!");
    }

    public function update(Request $request, $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session()->get('cart', []);

        if (!isset($cart[$product])) {
            return response()->json(['ok'=>false,'message'=>'Item not found in cart'], 404);
        }

        $cart[$product]['qty'] = $qty;
        session()->put('cart', $cart);

        return response()->json([
            'ok' => true,
            'message' => "+ Quantity updated!",
            'cart_count' => array_sum(array_column($cart, 'qty')),
            'line_total' => number_format($cart[$product]['price'] * $cart[$product]['qty'], 2),
            'subtotal' => number_format($this->subtotal($cart), 2),
        ]);
    }

    public function remove(Request $request, $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product])) unset($cart[$product]);
        session()->put('cart', $cart);

        return response()->json([
            'ok' => true,
            'message' => "x Item removed!",
            'cart_count' => array_sum(array_column($cart, 'qty')),
            'subtotal' => number_format($this->subtotal($cart), 2),
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('cart_toast', 'Cart cleared!');
    }

    private function subtotal(array $cart): float
    {
        $sum = 0;
        foreach ($cart as $item) {
            $sum += ((float)$item['price']) * ((int)$item['qty']);
        }
        return $sum;
    }

}
