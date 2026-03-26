<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryProductFrontController extends Controller
{
    public function index(Category $category)
    {
        $products = Product::where('CategoryID', $category->id)
            ->latest()
            ->paginate(12);

        return view('front.category_products.index', compact('category', 'products'));
    }
}
