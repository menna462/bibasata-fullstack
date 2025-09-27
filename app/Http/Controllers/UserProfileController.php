<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order; // استدعاء نموذج الطلب

class UserProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // جلب الطلبات المؤكدة (is_paid = true) للمستخدم الحالي
        // مع جلب بيانات المنتج المرتبطة (product, bundle) لتجنب استعلامات متكررة
        $confirmedOrders = Order::with(['product', 'bundle'])
            ->where('user_id', $user->id)
            ->where('is_paid', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('include.profile', [
            'confirmedOrders' => $confirmedOrders, // تمرير المنتجات المؤكدة إلى الـ view
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('profile.show')->with('success', 'تم تحديث البيانات بنجاح!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('كلمة المرور الحالية غير صحيحة.');
                }
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}
