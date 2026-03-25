<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
      public function product()
    {
        $Categories = Category::all();
        return view('product', compact('Categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'CategoryID'    => 'required|integer',
            'productName'   => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'productImage'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $newImageName = null;

        if ($request->hasFile('productImage')) {
            $newImageName = time() . '-' . $request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->move(public_path('img/product'), $newImageName);
        }

        Product::create([
            'CategoryID'   => $request->CategoryID,
            'ProductName'  => $request->productName,
            'Price'        => $request->price,
            'ProductImage' => $newImageName,
        ]);

        return redirect('productList');
    }
    function productList()
    {
        $Products = Product::with('category')->latest()->get();
        return view('productList', compact('Products'));
    }
    public function productShowData($id)
    {
        $Product = Product::findOrFail($id);
        $Categories = Category::all();
        return view('productEdit', compact('Product', 'Categories'));
    }
    public function productUpdate(Request $request)
{
    $request->validate([
        'id'           => 'required|integer',
        'CategoryID'   => 'required|integer',
        'productName'  => 'required|string|max:255',
        'price'        => 'required|numeric|min:0',
        'productImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $Product = Product::findOrFail($request->id);

    // update basic fields
    $Product->CategoryID  = $request->CategoryID;
    $Product->ProductName = $request->productName;
    $Product->Price       = $request->price;

    // update image if uploaded
    if ($request->hasFile('productImage')) {
        $newImageName = time() . '-' . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->move(public_path('img/product'), $newImageName);

        // (optional) delete old file
        if (!empty($Product->ProductImage) && file_exists(public_path('img/product/'.$Product->ProductImage))) {
            unlink(public_path('img/product/'.$Product->ProductImage));
        }

        $Product->ProductImage = $newImageName;
    }

    $Product->save();
    return redirect('productList');
}
    public function productDelete($id)
    {
        $Product = Product::findOrFail($id);

        // delete image file if exists
        if (!empty($Product->ProductImage) && file_exists(public_path('img/product/'.$Product->ProductImage))) {
            unlink(public_path('img/product/'.$Product->ProductImage));
        }

        $Product->delete();
        return redirect('productList');
    }
}

