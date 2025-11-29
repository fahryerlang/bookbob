<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display reviews for a book (API endpoint)
     */
    public function index(Book $book)
    {
        $reviews = $book->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return response()->json([
            'reviews' => $reviews,
            'average_rating' => $book->average_rating,
            'review_count' => $book->review_count,
            'breakdown' => $book->getRatingBreakdown(),
        ]);
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Order $order, Book $book)
    {
        $user = Auth::user();

        // Validate order belongs to user and is completed
        if ($order->user_id !== $user->id) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Anda hanya dapat memberikan ulasan untuk pesanan yang sudah selesai.');
        }

        // Check if book is in this order
        $orderItem = $order->orderItems()->where('book_id', $book->id)->first();
        if (!$orderItem) {
            return back()->with('error', 'Buku tidak ditemukan dalam pesanan ini.');
        }

        // Check if already reviewed
        if ($order->hasReviewedBook($book->id)) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'is_verified_purchase' => true,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, Review $review)
    {
        $user = Auth::user();

        if (!$review->canBeEditedBy($user)) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit ulasan ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Ulasan berhasil diperbarui.');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        $user = Auth::user();

        if (!$review->canBeEditedBy($user)) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus ulasan ini.');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    /**
     * Show review form for an order item
     */
    public function create(Order $order, Book $book)
    {
        $user = Auth::user();

        // Validate order belongs to user
        if ($order->user_id !== $user->id) {
            abort(404);
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Anda hanya dapat memberikan ulasan untuk pesanan yang sudah selesai.');
        }

        // Check if book is in this order
        $orderItem = $order->orderItems()->where('book_id', $book->id)->first();
        if (!$orderItem) {
            abort(404);
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('order_id', $order->id)
            ->first();

        return view('reviews.create', [
            'order' => $order,
            'book' => $book,
            'orderItem' => $orderItem,
            'existingReview' => $existingReview,
        ]);
    }
}
