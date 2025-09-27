<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\DurationPrice;
use App\Models\Product;
use Illuminate\Http\Request;

class DurationPriceController extends Controller
{
    public function index()
    {
        $durations = DurationPrice::with(['product', 'bundle'])->get();
        return view('backend.durationprice', compact('durations'));
    }

    public function create()
    {
        $products = Product::all();
        $bundles = Bundle::all();
        return view('backend.product-price.create', compact('products', 'bundles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'duration_in_months' => 'required|integer|min:1',
            'price_usd' => 'required|numeric|min:0',
            'price_egp' => 'required|numeric|min:0',
        ]);

        DurationPrice::create($request->all());
        return redirect()->route('durationprice')->with('message', 'Duration Price Added Successfully');
    }

    public function edit($id)
    {
        $duration = DurationPrice::findOrFail($id);
        $product = Product::all();
        $bundles = Bundle::all();
        return view('backend.durationprice.edit', compact('duration', 'product', 'bundles'));
    }

  public function update(Request $request)
    {
        $duration_id = $request->input('id');
        $duration = DurationPrice::findOrFail($duration_id);

        $request->validate([
            'duration_in_months' => 'required|integer|min:1',
            'price_usd' => 'required|numeric|min:0',
            'price_egp' => 'required|numeric|min:0',
            // أضيفي validation لـ product_id و bundle_id لو لسه مش موجود
            'product_id' => 'nullable|exists:products,id',
            'bundle_id' => 'nullable|exists:bundles,id',
        ]);

        $duration->update($request->all());
        return redirect()->route('durationprice')->with('message', 'Updated Successfully');
    }


    public function destroy($id)
    {
        DurationPrice::findOrFail($id)->delete();
        return redirect()->route('durationprice')->with('message', 'Deleted Successfully');
    }
}
