<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use Illuminate\Http\Request;

class CoverController extends Controller
{
    public function index()
    {
        $cover = Cover::all();
        return view('backend.cover', compact('cover'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.cover.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // ✅ نحفظ الصورة داخل مجلد يمكن الوصول إليه من الدومين
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/cover/', $imageName);
        }

        Cover::create([
            "image" => $imageName,
        ]);

        return redirect()->route("cover")->with("message", "Created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    public function edit(string $id)
    {
        $cover = Cover::findOrFail($id);
        return view('backend.cover.edit', ["result" => $cover]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $cover = Cover::findOrFail($old_id);

        if ($request->hasFile('image')) {
            // ✅ نحذف الصورة القديمة لو موجودة
            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/image/cover/' . $cover->image;
            if ($cover->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // ✅ نرفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/cover/', $imageName);

            // ✅ نحدث الداتا
            $cover->update([
                "image" => $imageName,
            ]);
        }

        return redirect()->route("cover")->with("message", "Updated successfully");
    }

    public function destroy(string $id)
    {
        $cover = Cover::findOrFail($id);

        // ✅ نحذف الصورة من السيرفر
        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/image/cover/' . $cover->image;
        if ($cover->image && file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        $cover->delete();

        return redirect()->route("cover")->with("message", "Deleted successfully");
    }
}
