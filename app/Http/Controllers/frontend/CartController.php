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
        $cart = session()->get('cart', []);
        $formattedCartItems = [];
        $cartTotal = 0;

        $currency = session()->get('user_currency', 'EGP');

        foreach ($cart as $durationPriceId => $itemDetails) {
            $durationPrice = DurationPrice::with(['product', 'bundle'])->find($durationPriceId);

            if ($durationPrice) {
                // اختيار السعر حسب العملة
                $price = $currency === 'EGP'
                    ? $durationPrice->price_egp
                    : $durationPrice->price_usd;

                $itemTotal = $price * $itemDetails['quantity'];

                $cartItem = [
                    'duration_price_id' => $durationPrice->id,
                    'quantity' => $itemDetails['quantity'],
                    'price' => $price, // السعر حسب العملة
                    'total_price' => $itemTotal,
                    'duration_in_months' => $durationPrice->duration_in_months,
                ];

                if ($durationPrice->product_id) {
                    $cartItem['type'] = 'product';
                    $cartItem['id'] = $durationPrice->product->id;
                    $cartItem['name_en'] = $durationPrice->product->name_en ?? 'Product Name Not Available';
                    $cartItem['image'] = $durationPrice->product->image;
                } elseif ($durationPrice->bundle_id) {
                    $cartItem['type'] = 'bundle';
                    $cartItem['id'] = $durationPrice->bundle->id;
                    $cartItem['name_en'] = $durationPrice->bundle->name_en ?? 'Bundle Name Not Available';
                    $cartItem['image'] = $durationPrice->bundle->image;
                }

                $formattedCartItems[$durationPriceId] = $cartItem;
                $cartTotal += $itemTotal;
            } else {
                unset($cart[$durationPriceId]);
                session()->put('cart', $cart);
            }
        }

        return view('include.cart_price', compact('formattedCartItems', 'cartTotal', 'cart'));
    }


    public function add(Request $request)
    {
        $durationPriceId = $request->input('duration_price_id');
        $quantity = $request->input('quantity', 1);

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

        return redirect()->back()->with('success', __('language.added_to_cart'));
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

                $availableAccountQuery->where('duration_in_days', $durationInDays);

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

            // بعد تسجيل الطلب بنجاح نحذف السلة
            Session::forget('cart');
        });

        // ✅ التوجيه إلى صفحة الدفع بعد نجاح الطلب
        return redirect()->route('payment.page')->with('success', 'Your order has been created. Please complete the payment.');

    } catch (\Exception $e) {
        Log::error('Checkout failed: ' . $e->getMessage(), [
            'exception' => $e,
            'user_id' => $userId,
            'cart' => $cart
        ]);
        return redirect()->route('cart')->with('error', 'Failed to place your order: ' . $e->getMessage());
    }
}

}
