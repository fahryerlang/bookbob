@extends('layouts.user')

@section('title', 'Tulis Ulasan - ' . $book->title)

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-indigo-600">Pesanan Saya</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('orders.show', $order) }}" class="text-gray-500 hover:text-indigo-600">{{ $order->order_number }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-800 font-medium">Tulis Ulasan</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                <h1 class="text-xl font-bold text-white">
                    {{ $existingReview ? 'Edit Ulasan' : 'Tulis Ulasan' }}
                </h1>
            </div>

            <div class="p-6">
                <!-- Book Info -->
                <div class="flex gap-4 mb-6 pb-6 border-b">
                    <div class="w-20 h-28 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-800">{{ $book->title }}</h2>
                        <p class="text-sm text-gray-500">oleh {{ $book->author }}</p>
                        <p class="text-sm text-gray-400 mt-1">Pesanan: {{ $order->order_number }}</p>
                    </div>
                </div>

                <!-- Review Form -->
                <form action="{{ $existingReview ? route('reviews.update', $existingReview) : route('reviews.store', [$order, $book]) }}" 
                      method="POST">
                    @csrf
                    @if($existingReview)
                        @method('PUT')
                    @endif

                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Berikan Rating <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" 
                                        onclick="setRating({{ $i }})"
                                        class="star-btn text-4xl transition-all hover:scale-110 focus:outline-none {{ ($existingReview && $existingReview->rating >= $i) ? 'text-amber-400' : 'text-gray-300' }}"
                                        data-rating="{{ $i }}">
                                    ★
                                </button>
                            @endfor
                            <span id="rating-text" class="ml-3 text-sm text-gray-500">
                                @if($existingReview)
                                    @switch($existingReview->rating)
                                        @case(1) Sangat Buruk @break
                                        @case(2) Buruk @break
                                        @case(3) Cukup @break
                                        @case(4) Bagus @break
                                        @case(5) Sangat Bagus @break
                                    @endswitch
                                @else
                                    Klik bintang untuk memberi rating
                                @endif
                            </span>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ $existingReview?->rating ?? '' }}" required>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Review Text -->
                    <div class="mb-6">
                        <label for="review" class="block text-sm font-medium text-gray-700 mb-2">
                            Tulis Ulasan Anda (Opsional)
                        </label>
                        <textarea name="review" 
                                  id="review" 
                                  rows="5"
                                  placeholder="Ceritakan pengalaman Anda dengan buku ini..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none">{{ old('review', $existingReview?->review) }}</textarea>
                        <p class="mt-1 text-xs text-gray-400">Maksimal 1000 karakter</p>
                        @error('review')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('orders.show', $order) }}" 
                           class="text-gray-600 hover:text-gray-800">
                            ← Kembali ke Pesanan
                        </a>
                        <div class="flex gap-3">
                            @if($existingReview)
                                <button type="button"
                                        onclick="if(confirm('Hapus ulasan ini?')) document.getElementById('delete-form').submit()"
                                        class="px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                                    Hapus Ulasan
                                </button>
                            @endif
                            <button type="submit"
                                    class="px-6 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition">
                                {{ $existingReview ? 'Update Ulasan' : 'Kirim Ulasan' }}
                            </button>
                        </div>
                    </div>
                </form>

                @if($existingReview)
                    <form id="delete-form" action="{{ route('reviews.destroy', $existingReview) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
const ratingTexts = {
    1: 'Sangat Buruk',
    2: 'Buruk', 
    3: 'Cukup',
    4: 'Bagus',
    5: 'Sangat Bagus'
};

function setRating(rating) {
    document.getElementById('rating-input').value = rating;
    document.getElementById('rating-text').textContent = ratingTexts[rating];
    
    document.querySelectorAll('.star-btn').forEach((btn, index) => {
        if (index < rating) {
            btn.classList.remove('text-gray-300');
            btn.classList.add('text-amber-400');
        } else {
            btn.classList.remove('text-amber-400');
            btn.classList.add('text-gray-300');
        }
    });
}
</script>
@endsection
