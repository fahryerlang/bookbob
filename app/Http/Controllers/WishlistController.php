<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the wishlist.
     */
    public function index()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('book.category')
            ->latest()
            ->get();

        // Count items with price drop
        $priceDropCount = $wishlists->filter(fn($w) => $w->hasPriceDropped())->count();

        return view('wishlist.index', compact('wishlists', 'priceDropCount'));
    }

    /**
     * Toggle wishlist (add/remove).
     */
    public function toggle(Request $request, Book $book)
    {
        $user = auth()->user();
        $wishlist = $user->wishlists()->where('book_id', $book->id)->first();

        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
            $message = 'Buku dihapus dari wishlist';
            $inWishlist = false;
        } else {
            // Add to wishlist
            $user->wishlists()->create([
                'book_id' => $book->id,
                'price_when_added' => $book->price,
            ]);
            $message = 'Buku ditambahkan ke wishlist';
            $inWishlist = true;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'in_wishlist' => $inWishlist,
                'wishlist_count' => $user->wishlists()->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Remove from wishlist.
     */
    public function remove(Wishlist $wishlist)
    {
        // Check ownership
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return back()->with('success', 'Buku dihapus dari wishlist');
    }

    /**
     * Move item to cart.
     */
    public function moveToCart(Wishlist $wishlist)
    {
        // Check ownership
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $book = $wishlist->book;

        // Check stock
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis');
        }

        // Check if already in cart
        $cartItem = Cart::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            if ($cartItem->quantity < $book->stock) {
                $cartItem->increment('quantity');
            }
        } else {
            // Add to cart
            Cart::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'quantity' => 1,
            ]);
        }

        // Remove from wishlist
        $wishlist->delete();

        return back()->with('success', 'Buku dipindahkan ke keranjang');
    }

    /**
     * Move all items to cart.
     */
    public function moveAllToCart()
    {
        $user = auth()->user();
        $wishlists = $user->wishlists()->with('book')->get();
        $movedCount = 0;
        $outOfStockCount = 0;

        foreach ($wishlists as $wishlist) {
            $book = $wishlist->book;

            if ($book->stock < 1) {
                $outOfStockCount++;
                continue;
            }

            $cartItem = Cart::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity < $book->stock) {
                    $cartItem->increment('quantity');
                }
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'quantity' => 1,
                ]);
            }

            $wishlist->delete();
            $movedCount++;
        }

        $message = "{$movedCount} buku dipindahkan ke keranjang";
        if ($outOfStockCount > 0) {
            $message .= ". {$outOfStockCount} buku tidak tersedia (stok habis)";
        }

        return back()->with('success', $message);
    }

    /**
     * Clear all wishlist.
     */
    public function clear()
    {
        auth()->user()->wishlists()->delete();

        return back()->with('success', 'Wishlist dikosongkan');
    }
}
