@extends('layouts.user')

@section('title', 'Detail Top Up')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <a href="{{ route('wallet.history') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 transition mb-2 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Permintaan Top Up</h1>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Status Header -->
            <div class="p-6 border-b border-gray-100
                @if($topupRequest->status == 'approved') bg-green-50
                @elseif($topupRequest->status == 'rejected') bg-red-50
                @elseif($topupRequest->status == 'expired') bg-gray-50
                @else bg-amber-50 @endif">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center
                        @if($topupRequest->status == 'approved') bg-green-100 text-green-600
                        @elseif($topupRequest->status == 'rejected') bg-red-100 text-red-600
                        @elseif($topupRequest->status == 'expired') bg-gray-200 text-gray-600
                        @else bg-amber-100 text-amber-600 @endif">
                        @if($topupRequest->status == 'approved')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @elseif($topupRequest->status == 'rejected')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @elseif($topupRequest->status == 'expired')
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Rp {{ number_format($topupRequest->amount, 0, ',', '.') }}</h2>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($topupRequest->status == 'approved') bg-green-100 text-green-700
                                @elseif($topupRequest->status == 'rejected') bg-red-100 text-red-700
                                @elseif($topupRequest->status == 'expired') bg-gray-200 text-gray-700
                                @else bg-amber-100 text-amber-700 @endif">
                                {{ $topupRequest->status_label }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                @if($topupRequest->method == 'request') bg-blue-100 text-blue-700
                                @elseif($topupRequest->method == 'transfer') bg-green-100 text-green-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ $topupRequest->method_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">ID Permintaan</p>
                        <p class="font-medium text-gray-900">#{{ $topupRequest->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                        <p class="font-medium text-gray-900">{{ $topupRequest->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($topupRequest->method == 'transfer' && $topupRequest->bankAccount)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Bank Tujuan</p>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                            @if($topupRequest->bankAccount->logo)
                                <img src="{{ asset('storage/' . $topupRequest->bankAccount->logo) }}" alt="{{ $topupRequest->bankAccount->bank_name }}" class="w-10 h-10 object-contain rounded-lg">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $topupRequest->bankAccount->bank_name }}</p>
                                <p class="text-sm text-gray-500">{{ $topupRequest->bankAccount->account_number }} - {{ $topupRequest->bankAccount->account_name }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($topupRequest->proof_image)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Bukti Transfer</p>
                        <a href="{{ asset('storage/' . $topupRequest->proof_image) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $topupRequest->proof_image) }}" alt="Bukti Transfer" class="rounded-xl max-h-64 object-contain border border-gray-200">
                        </a>
                    </div>
                @endif

                @if($topupRequest->notes)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Catatan Anda</p>
                        <p class="text-gray-900">{{ $topupRequest->notes }}</p>
                    </div>
                @endif

                @if($topupRequest->admin_notes)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Catatan Admin</p>
                        <p class="text-gray-900">{{ $topupRequest->admin_notes }}</p>
                    </div>
                @endif

                @if($topupRequest->approved_at)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Diproses pada</p>
                        <p class="font-medium text-gray-900">{{ $topupRequest->approved_at->format('d M Y, H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        @if($topupRequest->status == 'pending')
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Menunggu Verifikasi</p>
                        <p class="text-blue-600">Permintaan Anda sedang diproses oleh admin. Mohon tunggu hingga verifikasi selesai.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back to Wallet -->
        <div class="text-center">
            <a href="{{ route('wallet.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Kembali ke Dompet
            </a>
        </div>
    </div>
</div>
@endsection
