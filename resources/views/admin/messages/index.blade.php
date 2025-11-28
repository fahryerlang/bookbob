@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pusat Pesan</h1>
                <p class="text-indigo-100">Kelola semua pesan dari pelanggan Anda</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <!-- Stats Cards -->
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[120px]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">{{ $messages->total() }}</p>
                            <p class="text-xs text-indigo-100">Total Pesan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[120px]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-400/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            @php
                                $unreadCount = \App\Models\Message::where('is_read', false)->count();
                            @endphp
                            <p class="text-2xl font-bold">{{ $unreadCount }}</p>
                            <p class="text-xs text-indigo-100">Belum Dibaca</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.messages.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan nama, email, atau subjek..."
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div class="flex gap-3">
                    <select name="status" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all min-w-[160px]">
                        <option value="">Semua Status</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>📩 Belum Dibaca</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>✅ Sudah Dibaca</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span>Filter</span>
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.messages.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Messages List -->
    @if($messages->count() > 0)
        <div class="space-y-4">
            @foreach($messages as $message)
                <div class="bg-white rounded-2xl shadow-sm border {{ !$message->is_read ? 'border-indigo-200 bg-gradient-to-r from-indigo-50/50 to-white' : 'border-gray-100' }} overflow-hidden hover:shadow-md transition-all duration-300 group">
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <!-- Avatar & Status -->
                            <div class="relative flex-shrink-0">
                                <div class="w-14 h-14 rounded-xl {{ !$message->is_read ? 'bg-indigo-100' : 'bg-gray-100' }} flex items-center justify-center text-xl font-bold {{ !$message->is_read ? 'text-indigo-600' : 'text-gray-500' }}">
                                    {{ strtoupper(substr($message->name, 0, 1)) }}
                                </div>
                                @if(!$message->is_read)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-indigo-600 rounded-full border-2 border-white animate-pulse"></span>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-semibold text-gray-800 {{ !$message->is_read ? 'text-indigo-900' : '' }}">
                                                {{ $message->name }}
                                            </h3>
                                            @if(!$message->is_read)
                                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                                    Baru
                                                </span>
                                            @endif
                                            @if($message->user_id)
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Member
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $message->email }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-sm text-gray-500">{{ $message->created_at->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $message->created_at->format('H:i') }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h4 class="font-medium text-gray-800 {{ !$message->is_read ? 'font-semibold text-indigo-900' : '' }} mb-1">
                                        {{ $message->subject }}
                                    </h4>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        @if($message->phone)
                                            <span class="flex items-center bg-gray-100 px-2 py-1 rounded-lg">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $message->phone }}
                                            </span>
                                        @endif
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if(!$message->is_read)
                                            <form action="{{ route('admin.messages.markAsRead', $message) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Tandai Sudah Dibaca">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.messages.show', $message) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat
                                        </a>
                                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pesan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesan</h2>
            <p class="text-gray-500 max-w-md mx-auto">
                @if(request('search') || request('status'))
                    Tidak ada pesan yang sesuai dengan filter Anda. Coba ubah kriteria pencarian.
                @else
                    Belum ada pesan dari pelanggan. Pesan akan muncul di sini ketika pelanggan menghubungi Anda.
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset Filter
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
