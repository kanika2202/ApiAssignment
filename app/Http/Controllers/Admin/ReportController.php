<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // 1. ចំណូលសរុប (Total Revenue)
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        // 2. ការកុម្ម៉ង់ថ្ងៃនេះ (Today's Orders)
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // 3. ចំណូលថ្ងៃនេះ (Today's Revenue)
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->where('payment_status', 'paid')
            ->sum('total');

        // 4. ចំនួនផលិតផលសរុប (Total Products Count)
        $totalProductsCount = Product::count();

        // 5. ផលិតផលលក់ដាច់បំផុតទាំង ៥ (Top 5 Best Sellers)
        $products = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('products.ProductName', DB::raw('SUM(order_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.ProductName')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // 6. ចំណូលប្រចាំខែសម្រាប់ Chart (Monthly Revenue)
        $monthlyData = Order::select(
                DB::raw('SUM(total) as revenue'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month")
            )
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('created_at', 'asc')
            ->get();

        // 7. ចំណូល ៧ ថ្ងៃចុងក្រោយសម្រាប់ Chart (Daily Revenue)
        $dailyData = Order::select(
                DB::raw('SUM(total) as revenue'),
                DB::raw("DATE_FORMAT(created_at, '%D %b') as date")
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('created_at', 'asc')
            ->get();

        // 8. របាយការណ៍តាមវិធីសាស្រ្តបង់ប្រាក់ (Payment Methods: QR vs COD)
        $paymentMethods = Order::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->get();

        // 9. របាយការណ៍តាមទីក្រុង (Orders by City)
        $cityReports = Order::select('city', DB::raw('count(*) as count'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->get();

        // 10. ចំនួនផលិតផលតាមប្រភេទ (Products by Category)
        $categoryReports = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.CategoryID')
            ->select('categories.CategoryName', DB::raw('count(products.id) as total_products'))
            ->groupBy('categories.id', 'categories.CategoryName')
            ->get();

        return view('layouts.admin.reports.index', compact(
            'totalRevenue', 'todayOrders', 'todayRevenue', 'totalProductsCount',
            'products', 'monthlyData', 'dailyData', 'paymentMethods', 
            'cityReports', 'categoryReports'
        ));
    }
}