<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'low_stock_books' => Book::where('stock', '<', 10)->take(5)->get(),
        ];

        // Revenue stats
        $stats['total_revenue'] = Order::where('status', 'delivered')->sum('total_amount');
        $stats['monthly_revenue'] = Order::where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');
        
        // Orders this month
        $stats['orders_this_month'] = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // New users this month
        $stats['new_users_this_month'] = User::where('role', 'user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Orders by status for chart
        $stats['orders_by_status'] = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Monthly revenue for the last 6 months
        $stats['monthly_chart'] = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Order::where('status', 'delivered')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            $orders = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $stats['monthly_chart'][] = [
                'month' => $date->format('M'),
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        // Top selling books
        $stats['top_books'] = Book::select('books.id', 'books.title', 'books.author', 'books.cover_image', 'books.price', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->leftJoin('order_items', 'books.id', '=', 'order_items.book_id')
            ->groupBy('books.id', 'books.title', 'books.author', 'books.cover_image', 'books.price')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats'));
    }
}
