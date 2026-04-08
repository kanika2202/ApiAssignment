<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryFrontController extends Controller
{
    // សម្រាប់បង្ហាញនៅលើទំព័រ Website (HTML)
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('front.categories.index', compact('categories'));
    }

    // សម្រាប់ប្រើប្រាស់ជា API (JSON) - ប្តូរឈ្មោះទៅជា apiIndex
    public function apiIndex()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}