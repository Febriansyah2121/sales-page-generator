@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sales Pages</h1>
            <p class="text-gray-500 text-sm mt-1">Semua halaman sales yang telah Anda buat</p>
        </div>
        <a href="{{ route('sales-pages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl transition flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Buat Sales Page Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($pages->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📄</div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada sales page</h3>
            <p class="text-gray-500 mb-4">Klik tombol di atas untuk membuat sales page pertamamu</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Nama Produk</th>
                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Target Audiens</th>
                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Harga</th>
                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Dibuat</th>
                            <th class="text-right px-6 py-4 text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $page->product_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $page->target_audience }}</td>
                                <td class="px-6 py-4 text-gray-900">Rp {{ number_format($page->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $page->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('sales-pages.show', $page->id) }}" class="text-gray-600 hover:text-gray-900 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('sales-pages.destroy', $page->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-gray-400 hover:text-red-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection