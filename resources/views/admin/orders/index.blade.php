@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Pesanan</h1>
                <p class="text-indigo-100">Kelola dan pantau semua pesanan pelanggan</p>
            </div>
            <div class="flex flex-wrap gap-4">
                @php
                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                    $processingCount = \App\Models\Order::where('status', 'processing')->count();
                    $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount');
                @endphp
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[130px]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-400/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $pendingCount }}</p>
                            <p class="text-xs text-indigo-100">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[130px]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-400/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $processingCount }}</p>
                            <p class="text-xs text-indigo-100">Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[160px]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-400/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold">Rp {{ number_format($totalRevenue / 1000000, 1) }}jt</p>
                            <p class="text-xs text-indigo-100">Total Pendapatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nomor pesanan, nama pelanggan..."
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div class="flex gap-3">
                    <select name="status" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all min-w-[160px]">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>📦 Diproses</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span>Filter</span>
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'bg-amber-100', 'label' => 'Pending', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                        'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'bg-blue-100', 'label' => 'Diproses', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>'],
                        'shipped' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'bg-purple-100', 'label' => 'Dikirim', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>'],
                        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-100', 'label' => 'Selesai', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'],
                        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'bg-red-100', 'label' => 'Dibatalkan', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'],
                    ];
                    $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    
                    $paymentConfig = [
                        'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Lunas'],
                        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Belum Bayar'],
                        'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Gagal'],
                    ];
                    $payment = $paymentConfig[$order->payment_status] ?? $paymentConfig['pending'];
                @endphp
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                            <!-- Order Info -->
                            <div class="flex items-start space-x-4 flex-1">
                                <div class="w-12 h-12 rounded-xl {{ $status['icon'] }} {{ $status['text'] }} flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $status['iconSvg'] !!}
                                    </svg>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 flex-wrap mb-1">
                                        <h3 class="font-bold text-gray-800">{{ $order->order_number }}</h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }} {{ $status['border'] }} border">
                                            {{ $status['label'] }}
                                        </span>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $payment['bg'] }} {{ $payment['text'] }}">
                                            {{ $payment['label'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            {{ $order->orderItems->count() }} item
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="flex items-center space-x-3 lg:min-w-[200px]">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 truncate">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $order->user->email }}</p>
                                </div>
                            </div>

                            <!-- Total & Action -->
                            <div class="flex items-center justify-between lg:justify-end gap-4 lg:min-w-[200px]">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-lg font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 max-w-md mx-auto">
                @if(request('search') || request('status'))
                    Tidak ada pesanan yang sesuai dengan filter Anda. Coba ubah kriteria pencarian.
                @else
                    Belum ada pesanan dari pelanggan. Pesanan akan muncul di sini ketika ada pembelian baru.
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset Filter
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
