<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductFrontController extends Controller
{
   public function show($id)
{
    $product = Product::findOrFail($id);

    // If your Product has category relation by CategoryID
    $category = Category::find($product->CategoryID);

    // Optional: related products in same category
    $related = Product::where('CategoryID', $product->CategoryID)
                ->where('id','!=',$product->id)
                ->orderBy('id','desc')
                ->take(8)
                ->get();

    // Optional gallery images (if you have product_images table)
    // $images = ProductImage::where('ProductID',$product->id)->get();

    return view('front.product.show', compact('product','category','related'));
}
public function search(Request $request)
{
    $query = $request->input('query');

    // ស្វែងរកក្នុងតារាង Products (តាមឈ្មោះ) និង Categories (តាមឈ្មោះប្រភេទ)
    $products = Product::where('ProductName', 'LIKE', "%{$query}%")
        ->orWhereHas('category', function($q) use ($query) {
            $q->where('CategoryName', 'LIKE', "%{$query}%");
        })
        ->latest()
        ->paginate(12);

    return view('front.search_results', compact('products', 'query'));
}


}
