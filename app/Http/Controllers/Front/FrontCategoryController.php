<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class FrontCategoryController extends Controller
{
        public function categoryProducts(Request $request, $id) {
    $categories = \App\Models\Category::all(); // សម្រាប់ប៊ូតុង Filter ខាងលើ
    $category = \App\Models\Category::findOrFail($id); // Category ដែលកំពុងមើល
    
    // ទាញ Product តាម CategoryID និងបន្ថែមការ Sort (បើមាន)
    $q = \App\Models\Product::where('CategoryID', $id);
    
    if ($request->sort == 'price_asc') $q->orderBy('Price', 'asc');
    else if ($request->sort == 'price_desc') $q->orderBy('Price', 'desc');
    else $q->orderBy('id', 'desc');

    $products = $q->get();

    return view('front.category_products.index', compact('categories', 'category', 'products'));
}

}
