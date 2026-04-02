<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get Current User ID 
     * មុខងារជំនួយសម្រាប់ស្វែងរក ID អ្នកប្រើប្រាស់ (ទាញពី Login ឬប្រើ Default លេខ 1)
     */
    private function getUserId()
    {
        // បើមានការ Login វានឹងយក ID អ្នកនោះ តែបើអត់ទេ វានឹងយក ID លេខ 1 មកតេស្ត
        return Auth::id() ?? 1; 
    }

    /**
     * ១. បន្ថែមទំនិញទៅក្នុងកន្ត្រក (Add to Cart)
     */
    public function add(Request $request, $productId)
    {
        $userId = $this->getUserId(); 

        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        $qtyToAdd = $request->input('qty', 1);

        if ($cartItem) {
            $cartItem->increment('quantity', $qtyToAdd);
        } else {
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $qtyToAdd,
            ]);
        }

        return response()->json([
            'status'  => true,
            'user_id' => $userId,
            'message' => '✅ បានបញ្ចូលទៅក្នុងកន្ត្រកទំនិញជោគជ័យ!'
        ], 200);
    }

    /**
     * ២. បង្ហាញបញ្ជីទំនិញក្នុងកន្ត្រកទាំងអស់ (List Cart Details)
     */
    public function index()
    {
        $userId = $this->getUserId(); 

        // ទាញយក Cart Items រួមជាមួយព័ត៌មាន Product
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status'  => false,
                'user_id' => $userId,
                'message' => 'កន្ត្រកទំនិញទទេរ!',
                'data'    => []
            ], 200);
        }

        $subtotal = $cartItems->sum(fn($item) => optional($item->product)->Price * $item->quantity);
        $totalQty = $cartItems->sum('quantity');

        $formattedItems = $cartItems->map(function($item) {
            return [
                'cart_id'      => $item->id,
                'product_id'   => $item->product_id,
                'product_name' => optional($item->product)->ProductName,
                'price'        => "$" . number_format(optional($item->product)->Price, 2),
                'quantity'     => $item->quantity,
                'image_url'    => optional($item->product)->Image ? url('uploads/products/' . $item->product->Image) : null,
                'line_total'   => "$" . number_format(optional($item->product)->Price * $item->quantity, 2),
            ];
        });

        return response()->json([
            'status' => true,
            'cart_summary' => [
                'user_id'     => $userId,
                'total_items' => $totalQty,
                'subtotal'    => "$" . number_format($subtotal, 2),
                'note'        => 'តម្លៃនេះមិនទាន់បូកបញ្ចូលសេវាដឹកជញ្ជូន និង Promotion ទេ'
            ],
            'items' => $formattedItems
        ], 200);
    }

    /**
     * ៣. កែប្រែចំនួនទំនិញ (Update Quantity)
     */
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->update(['quantity' => $request->qty]);
            return response()->json(['status' => true, 'message' => 'បានកែប្រែចំនួនជោគជ័យ!']);
        }
        return response()->json(['status' => false, 'message' => 'រកមិនឃើញទំនិញ'], 404);
    }

    /**
     * ៤. លុបទំនិញចេញពីកន្ត្រក (Remove Item)
     */
    public function remove($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['status' => true, 'message' => 'លុបទំនិញចេញរួចរាល់!']);
        }
        return response()->json(['status' => false, 'message' => 'រកមិនឃើញទំនិញ'], 404);
    }
}