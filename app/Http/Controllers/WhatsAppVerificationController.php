<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OTPService;
use Illuminate\Support\Facades\Auth;

class WhatsAppVerificationController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        
        // Jika sudah terverifikasi, redirect ke dashboard
        if ($user->phone_verified_at) {
            return redirect()->route('dashboard')->with('info', 'WhatsApp Anda sudah terverifikasi.');
        }
        
        return view('auth.verify-whatsapp');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|unique:users,phone,' . Auth::id(),
        ]);

        $user = Auth::user();
        $phone = $this->formatPhoneNumber($request->phone);
        
        // Simpan nomor sementara
        $user->phone = $phone;
        $user->save();
        
        $otp = $this->otpService->generateOTP($phone);
        $result = $this->otpService->sendOTP($phone, $otp);
        
        // Cek apakah ini mode simulasi
        if (isset($result['simulation']) && $result['simulation'] == true) {
            return back()->with('success', 'Kode OTP telah dibuat. Silakan cek kode di bawah.')
                         ->with('simulation_otp', $result['otp']);
        }
        
        // Mode real WhatsApp
        if (isset($result['status']) && $result['status'] == true) {
            return back()->with('success', 'Kode OTP telah dikirim ke WhatsApp Anda. Cek pesan masuk.');
        }
        
        return back()->with('error', 'Gagal mengirim OTP. Pastikan nomor WhatsApp Anda terdaftar dan coba lagi.');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $phone = $user->phone;
        
        if (!$phone) {
            return redirect()->route('whatsapp.verify')->with('error', 'Nomor WhatsApp belum diisi. Silakan isi nomor Anda.');
        }
        
        if ($this->otpService->verifyOTP($phone, $request->otp)) {
            $user->phone_verified_at = now();
            $user->save();
            
            return redirect()->route('dashboard')->with('success', 'WhatsApp berhasil diverifikasi! Sekarang Anda bisa membuat sales page.');
        }
        
        return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa. Silakan minta kode baru.');
    }

    public function resendOTP()
    {
        $user = Auth::user();
        $phone = $user->phone;
        
        if (!$phone) {
            return back()->with('error', 'Nomor WhatsApp belum diisi. Silakan isi nomor Anda.');
        }
        
        $otp = $this->otpService->generateOTP($phone);
        $result = $this->otpService->sendOTP($phone, $otp);
        
        // Cek apakah ini mode simulasi
        if (isset($result['simulation']) && $result['simulation'] == true) {
            return back()->with('success', 'Kode OTP baru telah dibuat.')
                         ->with('simulation_otp', $result['otp']);
        }
        
        // Mode real WhatsApp
        if (isset($result['status']) && $result['status'] == true) {
            return back()->with('success', 'Kode OTP baru telah dikirim ke WhatsApp Anda.');
        }
        
        return back()->with('error', 'Gagal mengirim ulang OTP. Coba lagi nanti.');
    }

    private function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // Jika diawali 8, tambahkan 62
        if (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }
}