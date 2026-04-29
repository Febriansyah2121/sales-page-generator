@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📄 Sales Pages</h1>
            <p class="text-gray-500 text-sm">Semua halaman sales yang telah Anda buat</p>
        </div>
        <a href="{{ route('sales-pages.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
            + Buat Sales Page Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($pages->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada sales page</h3>
            <p class="text-gray-500 mb-4">Klik tombol di atas untuk membuat sales page pertamamu</p>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Target</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $page->product_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $page->target_audience }}</td>
                                <td class="px-6 py-4 text-gray-900 font-medium">Rp {{ number_format($page->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $page->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('sales-pages.show', $page->id) }}" class="text-gray-500 hover:text-gray-700" title="Lihat">👁️</a>
                                        <a href="{{ route('sales-pages.edit', $page->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">✏️</a>
                                        <form action="{{ route('sales-pages.destroy', $page->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500" title="Hapus">🗑️</button>
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