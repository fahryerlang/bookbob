@extends('layouts.user')

@section('title', 'Detail Pesan')

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
                <h1 class="text-3xl font-bold mb-1">Detail Pesan</h1>
                <p class="text-indigo-100">Lihat detail pesan yang telah dikirim</p>
            </div>
        </div>
    </div>

    <!-- Message Detail -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Message Header -->
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start space-x-4">
                    <div class="w-14 h-14 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $message->subject }}</h2>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $message->created_at->format('d M Y, H:i') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $message->name }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($message->is_read)
                    <span class="px-4 py-2 bg-green-100 text-green-700 text-sm font-semibold rounded-full flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Sudah Dibaca
                    </span>
                @else
                    <span class="px-4 py-2 bg-amber-100 text-amber-700 text-sm font-semibold rounded-full flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu Dibaca
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Message Content -->
        <div class="p-6">
            <div class="prose prose-indigo max-w-none">
                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
            </div>
        </div>

        <!-- Message Footer -->
        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-500">
                    <p>Dikirim dari: <span class="font-medium text-gray-700">{{ $message->email }}</span></p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('messages.index') }}" 
                       class="inline-flex items-center px-5 py-2.5 text-gray-600 font-semibold hover:text-gray-800 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('messages.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Kirim Pesan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Info -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-blue-800 mb-1">Informasi</h4>
                <p class="text-sm text-blue-700">
                    @if($message->is_read)
                        Pesan Anda sudah dibaca oleh admin. Jika ada pertanyaan lebih lanjut, silakan kirim pesan baru atau hubungi kami melalui WhatsApp.
                    @else
                        Pesan Anda sedang menunggu untuk dibaca oleh admin. Kami akan segera merespons melalui email yang terdaftar.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
