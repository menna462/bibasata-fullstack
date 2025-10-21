<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::all();
        return view('backend.slider', compact('slider'));
    }

    public function create()
    {
        return view("backend.slider.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $imageName = null;

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // ✅ نحفظ الصورة داخل مجلد public/image/slider/
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/slider/', $imageName);
        }

        Slider::create([
            "image" => $imageName,
        ]);

        return redirect()->route("slider")->with("message", "Created successfully");
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit', ["result" => $slider]);
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $slider = Slider::findOrFail($old_id);

        if ($request->hasFile('image')) {
            // ✅ حذف الصورة القديمة
            if ($slider->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/slider/' . $slider->image)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/image/slider/' . $slider->image);
            }

            // ✅ رفع الصورة الجديدة في نفس المسار
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/image/slider/', $imageName);

            $slider->update([
                "image" => $imageName,
            ]);
        }

        return redirect()->route("slider")->with("message", "Updated successfully");
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        // ✅ نحذف الصورة من السيرفر قبل حذف السجل
        if ($slider->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/image/slider/' . $slider->image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/image/slider/' . $slider->image);
        }

        $slider->delete();

        return redirect()->route("slider")->with("message", "Deleted successfully");
    }
}
