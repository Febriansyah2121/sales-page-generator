@extends('layouts.app')

@section('content')
<div class="py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Sales Page</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalSalesPages }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Generate</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalGenerations }}</p>
        </div>
    </div>
</div>
@endsection