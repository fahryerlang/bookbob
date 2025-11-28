@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.books.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center space-x-1 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali</span>
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Edit Buku</h1>
    <p class="text-gray-600">Perbarui informasi buku</p>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-4xl">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Buku</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Masukkan judul buku">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category_id" id="category_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Nama penulis">
                @error('author')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">Penerbit</label>
                <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Nama penerbit">
                @error('publisher')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="year_published" class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit</label>
                <input type="number" name="year_published" id="year_published" value="{{ old('year_published', $book->year_published) }}" min="1900" max="{{ date('Y') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="{{ date('Y') }}">
                @error('year_published')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="978-xxx-xxx-xxx-x">
                @error('isbn')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" required min="0"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="50000">
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="10">
                @error('stock')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Deskripsi singkat tentang buku">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Buku</label>
                @if($book->cover_image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="h-32 w-auto object-cover rounded">
                        <p class="mt-1 text-sm text-gray-500">Cover saat ini</p>
                    </div>
                @endif
                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah cover.</p>
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $book->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="text-sm font-medium text-gray-700">Aktifkan buku (tampilkan di katalog)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex items-center space-x-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Perbarui Buku
            </button>
            <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
