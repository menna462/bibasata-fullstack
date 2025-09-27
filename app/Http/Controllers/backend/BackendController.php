<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function admin()
    {
        $users = User::count();
        $order = Order::count();
        $bundel = Bundle::count();
        $product = Product::count();
        $category = Category::count();
        return view('backend.include.body', compact('users', 'bundel', 'product', 'category', 'order'));
    }
}
