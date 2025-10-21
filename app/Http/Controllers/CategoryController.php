<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('backend.category', compact('category'));
    }

    public function create()
    {
        return view("backend.categories.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,gif',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);

        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            // ✅ نحفظ الصورة في مجلد public
           $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/category/', $imageName);
        }

        Category::create([
            "image" => $imageName,
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
        ]);

        return redirect()->route("category")->with("message", "Created successfully");
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', ["result" => $category]);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $category = Category::findOrFail($old_id);

        if ($request->hasFile('image')) {
            // ✅ نحذف الصورة القديمة لو موجودة
            if ($category->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/category/' . $category->image)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/image/category/' . $category->image);
                    }

            // ✅ رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/category/', $imageName);

            $category->update([
                "image" => $imageName,
                "name_en" => $request->name_en,
                "name_ar" => $request->name_ar,
            ]);
        } else {
            $category->update([
                "name_en" => $request->name_en,
                "name_ar" => $request->name_ar,
            ]);
        }

        return redirect()->route("category")->with("message", "Updated successfully");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route("category")->with("message", "Deleted successfully");
    }
}
