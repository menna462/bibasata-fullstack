<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
    public function toggleMaintenance()
    {
        $path = base_path('.env');
        $content = file_get_contents($path);

        if (strpos($content, 'MAINTENANCE_MODE=true') !== false) {
            $newContent = str_replace('MAINTENANCE_MODE=true', 'MAINTENANCE_MODE=false', $content);
            $msg = 'تم إيقاف وضع الصيانة ✅';
        } else {
            $newContent = str_replace('MAINTENANCE_MODE=false', 'MAINTENANCE_MODE=true', $content);
            $msg = 'تم تفعيل وضع الصيانة 🚧';
        }

        file_put_contents($path, $newContent);

        // ✅ نحدث الكاش فوراً
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', $msg);
    }
}
