@extends('layouts.main')

@section('content')
<!-- About Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Tentang Kami</h1>
        <p class="text-indigo-100 max-w-2xl mx-auto">Mengenal lebih dekat BookBob - mitra terpercaya Anda dalam memenuhi kebutuhan literasi</p>
    </div>
</section>

<!-- About Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Cerita Kami</h2>
                <p class="text-gray-600 mb-4">
                    BookBob didirikan pada tahun 2020 dengan satu misi sederhana: membuat buku berkualitas lebih mudah diakses oleh semua orang. Berawal dari sebuah toko kecil di Jakarta, kami kini telah berkembang menjadi toko buku online yang melayani pelanggan di seluruh Indonesia.
                </p>
                <p class="text-gray-600 mb-4">
                    Nama "BookBob" sendiri terinspirasi dari keinginan kami untuk menjadi teman yang selalu ada untuk para pecinta buku. Seperti sahabat yang dapat diandalkan, kami ingin membantu Anda menemukan buku-buku yang tepat untuk setiap momen dalam hidup Anda.
                </p>
                <p class="text-gray-600">
                    Dengan tim yang terdiri dari para pecinta buku dan profesional di bidang e-commerce, kami berkomitmen untuk terus meningkatkan layanan dan memperluas koleksi kami demi kepuasan pelanggan.
                </p>
            </div>
            <div class="bg-indigo-100 rounded-xl p-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">5+</div>
                        <div class="text-gray-600">Tahun Pengalaman</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">10K+</div>
                        <div class="text-gray-600">Buku Terjual</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">5K+</div>
                        <div class="text-gray-600">Pelanggan Puas</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">100+</div>
                        <div class="text-gray-600">Penerbit Partner</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-indigo-50 rounded-xl p-8">
                <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Visi Kami</h3>
                <p class="text-gray-600">
                    Menjadi toko buku online terdepan di Indonesia yang menginspirasi dan memfasilitasi masyarakat untuk terus belajar dan berkembang melalui literasi.
                </p>
            </div>
            <div class="bg-green-50 rounded-xl p-8">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Misi Kami</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>• Menyediakan koleksi buku yang lengkap dan berkualitas</li>
                    <li>• Memberikan harga yang kompetitif dan terjangkau</li>
                    <li>• Menjamin pengiriman yang cepat dan aman</li>
                    <li>• Memberikan pelayanan pelanggan yang prima</li>
                </ul>
            </div>
        </div>

        <!-- Values -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Nilai-Nilai Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Prinsip yang menjadi dasar setiap langkah kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Kepercayaan</h3>
                <p class="text-gray-600">Membangun kepercayaan melalui transparansi dan integritas dalam setiap transaksi</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Passion</h3>
                <p class="text-gray-600">Cinta terhadap buku dan literasi yang mendorong kami untuk terus berkembang</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Komunitas</h3>
                <p class="text-gray-600">Membangun komunitas pembaca yang saling mendukung dan berbagi pengetahuan</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ada Pertanyaan?</h2>
        <p class="text-gray-600 mb-8">Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda.</p>
        <a href="{{ route('contact') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition inline-block">Hubungi Kami</a>
    </div>
</section>
@endsection
