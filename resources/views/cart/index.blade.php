@extends('layouts.user')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h1>
    </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-4 border-b bg-gray-50">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-800">{{ $cartItems->count() }} Item</span>
                                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm">Kosongkan Keranjang</button>
                                </form>
                            </div>
                        </div>

                        <div class="divide-y">
                            @foreach($cartItems as $item)
                                <div class="p-4 flex items-center space-x-4 cart-item" data-item-id="{{ $item->id }}" data-price="{{ $item->book->price }}">
                                    <!-- Book Image -->
                                    <div class="w-20 h-28 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
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

                                    <!-- Book Info -->
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('catalog.show', $item->book->slug) }}" class="font-semibold text-gray-800 hover:text-indigo-600 line-clamp-2">
                                            {{ $item->book->title }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $item->book->author }}</p>
                                        <p class="text-indigo-600 font-semibold mt-1">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="flex items-center">
                                        <button type="button" onclick="updateQty({{ $item->id }}, -1, {{ $item->book->stock }})" 
                                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-l-lg bg-gray-50 hover:bg-gray-100 transition text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="text" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" 
                                            data-max="{{ $item->book->stock }}"
                                            onchange="updateQtyDirect({{ $item->id }}, this.value, {{ $item->book->stock }})"
                                            class="w-14 h-9 text-center border-t border-b border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm font-medium [appearance:textfield]">
                                        <button type="button" onclick="updateQty({{ $item->id }}, 1, {{ $item->book->stock }})" 
                                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-r-lg bg-gray-50 hover:bg-gray-100 transition text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <p class="font-bold text-gray-800 subtotal" id="subtotal-{{ $item->id }}">Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Remove -->
                                    <button type="button" onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-600 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal (<span id="total-items">{{ $cartItems->sum('quantity') }}</span> item)</span>
                                <span class="text-gray-800" id="subtotal-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="text-green-600">Gratis</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-800">Total</span>
                                <span class="text-indigo-600" id="total-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Lanjut ke Pembayaran
                        </a>

                        <a href="{{ route('catalog.index') }}" class="block w-full text-center mt-4 text-indigo-600 hover:text-indigo-700">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-600 mb-6">Belum ada buku di keranjang Anda</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Jelajahi Katalog
                </a>
            </div>
        @endif
</div>

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';

    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateQty(itemId, change, maxStock) {
        const input = document.getElementById('qty-' + itemId);
        let value = parseInt(input.value) || 1;
        let newValue = value + change;
        
        if (newValue < 1) newValue = 1;
        if (newValue > maxStock) newValue = maxStock;
        
        if (newValue !== value) {
            input.value = newValue;
            saveQuantity(itemId, newValue);
        }
    }

    function updateQtyDirect(itemId, value, maxStock) {
        let newValue = parseInt(value) || 1;
        
        if (newValue < 1) newValue = 1;
        if (newValue > maxStock) newValue = maxStock;
        
        const input = document.getElementById('qty-' + itemId);
        input.value = newValue;
        saveQuantity(itemId, newValue);
    }

    function saveQuantity(itemId, quantity) {
        fetch(`/cart/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update subtotal for this item
                const cartItem = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                const price = parseFloat(cartItem.dataset.price);
                const subtotal = price * quantity;
                document.getElementById('subtotal-' + itemId).textContent = formatRupiah(subtotal);
                
                // Update totals
                updateTotals();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeItem(itemId) {
        if (!confirm('Hapus item ini dari keranjang?')) return;
        
        fetch(`/cart/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM
                const cartItem = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                cartItem.remove();
                
                // Check if cart is empty
                const remainingItems = document.querySelectorAll('.cart-item');
                if (remainingItems.length === 0) {
                    location.reload();
                } else {
                    updateTotals();
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function updateTotals() {
        let totalItems = 0;
        let totalAmount = 0;
        
        document.querySelectorAll('.cart-item').forEach(item => {
            const itemId = item.dataset.itemId;
            const price = parseFloat(item.dataset.price);
            const qty = parseInt(document.getElementById('qty-' + itemId).value) || 0;
            
            totalItems += qty;
            totalAmount += price * qty;
        });
        
        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('subtotal-display').textContent = formatRupiah(totalAmount);
        document.getElementById('total-display').textContent = formatRupiah(totalAmount);
    }
</script>
@endpush
@endsection
