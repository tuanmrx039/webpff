@extends('panel.layout')

@section('title', 'Kelola Item Event')
@section('page_title', 'KELOLA 9 ITEM REWARD EVENT')

@section('content')
<div class="space-y-8">

  <!-- Header & Actions -->
  <div class="glass-card rounded-2xl p-6 border-red-900/40 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h3 class="font-gaming font-extrabold text-xl text-white tracking-wide flex items-center gap-2">
        <i class="fa-solid fa-gift text-red-400"></i> DAFTAR ITEM EVENT FREE FIRE
      </h3>
      <p class="text-xs text-gray-400 mt-1">Item aktif akan tampil secara dinamis pada grid 3x3 di halaman depan (frontend)</p>
    </div>

    <button onclick="openAddItemModal()"
            class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 shadow-lg shadow-red-900/50 transition-all flex items-center gap-2 self-start md:self-auto">
      <i class="fa-solid fa-plus"></i> Tambah Item Baru
    </button>
  </div>

  <!-- Items Grid (3x3 Preview Layout) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
    @foreach($items as $item)
      <div class="glass-card rounded-2xl p-4 border-red-900/40 hover:border-red-600/60 transition-all relative flex flex-col justify-between group">
        
        <!-- Top Badges & Status -->
        <div class="flex items-center justify-between mb-3">
          <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-black/60 border border-red-900/50 text-gray-300">
            Slot #{{ $item->order }}
          </span>

          <form action="{{ route('panel.items.toggle', $item->id) }}" method="POST">
            @csrf
            @if($item->is_active)
              <button type="submit" class="px-2 py-0.5 rounded-full bg-emerald-950 border border-emerald-500/50 text-emerald-400 text-[10px] font-bold hover:bg-emerald-900 transition-colors">
                AKTIF
              </button>
            @else
              <button type="submit" class="px-2 py-0.5 rounded-full bg-gray-900 border border-gray-700 text-gray-400 text-[10px] font-bold hover:bg-gray-800 transition-colors">
                NONAKTIF
              </button>
            @endif
          </form>
        </div>

        <!-- Item Thumbnail Preview -->
        <div class="w-full aspect-[4/3] rounded-xl bg-gradient-to-b from-[#1b0509] to-[#0a0103] border border-red-900/50 flex items-center justify-center p-3 relative overflow-hidden mb-3">
          <div class="absolute inset-0 bg-radial from-red-600/10 via-transparent to-transparent pointer-events-none"></div>
          <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="max-h-full max-w-full object-contain filter drop-shadow-[0_5px_15px_rgba(255,0,0,0.4)] group-hover:scale-105 transition-transform duration-300"/>
        </div>

        <!-- Item Information -->
        <div class="space-y-1 mb-4">
          <span class="text-[10px] font-semibold uppercase tracking-wider text-amber-400 block truncate">
            {{ $item->type }}
          </span>
          <h4 class="text-sm font-bold text-white tracking-wide truncate" title="{{ $item->name }}">
            {{ $item->name }}
          </h4>
          <p class="text-[11px] text-gray-400 truncate">
            Display: {{ $item->short_name ?: $item->name }}
          </p>
        </div>

        <!-- Actions -->
        <div class="pt-3 border-t border-red-950/60 flex items-center justify-between gap-2">
          <button type="button" 
                  onclick="openEditModal({{ json_encode($item) }})"
                  class="flex-1 py-1.5 px-3 rounded-lg bg-red-950/60 hover:bg-red-900/80 text-red-200 border border-red-800/40 text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
          </button>
          
          <form action="{{ route('panel.items.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item {{ $item->name }}?');">
            @csrf
            <button type="submit" 
                    class="py-1.5 px-3 rounded-lg bg-gray-900 hover:bg-red-950 text-gray-400 hover:text-red-400 border border-gray-800 hover:border-red-800 text-xs transition-colors">
              <i class="fa-solid fa-trash-can"></i>
            </button>
          </form>
        </div>

      </div>
    @endforeach
  </div>

</div>

<!-- MODAL TAMBAH ITEM -->
<div id="addItemModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="glass-card w-full max-w-lg rounded-2xl border-red-900/80 p-6 shadow-2xl relative">
    <div class="flex items-center justify-between pb-3 border-b border-red-950 mb-4">
      <h3 class="font-gaming font-extrabold text-lg text-white">TAMBAH ITEM REWARD BARU</h3>
      <button onclick="closeAddItemModal()" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
    </div>

    <form action="{{ route('panel.items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      
      <div>
        <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Nama Lengkap Item</label>
        <input type="text" name="name" required class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none" placeholder="Contoh: M1887 - INCUBATOR"/>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Nama Pendek (Di Box)</label>
          <input type="text" name="short_name" class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none" placeholder="M1887 - INC..."/>
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Tipe / Kategori</label>
          <input type="text" name="type" required value="Skin Senjata Tier S" class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Urutan Slot (Order)</label>
          <input type="number" name="order" value="{{ count($items) + 1 }}" class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
        </div>
        <div class="flex items-center pt-5">
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
            <div class="w-9 h-5 bg-gray-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
            <span class="ml-2 text-xs text-gray-300">Tampilkan di Web</span>
          </label>
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Unggah Gambar (PNG Transparan)</label>
        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-red-950 file:text-red-300 cursor-pointer"/>
        <p class="text-[10px] text-gray-500 mt-1">Atau gunakan URL:</p>
        <input type="text" name="image_url" placeholder="images/item_hd_1.png" class="w-full mt-1 bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2 outline-none"/>
      </div>

      <div class="pt-3 border-t border-red-950 flex justify-end gap-2">
        <button type="button" onclick="closeAddItemModal()" class="px-4 py-2 rounded-xl bg-gray-900 text-gray-300 text-xs">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-red-600 to-amber-600 text-white font-bold text-xs">Simpan Item</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT ITEM -->
<div id="editItemModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="glass-card w-full max-w-lg rounded-2xl border-red-900/80 p-6 shadow-2xl relative">
    <div class="flex items-center justify-between pb-3 border-b border-red-950 mb-4">
      <h3 class="font-gaming font-extrabold text-lg text-white">EDIT ITEM EVENT</h3>
      <button onclick="closeEditModal()" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
    </div>

    <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      
      <div>
        <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Nama Lengkap Item</label>
        <input type="text" id="edit_name" name="name" required class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Nama Pendek</label>
          <input type="text" id="edit_short_name" name="short_name" class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Tipe / Kategori</label>
          <input type="text" id="edit_type" name="type" required class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Urutan Slot</label>
          <input type="number" id="edit_order" name="order" class="w-full bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2.5 outline-none"/>
        </div>
        <div class="flex items-center pt-5">
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="sr-only peer">
            <div class="w-9 h-5 bg-gray-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
            <span class="ml-2 text-xs text-gray-300">Tampilkan di Web</span>
          </label>
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Ganti Gambar (Opsional)</label>
        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-red-950 file:text-red-300 cursor-pointer"/>
        <p class="text-[10px] text-gray-500 mt-1">Atau ganti URL:</p>
        <input type="text" id="edit_image_url" name="image_url" class="w-full mt-1 bg-[#180508] border border-red-900/60 text-white text-xs rounded-xl p-2 outline-none"/>
      </div>

      <div class="pt-3 border-t border-red-950 flex justify-end gap-2">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-gray-900 text-gray-300 text-xs">Batal</button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-red-600 to-amber-600 text-white font-bold text-xs">Perbarui Item</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function openAddItemModal() {
    document.getElementById('addItemModal').classList.remove('hidden');
  }
  function closeAddItemModal() {
    document.getElementById('addItemModal').classList.add('hidden');
  }

  function openEditModal(item) {
    document.getElementById('editForm').action = '/panel/items/' + item.id + '/update';
    document.getElementById('edit_name').value = item.name;
    document.getElementById('edit_short_name').value = item.short_name || item.name;
    document.getElementById('edit_type').value = item.type;
    document.getElementById('edit_order').value = item.order;
    document.getElementById('edit_image_url').value = item.image;
    document.getElementById('edit_is_active').checked = item.is_active == 1;

    document.getElementById('editItemModal').classList.remove('hidden');
  }
  function closeEditModal() {
    document.getElementById('editItemModal').classList.add('hidden');
  }
</script>
@endsection
