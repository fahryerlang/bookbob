@extends('layouts.user')

@section('title', 'Request Top Up')

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
            <h1 class="text-2xl font-bold text-gray-900">Request Top Up</h1>
            <p class="text-gray-600">Ajukan permintaan top up saldo ke admin</p>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-sm text-blue-700">
                    <p class="font-medium mb-1">Bagaimana cara kerjanya?</p>
                    <ol class="list-decimal list-inside space-y-1 text-blue-600">
                        <li>Masukkan nominal yang ingin Anda top up</li>
                        <li>Kirim permintaan ke admin</li>
                        <li>Tunggu admin memproses permintaan Anda</li>
                        <li>Setelah disetujui, saldo akan otomatis masuk ke dompet Anda</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('wallet.topup.request') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Nominal Top Up
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="10000" step="1000"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg font-semibold @error('amount') border-red-500 @enderror"
                            placeholder="0" required>
                    </div>
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Minimal top up Rp 10.000</p>
                </div>

                <!-- Quick Amount Buttons -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nominal Cepat</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach([50000, 100000, 200000, 300000, 500000, 1000000] as $nominal)
                            <button type="button" onclick="document.getElementById('amount').value = {{ $nominal }}"
                                class="px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-500 hover:text-indigo-600 transition-colors">
                                Rp {{ number_format($nominal, 0, ',', '.') }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan <span class="text-gray-400">(opsional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                        placeholder="Tambahkan catatan untuk admin jika diperlukan...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Permintaan
                    </button>
                </div>
            </form>
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
