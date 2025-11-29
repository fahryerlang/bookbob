@extends('layouts.admin')

@section('title', 'Kelola Kupon')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kupon</h1>
            <p class="text-gray-600 mt-1">Buat dan kelola kode voucher/kupon diskon</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kupon
        </a>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kupon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penggunaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $coupon->name }}</p>
                                    @if($coupon->is_first_purchase_only)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pembelian Pertama
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="px-3 py-1 bg-gray-100 text-gray-800 font-mono font-bold rounded">{{ $coupon->code }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold text-green-600">{{ $coupon->discount_label }}</span>
                                @if($coupon->max_discount)
                                    <p class="text-xs text-gray-500">Maks: Rp {{ number_format($coupon->max_discount, 0, ',', '.') }}</p>
                                @endif
                                @if($coupon->min_purchase > 0)
                                    <p class="text-xs text-gray-500">Min: Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-gray-800 font-medium">{{ $coupon->used_count }}</span>
                                    <span class="text-gray-500 mx-1">/</span>
                                    <span class="text-gray-500">{{ $coupon->usage_limit ?? '∞' }}</span>
                                </div>
                                <p class="text-xs text-gray-500">Per user: {{ $coupon->usage_limit_per_user }}x</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($coupon->start_date && $coupon->end_date)
                                    <p class="text-gray-800">{{ $coupon->start_date->format('d M Y') }}</p>
                                    <p class="text-gray-500">s/d {{ $coupon->end_date->format('d M Y') }}</p>
                                @elseif($coupon->end_date)
                                    <p class="text-gray-500">s/d {{ $coupon->end_date->format('d M Y') }}</p>
                                @else
                                    <span class="text-gray-500">Tidak terbatas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $coupon->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $coupon->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kupon ini?')">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                <p class="text-gray-500">Belum ada kupon</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($coupons->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
