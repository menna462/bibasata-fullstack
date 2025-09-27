<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
     public function store(Request $request)
    {
        $rules = [
            'content' => 'required|string|max:1000',
            'page_name' => 'required|string|in:homepage', // تأكد إن التعليق ده للصفحة الرئيسية بس
        ];

        // لو المستخدم مش مسجل دخول، خليه يدخل اسمه
        if (!Auth::check()) {
            $rules['guest_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $commentData = [
            'content' => $request->input('content'),
            'page_name' => 'homepage', // دايماً للصفحة الرئيسية
        ];

        // لو المستخدم مسجل دخول، استخدم الـ user_id بتاعه
        if (Auth::check()) {
            $commentData['user_id'] = Auth::id();
        } else {
            // لو مش مسجل، استخدم الاسم اللي كتبه كضيف
            $commentData['guest_name'] = $request->input('guest_name');
        }

        Comment::create($commentData);

        return back()->with('success', 'تم إضافة تعليقك بنجاح!');
    }
    public function update(Request $request, Comment $comment)
{
    // تحقق من أن المستخدم الحالي هو صاحب التعليق
    if (Auth::id() !== $comment->user_id) {
        return back()->with('error', 'غير مصرح لك بتعديل هذا التعليق.');
    }

    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comment->update([
        'content' => $request->input('content'),
    ]);

    return back()->with('success', 'تم تحديث التعليق بنجاح!');
}

public function destroy(Comment $comment)
{
    // تحقق من أن المستخدم الحالي هو صاحب التعليق
    if (Auth::id() !== $comment->user_id) {
        return back()->with('error', 'غير مصرح لك بحذف هذا التعليق.');
    }

    $comment->delete();

    return back()->with('success', 'تم حذف التعليق بنجاح!');
}
}
