<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SalesPage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    // Dashboard Admin
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalSalesPages = SalesPage::count();
        $totalGenerations = SalesPage::whereNotNull('generated_content')->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentSalesPages = SalesPage::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalSalesPages', 'totalGenerations',
            'recentUsers', 'recentSalesPages'
        ));
    }
    
    // Manajemen User
    public function users()
    {
        $users = User::withCount('salesPages')->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->salesPages()->delete();
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }
    
    // Manajemen Sales Page
    public function salesPages()
    {
        $salesPages = SalesPage::with('user')->latest()->paginate(15);
        return view('admin.sales-pages', compact('salesPages'));
    }
    
    public function deleteSalesPage($id)
    {
        $salesPage = SalesPage::findOrFail($id);
        $salesPage->delete();
        
        return redirect()->route('admin.sales-pages')->with('success', 'Sales page berhasil dihapus!');
    }
}