@extends('layouts.admin')

@section('title', 'Edit Promo')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.promos.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center text-sm mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Promo
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Promo: {{ $promo->name }}</h1>
    </div>

    <form action="{{ route('admin.promos.update', $promo) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Promo</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Promo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $promo->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $promo->description) }}</textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Promo</label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="flash_sale" {{ old('type', $promo->type) == 'flash_sale' ? 'selected' : '' }}>🔥 Flash Sale</option>
                        <option value="seasonal" {{ old('type', $promo->type) == 'seasonal' ? 'selected' : '' }}>🎄 Seasonal</option>
                        <option value="clearance" {{ old('type', $promo->type) == 'clearance' ? 'selected' : '' }}>📦 Clearance</option>
                        <option value="bundle" {{ old('type', $promo->type) == 'bundle' ? 'selected' : '' }}>📚 Bundle</option>
                    </select>
                </div>

                <div>
                    <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Banner</label>
                    @if($promo->banner_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($promo->banner_image) }}" alt="Banner" class="h-20 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="banner_image" id="banner_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Discount Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Diskon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Diskon</label>
                    <select name="discount_type" id="discount_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="percentage" {{ old('discount_type', $promo->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('discount_type', $promo->discount_type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>

                <div>
                    <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-1">Nilai Diskon</label>
                    <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value', $promo->discount_value) }}" required step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="max_discount" class="block text-sm font-medium text-gray-700 mb-1">Maksimal Diskon (Rp)</label>
                    <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount', $promo->max_discount) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">Minimal Pembelian (Rp)</label>
                    <input type="number" name="min_purchase" id="min_purchase" value="{{ old('min_purchase', $promo->min_purchase) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Period -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Periode Promo</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="start_date" 
                        value="{{ old('start_date', $promo->start_date->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="datetime-local" name="end_date" id="end_date" 
                        value="{{ old('end_date', $promo->end_date->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Book Selection -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Buku</h2>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="apply_to_all_books" id="apply_to_all_books" value="1" 
                        {{ old('apply_to_all_books', $promo->apply_to_all_books) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        onchange="toggleBookSelection()">
                    <span class="ml-2 text-gray-700">Terapkan ke semua buku</span>
                </label>
            </div>

            <div id="book-selection" class="{{ old('apply_to_all_books', $promo->apply_to_all_books) ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku</label>
                <div class="border border-gray-300 rounded-lg max-h-64 overflow-y-auto p-3 space-y-2">
                    @foreach($books as $book)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" 
                                {{ in_array($book->id, old('book_ids', $selectedBooks)) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <span class="ml-3 text-gray-700">{{ $book->title }}</span>
                            <span class="ml-auto text-sm text-gray-500">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Active Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-gray-700 font-medium">Aktifkan Promo</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.promos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Update Promo
            </button>
        </div>
    </form>
</div>

<script>
function toggleBookSelection() {
    const checkbox = document.getElementById('apply_to_all_books');
    const bookSelection = document.getElementById('book-selection');
    if (checkbox.checked) {
        bookSelection.classList.add('hidden');
    } else {
        bookSelection.classList.remove('hidden');
    }
}
</script>
@endsection
