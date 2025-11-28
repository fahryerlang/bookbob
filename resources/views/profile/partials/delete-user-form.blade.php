<section x-data="{ showModal: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-red-800">Zona Berbahaya</h3>
                <p class="mt-1 text-sm text-red-600">
                    Setelah akun Anda dihapus, semua data dan informasi akan hilang secara permanen. 
                    Pastikan Anda sudah mengunduh data yang ingin disimpan sebelum menghapus akun.
                </p>
                <button type="button" @click="showModal = true"
                    class="mt-4 px-5 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Akun
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showModal" x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="showModal = false"></div>
        
        <!-- Modal -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <!-- Modal Header -->
                    <div class="text-center mb-6">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus Akun</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Tindakan ini tidak dapat dibatalkan. Semua data Anda termasuk pesanan dan riwayat akan dihapus permanen.
                        </p>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-6">
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" id="delete_password" name="password" placeholder="Password Anda"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                        @if($errors->userDeletion->get('password'))
                            <p class="mt-1 text-sm text-red-500">{{ $errors->userDeletion->first('password') }}</p>
                        @endif
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex space-x-3">
                        <button type="button" @click="showModal = false"
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                            Ya, Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
