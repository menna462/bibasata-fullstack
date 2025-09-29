<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
        $currentLocale = App::getLocale();
        $nameColumn = 'name_' . $currentLocale;
        return view('include.product', compact('category', 'products', 'categories','nameColumn','currentLocale'));
    }
}
