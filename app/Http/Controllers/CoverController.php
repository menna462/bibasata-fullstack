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
            'images' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/cover/'), $imageName);
        }
        Cover::create([
            "image" => $imageName,
        ]);
        return redirect()->route("cover")->with("message", "Creeted successfully");
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
            if ($cover->image && file_exists(public_path('image/cover/' . $cover->image))) {
                unlink(public_path('image/cover/' . $cover->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/category/'), $imageName);

            // تحديث الفئة مع الصورة الجديدة
            $cover->update([
                "image" => $imageName,
            ]);
        }


        return redirect()->route("cover")->with("message", "updated successfuly");
    }

    public function destroy(string $id)
    {
        $cover = Cover::findOrFail($id);
        $cover->delete();
        return redirect()->route("cover")->with("message", "Deleted successfully");
    }
}
