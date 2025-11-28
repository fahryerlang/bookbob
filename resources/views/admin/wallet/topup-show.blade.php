@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.wallet.topup-requests') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 transition mb-2 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Permintaan Top Up</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100
                    @if($topupRequest->status == 'approved') bg-green-50
                    @elseif($topupRequest->status == 'rejected') bg-red-50
                    @elseif($topupRequest->status == 'expired') bg-gray-50
                    @else bg-amber-50 @endif">
                    <div class="flex items-center justify-between">
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
                </div>

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

                    @if($topupRequest->notes)
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">Catatan Pengguna</p>
                            <p class="text-gray-900">{{ $topupRequest->notes }}</p>
                        </div>
                    @endif

                    @if($topupRequest->admin_notes)
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">Catatan Admin</p>
                            <p class="text-gray-900">{{ $topupRequest->admin_notes }}</p>
                        </div>
                    @endif

                    @if($topupRequest->approver && $topupRequest->approved_at)
                        <div class="pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Diproses oleh</p>
                                    <p class="font-medium text-gray-900">{{ $topupRequest->approver->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Diproses pada</p>
                                    <p class="font-medium text-gray-900">{{ $topupRequest->approved_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Proof Image -->
            @if($topupRequest->proof_image)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Transfer</h3>
                    <a href="{{ asset('storage/' . $topupRequest->proof_image) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $topupRequest->proof_image) }}" alt="Bukti Transfer" class="rounded-xl max-h-96 object-contain mx-auto border border-gray-200">
                    </a>
                </div>
            @endif

            <!-- Actions -->
            @if($topupRequest->status == 'pending')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Approve Form -->
                        <form action="{{ route('admin.wallet.topup.approve', $topupRequest) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                <textarea name="admin_notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Catatan untuk pengguna..."></textarea>
                            </div>
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui Permintaan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('admin.wallet.topup.reject', $topupRequest) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                <textarea name="admin_notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Alasan penolakan..." required></textarea>
                            </div>
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Permintaan
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - User Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengguna</h3>
                
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl font-medium text-gray-600">{{ strtoupper(substr($topupRequest->user->name, 0, 2)) }}</span>
                    </div>
                    <h4 class="font-semibold text-gray-900">{{ $topupRequest->user->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $topupRequest->user->email }}</p>
                </div>

                <div class="space-y-3 border-t border-gray-100 pt-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Saldo Saat Ini</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($topupRequest->user->wallet_balance, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Total Top Up</span>
                        <span class="font-medium text-gray-900">{{ $topupRequest->user->topupRequests()->where('status', 'approved')->count() }}x</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Bergabung</span>
                        <span class="font-medium text-gray-900">{{ $topupRequest->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Topups by this User -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Top Up Pengguna</h3>
                
                @php
                    $recentTopups = $topupRequest->user->topupRequests()
                        ->where('id', '!=', $topupRequest->id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($recentTopups->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTopups as $recent)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">Rp {{ number_format($recent->amount, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $recent->created_at->format('d M Y') }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($recent->status == 'approved') bg-green-100 text-green-700
                                    @elseif($recent->status == 'rejected') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700 @endif">
                                    {{ $recent->status_label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat top up lainnya</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
