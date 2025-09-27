<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bundle;
use App\Models\DurationPrice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // لاستخدام Session
use Illuminate\Support\Facades\DB; // لاستخدام المعاملات (Transactions)
use Illuminate\Support\Facades\Log; // لتسجيل الأخطاء
use Illuminate\Support\Facades\Auth; // للتحقق من المستخدم المسجل دخولاً
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // استرجاع بيانات سلة التسوق من الجلسة (Session)
        $cart = session()->get('cart', []);
        $formattedCartItems = [];
        $cartTotal = 0;

        foreach ($cart as $durationPriceId => $itemDetails) {
            // جلب البيانات من جدول duration_prices مع علاقاته
            $durationPrice = DurationPrice::with(['product', 'bundle'])->find($durationPriceId);

            if ($durationPrice) {
                $itemTotal = $durationPrice->price_usd * $itemDetails['quantity'];

                $cartItem = [
                    'duration_price_id' => $durationPrice->id,
                    'quantity' => $itemDetails['quantity'],
                    'price_usd' => $durationPrice->price_usd,
                    'total_price_usd' => $itemTotal,
                    // التعديل هنا: جلب المدة مباشرة من durationPrice
                    'duration_in_months' => $durationPrice->duration_in_months,
                ];

                if ($durationPrice->product_id) {
                    $cartItem['type'] = 'product';
                    $cartItem['id'] = $durationPrice->product->id;
                    // التعديل هنا: التأكد من جلب الاسم بشكل صحيح
                    $cartItem['name_en'] = $durationPrice->product->name_en ?? 'Product Name Not Available';
                    $cartItem['image'] = $durationPrice->product->image;
                } elseif ($durationPrice->bundle_id) {
                    $cartItem['type'] = 'bundle';
                    $cartItem['id'] = $durationPrice->bundle->id;
                    // التعديل هنا: التأكد من جلب الاسم بشكل صحيح
                    $cartItem['name_en'] = $durationPrice->bundle->name_en ?? 'Bundle Name Not Available';
                    $cartItem['image'] = $durationPrice->bundle->image;
                }

                $formattedCartItems[$durationPriceId] = $cartItem;
                $cartTotal += $itemTotal;
            } else {
                // إذا لم يتم العثور على المنتج، يتم حذفه من السلة (Session)
                unset($cart[$durationPriceId]);
                session()->put('cart', $cart);
            }
        }
        return view('include.cart', compact('formattedCartItems', 'cartTotal', 'cart'));
    }

    public function add(Request $request)
    {
        // We now expect 'duration_price_id' and 'quantity' from the request
        $durationPriceId = $request->input('duration_price_id');
        $quantity = $request->input('quantity', 1);

        // Basic validation
        $request->validate([
            'duration_price_id' => 'required|exists:duration_prices,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$durationPriceId])) {
            $cart[$durationPriceId]['quantity'] += $quantity;
        } else {
            $cart[$durationPriceId] = [
                "quantity" => $quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart!');
    }


    public function update(Request $request, $durationPriceId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$durationPriceId])) {
            if ($request->has('action')) {
                if ($request->input('action') == 'increase') {
                    $cart[$durationPriceId]['quantity']++;
                } elseif ($request->input('action') == 'decrease') {
                    if ($cart[$durationPriceId]['quantity'] > 1) {
                        $cart[$durationPriceId]['quantity']--;
                    }
                }
            } elseif ($request->has('quantity')) {
                $quantity = (int) $request->input('quantity');
                if ($quantity > 0) {
                    $cart[$durationPriceId]['quantity'] = $quantity;
                } else {
                    unset($cart[$durationPriceId]);
                }
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove($durationPriceId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$durationPriceId])) {
            unset($cart[$durationPriceId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart!');
        }
        return redirect()->back()->with('error', 'Item not found in cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    public function getCartItemCount(Request $request)
    {
        $cart = $this->getCartForCurrentUser();
        $itemCount = 0;

        if ($cart) {
            foreach ($cart->items as $item) {
                $itemCount += $item->quantity;
            }
        }

        return response()->json(['count' => $itemCount]);
    }
    public function checkout(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in to proceed with checkout.');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        try {
            DB::transaction(function () use ($cart, $userId) {
                foreach ($cart as $durationPriceId => $itemDetails) {
                    $durationPrice = DurationPrice::with(['product', 'bundle'])->find($durationPriceId);

                    if (!$durationPrice) {
                        throw new \Exception("Duration price with ID {$durationPriceId} not found in database.");
                    }

                    $itemType = null;
                    $itemId = null;

                    if ($durationPrice->product_id) {
                        $itemType = 'product';
                        $itemId = $durationPrice->product_id;
                    } elseif ($durationPrice->bundle_id) {
                        $itemType = 'bundle';
                        $itemId = $durationPrice->bundle_id;
                    } else {
                        throw new \Exception("Cart item (DurationPrice ID: {$durationPriceId}) is not linked to a product or bundle. Cannot proceed with checkout.");
                    }

                    $quantity = $itemDetails['quantity'];
                    $durationInDays = $durationPrice->duration_in_months * 30;

                    $availableAccountQuery = Account::where('is_full', false)
                        ->whereRaw('current_users < max_users');

                    if ($itemType === 'product') {
                        $availableAccountQuery->where('product_id', $itemId);
                    } elseif ($itemType === 'bundle') {
                        $availableAccountQuery->where('bundle_id', $itemId);
                    }

                    // ** إضافة الشرط الجديد للبحث بناءً على المدة **
                    // هذا يضمن أن الحساب المتاح يتطابق مع المدة التي اشتراها المستخدم
                    $availableAccountQuery->where('duration_in_days', $durationInDays);
                    // ** نهاية الإضافة **

                    $availableAccount = $availableAccountQuery->first();
                    $accountId = null;

                    if ($availableAccount) {
                        $availableAccount->current_users += 1;
                        $availableAccount->is_full = ($availableAccount->current_users >= $availableAccount->max_users);
                        $availableAccount->save();
                        $accountId = $availableAccount->id;
                    }

                    $orderDate = Carbon::now();
                    $startDate = Carbon::now();
                    $endDate = $startDate->copy()->addDays($durationInDays);

                    Order::create([
                        'user_id' => $userId,
                        'product_id' => ($itemType === 'product' ? $itemId : null),
                        'bundle_id' => ($itemType === 'bundle' ? $itemId : null),
                        'account_id' => $accountId,
                        'duration_in_days' => $durationInDays,
                        'order_date' => $orderDate,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]);
                }
                Session::forget('cart');
            });

            return redirect()->route('cart')->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e, 'user_id' => $userId, 'cart' => $cart]);
            return redirect()->route('cart')->with('error', 'Failed to place your order: ' . $e->getMessage());
        }
    }
}
