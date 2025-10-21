<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with('category')->get();
        return view('backend.product', compact('product'));
    }

    public function create()
    {
        $category = Category::all();
        return view('backend.product.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'long_description_en' => 'required|string',
            'long_description_ar' => 'required|string',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // ✅ نحفظ الصورة في المسار داخل public_html/image/products/
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/products/', $imageName);
        }

        Product::create([
            "category_id" => $request->category_id,
            "image" => $imageName,
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "description_en" => $request->description_en,
            "description_ar" => $request->description_ar,
            "long_description_en" => $request->long_description_en,
            "long_description_ar" => $request->long_description_ar,
            "price_usd" => $request->price_usd,
            "price_egp" => $request->price_egp,
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
        return view('backend.product.edit', ["result" => $product], compact('category'));
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $product = Product::findOrFail($old_id);

        if ($request->hasFile('image')) {
            // ✅ نحذف الصورة القديمة من نفس المسار
            if ($product->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/products/' . $product->image)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/image/products/' . $product->image);
            }

            // ✅ رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/products/', $imageName);

            $product->update([
                "category_id" => $request->category_id,
                "image" => $imageName,
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

        return redirect()->route("product")->with("message", "Updated successfully");
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // ✅ نحذف الصورة من السيرفر
        if ($product->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/products/' . $product->image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/image/products/' . $product->image);
        }

        $product->delete();
        return redirect()->route("product")->with("message", "Deleted successfully");
    }
}
