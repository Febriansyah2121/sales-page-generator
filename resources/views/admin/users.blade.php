@extends('layouts.app')

@section('content')
<div class="py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Manajemen User</h1>
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Admin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Sales Page</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-3 text-sm">{{ $user->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $user->email }}</td>
                    <td class="px-6 py-3 text-sm">{{ $user->is_admin ? '✅ Ya' : '❌ Tidak' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $user->sales_pages_count }}</td>
                    <td class="px-6 py-3">
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
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