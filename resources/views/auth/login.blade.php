<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - BookBob</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .glow-purple {
            box-shadow: 0 0 60px rgba(139, 92, 246, 0.5), 0 0 100px rgba(139, 92, 246, 0.3);
        }
        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, #c4b5fd 50%, #fff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }
        .role-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f9fafb;
        }
        .role-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15);
        }
        .role-card.selected {
            border-color: #6366f1;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.25);
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
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .feature-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .feature-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
            border-color: rgba(255, 255, 255, 0.2);
        }
        .stat-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen gradient-bg flex">
        
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <!-- Decorative Circles -->
            <div class="decorative-circle w-96 h-96 bg-violet-600 -top-20 -left-20"></div>
            <div class="decorative-circle w-80 h-80 bg-indigo-600 bottom-20 right-10"></div>
            <div class="decorative-circle w-64 h-64 bg-purple-500 top-1/2 left-1/3"></div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12">
                <div class="max-w-md w-full">
                    <!-- Logo -->
                    <div class="floating mb-12 flex justify-center">
                        <div class="w-28 h-28 bg-gradient-to-br from-violet-500 via-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center glow-purple shadow-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Brand Name -->
                    <div class="text-center mb-12">
                        <h1 class="text-6xl font-extrabold text-gradient mb-4">BookBob</h1>
                        <p class="text-xl text-purple-200 font-medium">Temukan Dunia dalam Setiap Halaman</p>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-12">
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <div class="text-3xl font-bold text-white mb-1">10K+</div>
                            <div class="text-sm text-purple-300 font-medium">Judul Buku</div>
                        </div>
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <div class="text-3xl font-bold text-white mb-1">50K+</div>
                            <div class="text-sm text-purple-300 font-medium">Pembeli</div>
                        </div>
                        <div class="stat-box rounded-2xl p-5 text-center">
                            <div class="text-3xl font-bold text-white mb-1">4.9</div>
                            <div class="text-sm text-purple-300 font-medium">Rating</div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg">Koleksi Premium</h3>
                                <p class="text-purple-300 text-sm">Ribuan buku berkualitas dari berbagai genre</p>
                            </div>
                        </div>

                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg">Pengiriman Cepat</h3>
                                <p class="text-purple-300 text-sm">Gratis ongkir ke seluruh Indonesia</p>
                            </div>
                        </div>

                        <div class="feature-item rounded-2xl p-5 flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg">100% Original</h3>
                                <p class="text-purple-300 text-sm">Garansi keaslian setiap produk</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="mt-10 p-6 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10">
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                        </div>
                        <p class="text-purple-100 text-base italic mb-4">"Pengalaman belanja buku online terbaik! Koleksinya lengkap dan pengirimannya super cepat."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-violet-400 to-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-semibold">Sarah Dewi</p>
                                <p class="text-purple-400 text-sm">Verified Buyer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
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
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-5 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
                    <p class="text-gray-500 mt-2 text-base">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Role Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Login Sebagai</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="role-card selected cursor-pointer rounded-xl border-2 border-gray-200 p-4 text-center" id="role-user-label">
                                <input type="radio" name="login_as" value="user" class="sr-only" id="role-user" checked>
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-3 shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-800">Pembeli</span>
                                    <span class="text-xs text-gray-500 mt-1">Belanja buku favorit</span>
                                </div>
                            </label>
                            <label class="role-card cursor-pointer rounded-xl border-2 border-gray-200 p-4 text-center" id="role-admin-label">
                                <input type="radio" name="login_as" value="admin" class="sr-only" id="role-admin">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mb-3 shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-800">Admin</span>
                                    <span class="text-xs text-gray-500 mt-1">Kelola toko buku</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="input-modern w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="input-modern w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 text-gray-800 font-medium"
                                placeholder="Masukkan password">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 btn-gradient text-white font-bold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t-2 border-gray-200"></div>
                    <span class="px-4 text-sm text-gray-500 font-medium">atau</span>
                    <div class="flex-1 border-t-2 border-gray-200"></div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600 font-medium">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-bold">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
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
        // Role selection
        const roleUserLabel = document.getElementById('role-user-label');
        const roleAdminLabel = document.getElementById('role-admin-label');
        const roleUser = document.getElementById('role-user');
        const roleAdmin = document.getElementById('role-admin');

        roleUserLabel.addEventListener('click', () => {
            roleUserLabel.classList.add('selected');
            roleAdminLabel.classList.remove('selected');
        });

        roleAdminLabel.addEventListener('click', () => {
            roleAdminLabel.classList.add('selected');
            roleUserLabel.classList.remove('selected');
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
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
