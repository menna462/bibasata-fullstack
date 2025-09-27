<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return view('backend.category', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);
        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/category/'), $imageName);
        }
        Category::create([
            "image" => $imageName,
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
        ]);
        return redirect()->route("category")->with("message", "Creeted successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }


    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', ["result" => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $category = Category::findOrFail($old_id);

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('image/category/' . $category->image))) {
                unlink(public_path('image/category/' . $category->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/category/'), $imageName);

            // تحديث الفئة مع الصورة الجديدة
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

        return redirect()->route("category")->with("message", "updated successfuly");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route("category")->with("message", "Deleted successfully");
    }
}
