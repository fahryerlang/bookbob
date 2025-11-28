@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Temukan Buku Favoritmu di BookBob</h1>
                <p class="text-lg mb-8 text-indigo-100">Jelajahi ribuan koleksi buku berkualitas dengan harga terjangkau. Belanja mudah, cepat, dan aman.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('catalog.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition text-center">Lihat Katalog</a>
                    @guest
                        <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition text-center">Daftar Sekarang</a>
                    @endguest
                </div>
            </div>
            <div class="hidden md:block">
                <svg class="w-full max-w-md mx-auto" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="50" y="50" width="120" height="180" rx="5" fill="#E0E7FF" stroke="#6366F1" stroke-width="3"/>
                    <rect x="60" y="70" width="100" height="20" rx="3" fill="#6366F1"/>
                    <rect x="60" y="100" width="80" height="10" rx="2" fill="#A5B4FC"/>
                    <rect x="60" y="120" width="90" height="10" rx="2" fill="#A5B4FC"/>
                    <rect x="60" y="140" width="70" height="10" rx="2" fill="#A5B4FC"/>
                    <rect x="140" y="80" width="140" height="200" rx="5" fill="#FEF3C7" stroke="#F59E0B" stroke-width="3"/>
                    <rect x="150" y="100" width="120" height="25" rx="3" fill="#F59E0B"/>
                    <rect x="150" y="135" width="100" height="12" rx="2" fill="#FCD34D"/>
                    <rect x="150" y="155" width="110" height="12" rx="2" fill="#FCD34D"/>
                    <rect x="150" y="175" width="90" height="12" rx="2" fill="#FCD34D"/>
                    <rect x="230" y="40" width="130" height="190" rx="5" fill="#D1FAE5" stroke="#10B981" stroke-width="3"/>
                    <rect x="240" y="60" width="110" height="22" rx="3" fill="#10B981"/>
                    <rect x="240" y="92" width="90" height="11" rx="2" fill="#6EE7B7"/>
                    <rect x="240" y="112" width="100" height="11" rx="2" fill="#6EE7B7"/>
                    <rect x="240" y="132" width="80" height="11" rx="2" fill="#6EE7B7"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Mengapa Memilih BookBob?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kami berkomitmen memberikan pengalaman belanja buku terbaik untuk Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 rounded-xl bg-gray-50 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Koleksi Lengkap</h3>
                <p class="text-gray-600">Ribuan judul buku dari berbagai kategori tersedia untuk Anda pilih</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-gray-50 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600">Dapatkan buku berkualitas dengan harga yang ramah di kantong</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-gray-50 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Pengiriman Cepat</h3>
                <p class="text-gray-600">Pesanan Anda akan kami proses dan kirim dengan cepat</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang BookBob</h2>
                <p class="text-gray-600 mb-4">
                    BookBob adalah toko buku online yang didirikan dengan visi untuk mempermudah akses masyarakat Indonesia terhadap buku-buku berkualitas. Kami percaya bahwa membaca adalah kunci untuk membuka pintu pengetahuan dan mengembangkan diri.
                </p>
                <p class="text-gray-600 mb-4">
                    Dengan koleksi yang terus bertambah dan pelayanan yang prima, kami berkomitmen untuk menjadi mitra terpercaya Anda dalam memenuhi kebutuhan literasi. Dari buku fiksi hingga non-fiksi, dari buku anak hingga buku akademik, semuanya tersedia di BookBob.
                </p>
                <p class="text-gray-600 mb-6">
                    Tim kami yang berdedikasi siap membantu Anda menemukan buku yang tepat untuk setiap kebutuhan. Bergabunglah dengan ribuan pelanggan puas yang telah mempercayakan kebutuhan buku mereka kepada kami.
                </p>
                <a href="{{ route('about') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">Pelajari Lebih Lanjut</a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <div class="grid grid-cols-2 gap-6 text-center">
                    <div class="p-4">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">1000+</div>
                        <div class="text-gray-600">Judul Buku</div>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
                        <div class="text-gray-600">Pelanggan</div>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-orange-600 mb-2">50+</div>
                        <div class="text-gray-600">Kategori</div>
                    </div>
                    <div class="p-4">
                        <div class="text-4xl font-bold text-purple-600 mb-2">24/7</div>
                        <div class="text-gray-600">Layanan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Memulai Petualangan Membaca?</h2>
        <p class="text-indigo-100 mb-8 max-w-2xl mx-auto">Daftar sekarang dan temukan buku-buku terbaik untuk Anda. Nikmati pengalaman belanja buku yang menyenangkan di BookBob.</p>
        @guest
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Login</a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition">Daftar Gratis</a>
            </div>
        @else
            <a href="{{ route('catalog.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition inline-block">Jelajahi Katalog</a>
        @endguest
    </div>
</section>
@endsection
