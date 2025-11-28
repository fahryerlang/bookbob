@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            <p class="mt-1 text-gray-500">Organisasi buku berdasarkan kategori</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </a>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-medium">Total Kategori</p>
                <p class="text-3xl font-bold mt-1">{{ $categories->total() }}</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-medium">Kategori Aktif</p>
                <p class="text-3xl font-bold mt-1">{{ $categories->filter(fn($c) => $c->books_count > 0)->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm font-medium">Total Buku</p>
                <p class="text-3xl font-bold mt-1">{{ $categories->sum('books_count') }}</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($categories as $category)
        @php
            $colors = [
                'from-blue-500 to-blue-600',
                'from-purple-500 to-purple-600',
                'from-pink-500 to-pink-600',
                'from-cyan-500 to-cyan-600',
                'from-teal-500 to-teal-600',
                'from-rose-500 to-rose-600',
                'from-violet-500 to-violet-600',
                'from-fuchsia-500 to-fuchsia-600',
            ];
            $colorIndex = $loop->index % count($colors);
            $gradientColor = $colors[$colorIndex];
        @endphp
        <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300">
            <!-- Category Header with Gradient -->
            <div class="h-24 bg-gradient-to-r {{ $gradientColor }} relative overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-white/20 text-white text-sm font-medium rounded-full backdrop-blur-sm">
                        {{ $category->books_count }} buku
                    </span>
                </div>
            </div>
            
            <!-- Category Content -->
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">{{ $category->slug }}</p>
                    </div>
                </div>
                
                <p class="text-gray-500 text-sm mb-6 line-clamp-2 min-h-[40px]">
                    {{ $category->description ?? 'Tidak ada deskripsi' }}
                </p>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.books.index', ['category' => $category->id]) }}" 
                        class="text-sm text-gray-500 hover:text-indigo-600 transition flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Buku
                    </a>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" 
                            class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 hover:bg-indigo-100 transition"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-9 h-9 bg-red-50 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-100 transition"
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kategori</h3>
                <p class="text-gray-500 mb-6">Mulai dengan membuat kategori pertama Anda</p>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Kategori Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $categories->links() }}
</div>
@endsection
