@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Shipping Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Pengiriman</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('shipping_address') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap untuk pengiriman">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="shipping_phone" id="shipping_phone" required
                                    value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('shipping_phone') border-red-500 @enderror"
                                    placeholder="Contoh: 081234567890">
                                @error('shipping_phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Catatan tambahan untuk pesanan Anda">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Metode Pembayaran</h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                <input type="radio" name="payment_method" value="transfer" class="text-indigo-600 focus:ring-indigo-500" checked>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Transfer Bank</p>
                                    <p class="text-sm text-gray-500">Pembayaran melalui transfer bank</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                <input type="radio" name="payment_method" value="cod" class="text-indigo-600 focus:ring-indigo-500">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Bayar di Tempat (COD)</p>
                                    <p class="text-sm text-gray-500">Bayar saat pesanan diterima</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Pesanan Anda</h2>
                        
                        <div class="divide-y">
                            @foreach($cartItems as $item)
                                <div class="py-4 flex items-center space-x-4">
                                    <div class="w-16 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->book->cover_image)
                                            <img src="{{ Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                                <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $item->book->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="font-bold text-gray-800">
                                        Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="text-green-600">Gratis</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-800">Total</span>
                                <span class="text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" class="block text-center mt-4 text-gray-600 hover:text-indigo-600">
                            Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
</div>
@endsection
