@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
<div class="space-y-6" x-data="checkoutCoupon()">
    <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <input type="hidden" name="coupon_code" x-model="appliedCouponCode">
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

                    <!-- Coupon Section -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kode Kupon</h2>
                        
                        <!-- Applied Coupon -->
                        <div x-show="appliedCoupon" class="mb-4 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-green-800" x-text="appliedCoupon?.name"></p>
                                        <p class="text-sm text-green-600">
                                            Hemat <span x-text="formatRupiah(discountAmount)"></span>
                                        </p>
                                    </div>
                                </div>
                                <button type="button" @click="removeCoupon()" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Coupon Input -->
                        <div x-show="!appliedCoupon">
                            <div class="flex gap-2">
                                <input type="text" x-model="couponCode" @keyup.enter.prevent="applyCoupon()"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent uppercase font-mono"
                                    placeholder="Masukkan kode kupon">
                                <button type="button" @click="applyCoupon()" :disabled="loading"
                                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition disabled:opacity-50">
                                    <span x-show="!loading">Terapkan</span>
                                    <span x-show="loading">
                                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"></circle>
                                            <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <p x-show="errorMessage" x-text="errorMessage" class="mt-2 text-sm text-red-500"></p>
                        </div>

                        @if($isFirstPurchase)
                        <!-- First Purchase Info -->
                        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Ini adalah pembelian pertama Anda!</p>
                                    <p class="text-xs text-yellow-600">Anda mungkin berhak mendapatkan kupon diskon pembelian pertama.</p>
                                </div>
                            </div>
                        </div>
                        @endif
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
                            <div x-show="discountAmount > 0" class="flex justify-between text-green-600">
                                <span>Diskon Kupon</span>
                                <span>- <span x-text="formatRupiah(discountAmount)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="text-green-600">Gratis</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-800">Total</span>
                                <span class="text-indigo-600" x-text="formatRupiah(finalTotal)"></span>
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

<script>
function checkoutCoupon() {
    return {
        subtotal: {{ $total }},
        couponCode: '',
        appliedCoupon: null,
        appliedCouponCode: '',
        discountAmount: 0,
        finalTotal: {{ $total }},
        loading: false,
        errorMessage: '',

        formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        },

        applyCoupon() {
            if (!this.couponCode.trim()) {
                this.errorMessage = 'Masukkan kode kupon';
                return;
            }

            this.loading = true;
            this.errorMessage = '';

            fetch('{{ route("coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    code: this.couponCode,
                    subtotal: this.subtotal
                })
            })
            .then(response => response.json())
            .then(data => {
                this.loading = false;
                if (data.success) {
                    this.appliedCoupon = data.coupon;
                    this.appliedCouponCode = data.coupon.code;
                    this.discountAmount = data.discount;
                    this.finalTotal = this.subtotal - this.discountAmount;
                    this.couponCode = '';
                } else {
                    this.errorMessage = data.message;
                }
            })
            .catch(error => {
                this.loading = false;
                this.errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            });
        },

        removeCoupon() {
            this.appliedCoupon = null;
            this.appliedCouponCode = '';
            this.discountAmount = 0;
            this.finalTotal = this.subtotal;
            this.couponCode = '';
            this.errorMessage = '';
        }
    }
}
</script>
@endsection
