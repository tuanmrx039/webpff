<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') – Super Admin Panel Free Fire</title>
  
  <!-- Google Fonts: Outfit & Rajdhani -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Rajdhani:wght@600;700;800&display=swap" rel="stylesheet"/>

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              red: '#e50914',
              crimson: '#9e0915',
              dark: '#0d0204',
              gold: '#ffb700',
              accent: '#ff2a44',
            }
          },
          fontFamily: {
            sans: ['Outfit', 'sans-serif'],
            gaming: ['Rajdhani', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    body {
      background-color: #0b0204;
      background-image: 
        radial-gradient(circle at 15% 10%, rgba(229, 9, 20, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 85% 80%, rgba(255, 183, 0, 0.05) 0%, transparent 40%);
      color: #e6e6e6;
      font-family: 'Outfit', sans-serif;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #110306;
    }
    ::-webkit-scrollbar-thumb {
      background: #470d13;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #e50914;
    }

    .glass-card {
      background: rgba(18, 4, 7, 0.85);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(229, 9, 20, 0.2);
    }
    .glass-card-hover {
      transition: all 0.2s ease;
    }
    .glass-card-hover:hover {
      border-color: rgba(229, 9, 20, 0.5);
      box-shadow: 0 8px 30px rgba(229, 9, 20, 0.15);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row antialiased">

  <!-- Mobile Top Bar -->
  <div class="md:hidden flex items-center justify-between px-4 py-3 bg-[#130306] border-b border-red-950 sticky top-0 z-40">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-amber-600 flex items-center justify-center font-gaming font-extrabold text-white text-lg shadow-lg shadow-red-900/50">
        FF
      </div>
      <span class="font-gaming font-extrabold tracking-wider text-white text-lg">SUPER ADMIN</span>
    </div>
    <button id="mobileMenuBtn" class="text-gray-300 hover:text-white p-2">
      <i class="fa-solid fa-bars text-xl"></i>
    </button>
  </div>

  <!-- Sidebar -->
  <aside id="sidebar" class="hidden md:flex flex-col w-64 bg-[#110306] border-r border-red-950/60 min-h-screen sticky top-0 z-30 transition-all duration-300">
    
    <!-- Sidebar Brand Header -->
    <div class="px-6 py-6 border-b border-red-950/60 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 via-red-700 to-amber-500 flex items-center justify-center font-gaming font-extrabold text-white text-xl shadow-lg shadow-red-900/60 ring-2 ring-red-500/30">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
          <h1 class="font-gaming font-extrabold text-lg text-white tracking-wider flex items-center gap-1.5 leading-none">
            FREE FIRE <span class="text-xs px-1.5 py-0.5 rounded bg-red-900/60 text-red-300 font-sans font-medium">PANEL</span>
          </h1>
          <p class="text-[11px] text-gray-400 mt-1">Super Admin Control</p>
        </div>
      </div>
    </div>

    <!-- Quick Status Badge -->
    <div class="px-5 py-3">
      <div class="bg-[#1c060a] border border-red-900/40 rounded-lg p-2.5 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
          </span>
          <span class="text-xs font-semibold text-gray-300">Server Status: Online</span>
        </div>
        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-red-950 text-amber-400 border border-amber-500/20">LIVE</span>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-2 space-y-1.5">
      <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500 px-3 py-2">Navigasi Utama</div>
      
      <a href="{{ route('panel.dashboard') }}" 
         class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all {{ request()->routeIs('panel.dashboard') ? 'bg-gradient-to-r from-red-600 to-red-800 text-white shadow-lg shadow-red-900/40' : 'text-gray-300 hover:bg-[#1a0509] hover:text-white' }}">
        <i class="fa-solid fa-gauge-high w-5 text-center text-base {{ request()->routeIs('panel.dashboard') ? 'text-amber-300' : 'text-red-400' }}"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('panel.settings') }}" 
         class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all {{ request()->routeIs('panel.settings') ? 'bg-gradient-to-r from-red-600 to-red-800 text-white shadow-lg shadow-red-900/40' : 'text-gray-300 hover:bg-[#1a0509] hover:text-white' }}">
        <i class="fa-solid fa-sliders w-5 text-center text-base {{ request()->routeIs('panel.settings') ? 'text-amber-300' : 'text-red-400' }}"></i>
        <span>Atur Frontend</span>
      </a>

      <a href="{{ route('panel.items') }}" 
         class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all {{ request()->routeIs('panel.items') ? 'bg-gradient-to-r from-red-600 to-red-800 text-white shadow-lg shadow-red-900/40' : 'text-gray-300 hover:bg-[#1a0509] hover:text-white' }}">
        <i class="fa-solid fa-gift w-5 text-center text-base {{ request()->routeIs('panel.items') ? 'text-amber-300' : 'text-red-400' }}"></i>
        <span>Kelola Item (9 Reward)</span>
      </a>

      <a href="{{ route('panel.claims') }}" 
         class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all {{ request()->routeIs('panel.claims') ? 'bg-gradient-to-r from-red-600 to-red-800 text-white shadow-lg shadow-red-900/40' : 'text-gray-300 hover:bg-[#1a0509] hover:text-white' }}">
        <i class="fa-solid fa-clipboard-list w-5 text-center text-base {{ request()->routeIs('panel.claims') ? 'text-amber-300' : 'text-red-400' }}"></i>
        <span>Log Verifikasi / Klaim</span>
      </a>

      <div class="pt-4 text-[10px] font-bold uppercase tracking-wider text-gray-500 px-3 py-2">Akses Cepat</div>

      <a href="{{ route('event.index') }}" target="_blank"
         class="flex items-center justify-between px-3.5 py-2 rounded-lg font-medium text-xs text-amber-300 bg-amber-500/10 border border-amber-500/20 hover:bg-amber-500/20 transition-all">
        <span class="flex items-center space-x-2">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
          <span>Buka Web Event</span>
        </span>
        <span class="text-[10px] bg-amber-400/20 px-1.5 py-0.5 rounded text-amber-200">Live</span>
      </a>
    </nav>

    <!-- User Profile & Logout -->
    <div class="p-4 border-t border-red-950/60 bg-[#0e0205]">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3 overflow-hidden">
          <div class="w-9 h-9 rounded-full bg-red-950 border border-red-600/50 flex items-center justify-center text-red-300 font-bold text-sm shrink-0">
            <i class="fa-solid fa-user-shield"></i>
          </div>
          <div class="truncate">
            <div class="text-xs font-semibold text-white truncate">{{ session('admin_name', 'Super Admin') }}</div>
            <div class="text-[10px] text-gray-400 truncate">{{ session('admin_email', 'admin@gmail.com') }}</div>
          </div>
        </div>
        <a href="{{ route('panel.logout') }}" 
           class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-950/60 rounded-lg transition-colors"
           title="Logout"
           onclick="return confirm('Apakah Anda yakin ingin logout?');">
          <i class="fa-solid fa-right-from-bracket text-sm"></i>
        </a>
      </div>
    </div>
  </aside>

  <!-- Main Content Layout -->
  <main class="flex-1 flex flex-col min-w-0">
    
    <!-- Top Header -->
    <header class="hidden md:flex items-center justify-between px-8 py-4 bg-[#110306]/80 backdrop-blur-md border-b border-red-950/60 sticky top-0 z-20">
      <div class="flex items-center space-x-3">
        <h2 class="font-gaming font-extrabold text-2xl text-white tracking-wide">
          @yield('page_title', 'Dashboard')
        </h2>
        <span class="text-xs text-gray-400">/ Super Admin Management</span>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Live Web Button -->
        <a href="{{ route('event.index') }}" target="_blank"
           class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 text-white shadow-md shadow-red-900/40 flex items-center space-x-2 transition-all">
          <i class="fa-solid fa-eye text-xs"></i>
          <span>Lihat Tampilan Web</span>
        </a>

        <!-- System Time -->
        <div class="text-xs font-mono text-gray-400 bg-[#1a0509] px-3 py-1.5 rounded border border-red-950">
          <i class="fa-regular fa-clock mr-1 text-red-400"></i>
          <span id="systemClock">{{ date('H:i:s') }}</span> WIB
        </div>
      </div>
    </header>

    <!-- Page Content Container -->
    <div class="p-4 md:p-8 flex-1">
      
      <!-- Flash Notifications -->
      @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-lg backdrop-blur-md">
          <div class="flex items-center space-x-3">
            <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif

      @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-950/80 border border-red-500/40 text-red-200 flex items-center justify-between shadow-lg backdrop-blur-md">
          <div class="flex items-center space-x-3">
            <i class="fa-solid fa-triangle-exclamation text-red-400 text-lg"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-200">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-950/80 border border-red-500/40 text-red-200 shadow-lg">
          <div class="font-semibold text-sm mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> Terdapat kesalahan pada input:
          </div>
          <ul class="list-disc list-inside text-xs space-y-1 text-red-300">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')

    </div>

    <!-- Admin Footer -->
    <footer class="px-8 py-4 border-t border-red-950/60 bg-[#0e0205] text-xs text-gray-500 flex flex-col md:flex-row items-center justify-between gap-2">
      <div>
        <span>Free Fire Event Control Panel &copy; {{ date('Y') }}.</span>
      </div>
      <div class="flex items-center space-x-4 text-gray-400">
        <span>Framework: Laravel 11</span>
        <span>&bull;</span>
        <span>Server Port: 3000</span>
      </div>
    </footer>

  </main>

  <script>
    // Live Clock
    setInterval(() => {
      const el = document.getElementById('systemClock');
      if (el) {
        const now = new Date();
        el.innerText = now.toTimeString().split(' ')[0];
      }
    }, 1000);

    // Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    if (mobileBtn && sidebar) {
      mobileBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
      });
    }
  </script>

  @yield('scripts')
</body>
</html>
