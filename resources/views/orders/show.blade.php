@extends('layouts.user')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusConfig = [
        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-200', 'gradient' => 'from-amber-500 to-orange-500', 'label' => 'Menunggu Pembayaran'],
        'paid' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-200', 'gradient' => 'from-blue-500 to-indigo-500', 'label' => 'Dibayar'],
        'processing' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-200', 'gradient' => 'from-indigo-500 to-purple-500', 'label' => 'Sedang Diproses'],
        'shipped' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-200', 'gradient' => 'from-purple-500 to-pink-500', 'label' => 'Dalam Pengiriman'],
        'delivered' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'gradient' => 'from-emerald-500 to-teal-500', 'label' => 'Selesai'],
        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'gradient' => 'from-emerald-500 to-teal-500', 'label' => 'Selesai'],
        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200', 'gradient' => 'from-red-500 to-rose-500', 'label' => 'Dibatalkan'],
    ];
    $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
@endphp

<div class="space-y-6">
    <!-- Header Section with Gradient -->
    <div class="bg-gradient-to-r {{ $status['gradient'] }} rounded-2xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-24 -translate-x-24"></div>
        
        <div class="relative z-10">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-white/80">
                    <li>
                        <a href="{{ route('orders.index') }}" class="hover:text-white flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Pesanan Saya
                        </a>
                    </li>
                    <li><span class="text-white/50">/</span></li>
                    <li><span class="text-white font-medium">{{ $order->order_number }}</span></li>
                </ol>
            </nav>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold">{{ $order->order_number }}</h1>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                            {{ $status['label'] }}
                        </span>
                    </div>
                    <p class="text-white/80 flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[120px]">
                        <p class="text-white/70 text-xs mb-1">Total</p>
                        <p class="text-xl font-bold">Rp {{ number_format($order->total_amount / 1000, 0) }}rb</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[100px]">
                        <p class="text-white/70 text-xs mb-1">Items</p>
                        <p class="text-xl font-bold">{{ $order->orderItems->sum('quantity') }} Buku</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
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
                    $steps = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentStep = array_search($order->status, $steps);
                    if ($order->status === 'cancelled') $currentStep = -1;
                    if ($order->status === 'paid') $currentStep = 0.5;
                    if ($order->status === 'completed') $currentStep = 3;
                    
                    $stepLabels = ['Pesanan Dibuat', 'Diproses', 'Dikirim', 'Selesai'];
                    
                    $stepConfig = [
                        ['gradient' => 'from-amber-500 to-orange-500', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>'],
                        ['gradient' => 'from-blue-500 to-indigo-500', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>'],
                        ['gradient' => 'from-purple-500 to-pink-500', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>'],
                        ['gradient' => 'from-emerald-500 to-teal-500', 'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'],
                    ];
                @endphp
                
                <div class="flex items-center justify-between relative py-6">
                    @foreach($stepLabels as $index => $label)
                        @php
                            $isActive = $index <= $currentStep;
                            $isCurrent = $index == $currentStep;
                            $config = $stepConfig[$index];
                        @endphp
                        <div class="flex flex-col items-center relative z-10" style="width: 25%;">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $isActive ? 'bg-gradient-to-r '.$config['gradient'].' text-white shadow-lg' : 'bg-gray-100 text-gray-400' }} {{ $isCurrent ? 'ring-4 ring-offset-2 ring-opacity-50' : '' }}" style="{{ $isCurrent ? 'ring-color: currentColor;' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $config['iconSvg'] !!}
                                </svg>
                            </div>
                            <p class="mt-2 text-xs font-medium {{ $isActive ? 'text-gray-800' : 'text-gray-400' }}">{{ $label }}</p>
                        </div>
                        
                        @if($index < count($stepLabels) - 1)
                            <div class="absolute left-0 right-0 h-0.5 -z-0" style="top: calc(1.5rem + 1.5rem); margin-left: 12.5%; margin-right: 12.5%;">
                                <div class="h-full bg-gray-200 rounded-full">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500" style="width: {{ $index < $currentStep ? (($index + 1) / (count($stepLabels) - 1)) * 100 : ($index == 0 && $currentStep >= 0 ? (($currentStep) / (count($stepLabels) - 1)) * 100 : 0) }}%;"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                @if($order->status === 'cancelled')
                    <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center">
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
                        <div class="p-5 flex items-center gap-5 hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0 w-20 h-28 rounded-xl overflow-hidden bg-gray-100 shadow-sm">
                                @if($item->book->cover_image)
                                    <img src="{{ Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                        <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 mb-1">{{ $item->book->title }}</h4>
                                <p class="text-sm text-gray-500 mb-2">oleh {{ $item->book->author }}</p>
                                <div class="flex items-center gap-3 text-sm">
                                    <span class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <span class="text-gray-400">×</span>
                                    <span class="px-2 py-0.5 bg-gray-100 rounded text-gray-600 font-medium">{{ $item->quantity }}</span>
                                </div>
                                
                                @if($order->status === 'completed')
                                    @php
                                        $existingReview = $order->reviews()->where('book_id', $item->book_id)->first();
                                    @endphp
                                    <div class="mt-3">
                                        @if($existingReview)
                                            <div class="flex items-center gap-2">
                                                <div class="flex text-amber-400 text-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span>{{ $i <= $existingReview->rating ? '★' : '☆' }}</span>
                                                    @endfor
                                                </div>
                                                <a href="{{ route('reviews.create', [$order, $item->book]) }}" 
                                                   class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                                                    Edit Ulasan
                                                </a>
                                            </div>
                                        @else
                                            <a href="{{ route('reviews.create', [$order, $item->book]) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-amber-100 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-200 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                                Tulis Ulasan
                                            </a>
                                        @endif
                                    </div>
                                @endif
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

            <!-- Shipping Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Informasi Pengiriman
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Alamat Pengiriman</p>
                                <p class="text-gray-800 font-medium">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Nomor Telepon</p>
                                <p class="text-gray-800 font-medium">{{ $order->shipping_phone }}</p>
                            </div>
                        </div>
                        @if($order->notes)
                            <div class="md:col-span-2 flex items-start">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 mr-4">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Catatan</p>
                                    <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $order->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Payment Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-20">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Ringkasan Pembayaran
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Subtotal
                            </span>
                            <span class="text-gray-800 font-medium">Rp {{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Diskon
                                    @if($order->coupon)
                                        <span class="ml-1 px-1.5 py-0.5 bg-green-100 text-green-700 text-xs rounded font-mono">{{ $order->coupon->code }}</span>
                                    @endif
                                </span>
                                <span class="text-green-600 font-medium">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                                Ongkos Kirim
                            </span>
                            <span class="text-emerald-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Gratis
                            </span>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold">Total</span>
                                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Metode
                            </span>
                            <span class="text-gray-800 font-medium px-2 py-0.5 bg-white rounded-lg">
                                {{ $order->payment_method === 'transfer' ? 'Transfer Bank' : 'Bayar di Tempat' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status
                            </span>
                            @php
                                $paymentConfig = [
                                    'unpaid' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Belum Dibayar'],
                                    'paid' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Sudah Dibayar'],
                                    'refunded' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dikembalikan'],
                                ];
                                $payment = $paymentConfig[$order->payment_status] ?? $paymentConfig['unpaid'];
                            @endphp
                            <span class="px-2 py-0.5 rounded-lg text-xs font-medium {{ $payment['bg'] }} {{ $payment['text'] }}">
                                {{ $payment['label'] }}
                            </span>
                        </div>
                        @if($order->paid_at)
                            <div class="flex justify-between text-sm pt-2 border-t border-gray-200">
                                <span class="text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Dibayar
                                </span>
                                <span class="text-gray-800 font-medium">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>

                    @if($order->status === 'pending' && $order->payment_status === 'unpaid')
                        <div class="space-y-3">
                            <form action="{{ route('orders.pay', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Bayar Sekarang
                                </button>
                            </form>
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="w-full border-2 border-red-200 text-red-500 px-6 py-3 rounded-xl font-semibold hover:bg-red-50 hover:border-red-300 transition-all flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif

                    <a href="{{ route('orders.index') }}" class="mt-6 w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
            
            <!-- Need Help Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Butuh Bantuan?
                </h3>
                <p class="text-white/80 text-sm mb-4">Hubungi kami jika ada pertanyaan tentang pesanan Anda.</p>
                <a href="{{ route('messages.create') }}" class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
