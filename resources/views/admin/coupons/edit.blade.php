@extends('layouts.admin')

@section('title', 'Edit Kupon')

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
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-800">Edit Kupon</h1>
            <span class="px-3 py-1 bg-gray-100 text-gray-700 font-mono text-sm rounded">{{ $coupon->code }}</span>
        </div>
    </div>

    <!-- Usage Stats -->
    @if($coupon->used_count > 0)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center gap-2 text-blue-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">Kupon ini sudah digunakan {{ $coupon->used_count }} kali</span>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kupon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Kupon</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase font-mono">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kupon</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $coupon->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $coupon->description) }}</textarea>
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
                        <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Nilai Diskon</label>
                    <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" required step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('value')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_discount" class="block text-sm font-medium text-gray-700 mb-1">Maksimal Diskon (Rp)</label>
                    <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada batas (untuk tipe persentase)</p>
                </div>

                <div>
                    <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">Minimal Pembelian (Rp)</label>
                    <input type="number" name="min_purchase" id="min_purchase" value="{{ old('min_purchase', $coupon->min_purchase ?? 0) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Usage Limits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Batas Penggunaan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Total Penggunaan</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Kosongkan jika tidak ada batas. 
                        @if($coupon->used_count > 0)
                            <span class="text-blue-600">Sudah digunakan {{ $coupon->used_count }} kali.</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">Penggunaan Per User</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? 1) }}" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Period -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Periode Berlaku</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai (Opsional)</label>
                    <input type="datetime-local" name="start_date" id="start_date" 
                        value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir (Opsional)</label>
                    <input type="datetime-local" name="end_date" id="end_date" 
                        value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Special Options -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Opsi Tambahan</h2>
            
            <label class="flex items-center">
                <input type="checkbox" name="is_first_purchase_only" value="1" 
                    {{ old('is_first_purchase_only', $coupon->is_first_purchase_only) ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-gray-700">Hanya untuk pembelian pertama</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" 
                    {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
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
                Update Kupon
            </button>
        </div>
    </form>
</div>
@endsection
