<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's orders statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $user->id)->where('status', 'processing')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();
        
        // Get total spent
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('orderItems.book')
            ->latest()
            ->take(5)
            ->get();
        
        // Get cart count
        $cartCount = $user->carts()->sum('quantity');
        
        // Get recommended books (latest books not in user's orders)
        $purchasedBookIds = Order::where('user_id', $user->id)
            ->with('orderItems')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->pluck('book_id')
            ->unique()
            ->toArray();
        
        $recommendedBooks = Book::whereNotIn('id', $purchasedBookIds)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalSpent',
            'recentOrders',
            'cartCount',
            'recommendedBooks'
        ));
    }
}
