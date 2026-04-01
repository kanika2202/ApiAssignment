<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function show($id)
{
    // 1. Find the product by ID including its category relation
    $product = Product::with('category')->find($id);

    // 2. Check if the product exists
    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404); // 404 is the standard HTTP code for Not Found
    }

    // 3. Return the product data in JSON format
    return response()->json([
        'status' => true,
        'message' => 'Product details retrieved successfully',
        'data' => $product
    ]);
}
    public function store(Request $request)
{
    // 1. Validate using exact column names from your Model
    $data = $request->validate([
        'CategoryID'       => 'required|integer',
        'ProductName'      => 'required|string|max:255',
        'Price'            => 'required|numeric|min:0',
        'ProductImage'     => 'nullable|string', 
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'is_promo'         => 'nullable|boolean',
    ]);

    // 2. Create the record
    $product = Product::create($data);

    return response()->json([
        'status' => true,
        'message' => '✅ Product created successfully!',
        'data' => $product
    ], 201);
}
public function getByCategory($id)
{
    // កែពី category_id ទៅជា CategoryID ឱ្យដូចក្នុង Database Migration របស់អ្នក
    $products = Product::with('category')
                        ->where('CategoryID', $id) // <--- កែត្រង់នេះ
                        ->latest()
                        ->get();

    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'រកមិនឃើញផលិតផលក្នុងប្រភេទនេះទេ',
            'data' => []
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'ទាញយកទិន្នន័យជោគជ័យ',
        'data' => $products
    ]);
}

public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'CategoryID'       => 'required|integer',
        'ProductName'      => 'required|string|max:255',
        'Price'            => 'required|numeric|min:0',
        'ProductImage'     => 'nullable|string',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'is_promo'         => 'nullable|boolean',
    ]);

    $product->update($data);

    return response()->json([
        'status' => true,
        'message' => '✅ Product updated successfully!',
        'data' => $product
    ]);
}
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => '✅ Product deleted successfully!',
        ]);

    }
}
