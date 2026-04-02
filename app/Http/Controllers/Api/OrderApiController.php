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
    /**
     * ១. មុខងារបញ្ជាទិញ (Place Order) តាមរយៈ GET Method (សម្រាប់តេស្តក្នុង Browser)
     * រួមបញ្ចូល Logic Promotion លើតម្លៃដឹកជញ្ជូន និងតម្លៃសរុប
     */
    public function placeOrder(Request $request)
    {
        // Validation ទិន្នន័យពី URL Query Parameters
        $request->validate([
            'customer_name'  => 'required',
            'customer_phone' => 'required',
            'address_line'   => 'required',
        ]);

        $userId = 1; // កំណត់ User ID ថេរសម្រាប់តេស្ត

        // ទាញទិន្នន័យពី Cart មកឆែកមើលចំនួន និងតម្លៃ
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'កន្ត្រកទំនិញទទេរ! សូមថែមអីវ៉ាន់សិន'], 400);
        }

        // --- ផ្នែកគណនា Promotion & Totals ---
        $subtotal = $cartItems->sum(fn($item) => $item->product->Price * $item->quantity);
        $totalQty = $cartItems->sum('quantity');

        // Logic Promotion: បើទិញចាប់ពី ៣ មុខឡើងទៅ ដឹកជញ្ជូនឥតគិតថ្លៃ ($0)
        if ($totalQty >= 3) {
            $shipping = 0.00;
            $promoLabel = "Promotion: Free Shipping (ទិញ $totalQty មុខ)";
        } else {
            $shipping = 1.50; // តម្លៃដឹកធម្មតា
            $promoLabel = "Standard Shipping $1.50";
        }

        $total = $subtotal + $shipping;

        return DB::transaction(function () use ($request, $userId, $subtotal, $shipping, $total, $cartItems, $promoLabel) {
            
            // បង្កើត Order ថ្មី
            $order = Order::create([
                'user_id'        => $userId,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'address_line'   => $request->address_line,
                'city'           => $request->city ?? 'Phnom Penh',
                'subtotal'       => $subtotal,
                'shipping'       => $shipping,
                'total'          => $total,
                'status'         => 'pending', // រង់ចាំ Admin ចុច Paid/Approve
                'note'           => $promoLabel,
                'payment_method' => $request->payment_method ?? 'KHQR',
            ]);

            // បង្កើតបញ្ជីទំនិញក្នុង Order (Order Items)
            $itemsDetail = [];
            foreach ($cartItems as $item) {
                $orderItem = OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->ProductName,
                    'price'        => $item->product->Price,
                    'qty'          => $item->quantity,
                    'line_total'   => $item->product->Price * $item->quantity,
                ]);
                $itemsDetail[] = $orderItem;
            }

            // លុបអីវ៉ាន់ចេញពី Cart ក្រោយពេល Order រួចរាល់
            CartItem::where('user_id', $userId)->delete();

            // បង្ហាញលទ្ធផល "ទាំងអស់" ទៅ Browser
            return response()->json([
                'status' => 'Success',
                'message' => '✅ ការបញ្ជាទិញជោគជ័យ!',
                'order_summary' => [
                    'order_id'      => $order->id,
                    'customer'      => $order->customer_name,
                    'total_items'   => $total,
                    'subtotal'      => "$" . number_format($subtotal, 2),
                    'shipping'      => "$" . number_format($shipping, 2),
                    'grand_total'   => "$" . number_format($total, 2),
                    'promotion'     => $promoLabel
                ],
                'products' => $itemsDetail
            ], 200);
        });
    }

    /**
     * ២. មុខងារ List អ្នកដែលបាន Order ទាំងអស់ (សម្រាប់ Admin ឆែកមើល)
     */
    public function listAllOrders()
    {
        // ទាញយក Order ទាំងអស់ រួមជាមួយទំនិញ (Items)
        $orders = Order::with('items')->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'total_orders' => $orders->count(),
            'data' => $orders
        ], 200);
    }

    /**
     * ៣. មុខងារមើលប្រវត្តិបញ្ជាទិញ (Order History) សម្រាប់ User
     */
    public function orderHistory()
    {
        $userId = 1;
        $history = Order::with('items')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => true,
            'user_id' => $userId,
            'history' => $history
        ]);
    }
}