<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('book')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->book->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1|max:' . $book->stock,
        ]);

        $quantity = $validated['quantity'] ?? 1;

        if ($book->stock < $quantity) {
            return redirect()->back()
                ->with('error', 'Stok buku tidak mencukupi!');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $book->stock) {
                return redirect()->back()
                    ->with('error', 'Stok buku tidak mencukupi!');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->book->stock,
        ]);

        $cart->update($validated);

        return redirect()->back()
            ->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()
            ->with('success', 'Buku berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->back()
            ->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
