<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // استدعي موديل Product
use App\Models\Bundle;  // استدعي موديل Bundle
use App\Models\Favorite; // استدعي موديل Favorite (الـ Pivot Model)
use Carbon\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{

    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:product,bundle',
        ]);

        // التأكد إن المستخدم مسجل دخوله
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please log in to add to favorites.'], 401);
        }

        $user = Auth::user();
        $favoritableId = $request->favoritable_id;
        $favoritableType = $request->favoritable_type;

        // بناء اسم الكلاس الكامل
        $modelClass = 'App\\Models\\' . ucfirst($favoritableType);

        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid favoritable type provided.'], 400);
        }

        // البحث عن العنصر (المنتج أو الـ Bundle)
        $favoritable = $modelClass::find($favoritableId);

        if (!$favoritable) {
            return response()->json(['status' => 'error', 'message' => ucfirst($favoritableType) . ' not found.'], 404);
        }

        // التحقق مما إذا كان العنصر مفضلاً بالفعل
        $isFavorited = $user->allFavorites()
            ->where('favoritable_id', $favoritableId)
            ->where('favoritable_type', $modelClass)
            ->exists();

        if ($isFavorited) {
            // إذا كان مفضلاً، قم بإزالته
            Favorite::where('user_id', $user->id)
                ->where('favoritable_id', $favoritableId)
                ->where('favoritable_type', $modelClass)
                ->delete();
            return response()->json(['status' => 'removed', 'message' => ucfirst($favoritableType) . ' removed from favorites.']);
        } else {
            // إذا لم يكن مفضلاً، قم بإضافته
            Favorite::create([
                'user_id' => $user->id,
                'favoritable_id' => $favoritableId,
                'favoritable_type' => $modelClass,
            ]);
            return response()->json(['status' => 'added', 'message' => ucfirst($favoritableType) . ' added to favorites.']);
        }
    }

    public function index(): Factory|RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your favorites.');
        }

        $user = Auth::user();
        $favorites = $user->allFavorites()->with('favoritable')->paginate(10); // paginate لعرض 10 عناصر في الصفحة

        return view('include.favorites', compact('favorites'));
    }
    public function removeFavorite(Request $request)
    {
        $request->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:product,bundle',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your favorites.');
        }

        $user = Auth::user();
        $favoritableId = $request->favoritable_id;
        $favoritableType = $request->favoritable_type;
        $modelClass = 'App\\Models\\' . ucfirst($favoritableType);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('favoritable_id', $favoritableId)
            ->where('favoritable_type', $modelClass)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'تمت إزالة العنصر من المفضلة بنجاح.');
        }

        return redirect()->back()->with('error', 'العنصر المحدد غير موجود في المفضلة.');
    }
}
