@extends('layouts.admin')

@section('content')
@php
    $statusConfig = [
        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-200', 'icon' => 'bg-amber-100', 'label' => 'Pending', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>', 'gradient' => 'from-amber-500 to-orange-500'],
        'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-200', 'icon' => 'bg-blue-100', 'label' => 'Diproses', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>', 'gradient' => 'from-blue-500 to-indigo-500'],
        'shipped' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-200', 'icon' => 'bg-purple-100', 'label' => 'Dikirim', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>', 'gradient' => 'from-purple-500 to-pink-500'],
        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-100', 'label' => 'Selesai', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>', 'gradient' => 'from-emerald-500 to-teal-500'],
        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200', 'icon' => 'bg-red-100', 'label' => 'Dibatalkan', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>', 'gradient' => 'from-red-500 to-rose-500'],
    ];
    $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
    
    $paymentConfig = [
        'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Lunas'],
        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Belum Bayar'],
        'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Gagal'],
    ];
    $payment = $paymentConfig[$order->payment_status] ?? $paymentConfig['pending'];
@endphp

<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r {{ $status['gradient'] }} rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-24 -translate-x-24"></div>
        
        <div class="relative z-10">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center space-x-2 text-white/80 hover:text-white transition-colors mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Daftar Pesanan</span>
            </a>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <h1 class="text-3xl font-bold">{{ $order->order_number }}</h1>
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                            {{ $status['label'] }}
                        </span>
                    </div>
                    <p class="text-white/80 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[140px]">
                        <p class="text-white/70 text-xs mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($order->total_amount / 1000, 0) }}rb</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[140px]">
                        <p class="text-white/70 text-xs mb-1">Jumlah Item</p>
                        <p class="text-2xl font-bold">{{ $order->orderItems->sum('quantity') }} Buku</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Progress Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </span>
                    Progres Pesanan
                </h3>
                
                @php
                    $steps = ['pending', 'processing', 'shipped', 'completed'];
                    $currentIndex = array_search($order->status, $steps);
                    if ($currentIndex === false) $currentIndex = -1;
                    if ($order->status === 'cancelled') $currentIndex = -1;
                @endphp
                
                <div class="flex items-center justify-between relative">
                    @foreach($steps as $index => $step)
                        @php
                            $stepConfig = $statusConfig[$step];
                            $isActive = $index <= $currentIndex;
                            $isCurrent = $index == $currentIndex;
                        @endphp
                        <div class="flex flex-col items-center relative z-10" style="width: 25%;">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $isActive ? 'bg-gradient-to-r '.$stepConfig['gradient'].' text-white shadow-lg' : 'bg-gray-100 text-gray-400' }} {{ $isCurrent ? 'ring-4 ring-offset-2 ring-opacity-50' : '' }}" style="{{ $isCurrent ? 'ring-color: currentColor;' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $stepConfig['iconSvg'] !!}
                                </svg>
                            </div>
                            <p class="mt-2 text-xs font-medium {{ $isActive ? 'text-gray-800' : 'text-gray-400' }}">{{ $stepConfig['label'] }}</p>
                        </div>
                        
                        @if($index < count($steps) - 1)
                            <div class="absolute top-6 left-0 right-0 h-0.5 -z-0" style="margin-left: 12.5%; margin-right: 12.5%;">
                                <div class="h-full bg-gray-200 rounded-full">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500" style="width: {{ $index < $currentIndex ? '100%' : '0%' }};"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                @if($order->status === 'cancelled')
                    <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-red-800">Pesanan Dibatalkan</p>
                            <p class="text-sm text-red-600">Pesanan ini telah dibatalkan dan tidak dapat diproses lebih lanjut.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </span>
                        Item Pesanan
                    </h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">{{ $order->orderItems->count() }} Item</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($order->orderItems as $item)
                        <div class="p-6 flex items-center gap-5 hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0 w-20 h-28 rounded-xl overflow-hidden bg-gray-100 shadow-sm">
                                @if($item->book && $item->book->cover_image)
                                    <img class="w-full h-full object-cover" src="{{ Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title ?? 'Book' }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 mb-1">{{ $item->book->title ?? 'Buku tidak tersedia' }}</h4>
                                @if($item->book && $item->book->author)
                                    <p class="text-sm text-gray-500 mb-2">oleh {{ $item->book->author }}</p>
                                @endif
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <span class="text-gray-400">×</span>
                                    <span class="px-2 py-0.5 bg-gray-100 rounded text-gray-600 font-medium">{{ $item->quantity }}</span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total -->
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total Pembayaran</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Update Status Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <span class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </span>
                        Perbarui Status
                    </h3>
                </div>
                
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                            <select name="status" id="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>📦 Diproses</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                            <select name="payment_status" id="payment_status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 hover:bg-white">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>⏳ Belum Bayar</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>✅ Lunas</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>❌ Gagal</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Perbarui Status</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pelanggan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-5">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.show', $order->user) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Profil Lengkap
                    </a>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">Penerima</p>
                            <p class="text-gray-800 font-medium">{{ $order->shipping_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">Telepon</p>
                            <p class="text-gray-800 font-medium">{{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">Alamat</p>
                            <p class="text-gray-800">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Informasi Pembayaran
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Metode
                        </span>
                        <span class="text-gray-800 font-medium px-3 py-1 bg-gray-100 rounded-lg">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-t border-gray-100">
                        <span class="text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $payment['bg'] }} {{ $payment['text'] }}">
                            {{ $payment['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Catatan Pelanggan
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Aksi Cepat
                </h3>
                <div class="space-y-3">
                    <a href="mailto:{{ $order->user->email }}" class="flex items-center px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Kirim Email</span>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->shipping_phone) }}" target="_blank" class="flex items-center px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="text-sm font-medium">Hubungi WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
