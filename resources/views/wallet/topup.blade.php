@extends('layouts.user')

@section('title', 'Top Up Saldo')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('wallet.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Top Up Saldo</h1>
                    <p class="text-gray-600">Pilih metode top up yang Anda inginkan</p>
                </div>
            </div>
            
            <!-- Current Balance -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white">
                <p class="text-emerald-100 text-sm">Saldo Saat Ini</p>
                <p class="text-3xl font-bold">Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Top Up Methods -->
        <div class="grid gap-6">
            <!-- Manual Request -->
            <a href="{{ route('wallet.topup.request.form') }}" 
               class="block bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 group">
                <div class="p-6 flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                            Request Manual
                        </h3>
                        <p class="text-gray-500 mt-1">
                            Ajukan permintaan top up dan admin akan memproses secara manual. Cocok untuk pembayaran langsung atau cash.
                        </p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Diproses Admin
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                1-24 jam
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-gray-400 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Bank Transfer -->
            <a href="{{ route('wallet.topup.transfer.form') }}" 
               class="block bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 group">
                <div class="p-6 flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                            Transfer Bank
                        </h3>
                        <p class="text-gray-500 mt-1">
                            Transfer ke rekening toko dan upload bukti pembayaran. Mendukung semua bank di Indonesia.
                        </p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                Rekomendasi
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                1-12 jam
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-gray-400 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Payment Gateway -->
            <a href="{{ route('wallet.topup.gateway') }}" 
               class="block bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 group relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                        Coming Soon
                    </span>
                </div>
                <div class="p-6 flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                            Payment Gateway
                        </h3>
                        <p class="text-gray-500 mt-1">
                            Top up instan menggunakan QRIS, e-wallet (GoPay, OVO, Dana), Virtual Account, dan kartu kredit.
                        </p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Otomatis
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                Instan
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-gray-400 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-blue-50 rounded-2xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-blue-900">Informasi Penting</h4>
                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                        <li>• Minimal top up adalah Rp 10.000</li>
                        <li>• Saldo tidak dapat ditarik kembali dalam bentuk uang tunai</li>
                        <li>• Pastikan nominal transfer sesuai dengan permintaan</li>
                        <li>• Hubungi admin jika ada kendala dalam proses top up</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        @if(auth()->user()->topupRequests()->pending()->exists())
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Permintaan Pending</h3>
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-amber-800">Anda memiliki permintaan top up yang sedang menunggu persetujuan.</span>
                    <a href="{{ route('wallet.history') }}" class="ml-auto text-amber-600 hover:text-amber-700 font-medium text-sm">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
