@extends('layouts.user')

@section('title', 'Pesan Saya')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pesan Saya</h1>
                <p class="text-indigo-100">Kirim pesan dan pertanyaan langsung ke admin</p>
            </div>
            <a href="{{ route('messages.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tulis Pesan Baru
            </a>
        </div>
    </div>

    @if($messages->count() > 0)
        <!-- Messages List -->
        <div class="space-y-4">
            @foreach($messages as $message)
                <a href="{{ route('messages.show', $message) }}" 
                   class="block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start space-x-4 flex-1">
                                <!-- Icon -->
                                <div class="w-12 h-12 rounded-xl {{ $message->is_read ? 'bg-gray-100 text-gray-500' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h3 class="font-semibold text-gray-800 truncate">{{ $message->subject }}</h3>
                                        @if(!$message->is_read)
                                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-600 text-xs font-medium rounded-full">Terkirim</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-green-100 text-green-600 text-xs font-medium rounded-full">Dibaca</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($message->message, 120) }}</p>
                                    <div class="flex items-center space-x-4 mt-2 text-xs text-gray-400">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $messages->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesan</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Anda belum mengirim pesan apapun. Silakan kirim pesan jika ada pertanyaan atau butuh bantuan!</p>
            <a href="{{ route('messages.create') }}" 
               class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tulis Pesan Pertama
            </a>
        </div>
    @endif
</div>
@endsection
