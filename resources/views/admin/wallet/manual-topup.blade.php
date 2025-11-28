@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.wallet.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 transition mb-2 group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Top Up Manual</h1>
        <p class="text-gray-600">Tambah saldo ke akun pengguna secara manual</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.wallet.manual-topup.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- User Search -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Pengguna
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('user_id') border-red-500 @enderror">
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }}) - Saldo: Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Nominal Top Up
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1000" step="1000"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg font-semibold @error('amount') border-red-500 @enderror"
                                placeholder="0" required>
                        </div>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quick Amount Buttons -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nominal Cepat</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([50000, 100000, 200000, 500000, 1000000, 2000000] as $nominal)
                                <button type="button" onclick="document.getElementById('amount').value = {{ $nominal }}"
                                    class="px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-500 hover:text-indigo-600 transition-colors">
                                    Rp {{ number_format($nominal, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                            placeholder="Contoh: Top up manual via transfer tunai">{{ old('description', 'Top up manual oleh admin') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Saldo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Informasi</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-600">
                            <li>Top up manual akan langsung menambah saldo pengguna</li>
                            <li>Transaksi akan tercatat dalam riwayat</li>
                            <li>Pastikan nominal yang dimasukkan sudah benar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Manual Topups -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Up Manual Terakhir</h3>
                
                @if($recentManualTopups->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentManualTopups as $topup)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $topup->wallet->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $topup->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="font-semibold text-green-600">+Rp {{ number_format($topup->amount, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada top up manual</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
