<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Bundle;
use App\Models\DurationPrice;
use App\Models\Product;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account =  Account::with('bundle', 'product', 'durationPrice')->get();
        return view('backend.account', compact('account'));
    }


    public function create()
    {
        $products = Product::all();
        $bundles = Bundle::all();
        $durationPrices = DurationPrice::with(['product', 'bundle'])->get();
        return view('backend.account.create', compact('products', 'bundles', 'durationPrices'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|string|min:4',
            'product_or_bundle' => 'nullable|string',
            'duration_price_id' => 'nullable|exists:duration_prices,id',
            'duration_in_days' => 'nullable|integer',
            'max_users' => 'required|integer|min:1',
            'current_users' => 'required|integer|min:0',
            'is_full' => 'required|boolean',
        ]);

        $product_id = null;
        $bundle_id = null;

        if ($request->has('product_or_bundle') && $request->product_or_bundle != '') {
            if (Str::startsWith($validated['product_or_bundle'], 'product_')) {
                $product_id = Str::after($validated['product_or_bundle'], 'product_');
            } elseif (Str::startsWith($validated['product_or_bundle'], 'bundle_')) {
                $bundle_id = Str::after($validated['product_or_bundle'], 'bundle_');
            }
        }

        $is_full = ($validated['current_users'] >= $validated['max_users']);

        Account::create([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'product_id' => $product_id,
            'bundle_id' => $bundle_id,
            'duration_price_id' => $validated['duration_price_id'],
            'duration_in_days' => $validated['duration_in_days'],
            'max_users' => $validated['max_users'],
            'current_users' => $validated['current_users'],
            'is_full' => $is_full,
        ]);

        return redirect()->route('account')->with('message', 'Account created successfully.');
    }






    public function show(Account $account)
    {
        //
    }


    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $products = Product::all();
        $bundles = Bundle::all();
        $durationPrices = DurationPrice::with(['product', 'bundle'])->get();
        return view('backend.account.edit', compact('account', 'products', 'bundles', 'durationPrices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $account = Account::findOrFail($request->old_id);

        // ** ملاحظة هامة: يمكنك استخدام هذه الدالة للتأكد من القيمة التي يتم إرسالها من الفورم **
        // dd($request->all());

        $validated = $request->validate([
            'email' => 'required|email|unique:accounts,email,' . $account->id,
            'password' => 'required|string|min:4',
            'product_or_bundle' => 'nullable|string',
            'duration_price_id' => 'nullable|exists:duration_prices,id',
            'duration_in_days' => 'nullable|integer',
            'max_users' => 'required|integer|min:1',
            'current_users' => 'required|integer|min:0',
            'is_full' => 'required|boolean',
        ]);

        $account->email = $request->email;
        $account->password = $request->password;
        $account->max_users = $request->max_users;
        $account->current_users = $request->current_users;
        $account->is_full = $request->is_full;
        $account->duration_in_days = $request->duration_in_days;

        // إعادة تعيين العلاقات
        $account->product_id = null;
        $account->bundle_id = null;

        // ** تم تعديل هذا الجزء ليتطابق مع منطق دالة store **
        if ($request->has('product_or_bundle') && $request->product_or_bundle != '') {
            if (Str::startsWith($request->product_or_bundle, 'product_')) {
                $account->product_id = Str::after($request->product_or_bundle, 'product_');
            } elseif (Str::startsWith($request->product_or_bundle, 'bundle_')) {
                $account->bundle_id = Str::after($request->product_or_bundle, 'bundle_');
            }
        }

        $account->duration_price_id = $request->duration_price_id;

        $account->save();

        return redirect()->route('account')->with('message', 'Account updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return redirect()->route("account")->with("message", "Deleted successfully");
    }
}
