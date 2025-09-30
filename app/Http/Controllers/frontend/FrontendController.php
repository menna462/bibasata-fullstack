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
         $currentLocale = App::getLocale();
         $nameColumn = 'name_' . $currentLocale;
        $comments = Comment::where('page_name', 'homepage')
            ->with('user')
            ->latest()
            ->get();

        return view('include.home', compact('categories', 'products', 'bundles', 'comments','sliders','nameColumn','currentLocale')); // <--- إضافة 'comments' هنا
    }

    public function show($id)
    {
        $categories = Category::with('products')->get();
        $products =Product::latest()->take(8)->get();
        $product = Product::with('durations')->findOrFail($id);
         $currentLocale = App::getLocale();
         $nameColumn = 'name_' . $currentLocale;
        return view('include.productdetails', compact('products','product', 'categories','nameColumn','currentLocale'));
    }

    public function showBundelDetails($id)
    {
        $categories = Category::with('products')->get();
        //  $currentLocale = App::getLocale();
        //  $nameColumn = 'name_' . $currentLocale;
        $bundle = Bundle::findOrFail($id);
        return view('include.bundeldetails', compact('bundle', 'categories',));
    }

 public function search(Request $request)
{
    $searchTerm = $request->input('query');
    $categoryId = $request->input('category_id');

    $categories = Category::with('products')->get(); // جلب الفئات مع منتجاتها

        $currentLocale = App::getLocale();
        $nameColumn = 'name_' . $currentLocale; // العمود الخاص باللغة الحالية للبحث

        $productsQuery = Product::query();
        $bundlesQuery = Bundle::query();

        if ($searchTerm) {
            $productsQuery->where(function ($q) use ($searchTerm, $nameColumn) { // إضافة $nameColumn
                $q->where($nameColumn, 'like', '%' . $searchTerm . '%'); // البحث في العمود الصحيح
            });

            $bundlesQuery->where(function ($q) use ($searchTerm, $nameColumn) { // إضافة $nameColumn
                $q->where($nameColumn, 'like', '%' . $searchTerm . '%'); // البحث في العمود الصحيح
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

    return view('welcome', compact('categories', 'products', 'bundles', 'searchTerm', 'categoryId', 'comments','nameColumn','currentLocale'));
}

    public function liveSearch(Request $request)
    {
        $searchTerm = $request->input('query');
        $currentLocale = App::getLocale();
        $nameColumn = 'name_' . $currentLocale;
        $descriptionColumn = 'description_' . $currentLocale; // إذا كان لديكِ description_ar و description_en
        $shortDescriptionColumn = 'short_description_' . $currentLocale;
        $products = collect();
        $bundles = collect();

       if ($searchTerm) {
            $products = Product::where($nameColumn, 'like', '%' . $searchTerm . '%') // البحث في عمود الاسم الصحيح
                ->orWhere($descriptionColumn, 'like', '%' . $searchTerm . '%') // البحث في عمود الوصف الصحيح
                ->get();

            $bundles = Bundle::where($nameColumn, 'like', '%' . $searchTerm . '%') // البحث في عمود الاسم الصحيح
                ->orWhere($shortDescriptionColumn, 'like', '%' . $searchTerm . '%') // البحث في عمود الوصف المختصر الصحيح
                ->get();
        }


        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'type' => 'product',
                'name' => $product->$nameColumn ?? $product->name_en, // استدعاء حسب المتغير
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
