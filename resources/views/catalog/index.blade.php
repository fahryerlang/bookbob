@extends('layouts.main')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">Katalog Buku</h1>
        <p class="text-indigo-100">Temukan buku favorit Anda dari koleksi kami yang lengkap</p>
    </div>
</section>

<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                    <h3 class="font-semibold text-gray-800 mb-4">Filter</h3>
                    
                    <form action="{{ route('catalog.index') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul atau penulis..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->books_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul (A-Z)</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Terapkan Filter
                        </button>

                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('catalog.index') }}" class="block text-center mt-2 text-sm text-gray-600 hover:text-indigo-600">
                                Reset Filter
                            </a>
                        @endif
                    </form>
                </div>
            </aside>

            <!-- Book Grid -->
            <div class="flex-1">
                @if($books->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($books as $book)
                            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden group">
                                <a href="{{ route('catalog.show', $book->slug) }}">
                                    <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                                        @if($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                                <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        @if($book->stock <= 0)
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                <span class="text-white font-semibold">Stok Habis</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <span class="text-xs text-indigo-600 font-medium">{{ $book->category->name }}</span>
                                    <a href="{{ route('catalog.show', $book->slug) }}">
                                        <h3 class="font-semibold text-gray-800 mt-1 line-clamp-2 hover:text-indigo-600 transition">{{ $book->title }}</h3>
                                    </a>
                                    <p class="text-sm text-gray-500 mt-1">{{ $book->author }}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                        @auth
                                            @if(auth()->user()->isUser() && $book->stock > 0)
                                                <form action="{{ route('cart.add', $book) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $books->withQueryString()->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada buku ditemukan</h3>
                        <p class="text-gray-600">Coba ubah filter pencarian Anda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
