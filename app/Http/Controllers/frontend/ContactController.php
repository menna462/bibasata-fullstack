<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('include.contact', compact('categories'));
    }
public function submitContactForm(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|min:10',
    ]);

    $data = $request->only('name', 'email', 'phone', 'message');

    try {
        Mail::to('mennaala407@gmail.com')->send(new ContactUsMail($data));
        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح!');
    } catch (\Exception $e) {
        Log::error('Email Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الرسالة.');
    }
}

}
