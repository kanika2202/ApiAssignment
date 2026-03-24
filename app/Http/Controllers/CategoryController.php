<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

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
    // Show edit form
    public function categoryShowData($id)
    {
        $Category = Category::findOrFail($id);
        return view('categoryEdit', compact('Category'));
    }

    // Update
    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'categoryName' => 'required|string|max:255',
            'fileCategoryImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $Category = Category::findOrFail($request->id);

        // update name
        $Category->CategoryName = $request->categoryName;

        // keep old image by default
        $imageName = $request->oldCategoryImage;

        // if upload new image
        if ($request->hasFile('fileCategoryImage')) {
            $imageName = time() . '-' . $request->file('fileCategoryImage')->getClientOriginalName();
            $request->file('fileCategoryImage')->move(public_path('img/product'), $imageName);
        }

        $Category->CategoryImage = $imageName;
        $Category->save();

        return redirect('categoryList')->with('success', 'Category updated!');
    }
     public function categoryDelete($id)
    {
        $Category = Category::findOrFail($id);

        // delete image file if exists
        if ($Category->CategoryImage && File::exists(public_path('img/product/'.$Category->CategoryImage))) {
            File::delete(public_path('img/product/'.$Category->CategoryImage));
        }

        // delete record
        $Category->delete();

        return redirect('categoryList')->with('success', 'Category deleted successfully!');
    }


}
