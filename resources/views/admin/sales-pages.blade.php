@extends('layouts.app')

@section('content')
<div class="py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Semua Sales Page</h1>
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesPages as $page)
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-3 text-sm">{{ $page->product_name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $page->user->name ?? 'Deleted' }}</td>
                    <td class="px-6 py-3 text-sm">Rp {{ number_format($page->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm">{{ $page->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-3">
                        <form action="{{ route('admin.sales-pages.delete', $page->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sales page ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection