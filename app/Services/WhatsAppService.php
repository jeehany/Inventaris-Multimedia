<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Mengirim notifikasi WhatsApp simulasi.
     *
     * @param string $recipient Nomor tujuan (misal WhatsApp Kepala Divisi atau Bendahara)
     * @param string $message Isi pesan notifikasi
     * @return bool
     */
    public static function send($recipient, $message)
    {
        // 1. Catat ke log sistem Laravel
        Log::channel('single')->info("===== [SIMULASI WA GATEWAY] =====");
        Log::channel('single')->info("Penerima : " . $recipient);
        Log::channel('single')->info("Pesan    : " . $message);
        Log::channel('single')->info("=================================");

        // 2. Simpan status notifikasi terkirim ke session untuk info sukses visual di web (opsional)
        session()->flash('wa_notif', [
            'to' => $recipient,
            'message' => $message
        ]);

        // 3. Opsional: Anda dapat mengintegrasikan API pihak ketiga (seperti Fonnte/Wablas) di sini:
        /*
        try {
            Http::withHeaders([
                'Authorization' => 'TOKEN_API_ANDA'
            ])->post('https://api.fonnte.com/send', [
                'target' => $recipient,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim WhatsApp API real: " . $e->getMessage());
        }
        */

        return true;
    }
}
