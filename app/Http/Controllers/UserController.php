<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('backend.user', compact('users'));
    }

    public function create()
    {
        return view("backend.user.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:20|unique:users,phone_number', // مطلوب وفريد
            'role' => 'required|in:admin,user,editor',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني موجود بالفعل.',
            'phone_number.required' => 'رقم الهاتف مطلوب.', // **تمت إضافتها**
            'phone_number.unique' => 'رقم الهاتف هذا موجود بالفعل لمستخدم آخر.', // **تمت إضافتها**
            'phone_number.max' => 'رقم الهاتف لا يجب أن يتجاوز 20 حرفًا.',
        ]);

        User::create([
            // "id" => $request->id, // **تمت إزالة هذا السطر - لا ترسل الـ ID عند الإنشاء**
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "phone_number" => $request->phone_number,
            "role" => $request->role,
        ]);

        return redirect()->route("users")->with("message", "Created successfully");
    }

    public function show(string $id)
    {
        $users = User::findOrFail($id);
        return view('backend.user.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view('backend.user.edit', ["result" => $users]);
    }

    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->route("users")->with("message", "Deleted successfully");
    }

    public function update(Request $request)
    {
        $old_id = $request->old_id;
        $users = User::findOrFail($old_id);

        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($old_id),
            ],
            'role' => ['required', Rule::in(['admin', 'user', 'editor'])],
            'phone_number' => [ // رقم الهاتف عند التحديث: اختياري وفريد مع تجاهل المستخدم الحالي
                'nullable', // هنا بنخليه اختياري في التحديث
                'string',
                'max:20',
                Rule::unique('users', 'phone_number')->ignore($old_id),
            ],
        ], [
            'phone_number.unique' => 'رقم الهاتف هذا موجود بالفعل لمستخدم آخر.', // رسالة مخصصة للتحديث
            'phone_number.max' => 'رقم الهاتف لا يجب أن يتجاوز 20 حرفًا.', // رسالة مخصصة للتحديث
        ]);


        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->role;
        $users->phone_number = $request->phone_number;

        // تحديث كلمة المرور فقط إذا تم إدخالها
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6',
            ]);
            $users->password = bcrypt($request->password);
        }

        $users->save();

        return redirect()->route("users")->with("message", "Updated successfully");
    }
}
