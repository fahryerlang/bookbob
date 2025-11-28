@extends('layouts.user')

@section('title', 'Pesanan Saya')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pesanan Saya</h1>
                <p class="text-indigo-100">Lacak dan kelola semua pesanan Anda</p>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <div class="bg-white/20 backdrop-blur rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold">{{ $orders->total() }}</p>
                    <p class="text-sm text-indigo-100">Total Pesanan</p>
                </div>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="space-y-5">
            @foreach($orders as $order)
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'bg-amber-100', 'label' => 'Menunggu Pembayaran'],
                        'paid' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'bg-blue-100', 'label' => 'Dibayar'],
                        'processing' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'bg-indigo-100', 'label' => 'Sedang Diproses'],
                        'shipped' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'bg-purple-100', 'label' => 'Dalam Pengiriman'],
                        'delivered' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-100', 'label' => 'Selesai'],
                        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-100', 'label' => 'Selesai'],
                        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'bg-red-100', 'label' => 'Dibatalkan'],
                    ];
                    $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    
                    $statusIcons = [
                        'pending' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                        'paid' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                        'processing' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>',
                        'shipped' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>',
                        'delivered' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                        'completed' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                        'cancelled' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    ];
                @endphp
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <!-- Order Header -->
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-start space-x-4">
                                <!-- Status Icon -->
                                <div class="w-12 h-12 rounded-xl {{ $status['icon'] }} {{ $status['text'] }} flex items-center justify-center flex-shrink-0">
                                    {!! $statusIcons[$order->status] ?? $statusIcons['pending'] !!}
                                </div>
                                
                                <div>
                                    <div class="flex items-center space-x-3 mb-1">
                                        <h3 class="font-bold text-gray-800">{{ $order->order_number }}</h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }} {{ $status['border'] }} border">
                                            {{ $status['label'] }}
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
                            
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Pembayaran</p>
                                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="p-5 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @foreach($order->orderItems->take(4) as $item)
                                    <div class="relative group">
                                        <div class="w-14 h-18 bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100">
                                            @if($item->book->cover_image)
                                                <img src="{{ Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">
                                                    <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        @if($item->quantity > 1)
                                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-indigo-600 text-white text-xs rounded-full flex items-center justify-center font-medium">
                                                {{ $item->quantity }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                                @if($order->orderItems->count() > 4)
                                    <div class="w-14 h-18 bg-white rounded-lg border border-gray-200 border-dashed flex items-center justify-center">
                                        <span class="text-gray-400 text-sm font-medium">+{{ $order->orderItems->count() - 4 }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('orders.show', $order) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
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
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Sepertinya Anda belum memiliki pesanan. Mulai jelajahi koleksi buku kami dan temukan bacaan favorit Anda!</p>
            <a href="{{ route('catalog.index') }}" 
               class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
