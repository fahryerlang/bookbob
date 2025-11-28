@extends('layouts.user')

@section('title', 'Payment Gateway')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <a href="{{ route('wallet.topup') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 transition mb-2 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Payment Gateway</h1>
            <p class="text-gray-600">Top up instan dengan berbagai metode pembayaran</p>
        </div>

        <!-- Coming Soon Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Segera Hadir!</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Fitur payment gateway sedang dalam pengembangan. Anda akan dapat melakukan top up instan menggunakan berbagai metode pembayaran seperti:
                </p>

                <!-- Payment Methods Preview -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Kartu Kredit</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">E-Wallet</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">QRIS</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Virtual Account</p>
                    </div>
                </div>

                <!-- Alternative Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('wallet.topup.request.form') }}" 
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Request Top Up
                    </a>
                    <a href="{{ route('wallet.topup.transfer.form') }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Transfer Bank
                    </a>
                </div>
            </div>
        </div>

        <!-- Current Balance -->
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Saldo Anda Saat Ini</span>
                <span class="text-xl font-bold text-gray-900">Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
