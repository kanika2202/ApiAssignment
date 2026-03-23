<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create()
    {
        return view('category'); // resources/views/category.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255',
            'CategoryImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('CategoryImage')) {
            $imageName = time() . '-' . $request->file('CategoryImage')->getClientOriginalName();
            $request->file('CategoryImage')->move(public_path('img/product'), $imageName);
        }

        Category::create([
            'CategoryName' => $request->CategoryName,
            'CategoryImage' => $imageName,
        ]);

        return redirect()->route('category.list')->with('success', 'Category created successfully!');
    }

    public function list()
    {
        $categories = Category::latest()->get();
        return view('category_list', compact('categories'));
    }
}
