<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bundel = Bundle::all();
        return view('backend.bundel', compact('bundel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all(); // جلب كل الأقسام
        return view('backend.bundel.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'category_id' => 'required|exists:categories,id',
            'images' => 'required|image|mimes:jpeg,png,jpg,webp',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'short_description_en' => 'required|string',
            'short_description_ar' => 'required|string',
            'long_description_en' => 'required|string',
            'long_description_ar' => 'required|string',
            'discount_percentage' => 'nullable|integer|min:0|max:100',

        ]);

        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/products/'), $imageName);
        }

        Bundle::create([
            // "category_id" => $request->category_id,
            "image" => $imageName, // اسم الصورة فقط بيتخزن
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "short_description_en" => $request->short_description_en,
            "short_description_ar" => $request->short_description_ar,
            "long_description_en" => $request->long_description_en,
            "long_description_ar" => $request->long_description_ar,
            "discount_percentage" => $request->discount_percentage,


        ]);

        return redirect()->route("bundel")->with("message", "Created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bundel = Bundle::findOrFail($id);
        return view('backend.bundel.show', compact('bundel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bundel = Bundle::findOrFail($id);
        $category = Category::all();
        return view('backend.bundel.edit', ["result" => $bundel], compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $bundel = Bundle::findOrFail(id: $old_id);

        $request->validate([
            'discount_percentage' => 'nullable|integer|min:0|max:100',
        ]);
        if ($request->hasFile('image')) {
            if (file_exists(public_path('image/products/' . $bundel->image))) {
                unlink(public_path('image/products/' . $bundel->image)); // حذف الصورة القديمة من السيرفر
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/products/'), $imageName); // حفظ الصورة في المسار

            // تحديث المنتج مع الصورة الجديدة
            $bundel->update([
                // "category_id" => $request->category_id,
                "image" => $imageName, // تحديث اسم الصورة فقط
                "name_en" => $request->name_en,
                "name_ar" => $request->name_ar,
                "short_description_en" => htmlspecialchars($request->short_description_en, ENT_QUOTES, 'UTF-8'),
                "short_description_ar" => htmlspecialchars($request->short_description_ar, ENT_QUOTES, 'UTF-8'),
                "long_description_en" => htmlspecialchars($request->long_description_en, ENT_QUOTES, 'UTF-8'),
                "long_description_ar" => htmlspecialchars($request->long_description_ar, ENT_QUOTES, 'UTF-8'),
                "discount_percentage" => $request->discount_percentage,


            ]);
        } else {
            // إذا مفيش صورة جديدة، بس حدّث باقي البيانات
            $bundel->update([
                // "category_id" => $request->category_id,
                "name_en" => $request->name_en,
                "name_ar" => $request->name_ar,
                "short_description_en" => htmlspecialchars($request->short_description_en, ENT_QUOTES, 'UTF-8'),
                "short_description_ar" => htmlspecialchars($request->short_description_ar, ENT_QUOTES, 'UTF-8'),
                "long_description_en" => htmlspecialchars($request->long_description_en, ENT_QUOTES, 'UTF-8'),
                "long_description_ar" => htmlspecialchars($request->long_description_ar, ENT_QUOTES, 'UTF-8'),
                "discount_percentage" => $request->discount_percentage,

            ]);
        }

        return redirect()->route("bundel")->with("message", "updated successfuly");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bundel = Bundle::findOrFail($id);
        $bundel->delete();
        return redirect()->route("bundel")->with("message", "Deleted successfully");
    }
}
