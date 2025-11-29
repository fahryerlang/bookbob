@extends('layouts.user')

@section('title', 'Wishlist')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Wishlist Saya</h1>
                <p class="text-gray-600 mt-1">{{ $wishlists->count() }} buku tersimpan</p>
            </div>

            @if($wishlists->count() > 0)
            <div class="flex items-center gap-3">
                <!-- Move All to Cart -->
                <form action="{{ route('wishlist.moveAllToCart') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Pindahkan Semua ke Keranjang
                    </button>
                </form>

                <!-- Clear All -->
                <form action="{{ route('wishlist.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan wishlist?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-600 rounded-xl hover:bg-red-50 transition-all font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Kosongkan
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Price Drop Alert -->
        @if($priceDropCount > 0)
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-4">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-green-800">🎉 Harga Turun!</h3>
                    <p class="text-green-700 text-sm">{{ $priceDropCount }} buku di wishlist Anda mengalami penurunan harga. Buruan checkout!</p>
                </div>
            </div>
        </div>
        @endif

        @if($wishlists->count() > 0)
        <!-- Wishlist Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group relative">
                <!-- Price Drop Badge -->
                @if($wishlist->hasPriceDropped())
                <div class="absolute top-3 left-3 z-10">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-sm">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        -{{ $wishlist->discount_percentage }}%
                    </span>
                </div>
                @endif

                <!-- Remove Button -->
                <form action="{{ route('wishlist.remove', $wishlist) }}" method="POST" class="absolute top-3 right-3 z-10">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>

                <!-- Book Image -->
                <a href="{{ route('catalog.show', $wishlist->book->slug) }}" class="block aspect-[3/4] overflow-hidden bg-gray-100">
                    @if($wishlist->book->cover_image)
                        <img src="{{ Storage::url($wishlist->book->cover_image) }}" alt="{{ $wishlist->book->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                            <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                </a>

                <!-- Book Info -->
                <div class="p-4">
                    <!-- Category -->
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 mb-2">
                        {{ $wishlist->book->category->name ?? 'Uncategorized' }}
                    </span>

                    <!-- Title -->
                    <a href="{{ route('catalog.show', $wishlist->book->slug) }}" class="block">
                        <h3 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $wishlist->book->title }}
                        </h3>
                    </a>

                    <!-- Author -->
                    <p class="text-sm text-gray-500 mt-1">{{ $wishlist->book->author }}</p>

                    <!-- Price -->
                    <div class="mt-3 flex items-center gap-2">
                        <span class="text-lg font-bold text-indigo-600">
                            Rp {{ number_format($wishlist->book->price, 0, ',', '.') }}
                        </span>
                        @if($wishlist->hasPriceDropped())
                        <span class="text-sm text-gray-400 line-through">
                            Rp {{ number_format($wishlist->price_when_added, 0, ',', '.') }}
                        </span>
                        @endif
                    </div>

                    <!-- Savings -->
                    @if($wishlist->savings > 0)
                    <p class="text-sm text-green-600 font-medium mt-1">
                        Hemat Rp {{ number_format($wishlist->savings, 0, ',', '.') }}!
                    </p>
                    @endif

                    <!-- Stock Status -->
                    <div class="mt-3">
                        @if($wishlist->book->stock > 0)
                            <span class="text-xs text-green-600 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Stok tersedia ({{ $wishlist->book->stock }})
                            </span>
                        @else
                            <span class="text-xs text-red-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Stok habis
                            </span>
                        @endif
                    </div>

                    <!-- Move to Cart Button -->
                    <div class="mt-4">
                        @if($wishlist->book->stock > 0)
                        <form action="{{ route('wishlist.moveToCart', $wishlist) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Pindahkan ke Keranjang
                            </button>
                        </form>
                        @else
                        <button disabled class="w-full py-2.5 bg-gray-200 text-gray-500 rounded-xl font-medium cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Stok Habis
                        </button>
                        @endif
                    </div>

                    <!-- Added Date -->
                    <p class="text-xs text-gray-400 mt-3 text-center">
                        Ditambahkan {{ $wishlist->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Wishlist Kosong</h2>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Belum ada buku yang disimpan di wishlist. Jelajahi katalog kami dan simpan buku favorit Anda!
            </p>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all shadow-sm font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Jelajahi Katalog
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
