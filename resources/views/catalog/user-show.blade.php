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
            
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->title }}</h1>
            <p class="text-xl text-gray-600 mb-4">oleh {{ $book->author }}</p>

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
</script>
@endsection
