<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendCategoryController extends Controller
{
    public function index()
    {
        // جلب الفئات مع المنتجات
        $categories = Category::with('products')->get();
        $products = Product::all();
        return view('include.shop', compact('categories', 'products'));
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        $categories = Category::withCount('products')->get(); // دي مهمة عشان يظهر العدد

        return view('include.product', compact('category', 'products', 'categories'));
    }
}
