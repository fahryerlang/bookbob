@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center space-x-1 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Daftar Pengguna</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-4">
                <span class="text-indigo-600 font-bold text-3xl">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </span>
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>
            <div class="mt-4">
                @if($user->role == 'admin')
                    <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                        Admin
                    </span>
                @else
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                        User
                    </span>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t text-left">
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-gray-800">{{ $user->phone ?? '-' }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="text-gray-800">{{ $user->address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bergabung</p>
                    <p class="text-gray-800">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="font-semibold text-gray-800 mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Order</span>
                    <span class="font-semibold text-gray-800">{{ $user->orders->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Pembelanjaan</span>
                    <span class="font-semibold text-indigo-600">Rp {{ number_format($user->orders->sum('total_amount'), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pesan</span>
                    <span class="font-semibold text-gray-800">{{ $user->messages->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-800">Riwayat Order</h3>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($user->orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                                @elseif($order->status == 'processing')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Diproses</span>
                                @elseif($order->status == 'shipped')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Dikirim</span>
                                @elseif($order->status == 'completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Selesai</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-700 text-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada order
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
