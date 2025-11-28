<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.book')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.book']);

        return view('orders.show', compact('order'));
    }

    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return redirect()->back()
                ->with('error', 'Pesanan sudah dibayar!');
        }

        // In a real application, this would integrate with a payment gateway
        // For now, we'll just mark it as paid
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'status' => 'processing',
        ]);

        return redirect()->back()
            ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending'])) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan!');
        }

        // Restore stock
        foreach ($order->orderItems as $item) {
            $item->book->increment('stock', $item->quantity);
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()
            ->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
