<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login – Super Admin Panel Free Fire</title>
  
  <!-- Google Fonts: Outfit & Rajdhani -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Rajdhani:wght@600;700;800&display=swap" rel="stylesheet"/>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-[#0a0103] antialiased" style="font-family: 'Outfit', sans-serif;">
  
  <!-- Background Glow & Particles -->
  <div class="fixed inset-0 pointer-events-none overflow-hidden">
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/10 blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-amber-500/10 blur-3xl"></div>
  </div>

  <div class="relative w-full max-w-md">
    
    <!-- Header Brand -->
    <div class="text-center mb-6">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-600 via-red-700 to-amber-500 text-white shadow-2xl shadow-red-900/60 ring-2 ring-red-500/40 mb-3">
        <i class="fa-solid fa-shield-halved text-2xl"></i>
      </div>
      <h1 class="text-2xl font-extrabold text-white tracking-wider" style="font-family: 'Rajdhani', sans-serif;">
        SUPER ADMIN PANEL
      </h1>
      <p class="text-xs text-gray-400 mt-1">Sistem Kontrol Event & Verifikasi Free Fire</p>
    </div>

    <!-- Login Card -->
    <div class="bg-[#120306]/90 backdrop-blur-xl border border-red-900/50 rounded-2xl p-6 md:p-8 shadow-2xl shadow-black">
      
      @if(session('error'))
        <div class="mb-5 p-3 rounded-xl bg-red-950/90 border border-red-600/40 text-red-200 text-xs flex items-center gap-2">
          <i class="fa-solid fa-circle-exclamation text-red-400 text-sm"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      @if(session('success'))
        <div class="mb-5 p-3 rounded-xl bg-emerald-950/90 border border-emerald-600/40 text-emerald-200 text-xs flex items-center gap-2">
          <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <form action="{{ route('panel.login.post') }}" method="POST" class="space-y-4">
        @csrf
        
        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-1.5">
            Email / Username Admin
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
              <i class="fa-solid fa-envelope"></i>
            </span>
            <input type="text" name="email" value="{{ old('email', 'admin@gmail.com') }}" required autofocus
                   class="w-full bg-[#1c060a] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-3 pl-10 pr-4 placeholder-gray-600 transition-all outline-none"
                   placeholder="admin@gmail.com"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-1.5">
            Password
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
              <i class="fa-solid fa-lock"></i>
            </span>
            <input type="password" id="passwordInput" name="password" required
                   class="w-full bg-[#1c060a] border border-red-900/60 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-white text-sm rounded-xl py-3 pl-10 pr-10 placeholder-gray-600 transition-all outline-none"
                   placeholder="••••••••"/>
            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-500 hover:text-gray-300">
              <i id="toggleIcon" class="fa-solid fa-eye text-xs"></i>
            </button>
          </div>
        </div>

        <div class="bg-[#190407] border border-red-950 rounded-lg p-2.5 text-[11px] text-gray-400 flex items-center gap-2">
          <i class="fa-solid fa-key text-amber-400"></i>
          <span>Default: <b>admin@gmail.com</b> / <b>admin123</b></span>
        </div>

        <button type="submit" 
                class="w-full py-3.5 px-4 rounded-xl font-bold text-sm text-white tracking-wider uppercase bg-gradient-to-r from-red-600 via-red-700 to-amber-600 hover:from-red-500 hover:to-amber-500 shadow-lg shadow-red-900/50 hover:shadow-red-800/80 transition-all transform active:scale-[0.98]">
          <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk ke Panel
        </button>
      </form>

      <div class="mt-6 text-center">
        <a href="{{ route('event.index') }}" class="text-xs text-gray-400 hover:text-amber-400 transition-colors inline-flex items-center gap-1.5">
          <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Event
        </a>
      </div>

    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('toggleIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
