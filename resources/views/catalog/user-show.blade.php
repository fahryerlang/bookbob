@extends('layouts.user')

@section('title', $book->title)

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav>
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-indigo-600">Katalog</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><span class="text-gray-800">{{ $book->title }}</span></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Book Image -->
        <div>
            <div class="aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden">
                @if($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                        <svg class="w-32 h-32 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Book Details -->
        <div>
            <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 text-sm font-medium rounded-full mb-4">
                {{ $book->category->name }}
            </span>
            
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 mb-2">oleh {{ $book->author }}</p>
                    
                    <!-- Rating Summary -->
                    @if($book->review_count > 0)
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-amber-400 text-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($book->average_rating))
                                        <span>★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-gray-600 font-medium">{{ number_format($book->average_rating, 1) }}</span>
                            <a href="#reviews" class="text-sm text-indigo-600 hover:text-indigo-700">({{ $book->review_count }} ulasan)</a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-2">Belum ada ulasan</p>
                    @endif
                </div>
                
                <!-- Wishlist Button -->
                <button type="button" 
                    onclick="toggleWishlist({{ $book->id }}, this)"
                    class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-red-50 transition-all group wishlist-btn"
                    data-in-wishlist="{{ auth()->user()->hasInWishlist($book->id) ? 'true' : 'false' }}"
                    title="{{ auth()->user()->hasInWishlist($book->id) ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                    <svg class="w-6 h-6 transition-colors {{ auth()->user()->hasInWishlist($book->id) ? 'text-red-500 fill-current' : 'text-gray-400 group-hover:text-red-400' }}" 
                         fill="{{ auth()->user()->hasInWishlist($book->id) ? 'currentColor' : 'none' }}" 
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>

            <div class="flex items-center space-x-4 mb-6">
                <span class="text-3xl font-bold text-indigo-600">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                @if($book->stock > 0)
                    <span class="px-3 py-1 bg-green-100 text-green-600 text-sm font-medium rounded-full">
                        Stok: {{ $book->stock }}
                    </span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-600 text-sm font-medium rounded-full">
                        Stok Habis
                    </span>
                @endif
            </div>

            <!-- Book Info -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Informasi Buku</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    @if($book->publisher)
                        <div>
                            <span class="text-gray-500">Penerbit</span>
                            <p class="text-gray-800 font-medium">{{ $book->publisher }}</p>
                        </div>
                    @endif
                    @if($book->year_published)
                        <div>
                            <span class="text-gray-500">Tahun Terbit</span>
                            <p class="text-gray-800 font-medium">{{ $book->year_published }}</p>
                        </div>
                    @endif
                    @if($book->isbn)
                        <div>
                            <span class="text-gray-500">ISBN</span>
                            <p class="text-gray-800 font-medium">{{ $book->isbn }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="text-gray-500">Kategori</span>
                        <p class="text-gray-800 font-medium">{{ $book->category->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Add to Cart -->
            @if($book->stock > 0)
                <form action="{{ route('cart.add', $book) }}" method="POST" class="flex items-center space-x-4 mb-6">
                    @csrf
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button type="button" onclick="decrementQty()" class="px-4 py-2 text-gray-600 hover:text-indigo-600">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $book->stock }}" 
                            class="w-16 text-center border-0 focus:ring-0">
                        <button type="button" onclick="incrementQty({{ $book->stock }})" class="px-4 py-2 text-gray-600 hover:text-indigo-600">+</button>
                    </div>
                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Tambah ke Keranjang</span>
                    </button>
                </form>
            @else
                <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed mb-6">
                    Stok Habis
                </button>
            @endif

            <!-- Description -->
            @if($book->description)
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Books -->
    @if($relatedBooks->count() > 0)
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Buku Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedBooks as $relatedBook)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                        <a href="{{ route('catalog.show', $relatedBook->slug) }}">
                            <div class="aspect-[3/4] bg-gray-100">
                                @if($relatedBook->cover_image)
                                    <img src="{{ Storage::url($relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-4">
                            <a href="{{ route('catalog.show', $relatedBook->slug) }}">
                                <h3 class="font-semibold text-gray-800 line-clamp-2 hover:text-indigo-600 transition">{{ $relatedBook->title }}</h3>
                            </a>
                            <p class="text-sm text-gray-500 mt-1">{{ $relatedBook->author }}</p>
                            <p class="text-indigo-600 font-bold mt-2">Rp {{ number_format($relatedBook->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Reviews Section -->
    <div id="reviews" class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Ulasan Pembeli
                </h2>
            </div>
            
            <div class="p-6">
                @if($book->review_count > 0)
                    <!-- Rating Summary -->
                    <div class="flex flex-col md:flex-row gap-8 mb-8 pb-8 border-b border-gray-100">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-gray-800">{{ number_format($book->average_rating, 1) }}</div>
                            <div class="flex justify-center text-amber-400 text-2xl mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($book->average_rating))
                                        <span>★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $book->review_count }} ulasan</p>
                        </div>
                        
                        <!-- Rating Breakdown -->
                        <div class="flex-1">
                            @php $breakdown = $book->getRatingBreakdown(); @endphp
                            @for($star = 5; $star >= 1; $star--)
                                @php 
                                    $count = $breakdown[$star] ?? 0;
                                    $percentage = $book->review_count > 0 ? ($count / $book->review_count) * 100 : 0;
                                @endphp
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="w-8 text-gray-600">{{ $star }} ★</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="w-8 text-gray-500 text-right">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Review List -->
                    <div class="space-y-6">
                        @foreach($book->reviews()->with('user')->latest()->take(10)->get() as $review)
                            <div class="border-b border-gray-100 pb-6 last:border-b-0 last:pb-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-800">{{ $review->user->name }}</span>
                                            @if($review->is_verified_purchase)
                                                <span class="px-2 py-0.5 bg-green-100 text-green-600 text-xs rounded-full flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Pembelian Terverifikasi
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex text-amber-400 text-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($review->review)
                                    <p class="text-gray-600">{{ $review->review }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Ulasan</h3>
                        <p class="text-gray-500">Jadilah yang pertama memberikan ulasan untuk buku ini!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function incrementQty(max) {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function toggleWishlist(bookId, button) {
    fetch(`/wishlist/toggle/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const svg = button.querySelector('svg');
            if (data.in_wishlist) {
                svg.classList.remove('text-gray-400', 'group-hover:text-red-400');
                svg.classList.add('text-red-500', 'fill-current');
                svg.setAttribute('fill', 'currentColor');
                button.dataset.inWishlist = 'true';
                button.title = 'Hapus dari Wishlist';
            } else {
                svg.classList.remove('text-red-500', 'fill-current');
                svg.classList.add('text-gray-400', 'group-hover:text-red-400');
                svg.setAttribute('fill', 'none');
                button.dataset.inWishlist = 'false';
                button.title = 'Tambah ke Wishlist';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
