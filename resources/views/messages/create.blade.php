@extends('layouts.user')

@section('title', 'Tulis Pesan')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
        <div class="flex items-center space-x-4">
            <a href="{{ route('messages.index') }}" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold mb-1">Tulis Pesan Baru</h1>
                <p class="text-indigo-100">Kirim pesan langsung ke admin BookBob</p>
            </div>
        </div>
    </div>

    <!-- Message Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('messages.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                        Subjek Pesan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="subject" 
                           id="subject" 
                           value="{{ old('subject') }}"
                           placeholder="Contoh: Pertanyaan tentang pesanan, Saran untuk toko, dll"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('subject') border-red-500 @enderror"
                           required>
                    @error('subject')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                        Isi Pesan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" 
                              id="message" 
                              rows="8"
                              placeholder="Tulis pesan Anda di sini..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none @error('message') border-red-500 @enderror"
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Maksimal 2000 karakter</p>
                </div>

                <!-- Info Box -->
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-indigo-800 mb-1">Informasi Pengirim</h4>
                            <p class="text-sm text-indigo-700">
                                Pesan akan dikirim sebagai <strong>{{ auth()->user()->name }}</strong> dengan email <strong>{{ auth()->user()->email }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <a href="{{ route('messages.index') }}" 
                       class="px-6 py-3 text-gray-600 font-semibold hover:text-gray-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Tips Menulis Pesan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <div class="flex items-start space-x-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Gunakan subjek yang jelas dan spesifik</span>
            </div>
            <div class="flex items-start space-x-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Jelaskan pertanyaan atau masalah dengan detail</span>
            </div>
            <div class="flex items-start space-x-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Sertakan nomor pesanan jika terkait pesanan</span>
            </div>
            <div class="flex items-start space-x-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Admin akan merespons melalui email</span>
            </div>
        </div>
    </div>
</div>
@endsection
