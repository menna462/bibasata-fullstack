<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        // جلب جميع الكوبونات من قاعدة البيانات مع أحدثها أولاً
        $coupons = Coupon::latest()->paginate(10);

        // إعادة عرض الـ View مع تمرير بيانات الكوبونات
        return view('backend.coupon', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المُرسلة من النموذج
        $request->validate([
            'code'                => 'required|unique:coupons|string|max:255',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'usage_limit'         => 'nullable|integer|min:1',
            'expiry_date'         => 'nullable|date',
        ]);

        // إنشاء وحفظ الكوبون الجديد في قاعدة البيانات
        Coupon::create($request->all());

        // إعادة التوجيه إلى صفحة القائمة مع رسالة نجاح
        return redirect()->route('coupons')->with('message', 'تم إنشاء الكوبون بنجاح!');
    }

    /**
     * Show the form for editing the specified coupon.
     */
public function edit($id)
{
    $coupon = Coupon::findOrFail($id); // ابحث عن الكوبون أو أظهر خطأ 404 إذا لم يوجد
    return view('backend.coupons.edit', compact('coupon'));
}

    /**
     * Update the specified coupon in storage.
     */
 public function update(Request $request)
    {
        // الحصول على ID الكوبون من الطلب
        $old_id = $request->old_id;

        $coupon = Coupon::findOrFail($old_id);
        $request->validate([
            'code'                => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'discount_percentage' => 'required|integer|min:0|max:100',
            'usage_limit'         => 'nullable|integer|min:1',
            'expiry_date'         => 'nullable|date',
        ]);

        // تحديث بيانات الكوبون
        $coupon->update([
            "code"                => $request->code,
            "discount_percentage" => $request->discount_percentage,
            "usage_limit"         => $request->usage_limit,
            "expiry_date"         => $request->expiry_date,
            "is_active"           => $request->has('is_active') ? true : false,
        ]);

        // إعادة التوجيه إلى صفحة القائمة مع رسالة نجاح
        return redirect()->route('coupons')->with('message', 'تم تحديث الكوبون بنجاح!');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(string $id)
    {
        // حذف الكوبون من قاعدة البيانات
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('coupons')->with('message', 'تم حذف الكوبون بنجاح!');
    }

    /**
     * Apply a coupon to the user's session.
     */
    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon_code');
        $coupon = Coupon::where('code', $code)
                        ->where('is_active', true)
                        ->where('expiry_date', '>', now())
                        ->first();

        if (!$coupon || ($coupon->usage_limit !== null && $coupon->usage_limit <= 0)) {
            return redirect()->back()->with('error', 'كود الخصم غير صالح أو منتهي الصلاحية.');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount_percentage,
        ]);

        return redirect()->back()->with('success', 'تم تطبيق الخصم بنجاح!');
    }
}
