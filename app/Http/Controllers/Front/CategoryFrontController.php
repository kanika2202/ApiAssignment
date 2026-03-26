<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryFrontController extends Controller
{
        public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('front.categories.index', compact('categories'));
    }
}
