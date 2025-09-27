<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $product = Product::with('category')->get();;
        return view('backend.product', compact('product'));
    }


    public function create()
    {
        $category = Category::all(); // جلب كل التصنيفات
        return view('backend.product.create', compact('category'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|image|mimes:jpeg,png,jpg',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'long_description_en' => 'required|string',
            'long_description_ar' => 'required|string',
        ]);
        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/products/'), $imageName);
        }

        Product::create([
            "category_id" => $request->category_id,
            "image" => $imageName, // اسم الصورة فقط بيتخزن
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "description_en" => $request->description_en,
            "description_ar" => $request->description_ar,
            "long_description_en" => $request->long_description_en,
            "long_description_ar" => $request->long_description_ar,

        ]);

        return redirect()->route("product")->with("message", "Created successfully");
    }


    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('backend.product.show', compact('product'));
    }


    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $category = Category::all();
        return view('backend.product.edit',["result" => $product], compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $product = Product::findOrFail(id: $old_id);

    // تحقق إذا كان فيه صورة جديدة
    if ($request->hasFile('image')) {
        if (file_exists(public_path('image/products/' . $product->image))) {
            unlink(public_path('image/products/' . $product->image)); // حذف الصورة القديمة من السيرفر
        }

        // رفع الصورة الجديدة
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image/products/'), $imageName); // حفظ الصورة في المسار

        // تحديث المنتج مع الصورة الجديدة
        $product->update([
            "category_id" => $request->category_id,
            "image" => $imageName, // تحديث اسم الصورة فقط
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "price_usd" => $request->price_usd,
            "price_egp" => $request->price_egp,
            "description_en" => htmlspecialchars($request->description_en, ENT_QUOTES, 'UTF-8'),
            "description_ar" => htmlspecialchars($request->description_ar, ENT_QUOTES, 'UTF-8'),
            "long_description_en" => htmlspecialchars($request->long_description_en, ENT_QUOTES, 'UTF-8'),
            "long_description_ar" => htmlspecialchars($request->long_description_ar, ENT_QUOTES, 'UTF-8'),

        ]);
    } else {
        // إذا مفيش صورة جديدة، بس حدّث باقي البيانات
        $product->update([
            "category_id" => $request->category_id,
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "price_usd" => $request->price_usd,
            "price_egp" => $request->price_egp,
            "description_en" => htmlspecialchars($request->description_en, ENT_QUOTES, 'UTF-8'),
            "description_ar" => htmlspecialchars($request->description_ar, ENT_QUOTES, 'UTF-8'),
            "long_description_en" => htmlspecialchars($request->long_description_en, ENT_QUOTES, 'UTF-8'),
            "long_description_ar" => htmlspecialchars($request->long_description_ar, ENT_QUOTES, 'UTF-8'),

        ]);
    }

        return redirect()->route("product")->with("message", "updated successfuly");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route("product")->with("message", "Deleted successfully");
    }

}
