<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Comment;
use App\Models\DurationPrice;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        $products = Product::latest()->take(8)->get();
        $bundles = Bundle::take(3)->get();
         $sliders = Slider::get();
        $comments = Comment::where('page_name', 'homepage')
            ->with('user')
            ->latest()
            ->get();

        return view('welcome', compact('categories', 'products', 'bundles', 'comments','sliders')); // <--- إضافة 'comments' هنا
    }

    public function show($id)
    {
        $categories = Category::with('products')->get();
        $product = Product::findOrFail($id);
        return view('include.productdetails', compact('product', 'categories'));
    }

    public function showBundelDetails($id)
    {
        $categories = Category::with('products')->get();
        $bundle = Bundle::findOrFail($id);
        return view('include.bundeldetails', compact('bundle', 'categories'));
    }

 public function search(Request $request)
{
    $searchTerm = $request->input('query');
    $categoryId = $request->input('category_id');

    $categories = Category::with('products')->get(); // جلب الفئات مع منتجاتها

    $productsQuery = Product::query();
    $bundlesQuery = Bundle::query();

    if ($searchTerm) {
        $productsQuery->where(function ($q) use ($searchTerm) {
            $q->where('name_en', 'like', '%' . $searchTerm . '%');
        });

        $bundlesQuery->where(function ($q) use ($searchTerm) {
            $q->where('name_en', 'like', '%' . $searchTerm . '%');
        });
    }

    if ($categoryId && $categoryId !== 'all') {
        $productsQuery->where('category_id', $categoryId);
    }

    $foundProducts = $productsQuery->get();
    $foundBundles = $bundlesQuery->get();

    if ($foundProducts->count() === 1 && $foundBundles->isEmpty()) {
        return redirect()->route('product.details', $foundProducts->first()->id);
    } elseif ($foundBundles->count() === 1 && $foundProducts->isEmpty()) {
        return redirect()->route('bundle.details', $foundBundles->first()->id);
    }

    // هنا يتم التعديل
    $products = $productsQuery->paginate(10, ['*'], 'product_page');
    $bundles = $bundlesQuery->paginate(10, ['*'], 'bundle_page');

    $comments = Comment::where('page_name', 'homepage')->with('user')->latest()->get();

    return view('welcome', compact('categories', 'products', 'bundles', 'searchTerm', 'categoryId', 'comments'));
}

    public function liveSearch(Request $request)
    {
        $searchTerm = $request->input('query');

        $products = collect();
        $bundles = collect();

        if ($searchTerm) {
            $products = Product::where('name_en', 'like', '%' . $searchTerm . '%')
                ->orWhere('description_en', 'like', '%' . $searchTerm . '%')
                ->get();

            $bundles = Bundle::where('name_en', 'like', '%' . $searchTerm . '%')
                ->orWhere('short_description_en', 'like', '%' . $searchTerm . '%')
                ->get();
        }


        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'type' => 'product',
                'name' => $product->name_en ?? $product->name,
                'url' => route('product.details', $product->id)
            ];
        }

        foreach ($bundles as $bundle) {
            $results[] = [
                'type' => 'bundle',
                'name' => $bundle->name_en ?? $bundle->name,
                'url' => route('bundle.details', $bundle->id)
            ];
        }

        return response()->json($results);
    }
}
