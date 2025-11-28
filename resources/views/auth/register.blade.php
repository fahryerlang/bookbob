<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - BookBob</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
            .gradient-bg {
                background: linear-gradient(135deg, #0f0c29 0%, #312e81 50%, #1f1b4b 100%);
            }
            .floating {
                animation: floating 6s ease-in-out infinite;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-18px); }
            }
            .glow-purple {
                box-shadow: 0 0 60px rgba(139, 92, 246, 0.55), 0 0 100px rgba(99, 102, 241, 0.35);
            }
            .text-gradient {
                background: linear-gradient(135deg, #fff 0%, #c4b5fd 50%, #fff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .feature-item {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(12px);
                transition: all 0.3s ease;
            }
            .feature-item:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateX(12px);
                border-color: rgba(255, 255, 255, 0.25);
            }
            .stat-box {
                background: rgba(255, 255, 255, 0.09);
                border: 1px solid rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(8px);
            }
            .input-modern {
                transition: all 0.3s ease;
                background: #f9fafb;
            }
            .input-modern:focus {
                background: #fff;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }
            .btn-gradient {
                background: linear-gradient(135deg, #f97316 0%, #ec4899 50%, #8b5cf6 100%);
                background-size: 200% 200%;
                animation: gradientMove 3s ease infinite;
            }
            @keyframes gradientMove {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            .decorative-circle {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.65;
            }
        </style>
</head>
    <body class="antialiased">
        <div class="min-h-screen gradient-bg flex">
            <!-- Left Side - Information -->
            <div class="hidden lg:flex lg:w-1/2 flex-col justify-center items-center p-12 relative overflow-hidden">
                <div class="decorative-circle w-96 h-96 bg-violet-600 -top-24 -left-12"></div>
                <div class="decorative-circle w-72 h-72 bg-indigo-600 bottom-10 right-20"></div>
                <div class="decorative-circle w-64 h-64 bg-fuchsia-500 top-1/2 left-1/3"></div>

                <div class="relative z-10 max-w-lg w-full">
                    <!-- Logo -->
                    <div class="floating mb-12 flex justify-center">
                        <div class="w-28 h-28 bg-gradient-to-br from-violet-500 via-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center glow-purple shadow-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="text-center text-white mb-12">
                        <h1 class="text-5xl font-extrabold text-gradient mb-4">Gabung dengan BookBob</h1>
                        <p class="text-lg text-purple-200">Dapatkan pengalaman belanja buku terbaik setiap hari.</p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-12">
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <p class="text-3xl font-bold text-white">15K+</p>
                            <span class="text-sm text-purple-200 font-medium">Member Aktif</span>
                        </div>
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <p class="text-3xl font-bold text-white">1.5M+</p>
                            <span class="text-sm text-purple-200 font-medium">Buku Terjual</span>
                        </div>
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <p class="text-3xl font-bold text-white">24/7</p>
                            <span class="text-sm text-purple-200 font-medium">Support</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Diskon Member Eksklusif</h3>
                                <p class="text-purple-200 text-sm">Cashback & promo khusus setiap minggu.</p>
                            </div>
                        </div>

                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Notifikasi Buku Terbaru</h3>
                                <p class="text-purple-200 text-sm">Koleksi terbaru langsung ke email Anda.</p>
                            </div>
                        </div>

                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Poin Reward</h3>
                                <p class="text-purple-200 text-sm">Tukar poin dengan voucer menarik.</p>
                            </div>
                        </div>

                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-rose-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Komunitas Pembaca</h3>
                                <p class="text-purple-200 text-sm">Ikuti event & klub buku eksklusif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-white">
                <div class="w-full max-w-md">
                    <!-- Logo Mobile -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-gray-800">BookBob</span>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-400 to-rose-500 rounded-2xl mb-5 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                        <p class="text-gray-500 mt-2 text-base">Mulai jelajahi ribuan koleksi buku.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                    class="input-modern w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="input-modern w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                    placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="input-modern w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                    placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePassword('password', 'eye-icon-1')" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <svg id="eye-icon-1" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="input-modern w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                    placeholder="Ulangi password">
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2')" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <svg id="eye-icon-2" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms" required class="w-4 h-4 mt-1 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">
                                    Saya setuju dengan
                                    <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold">Syarat & Ketentuan</a>
                                    serta
                                    <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold">Kebijakan Privasi</a> BookBob.
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-4 btn-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-0.5 text-lg">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Daftar Sekarang
                            </span>
                        </button>
                    </form>

                    <div class="my-8 flex items-center">
                        <div class="flex-1 border-t-2 border-gray-200"></div>
                        <span class="px-4 text-sm text-gray-500 font-medium">atau</span>
                        <div class="flex-1 border-t-2 border-gray-200"></div>
                    </div>

                    <div class="text-center">
                        <p class="text-gray-600 font-medium">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-bold">Masuk sekarang</a>
                        </p>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = document.getElementById(iconId);

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    `;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            }
        </script>
    </body>
    </html>
