@extends('layouts.user')

@section('title', 'Transfer Bank')

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
            <h1 class="text-2xl font-bold text-gray-900">Transfer Bank</h1>
            <p class="text-gray-600">Top up saldo dengan transfer ke rekening toko</p>
        </div>

        <!-- Info Card -->
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="text-sm text-amber-700">
                    <p class="font-medium mb-1">Penting!</p>
                    <ul class="list-disc list-inside space-y-1 text-amber-600">
                        <li>Transfer sesuai nominal yang Anda masukkan</li>
                        <li>Simpan bukti transfer untuk diupload</li>
                        <li>Verifikasi membutuhkan waktu 1x24 jam</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bank Account Selection -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilih Rekening Tujuan</h2>
                
                @if($bankAccounts->count() > 0)
                    <div class="space-y-3">
                        @foreach($bankAccounts as $bank)
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/50 transition-colors bank-option">
                                <input type="radio" name="bank_account_id" value="{{ $bank->id }}" class="sr-only bank-radio"
                                    {{ $loop->first ? 'checked' : '' }}>
                                <div class="flex items-center flex-1 space-x-4">
                                    @if($bank->logo)
                                        <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->bank_name }}" class="w-12 h-12 object-contain rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $bank->bank_name }}</p>
                                        <p class="text-lg font-mono text-gray-700">{{ $bank->account_number }}</p>
                                        <p class="text-sm text-gray-500">a.n. {{ $bank->account_name }}</p>
                                    </div>
                                    <button type="button" onclick="copyToClipboard('{{ $bank->account_number }}')" 
                                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                        title="Salin nomor rekening">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="ml-4 check-indicator hidden">
                                    <div class="w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500">Tidak ada rekening bank yang tersedia saat ini</p>
                    </div>
                @endif
            </div>

            <!-- Form -->
            @if($bankAccounts->count() > 0)
                <form action="{{ route('wallet.topup.transfer') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    <input type="hidden" name="bank_account_id" id="selected_bank_id" value="{{ $bankAccounts->first()->id }}">

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Nominal Transfer
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

                    <!-- Proof Upload -->
                    <div>
                        <label for="proof_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Transfer
                        </label>
                        <div class="relative">
                            <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                                class="hidden" onchange="previewImage(event)">
                            <label for="proof_image" 
                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/50 transition-colors"
                                id="upload-area">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                    <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-1"><span class="font-medium text-indigo-600">Klik untuk upload</span> atau drag & drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Maks. 2MB)</p>
                                </div>
                                <img id="image-preview" src="#" alt="Preview" class="hidden max-h-44 rounded-lg object-contain">
                            </label>
                        </div>
                        @error('proof_image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan <span class="text-gray-400">(opsional)</span>
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                            placeholder="Contoh: Transfer dari rekening BCA a.n. Budi">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Kirim Bukti Transfer
                        </button>
                    </div>
                </form>
            @endif
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

<script>
    // Bank selection
    document.querySelectorAll('.bank-option').forEach(option => {
        const radio = option.querySelector('.bank-radio');
        const checkIndicator = option.querySelector('.check-indicator');
        
        // Initialize checked state
        if (radio.checked) {
            option.classList.add('border-indigo-500', 'bg-indigo-50/50');
            checkIndicator.classList.remove('hidden');
        }
        
        option.addEventListener('click', function(e) {
            if (e.target.closest('button')) return; // Don't trigger for copy button
            
            // Uncheck all
            document.querySelectorAll('.bank-option').forEach(opt => {
                opt.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                opt.querySelector('.check-indicator').classList.add('hidden');
                opt.querySelector('.bank-radio').checked = false;
            });
            
            // Check this one
            radio.checked = true;
            option.classList.add('border-indigo-500', 'bg-indigo-50/50');
            checkIndicator.classList.remove('hidden');
            
            // Update hidden input
            document.getElementById('selected_bank_id').value = radio.value;
        });
    });
    
    // Copy to clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        });
    }
    
    // Image preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('image-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
