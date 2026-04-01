<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // បន្ថែមទំនិញទៅក្នុង Database
    public function add(Request $request, $productId)
    {
        // ឆែកមើល User តាមរយៈ Access Token
    $userId = Auth::id() ?? 1; // ប្រើ ID 1 ជា Default បើ User មិនបាន Authenticate

        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->input('qty', 1));
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $request->input('qty', 1),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'បានរក្សាទុកក្នុង Database ជោគជ័យ!'
        ]);
    }

    // ទាញយកទិន្នន័យក្នុងកន្ត្រករបស់ User ម្នាក់ៗ
    public function index()
    {
        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        return response()->json([
            'status' => true,
            'data' => $cartItems
        ]);
    }
}