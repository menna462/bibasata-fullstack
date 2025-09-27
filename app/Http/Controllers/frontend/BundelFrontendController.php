<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use Illuminate\Http\Request;

class BundelFrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        $bundles = Bundle::all(); // الكل
        return view('include.allbundel', compact('bundles','categories'));
    }
}
