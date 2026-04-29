<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class OTPService
{
    public function generateOTP($phone)
    {
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(10));
        return $otp;
    }

    public function verifyOTP($phone, $otp)
    {
        $cachedOtp = Cache::get('otp_' . $phone);
        
        if ($cachedOtp && $cachedOtp == $otp) {
            Cache::forget('otp_' . $phone);
            return true;
        }
        
        return false;
    }

    public function sendOTP($phone, $otp)
    {
        // SIMULASI: Simpan OTP ke session/laravel log saja
        // untuk testing, OTP akan ditampilkan di halaman web
        
        // Simpan ke cache agar bisa diambil oleh view
        Cache::put('last_otp_' . $phone, $otp, now()->addMinutes(10));
        
        // Log ke file (opsional)
        \Log::info("OTP untuk {$phone}: {$otp}");
        
        // Return sukses simulasi
        return [
            'status' => true,
            'simulation' => true,
            'otp' => $otp, // Hanya untuk testing, di production hapus ini
            'message' => "Kode OTP: {$otp} (Simulasi - ganti dengan WhatsApp nanti)"
        ];
    }
}