<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // لاستخدام Mail Facade
use App\Mail\AccountDetailsMail; // استيراد الـ Mailable الذي أنشأناه
use App\Models\Account;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with(['user', 'product', 'account', 'bundle'])->get();;
        return view('backend.order', compact('orders'));
    }
    public function markAsPaidAndSendAccount(Request $request, $orderId)
    {
        $order = Order::with(['user', 'account', 'product', 'bundle'])->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->is_paid) {
            return redirect()->back()->with('error', 'This order has already been marked as paid.');
        }

        // تحديث حالة الطلب إلى مدفوع دائمًا
        $order->is_paid = true;
        $order->save();

        // التحقق مما إذا كان الطلب مرتبطًا بحساب
        if ($order->account) {
            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new AccountDetailsMail($order));
                    Log::info("Account details email sent to {$order->user->email} for order #{$order->id}");
                    return redirect()->back()->with('success', 'Order marked as paid and account details sent to user email.');
                } else {
                    Log::warning("Could not send account details for order #{$order->id}: User email not found.");
                    return redirect()->back()->with('error', 'Order marked as paid, but could not send email (user email not found).');
                }
            } catch (\Exception $e) {
                Log::error('Failed to send account details email: ' . $e->getMessage(), ['order_id' => $order->id, 'exception' => $e]);
                return redirect()->back()->with('error', 'Order marked as paid, but email sending failed: ' . $e->getMessage());
            }
        } else {
            // إذا لم يكن هناك حساب مرتبط، يتم إرسال رسالة مختلفة
            return redirect()->back()->with('success', 'Order marked as paid. No account was associated with this order, so no email was sent.');
        }
    }
    public function resendEmail(Order $order)
    {
        if (!$order->is_paid) {
            return redirect()->back()->with('message', 'الطلب لم يتم دفعه بعد، لا يمكن إعادة إرسال الإيميل.');
        }

        try {
            Mail::to($order->user->email)->send(new AccountDetailsMail($order));

            return redirect()->back()->with('message', 'تم إعادة إرسال تفاصيل الحساب بنجاح.');
        } catch (\Exception $e) {

            return redirect()->back()->with('message', 'حدث خطأ أثناء إعادة إرسال الإيميل: ' . $e->getMessage());
        }
    }
    public function create() {}


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Find available accounts for the same product/bundle and duration
        $availableAccounts = Account::where('is_full', false)
            ->where('duration_in_days', $order->duration_in_days)
            ->where(function ($query) use ($order) {
                if ($order->product_id) {
                    $query->where('product_id', $order->product_id);
                } elseif ($order->bundle_id) {
                    $query->where('bundle_id', $order->bundle_id);
                }
            })
            ->get();

        return view('backend.orders.edit', compact('order', 'availableAccounts'));
    }


    public function update(Request $request, Order $order)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
        ]);

        $accountId = $request->input('account_id');
        $account = Account::find($accountId);

        if (!$account) {
            return redirect()->back()->with('error', 'Account not found.');
        }

        // Update the order with the selected account
        $order->account_id = $accountId;
        $order->start_date = now(); // Reset start date to now
        $order->end_date = now()->addDays($order->duration_in_days); // Recalculate end date
        $order->save();

        // Update the account's user count
        $account->current_users += 1;
        $account->is_full = ($account->current_users >= $account->max_users);
        $account->save();

        return redirect()->route('order')->with('success', 'Account has been successfully linked to the order.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
