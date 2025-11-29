<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('book')->where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->book->price;
        });

        // Check if this is user's first purchase
        $isFirstPurchase = !auth()->user()->orders()->where('payment_status', 'paid')->exists();

        return view('checkout.index', compact('cartItems', 'total', 'isFirstPurchase'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:transfer,cod,wallet',
            'notes' => 'nullable|string|max:500',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $cartItems = Cart::with('book')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->book->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok buku '{$item->book->title}' tidak mencukupi!");
            }
        }

        DB::beginTransaction();

        try {
            $subtotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->book->price;
            });

            $discountAmount = 0;
            $couponId = null;
            $discountType = null;
            $discountDescription = null;

            // Handle coupon
            if (!empty($validated['coupon_code'])) {
                $coupon = Coupon::where('code', strtoupper($validated['coupon_code']))->first();
                
                if ($coupon) {
                    $validation = $coupon->canBeUsedBy(auth()->user());
                    
                    if ($validation['valid'] && $subtotal >= ($coupon->min_purchase ?? 0)) {
                        $discountAmount = $coupon->calculateDiscount($subtotal);
                        $couponId = $coupon->id;
                        $discountType = 'coupon';
                        $discountDescription = "Kupon {$coupon->code}: {$coupon->discount_label}";
                    }
                }
            }

            $totalAmount = $subtotal - $discountAmount;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_type' => $discountType,
                'discount_description' => $discountDescription,
                'coupon_id' => $couponId,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_phone' => $validated['shipping_phone'],
                'notes' => $validated['notes'],
            ]);

            // Record coupon usage
            if ($coupon && $couponId) {
                $coupon->recordUsage(auth()->user(), $order, $discountAmount);
            }

            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                    'subtotal' => $item->quantity * $item->book->price,
                ]);

                // Reduce stock
                $item->book->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
