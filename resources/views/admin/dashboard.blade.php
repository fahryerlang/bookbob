@extends('layouts.admin')

@section('content')
<!-- Welcome Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-gray-500">Selamat datang kembali, <span class="font-medium text-indigo-600">{{ auth()->user()->name }}</span></p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <span class="text-sm text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>
</div>

<!-- Revenue Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Total Pendapatan</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-indigo-100">Dari {{ $stats['total_orders'] }} pesanan</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
    </div>

    <!-- Monthly Revenue -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-emerald-100">{{ $stats['orders_this_month'] }} pesanan bulan ini</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
    </div>

    <!-- Total Orders -->
    <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 text-white">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Total Pesanan</p>
                    <p class="text-2xl font-bold mt-2">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-amber-100">{{ $stats['pending_orders'] }} menunggu diproses</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
    </div>

    <!-- Total Users -->
    <div class="relative overflow-hidden bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl p-6 text-white">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-100 text-sm font-medium">Total Pengguna</p>
                    <p class="text-2xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-rose-100">+{{ $stats['new_users_this_month'] }} pengguna baru bulan ini</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full"></div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center space-x-4">
        <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_books'] }}</p>
            <p class="text-xs text-gray-500">Total Buku</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center space-x-4">
        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            <p class="text-xs text-gray-500">Kategori</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center space-x-4">
        <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
            <p class="text-xs text-gray-500">Menunggu</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center space-x-4">
        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['unread_messages'] }}</p>
            <p class="text-xs text-gray-500">Pesan Baru</p>
        </div>
    </div>
</div>

<!-- Charts & Tables Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Revenue Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Statistik Pendapatan</h2>
                <p class="text-sm text-gray-500">6 bulan terakhir</p>
            </div>
        </div>
        <div class="h-64 flex items-end justify-between space-x-2">
            @foreach($stats['monthly_chart'] as $data)
                @php
                    $maxRevenue = collect($stats['monthly_chart'])->max('revenue');
                    $height = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 0;
                @endphp
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full flex flex-col items-center">
                        <span class="text-xs text-gray-500 mb-2">Rp {{ number_format($data['revenue'] / 1000000, 1) }}jt</span>
                        <div class="w-full bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-t-lg transition-all duration-300 hover:from-indigo-600 hover:to-indigo-500" 
                            style="height: {{ max($height, 8) }}px; min-height: 8px;"></div>
                    </div>
                    <span class="text-xs text-gray-500 mt-2 font-medium">{{ $data['month'] }}</span>
                    <span class="text-xs text-gray-400">{{ $data['orders'] }} order</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Status Distribution -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Status Pesanan</h2>
            <p class="text-sm text-gray-500">Distribusi status saat ini</p>
        </div>
        <div class="space-y-4">
            @php
                $statusConfig = [
                    'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-500', 'bg' => 'bg-yellow-100'],
                    'paid' => ['label' => 'Dibayar', 'color' => 'bg-blue-500', 'bg' => 'bg-blue-100'],
                    'processing' => ['label' => 'Diproses', 'color' => 'bg-indigo-500', 'bg' => 'bg-indigo-100'],
                    'shipped' => ['label' => 'Dikirim', 'color' => 'bg-purple-500', 'bg' => 'bg-purple-100'],
                    'delivered' => ['label' => 'Selesai', 'color' => 'bg-green-500', 'bg' => 'bg-green-100'],
                    'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-red-500', 'bg' => 'bg-red-100'],
                ];
                $totalOrders = array_sum($stats['orders_by_status']);
            @endphp
            @foreach($statusConfig as $status => $config)
                @php
                    $count = $stats['orders_by_status'][$status] ?? 0;
                    $percentage = $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">{{ $config['label'] }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                    </div>
                    <div class="h-2 {{ $config['bg'] }} rounded-full overflow-hidden">
                        <div class="h-full {{ $config['color'] }} rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
                    <p class="text-sm text-gray-500">5 pesanan terakhir</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stats['recent_orders'] as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusStyles = [
                                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'paid' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'processing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'delivered' => 'bg-green-50 text-green-700 border-green-200',
                                        'completed' => 'bg-green-50 text-green-700 border-green-200',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'paid' => 'Dibayar',
                                        'processing' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Selesai',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusStyles[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Side Column -->
    <div class="space-y-6">
        <!-- Top Selling Books -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Buku Terlaris</h2>
                <p class="text-sm text-gray-500">Berdasarkan penjualan</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($stats['top_books'] as $index => $book)
                    <div class="p-4 flex items-center space-x-4 hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : ($index === 1 ? 'bg-gray-100 text-gray-600' : ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-gray-50 text-gray-500')) }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-shrink-0 w-10 h-14 bg-gray-100 rounded overflow-hidden">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</p>
                            <p class="text-xs text-gray-500">{{ $book->total_sold }} terjual</p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-sm">Belum ada data penjualan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-red-50 to-orange-50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Stok Rendah</h2>
                        <p class="text-sm text-gray-500">Perlu segera diisi ulang</p>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($stats['low_stock_books'] as $book)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="flex-shrink-0 w-10 h-14 bg-gray-100 rounded overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</p>
                                <p class="text-xs text-gray-500">{{ $book->author }}</p>
                            </div>
                        </div>
                        <span class="flex-shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                            {{ $book->stock <= 3 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $book->stock }}
                        </span>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Semua Stok Aman</p>
                        <p class="text-xs text-gray-500">Tidak ada buku dengan stok rendah</p>
                    </div>
                @endforelse
            </div>
            @if(count($stats['low_stock_books']) > 0)
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <a href="{{ route('admin.books.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Kelola Stok Buku →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
