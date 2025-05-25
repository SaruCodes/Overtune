<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $news = $category->news()->latest()->paginate(10);

        return view('categories.show', compact('category', 'news'));
    }
}
