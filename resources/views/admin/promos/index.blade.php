@extends('layouts.admin')

@section('title', 'Kelola Promo')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Promo</h1>
            <p class="text-gray-600 mt-1">Atur flash sale, diskon seasonal, dan promo lainnya</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Promo
        </a>
    </div>

    <!-- Promos Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($promos as $promo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($promo->banner_image)
                                        <img src="{{ Storage::url($promo->banner_image) }}" alt="{{ $promo->name }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $promo->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Str::limit($promo->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'flash_sale' => 'bg-red-100 text-red-700',
                                        'seasonal' => 'bg-green-100 text-green-700',
                                        'clearance' => 'bg-amber-100 text-amber-700',
                                        'bundle' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $typeColors[$promo->type] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $promo->type_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold text-red-600">{{ $promo->discount_label }}</span>
                                @if($promo->max_discount)
                                    <p class="text-xs text-gray-500">Maks: Rp {{ number_format($promo->max_discount, 0, ',', '.') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p class="text-gray-800">{{ $promo->start_date->format('d M Y') }}</p>
                                <p class="text-gray-500">s/d {{ $promo->end_date->format('d M Y') }}</p>
                                @if($promo->isCurrentlyActive())
                                    <span class="text-xs text-green-600 font-medium">● Berlangsung</span>
                                @elseif($promo->hasEnded())
                                    <span class="text-xs text-red-600 font-medium">● Berakhir</span>
                                @else
                                    <span class="text-xs text-amber-600 font-medium">● Belum Mulai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($promo->apply_to_all_books)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Semua Buku</span>
                                @else
                                    <span class="text-gray-800">{{ $promo->books_count }} buku</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.promos.toggle', $promo) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $promo->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $promo->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="inline" onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                                <p class="text-gray-500">Belum ada promo</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($promos->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $promos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
