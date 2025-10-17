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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.slider.create");
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
            $image->move(base_path('image/slider/'), $imageName);
        }
        Slider::create([
            "image" => $imageName,
        ]);
        return redirect()->route("slider")->with("message", "Creeted successfully");
    }


    public function show( )
    {
        //
    }


    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.categories.edit', ["result" => $slider]);
    }


    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $slider = Slider::findOrFail($old_id);

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path('image/slider/' . $slider->image))) {
                unlink(base_path('image/slider/' . $slider->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(base_path('image/category/'), $imageName);

            $slider->update([
                "image" => $imageName,
            ]);
        }


        return redirect()->route("slider")->with("message", "updated successfuly");
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route("slider")->with("message", "Deleted successfully");
    }
}
