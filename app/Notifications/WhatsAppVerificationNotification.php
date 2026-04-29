<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class WhatsAppVerificationNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['whatsapp'];
    }

    public function toWhatsApp($notifiable)
    {
        $apiKey = env('FONNTE_API_KEY');
        $targetNumber = $notifiable->phone ?? $notifiable->whatsapp_number;
        
        $message = "🔐 *Verifikasi Akun AI Sales Page Generator*\n\n";
        $message .= "Kode verifikasi Anda: *{$this->otp}*\n\n";
        $message .= "Jangan berikan kode ini kepada siapa pun.\n";
        $message .= "Kode berlaku selama 10 menit.\n\n";
        $message .= "Terima kasih telah mendaftar!";

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetNumber,
            'message' => $message,
        ]);

        return $response->successful();
    }
}   