<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Apply a coupon code
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $code = strtoupper(trim($request->code));
        $subtotal = $request->subtotal;

        // Find coupon
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak ditemukan.',
            ], 404);
        }

        // Check if coupon can be used by this user
        $canUse = $coupon->canBeUsedBy($user);
        if (!$canUse['valid']) {
            return response()->json([
                'success' => false,
                'message' => $canUse['message'],
            ], 400);
        }

        // Check minimum purchase
        if ($subtotal < $coupon->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian Rp ' . number_format($coupon->min_purchase, 0, ',', '.') . ' untuk menggunakan kupon ini.',
            ], 400);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'discount_label' => $coupon->discount_label,
            ],
            'discount' => $discount,
            'new_total' => max(0, $subtotal - $discount),
        ]);
    }

    /**
     * Remove applied coupon
     */
    public function remove(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus.',
        ]);
    }

    /**
     * Check if user is first time buyer (for first purchase coupon)
     */
    public function checkFirstPurchase()
    {
        $user = Auth::user();
        $hasPaidOrders = $user->orders()->where('payment_status', 'paid')->exists();

        // Find active first purchase coupon
        $firstPurchaseCoupon = Coupon::active()
            ->where('is_first_purchase_only', true)
            ->first();

        return response()->json([
            'is_first_purchase' => !$hasPaidOrders,
            'coupon' => $firstPurchaseCoupon ? [
                'code' => $firstPurchaseCoupon->code,
                'name' => $firstPurchaseCoupon->name,
                'discount_label' => $firstPurchaseCoupon->discount_label,
            ] : null,
        ]);
    }
}
