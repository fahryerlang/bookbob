@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.books.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center space-x-1 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Daftar Buku</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="md:flex">
        <!-- Cover Image -->
        <div class="md:w-1/3 p-8 bg-gray-50">
            @if($book->cover_image)
                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow">
            @else
                <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Book Details -->
        <div class="md:w-2/3 p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm mb-2 inline-block">
                        {{ $book->category->name }}
                    </span>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-600 mt-1">oleh {{ $book->author }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <p class="text-sm text-gray-500">Harga</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stok</p>
                    @if($book->stock > 10)
                        <p class="text-2xl font-bold text-green-600">{{ $book->stock }} unit</p>
                    @elseif($book->stock > 0)
                        <p class="text-2xl font-bold text-yellow-600">{{ $book->stock }} unit</p>
                    @else
                        <p class="text-2xl font-bold text-red-600">Habis</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    @if($book->is_active)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Aktif</span>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Nonaktif</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Slug</p>
                    <p class="text-gray-800">{{ $book->slug }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="font-semibold text-gray-800 mb-4">Informasi Detail</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Penerbit</p>
                        <p class="text-gray-800">{{ $book->publisher ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tahun Terbit</p>
                        <p class="text-gray-800">{{ $book->year_published ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">ISBN</p>
                        <p class="text-gray-800">{{ $book->isbn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Ditambahkan</p>
                        <p class="text-gray-800">{{ $book->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($book->description)
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
