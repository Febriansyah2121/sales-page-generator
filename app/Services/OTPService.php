<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OTPService
{
    /**
     * Generate OTP 6 digit
     */
    public function generateOTP(string $phone): int
    {
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(10));
        return $otp;
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOTP(string $phone, string $otp): bool
    {
        $cachedOtp = Cache::get('otp_' . $phone);
        
        if ($cachedOtp && $cachedOtp == $otp) {
            Cache::forget('otp_' . $phone);
            return true;
        }
        
        return false;
    }

    /**
     * Kirim OTP via WhatsApp (Simulasi)
     */
    public function sendOTP(string $phone, string $otp): array
    {
        // Simpan ke cache agar bisa diambil oleh view
        Cache::put('last_otp_' . $phone, $otp, now()->addMinutes(10));
        
        // Log ke file (untuk debugging)
        Log::info("OTP untuk {$phone}: {$otp}");
        
        // Return sukses simulasi
        return [
            'status' => true,
            'simulation' => true,
            'otp' => $otp,
            'message' => "Kode OTP: {$otp} (Simulasi - ganti dengan WhatsApp nanti)"
        ];
    }
}