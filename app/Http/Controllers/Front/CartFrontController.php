<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth; // បន្ថែមនេះ

class CartFrontController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front.cart.index', compact('cart'));
    }

    public function apiIndex() {
        // ទាញទិន្នន័យពី Database ទាំងអស់ (ដើម្បីឱ្យឃើញគ្រប់ User)
        $cart = \App\Models\CartItem::with('product')->get(); 
        return response()->json($cart);
    }

    public function add(Request $request, $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $p = Product::findOrFail($product);

        // --- ចាប់ផ្ដើមគណនាតម្លៃ Promotion (រក្សាទុកដដែល) ---
        $finalPrice = (float) $p->Price;
        if ($p->discount_percent > 0) {
            $finalPrice = $p->Price - ($p->Price * $p->discount_percent / 100);
        }
        // --- បញ្ចប់ការគណនា ---

        // ==========================================
        // ១. រក្សាទុកក្នុង DATABASE (សម្រាប់ API)
        // ==========================================
        $userId = Auth::id() ?? 1; // បើមិនទាន់ Login យក ID 1 តេស្តសិន
        
        $dbItem = CartItem::where('user_id', $userId)
                          ->where('product_id', $p->id)
                          ->first();

        if ($dbItem) {
            $dbItem->increment('quantity', $qty);
        } else {
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $p->id,
                'quantity'   => $qty,
            ]);
        }

        // ==========================================
        // ២. រក្សាទុកក្នុង SESSION (កូដដើមរបស់អ្នក)
        // ==========================================
        $cart = session()->get('cart', []);

        if (isset($cart[$p->id])) {
            $cart[$p->id]['qty'] += $qty;
        } else {
            $cart[$p->id] = [
                'id'    => $p->id,
                'name'  => $p->ProductName,
                'price' => $finalPrice,
                'image' => $p->ProductImage,
                'qty'   => $qty,
            ];
        }

        session()->put('cart', $cart);

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

    // មុខងារ update, remove, clear និង subtotal រក្សាទុកដូចដើម...
    public function update(Request $request, $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session()->get('cart', []);

        if (!isset($cart[$product])) {
            return response()->json(['ok'=>false,'message'=>'Item not found in cart'], 404);
        }

        $cart[$product]['qty'] = $qty;
        session()->put('cart', $cart);

        // កែសម្រួលក្នុង Database ផងដែរ
        CartItem::where('user_id', Auth::id() ?? 1)
                ->where('product_id', $product)
                ->update(['quantity' => $qty]);

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

        // លុបក្នុង Database ផងដែរ
        CartItem::where('user_id', Auth::id() ?? 1)
                ->where('product_id', $product)
                ->delete();

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
        // លុបកន្ត្រកក្នុង Database របស់ User នេះចោល
        CartItem::where('user_id', Auth::id() ?? 1)->delete();
        
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