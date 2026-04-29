@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-xl font-bold text-gray-900 mb-4">Edit Profile</h1>
        
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">Simpan</button>
        </form>
    </div>
</div>
@endsection