<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
     public function index(Request $request)
    {
        $q = Product::query()->whereNotNull('id'); // base

        // Search
        if ($request->filled('q')) {
            $q->where('ProductName', 'like', '%'.$request->q.'%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $q->where('CategoryID', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $q->where('Price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $q->where('Price', '<=', $request->max_price);
        }

        // Sort
        switch ($request->sort) {
            case 'latest':     $q->orderBy('id', 'desc'); break;
            case 'price_asc':  $q->orderBy('Price', 'asc'); break;
            case 'price_desc': $q->orderBy('Price', 'desc'); break;
            case 'name_asc':   $q->orderBy('ProductName', 'asc'); break;
            case 'name_desc':  $q->orderBy('ProductName', 'desc'); break;
            default:           $q->orderBy('id', 'desc');
        }

        $products = $q->paginate(8)->appends($request->query());
        $categories = Category::orderBy('id','desc')->get();

        return view('front.home', compact('products','categories'));
    }
}
