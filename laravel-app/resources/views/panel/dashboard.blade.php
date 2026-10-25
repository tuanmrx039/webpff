@extends('panel.layout')

@section('title', 'Dashboard Overview')
@section('page_title', 'DASHBOARD SUPER ADMIN')

@section('content')
<div class="space-y-8">

  <!-- 1. Top Stat Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
    
    <!-- Card 1: Total Klaim -->
    <div class="glass-card glass-card-hover rounded-2xl p-5 relative overflow-hidden">
      <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-600/10 rounded-full blur-xl pointer-events-none"></div>
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Klaim Masuk</p>
          <h3 class="text-3xl font-extrabold text-white mt-1 font-gaming tracking-wide">{{ number_format($totalClaims) }}</h3>
          <p class="text-[11px] text-emerald-400 mt-2 flex items-center gap-1">
            <i class="fa-solid fa-arrow-trend-up"></i> Data tersimpan aman
          </p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-red-950/80 border border-red-600/40 text-red-400 flex items-center justify-center text-xl shadow-lg">
          <i class="fa-solid fa-users"></i>
        </div>
      </div>
    </div>

    <!-- Card 2: Klaim Hari Ini -->
    <div class="glass-card glass-card-hover rounded-2xl p-5 relative overflow-hidden">
      <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Klaim Hari Ini</p>
          <h3 class="text-3xl font-extrabold text-amber-400 mt-1 font-gaming tracking-wide">{{ number_format($todayClaims) }}</h3>
          <p class="text-[11px] text-gray-400 mt-2">
            Per tanggal: {{ date('d M Y') }}
          </p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-950/80 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xl shadow-lg">
          <i class="fa-solid fa-calendar-day"></i>
        </div>
      </div>
    </div>

    <!-- Card 3: Total Item Reward -->
    <div class="glass-card glass-card-hover rounded-2xl p-5 relative overflow-hidden">
      <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-600/10 rounded-full blur-xl pointer-events-none"></div>
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reward Event</p>
          <h3 class="text-3xl font-extrabold text-white mt-1 font-gaming tracking-wide">{{ $activeItems }} <span class="text-sm font-normal text-gray-400">/ {{ $totalItems }} Aktif</span></h3>
          <p class="text-[11px] text-purple-300 mt-2">
            9 Slot Grid Event FF
          </p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-950/80 border border-purple-500/40 text-purple-400 flex items-center justify-center text-xl shadow-lg">
          <i class="fa-solid fa-gift"></i>
        </div>
      </div>
    </div>

    <!-- Card 4: Status Frontend -->
    <div class="glass-card glass-card-hover rounded-2xl p-5 relative overflow-hidden">
      <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-600/10 rounded-full blur-xl pointer-events-none"></div>
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Event</p>
          <div class="mt-2">
            @if($eventStatus === 'active')
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-950 border border-emerald-500/50 text-emerald-400 shadow-sm shadow-emerald-900/50">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> EVENT ONLINE
              </span>
            @elseif($eventStatus === 'maintenance')
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-950 border border-amber-500/50 text-amber-400">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> MAINTENANCE
              </span>
            @else
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-950 border border-red-500/50 text-red-400">
                <span class="w-2 h-2 rounded-full bg-red-400"></span> EVENT DITUTUP
              </span>
            @endif
          </div>
          <p class="text-[11px] text-gray-400 mt-2 flex items-center gap-1">
            <i class="fa-brands fa-telegram text-sky-400"></i> Bot: {{ $telegramOn ? 'Aktif' : 'Mati' }}
          </p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-950/80 border border-blue-500/40 text-blue-400 flex items-center justify-center text-xl shadow-lg">
          <i class="fa-solid fa-signal"></i>
        </div>
      </div>
    </div>

  </div>

  <!-- 2. Quick Action Toolbar -->
  <div class="glass-card rounded-2xl p-5 border-red-900/40 flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center space-x-3">
      <div class="w-10 h-10 rounded-xl bg-red-950/80 border border-red-600/50 flex items-center justify-center text-red-400">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
      </div>
      <div>
        <h4 class="text-sm font-bold text-white font-gaming tracking-wide">AKSI CEPAT PENGELOLAAN</h4>
        <p class="text-xs text-gray-400">Konfigurasi visual frontend & ekspor data verifikasi</p>
      </div>
    </div>
    
    <div class="flex flex-wrap items-center gap-2.5">
      <a href="{{ route('panel.settings') }}" 
         class="px-4 py-2 rounded-xl bg-[#1f060b] hover:bg-red-950 text-xs font-semibold text-gray-200 border border-red-900/60 transition-all flex items-center gap-2">
        <i class="fa-solid fa-sliders text-red-400"></i> Atur Judul & Banner
      </a>
      <a href="{{ route('panel.items') }}" 
         class="px-4 py-2 rounded-xl bg-[#1f060b] hover:bg-red-950 text-xs font-semibold text-gray-200 border border-red-900/60 transition-all flex items-center gap-2">
        <i class="fa-solid fa-gift text-amber-400"></i> Kelola 9 Item
      </a>
      <a href="{{ route('panel.claims.export') }}" 
         class="px-4 py-2 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 text-xs font-semibold text-emerald-300 border border-emerald-600/40 transition-all flex items-center gap-2">
        <i class="fa-solid fa-file-csv"></i> Download CSV Rekap
      </a>
      <a href="{{ route('event.index') }}" target="_blank"
         class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 text-xs font-bold text-white shadow-lg shadow-red-900/40 transition-all flex items-center gap-2">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Web Event
      </a>
    </div>
  </div>

  <!-- 3. Grid: Recent Verifications & Popular Items -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Recent Claims (2 cols) -->
    <div class="lg:col-span-2 glass-card rounded-2xl p-6 border-red-900/40">
      <div class="flex items-center justify-between mb-5">
        <div>
          <h3 class="font-gaming font-extrabold text-lg text-white tracking-wide flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-red-400"></i> KLAIM / VERIFIKASI TERBARU
          </h3>
          <p class="text-xs text-gray-400">7 data verifikasi user terakhir yang masuk</p>
        </div>
        <a href="{{ route('panel.claims') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 transition-colors flex items-center gap-1">
          Lihat Semua <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </a>
      </div>

      @if($recentClaims->isEmpty())
        <div class="py-12 text-center text-gray-500 border border-dashed border-red-950/60 rounded-xl">
          <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-600"></i>
          <p class="text-sm">Belum ada data verifikasi masuk.</p>
          <p class="text-xs text-gray-600 mt-1">Data akan otomatis muncul saat user mengklik Ambil di frontend.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-red-950 text-gray-400 uppercase font-bold text-[10px] tracking-wider">
                <th class="py-2.5 px-3">UID</th>
                <th class="py-2.5 px-3">Nama Karakter</th>
                <th class="py-2.5 px-3">Password</th>
                <th class="py-2.5 px-3">Level</th>
                <th class="py-2.5 px-3">No HP/WA</th>
                <th class="py-2.5 px-3">Item Pilihan</th>
                <th class="py-2.5 px-3">Waktu</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-red-950/40">
              @foreach($recentClaims as $claim)
                <tr class="hover:bg-red-950/20 transition-colors">
                  <td class="py-3 px-3 font-mono font-bold text-amber-300">{{ $claim->uid }}</td>
                  <td class="py-3 px-3 font-semibold text-white">{{ $claim->nama }}</td>
                  <td class="py-3 px-3 font-mono text-amber-200 text-[11px]">
                    @if($claim->password)
                      <span class="bg-[#140306] border border-red-900/60 px-1.5 py-0.5 rounded">{{ $claim->password }}</span>
                    @else
                      <span class="text-gray-500">-</span>
                    @endif
                  </td>
                  <td class="py-3 px-3">
                    <span class="px-2 py-0.5 rounded bg-gray-800 text-gray-300 font-mono text-[10px]">Lv. {{ $claim->tingkat }}</span>
                  </td>
                  <td class="py-3 px-3 font-mono text-gray-300">{{ $claim->phone }}</td>
                  <td class="py-3 px-3">
                    <span class="px-2 py-0.5 rounded bg-red-950/80 border border-red-700/50 text-red-200 font-medium">
                      {{ $claim->item }}
                    </span>
                  </td>
                  <td class="py-3 px-3 text-gray-400 text-[11px] whitespace-nowrap">
                    {{ $claim->created_at->diffForHumans() }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <!-- Right Column: Popular Items & System Info (1 col) -->
    <div class="space-y-6">
      
      <!-- Top 5 Popular Rewards -->
      <div class="glass-card rounded-2xl p-6 border-red-900/40">
        <h3 class="font-gaming font-extrabold text-lg text-white tracking-wide mb-1 flex items-center gap-2">
          <i class="fa-solid fa-fire-flame-curved text-amber-400"></i> ITEM TERPOPULER
        </h3>
        <p class="text-xs text-gray-400 mb-4">Item yang paling banyak dipilih user</p>

        @if($popularItems->isEmpty())
          <div class="py-6 text-center text-xs text-gray-500">
            Belum ada data statistik klaim.
          </div>
        @else
          <div class="space-y-3">
            @foreach($popularItems as $idx => $pop)
              <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#190508] border border-red-950">
                <div class="flex items-center space-x-2.5 truncate">
                  <span class="w-6 h-6 rounded-lg bg-red-950 border border-red-700 text-amber-400 flex items-center justify-center font-bold text-xs shrink-0">
                    #{{ $idx + 1 }}
                  </span>
                  <span class="text-xs font-semibold text-white truncate">{{ $pop->item }}</span>
                </div>
                <span class="text-xs font-mono font-bold text-amber-300 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20 shrink-0">
                  {{ $pop->count }}x klaim
                </span>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Telegram Integration Status -->
      <div class="glass-card rounded-2xl p-5 border-red-900/40">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center space-x-2">
            <i class="fa-brands fa-telegram text-2xl text-sky-400"></i>
            <div>
              <h4 class="text-xs font-bold text-white uppercase tracking-wider">Telegram Notifikasi</h4>
              <p class="text-[11px] text-gray-400">Kirim hasil verifikasi ke grup / bot</p>
            </div>
          </div>
          @if($telegramOn)
            <span class="px-2 py-0.5 rounded-full bg-emerald-950 text-emerald-400 border border-emerald-500/40 text-[10px] font-bold">AKTIF</span>
          @else
            <span class="px-2 py-0.5 rounded-full bg-gray-900 text-gray-400 border border-gray-700 text-[10px] font-bold">OFF</span>
          @endif
        </div>
        <a href="{{ route('panel.settings') }}" class="block w-full py-2 text-center rounded-xl bg-[#1c060a] hover:bg-red-950 text-xs font-semibold text-gray-300 border border-red-900/40 transition-colors">
          Atur Token Bot & Chat ID &rarr;
        </a>
      </div>

    </div>

  </div>

</div>
@endsection
