@extends('layouts.admin')

@section('title', 'Tambah Kupon')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center text-sm mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Kupon
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Kupon Baru</h1>
    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kupon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Kupon</label>
                    <div class="flex gap-2">
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase font-mono"
                            placeholder="DISKON10">
                        <button type="button" onclick="generateCode()" 
                            class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                            Generate
                        </button>
                    </div>
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kupon</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Diskon 10% untuk Semua">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Deskripsi singkat tentang kupon ini">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Discount Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Diskon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Diskon</label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Nilai Diskon</label>
                    <input type="number" name="value" id="value" value="{{ old('value') }}" required step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="10">
                    @error('value')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_discount" class="block text-sm font-medium text-gray-700 mb-1">Maksimal Diskon (Rp)</label>
                    <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount') }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="50000">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada batas (untuk tipe persentase)</p>
                </div>

                <div>
                    <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">Minimal Pembelian (Rp)</label>
                    <input type="number" name="min_purchase" id="min_purchase" value="{{ old('min_purchase', 0) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="0">
                </div>
            </div>
        </div>

        <!-- Usage Limits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Batas Penggunaan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Total Penggunaan</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="100">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada batas</p>
                </div>

                <div>
                    <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">Penggunaan Per User</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user', 1) }}" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="1">
                </div>
            </div>
        </div>

        <!-- Period -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Periode Berlaku</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai (Opsional)</label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir (Opsional)</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Special Options -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Opsi Tambahan</h2>
            
            <label class="flex items-center">
                <input type="checkbox" name="is_first_purchase_only" value="1" {{ old('is_first_purchase_only') ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-gray-700">Hanya untuk pembelian pertama</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-gray-700 font-medium">Aktifkan Kupon</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.coupons.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Simpan Kupon
            </button>
        </div>
    </form>
</div>

<script>
function generateCode() {
    fetch('{{ route("admin.coupons.generateCode") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('code').value = data.code;
        });
}
</script>
@endsection
