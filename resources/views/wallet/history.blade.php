@extends('layouts.user')

@section('title', 'Riwayat Top Up')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('wallet.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 transition mb-2 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Top Up</h1>
                <p class="text-gray-600">Daftar permintaan top up saldo Anda</p>
            </div>
            <a href="{{ route('wallet.topup') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Top Up Baru
            </a>
        </div>

        <!-- Topup Requests List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($topupRequests->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($topupRequests as $request)
                        <div class="p-5 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center
                                        @if($request->status == 'approved') bg-green-100 text-green-600
                                        @elseif($request->status == 'rejected') bg-red-100 text-red-600
                                        @elseif($request->status == 'expired') bg-gray-100 text-gray-600
                                        @else bg-amber-100 text-amber-600 @endif">
                                        @if($request->status == 'approved')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @elseif($request->status == 'rejected')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @elseif($request->status == 'expired')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            Rp {{ number_format($request->amount, 0, ',', '.') }}
                                        </p>
                                        <div class="flex items-center space-x-2 text-sm">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($request->method == 'request') bg-blue-100 text-blue-700
                                                @elseif($request->method == 'transfer') bg-green-100 text-green-700
                                                @else bg-purple-100 text-purple-700 @endif">
                                                {{ $request->method_label }}
                                            </span>
                                            <span class="text-gray-400">|</span>
                                            <span class="text-gray-500">{{ $request->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($request->status == 'approved') bg-green-100 text-green-700
                                        @elseif($request->status == 'rejected') bg-red-100 text-red-700
                                        @elseif($request->status == 'expired') bg-gray-100 text-gray-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ $request->status_label }}
                                    </span>
                                    <a href="{{ route('wallet.topup.show', $request) }}" class="text-indigo-600 hover:text-indigo-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @if($request->admin_notes && in_array($request->status, ['approved', 'rejected']))
                                <div class="mt-3 ml-16 p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Catatan Admin:</span> {{ $request->admin_notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="p-4 border-t border-gray-100">
                    {{ $topupRequests->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-500 mb-6">Anda belum pernah melakukan top up saldo</p>
                    <a href="{{ route('wallet.topup') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Top Up Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
