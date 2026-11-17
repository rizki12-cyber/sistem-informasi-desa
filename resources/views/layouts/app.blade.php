<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Informasi Desa')</title>
    <meta name="description" content="@yield('description', 'Website resmi desa')">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        :root {
            --primary-dark: #0f2310;
            --primary: #1b431c;
            --accent: #d4af37;
            --font-sans: 'Plus Jakarta Sans', -apple-system, sans-serif;
            --font-serif: 'Playfair Display', serif;
            --font-script: 'Alex Brush', cursive;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: var(--font-sans); 
            color: #1e2923; 
            background: #ffffff; 
            line-height: 1.6;
        }
        
        .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }
        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }
        
        .village-name-script {
            font-family: var(--font-script) !important;
            color: var(--accent);
            font-weight: 400;
            text-transform: none;
        }

        /* ===== LOGO AUTO-CLEAN ===== */
        img.auto-clean-logo {
            transition: opacity 0.3s ease;
            will-change: opacity;
        }

        img.auto-clean-logo.processing { opacity: 0.7; }

        /* ============================================= */
        /*  NAVBAR                                     */
        /* ============================================= */
        .navbar { 
            position: fixed; 
            top: 0; left: 0; right: 0; 
            z-index: 1000; 
            padding: 16px 0; 
            transition: all 0.4s ease; 
            background: linear-gradient(180deg, rgba(15,35,16,0.85) 0%, rgba(15,35,16,0) 100%);
        }

        .navbar.scrolled { 
            background: rgba(15, 35, 16, 0.95); 
            backdrop-filter: blur(12px); 
            padding: 10px 0; 
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .navbar .container { 
            max-width: 100%;
            padding: 0 32px;
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 32px;
        }

        /* ============================================= */
        /*  BRAND                                       */
        /* ============================================= */
        .navbar-brand { 
            display: flex; 
            align-items: center; 
            gap: 8px;
            color: #ffffff; 
            flex-shrink: 0;
            min-width: 0;
            margin-right: auto;
            padding-right: 20px;
        }

        .navbar-brand img { 
            height: 44px; 
            width: auto;
            max-width: 110px;
            object-fit: contain;
            display: block;
            flex-shrink: 0;
        }

        .brand-text-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            min-width: 0;
            padding: 2px 0;
        }

        .brand-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.6;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.5);
            white-space: nowrap;
            line-height: 1;
            margin-bottom: 2px;
        }

        .navbar-brand .village-name-script {
            font-size: 30px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            white-space: nowrap;
            display: block;
            font-weight: 500;

            background: linear-gradient(135deg, #ffffff 0%, #f5e6a8 45%, #d4af37 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;

            filter: drop-shadow(0 2px 10px rgba(212, 175, 55, 0.35))
                    drop-shadow(0 0 20px rgba(212, 175, 55, 0.15));
        }

        .navbar-brand .village-name-script .accent { color: var(--accent); }

        /* ============================================= */
        /*  MENU                                        */
        /* ============================================= */
        .navbar-menu { 
            display: flex; 
            align-items: center; 
            gap: 4px;
            list-style: none; 
            flex-shrink: 0;
            margin-left: auto;
        }

        .navbar-menu > li { flex-shrink: 0; position: relative; }

        .navbar-menu > li > a { 
            color: rgba(255, 255, 255, 0.85); 
            padding: 9px 14px;
            border-radius: 50px; 
            font-weight: 500; 
            font-size: 14px; 
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            line-height: 1;
        }

        .navbar-menu > li > a:hover { 
            color: #ffffff; 
            background: rgba(255, 255, 255, 0.08); 
        }

        .navbar-menu > li > a.active { 
            background: rgba(212, 175, 55, 0.2); 
            color: #ffffff; 
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .navbar-menu > li > a > .caret {
            font-size: 9px;
            opacity: 0.6;
            transition: transform 0.3s ease;
        }

        .navbar-menu > li:hover > a > .caret {
            transform: rotate(180deg);
        }

        /* ===== MENU LAYANAN — HIGHLIGHT GOLD ===== */
        .navbar-menu > li > a.menu-cta {
            background: linear-gradient(135deg, #f0d060, #d4af37);
            color: #0a1a0a;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.3);
            padding: 9px 18px;
        }

        .navbar-menu > li > a.menu-cta:hover,
        .navbar-menu > li:hover > a.menu-cta {
            background: linear-gradient(135deg, #d4af37, #c5a031);
            color: #0a1a0a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        .navbar-menu > li > a.menu-cta.active {
            background: linear-gradient(135deg, #d4af37, #c5a031);
            color: #0a1a0a;
            border: none;
        }

        .navbar-menu > li > a.menu-cta > .caret {
            opacity: 0.8;
        }

        .btn-dashboard {
            background: var(--accent) !important;
            color: var(--primary-dark) !important;
            font-weight: 700 !important;
            border: none !important;
        }

        .btn-dashboard:hover {
            background: #c5a031 !important;
            color: var(--primary-dark) !important;
        }

        .hamburger { 
            display: none; 
            background: none; 
            border: none; 
            color: white; 
            font-size: 24px; 
            cursor: pointer; 
            padding: 4px;
            flex-shrink: 0;
        }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 230px;
            background: rgba(15, 35, 16, 0.98);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 8px 0;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.35);
            margin-top: 8px;
            animation: dropdownFade 0.25s ease;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .navbar-menu > li:hover .dropdown-menu { display: block; }

        /* Panah kecil di atas dropdown */
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 24px;
            width: 12px;
            height: 12px;
            background: rgba(15, 35, 16, 0.98);
            border-left: 1px solid rgba(255, 255, 255, 0.06);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            transform: rotate(45deg);
            border-radius: 2px 0 0 0;
        }

        /* Untuk dropdown yang rata kanan (biar tidak keluar layar) */
        .dropdown-menu.right { left: auto; right: 0; }
        .dropdown-menu.right::before { left: auto; right: 24px; }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s ease;
        }

        .dropdown-menu a:hover {
            background: rgba(212, 175, 55, 0.08);
            color: #ffffff;
            padding-left: 24px;
        }

        .dropdown-menu a.active {
            background: rgba(212, 175, 55, 0.12);
            color: #ffffff;
        }

        .dropdown-menu a i {
            width: 18px;
            text-align: center;
            color: var(--accent);
            font-size: 14px;
            flex-shrink: 0;
        }

        .dropdown-menu a .menu-desc {
            font-size: 11px;
            opacity: 0.5;
            font-weight: 400;
            display: block;
            margin-top: 1px;
            color: rgba(255,255,255,0.5);
        }

        /* ===== FOOTER ===== */
        .footer { 
            background: var(--primary-dark); 
            color: rgba(255, 255, 255, 0.75); 
            padding: 70px 0 30px; 
            border-top: 1px solid rgba(212, 175, 55, 0.15);
        }

        .footer-grid { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr 1fr; 
            gap: 50px; 
            margin-bottom: 40px; 
        }

        .footer h4 { 
            font-family: var(--font-serif);
            color: #ffffff; 
            font-size: 18px; 
            margin-bottom: 18px; 
            font-weight: 600;
        }

        .footer-village-title {
            color: #ffffff;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .footer-village-title .village-name-script {
            font-size: 42px;
            line-height: 1.3;
            display: inline-block;
            font-weight: 500;

            background: linear-gradient(135deg, #ffffff 0%, #f5e6a8 45%, #d4af37 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;

            filter: drop-shadow(0 2px 10px rgba(212, 175, 55, 0.25));
        }

        .footer p { 
            font-size: 14px; 
            margin-bottom: 6px; 
            color: rgba(255, 255, 255, 0.6);
        }

        .footer a { 
            color: rgba(255, 255, 255, 0.6); 
            font-size: 14px; 
            display: block; 
            padding: 5px 0; 
            transition: all 0.3s ease;
        }

        .footer a:hover { 
            color: var(--accent);
            padding-left: 6px;
        }

        .footer .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .footer .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            transition: all 0.3s ease;
            padding: 0;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .footer .social-icons a:hover {
            background: var(--accent);
            color: var(--primary-dark);
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .footer-bottom { 
            border-top: 1px solid rgba(255, 255, 255, 0.06); 
            padding-top: 24px; 
            text-align: center; 
            font-size: 13px; 
            opacity: 0.6; 
            color: rgba(255, 255, 255, 0.4);
        }

        .footer-bottom .village-name-script {
            font-size: 22px;
            line-height: 1.3;
            color: var(--accent);
            opacity: 0.7;
        }

        /* ============================================= */
        /*  RESPONSIVE                                 */
        /* ============================================= */

        @media (max-width: 1200px) {
            .navbar .container { gap: 20px; padding: 0 24px; }

            .navbar-brand { gap: 6px; padding-right: 12px; }
            .navbar-brand img { height: 40px; max-width: 90px; }
            .navbar-brand .village-name-script { font-size: 26px; }

            .navbar-menu { gap: 2px; }
            .navbar-menu > li > a { padding: 8px 11px; font-size: 13px; }
            .navbar-menu > li > a.menu-cta { padding: 8px 14px; }
        }

        @media (max-width: 992px) {
            .hamburger { display: block; }

            .navbar-brand { margin-right: 0; padding-right: 0; max-width: none; }

            .navbar-menu { 
                display: none; 
                flex-direction: column; 
                position: absolute; 
                top: 100%; 
                left: 16px; 
                right: 16px; 
                background: rgba(15, 35, 16, 0.98); 
                padding: 16px; 
                gap: 2px; 
                border-radius: 16px;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
                margin-top: 8px;
                margin-left: 0;
            }
            .navbar-menu.open { display: flex; }

            .navbar-menu > li { width: 100%; }

            .navbar-menu > li > a {
                width: 100%;
                justify-content: space-between;
                padding: 12px 16px;
                font-size: 14px;
                border-radius: 10px;
            }

            .navbar-menu > li > a.menu-cta {
                padding: 12px 16px;
                margin-top: 6px;
                justify-content: center;
            }

            /* Mobile dropdown */
            .dropdown-menu {
                position: static;
                background: rgba(255, 255, 255, 0.03);
                border: none;
                box-shadow: none;
                padding: 4px 0 4px 12px;
                border-radius: 8px;
                margin-top: 2px;
                display: none;
                animation: none;
                min-width: 0;
            }

            .dropdown-menu::before { display: none; }

            .navbar-menu > li.open .dropdown-menu { display: block; }
            .dropdown-menu a { padding: 10px 14px; font-size: 13px; }
            .dropdown-menu a:hover { padding-left: 18px; }
            .dropdown-menu a .menu-desc { display: none; }
            
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }

            .navbar-brand .village-name-script { font-size: 24px; }
        }

        @media (max-width: 768px) {
            .navbar .container { padding: 0 20px; }

            .footer-grid { grid-template-columns: 1fr; gap: 28px; }
            
            .navbar-brand .village-name-script { font-size: 22px; }
            .navbar-brand img { height: 34px; max-width: 80px; }
            .footer-village-title .village-name-script { font-size: 34px; }
        }

        @media (max-width: 480px) {
            .navbar .container { padding: 0 16px; }

            .navbar-brand .village-name-script { font-size: 18px; }
            .navbar-brand img { height: 30px; max-width: 70px; }
            .container { padding: 0 16px; }
            .footer-village-title .village-name-script { font-size: 28px; }
            .footer-bottom .village-name-script { font-size: 24px; }
        }
    </style>
</head>
<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                @php 
                    $profile = App\Models\VillageProfile::first(); 
                @endphp
                @if(isset($profile) && $profile && $profile->logo)
                    <img src="{{ asset('storage/' . $profile->logo) }}" 
                         alt="Logo Desa" 
                         class="auto-clean-logo"
                         crossorigin="anonymous"
                         loading="lazy">
                @else
                    <span style="font-size: 24px;">🏛️</span>
                @endif
                <div class="brand-text-container">
                    <span class="brand-label"></span>
                    <span class="village-name-script">{{ isset($profile) && $profile ? $profile->village_name : 'Digital' }}</span>
                </div>
            </a>
            
            <button class="hamburger" id="hamburger" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-menu" id="navbarMenu">

                {{-- BERANDA --}}
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Beranda
                    </a>
                </li>

                {{-- PROFIL (dropdown) --}}
                <li class="dropdown">
                    <a href="#" onclick="return false;" class="{{ request()->routeIs('profile') || request()->routeIs('government') ? 'active' : '' }}">
                        Profil <i class="fas fa-chevron-down caret"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                            <i class="fas fa-building"></i>
                            <div>
                                Profil Desa
                                <span class="menu-desc">Sejarah, visi & misi</span>
                            </div>
                        </a>
                        <a href="{{ route('government') }}" class="{{ request()->routeIs('government') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <div>
                                Pemerintahan
                                <span class="menu-desc">Struktur perangkat desa</span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- INFORMASI (dropdown) --}}
                <li class="dropdown">
                    <a href="#" onclick="return false;" class="{{ request()->routeIs('public.news.*') || request()->routeIs('public.announcements') || request()->routeIs('public.agendas') || request()->routeIs('public.gallery.*') ? 'active' : '' }}">
                        Informasi <i class="fas fa-chevron-down caret"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('public.news.index') }}" class="{{ request()->routeIs('public.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i>
                            <div>
                                Berita
                                <span class="menu-desc">Kabar terbaru desa</span>
                            </div>
                        </a>
                        <a href="{{ route('public.announcements') }}" class="{{ request()->routeIs('public.announcements') ? 'active' : '' }}">
                            <i class="fas fa-bullhorn"></i>
                            <div>
                                Pengumuman
                                <span class="menu-desc">Info resmi desa</span>
                            </div>
                        </a>
                        <a href="{{ route('public.agendas') }}" class="{{ request()->routeIs('public.agendas') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                Agenda
                                <span class="menu-desc">Jadwal kegiatan desa</span>
                            </div>
                        </a>
                        <a href="{{ route('public.gallery') }}" class="{{ request()->routeIs('public.gallery') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            <div>
                                Galeri
                                <span class="menu-desc">Dokumentasi foto</span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- DATA DESA (dropdown) --}}
                <li class="dropdown">
                    <a href="#" onclick="return false;" class="{{ request()->routeIs('public.statistics') || request()->routeIs('public.potentials') || request()->routeIs('public.umkm') ? 'active' : '' }}">
                        Data Desa <i class="fas fa-chevron-down caret"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('public.statistics') }}" class="{{ request()->routeIs('public.statistics') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <div>
                                Statistik
                                <span class="menu-desc">Data kependudukan</span>
                            </div>
                        </a>
                        <a href="{{ route('public.potentials') }}" class="{{ request()->routeIs('public.potentials') ? 'active' : '' }}">
                            <i class="fas fa-seedling"></i>
                            <div>
                                Potensi Desa
                                <span class="menu-desc">Kekayaan & sumber daya</span>
                            </div>
                        </a>
                        <a href="{{ route('public.umkm') }}" class="{{ request()->routeIs('public.umkm') ? 'active' : '' }}">
                            <i class="fas fa-store"></i>
                            <div>
                                UMKM
                                <span class="menu-desc">Produk unggulan warga</span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- LAYANAN (dropdown, CTA gold) --}}
                <li class="dropdown">
                    <a href="#" onclick="return false;" class="menu-cta {{ request()->routeIs('public.complaints.*') || request()->routeIs('public.letters.*') ? 'active' : '' }}">
                        <i class="fas fa-headset"></i> Layanan <i class="fas fa-chevron-down caret"></i>
                    </a>
                    <div class="dropdown-menu right">
                        <a href="{{ route('public.complaints.create') }}" class="{{ request()->routeIs('public.complaints.create') ? 'active' : '' }}">
                            <i class="fas fa-bullhorn"></i>
                            <div>
                                Kirim Pengaduan
                                <span class="menu-desc">Sampaikan keluhan/saran</span>
                            </div>
                        </a>
                        <a href="{{ route('public.complaints.check') }}" class="{{ request()->routeIs('public.complaints.check') ? 'active' : '' }}">
                            <i class="fas fa-search"></i>
                            <div>
                                Cek Status Pengaduan
                                <span class="menu-desc">Lacak tiket pengaduan</span>
                            </div>
                        </a>
                        <a href="{{ route('public.letters.create') }}" class="{{ request()->routeIs('public.letters.create') ? 'active' : '' }}">
                            <i class="fas fa-file-signature"></i>
                            <div>
                                Ajukan Surat
                                <span class="menu-desc">Surat keterangan online</span>
                            </div>
                        </a>
                        <a href="{{ route('public.letters.check') }}" class="{{ request()->routeIs('public.letters.check') ? 'active' : '' }}">
                            <i class="fas fa-file-search"></i>
                            <div>
                                Cek Status Surat
                                <span class="menu-desc">Lacak permohonan surat</span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- KONTAK --}}
                <li>
                    <a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">
                        Kontak
                    </a>
                </li>

                {{-- DASHBOARD (admin only) --}}
                @auth
                    @if(Auth::user()->isAdmin())
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            @php 
                $profile = App\Models\VillageProfile::first(); 
                $contact = App\Models\Contact::first(); 
            @endphp
            <div class="footer-grid">
                <div>
                    <div class="footer-village-title">
                        <span class="village-name-script">{{ isset($profile) && $profile ? $profile->village_name : 'Digital' }}</span>
                    </div>
                    <p>{{ isset($profile) && $profile ? $profile->district : '' }}, {{ isset($profile) && $profile ? $profile->regency : '' }}</p>
                    <p>{{ isset($profile) && $profile ? $profile->province : '' }}</p>
                    @if(isset($contact) && $contact)
                        <p style="margin-top: 12px;">
                            <i class="fas fa-phone" style="color:var(--accent);width:20px;"></i> 
                            {{ $contact->phone }}
                        </p>
                        <p>
                            <i class="fas fa-envelope" style="color:var(--accent);width:20px;"></i> 
                            {{ $contact->email }}
                        </p>
                    @endif
                    <div class="social-icons">
                        @if(isset($contact) && $contact && $contact->whatsapp)
                            <a href="{{ $contact->whatsapp_link }}" target="_blank" aria-label="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4>Navigasi</h4>
                    <a href="{{ route('profile') }}">Profil Desa</a>
                    <a href="{{ route('government') }}">Pemerintahan</a>
                    <a href="{{ route('public.news.index') }}">Berita</a>
                    <a href="{{ route('public.gallery') }}">Galeri</a>
                    <a href="{{ route('public.contact') }}">Kontak</a>
                </div>
                
                <div>
                    <h4>Layanan</h4>
                    <a href="{{ route('public.announcements') }}">Pengumuman</a>
                    <a href="{{ route('public.statistics') }}">Statistik</a>
                    <a href="{{ route('public.potentials') }}">Potensi Desa</a>
                    <a href="{{ route('public.umkm') }}">UMKM</a>
                    <a href="{{ route('public.complaints.create') }}" style="color: var(--accent); font-weight: 600;">
                        <i class="fas fa-bullhorn" style="width:16px;"></i> Pengaduan Warga
                    </a>
                    <a href="{{ route('public.letters.create') }}" style="color: var(--accent); font-weight: 600;">
                        <i class="fas fa-file-signature" style="width:16px;"></i> Ajukan Surat
                    </a>
                </div>
                
                <div>
                    <h4>Kontak Cepat</h4>
                    @if(isset($contact) && $contact)
                        <p style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:4px;">
                            <i class="fas fa-phone" style="color:var(--accent);width:16px;"></i>
                            {{ $contact->phone }}
                        </p>
                        <p style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:4px;">
                            <i class="fas fa-envelope" style="color:var(--accent);width:16px;"></i>
                            {{ $contact->email }}
                        </p>
                        @if($contact->whatsapp)
                            <p style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:4px;">
                                <i class="fab fa-whatsapp" style="color:#25D366;width:16px;"></i>
                                {{ $contact->whatsapp }}
                            </p>
                        @endif
                        <p style="font-size:13px;color:rgba(255,255,255,0.5);">
                            <i class="fas fa-clock" style="color:var(--accent);width:16px;"></i>
                            {{ $contact->working_hours ?? 'Senin - Jumat: 08:00 - 16:00' }}
                        </p>
                    @else
                        <p style="font-size:13px;color:rgba(255,255,255,0.3);">Belum ada data kontak</p>
                    @endif
                </div>
            </div>
            
            <div class="footer-bottom">
                &copy; {{ date('Y') }} 
                <span class="village-name-script" style="font-size: 20px;">{{ isset($profile) && $profile ? $profile->village_name : '' }}</span>. 
                All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // =============================================
        //  AUTO REMOVE LOGO BACKGROUND
        // =============================================
        (function() {
            function cleanLogoBackground(imgElement) {
                if (!imgElement || !imgElement.src) return;
                if (imgElement.dataset.cleaned === '1') return;

                imgElement.dataset.cleaned = '1';
                imgElement.classList.add('processing');

                const src = imgElement.src;

                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.decoding = 'async';

                img.onload = function() {
                    try {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.naturalWidth;
                        canvas.height = img.naturalHeight;
                        const ctx = canvas.getContext('2d', { willReadFrequently: true });
                        ctx.drawImage(img, 0, 0);

                        let imageData;
                        try {
                            imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        } catch (corsErr) {
                            imgElement.classList.remove('processing');
                            return;
                        }

                        const data = imageData.data;
                        const w = canvas.width;
                        const h = canvas.height;

                        const WHITE_THRESHOLD = 235;

                        const corners = [0, (w - 1) * 4, (h - 1) * w * 4, ((h - 1) * w + (w - 1)) * 4];
                        let whiteCorners = 0;
                        corners.forEach(function(idx) {
                            if (idx >= 0 && idx < data.length) {
                                const r = data[idx], g = data[idx+1], b = data[idx+2];
                                if (r > WHITE_THRESHOLD && g > WHITE_THRESHOLD && b > WHITE_THRESHOLD) whiteCorners++;
                            }
                        });

                        if (whiteCorners < 2) {
                            imgElement.classList.remove('processing');
                            return;
                        }

                        for (let i = 0; i < data.length; i += 4) {
                            const r = data[i], g = data[i + 1], b = data[i + 2], a = data[i + 3];
                            if (a === 0) continue;

                            if (r > WHITE_THRESHOLD && g > WHITE_THRESHOLD && b > WHITE_THRESHOLD) {
                                data[i + 3] = 0;
                            } else if (r > WHITE_THRESHOLD - 15 && g > WHITE_THRESHOLD - 15 && b > WHITE_THRESHOLD - 15) {
                                const avg = (r + g + b) / 3;
                                data[i + 3] = Math.min(a, Math.round(((255 - avg) / 255) * 255));
                            }
                        }

                        ctx.putImageData(imageData, 0, 0);

                        try {
                            imgElement.src = canvas.toDataURL('image/png');
                        } catch (e) {}

                        imgElement.classList.remove('processing');
                    } catch (err) {
                        imgElement.classList.remove('processing');
                    }
                };

                img.onerror = function() { imgElement.classList.remove('processing'); };
                img.src = src;
            }

            function processAllLogos() {
                document.querySelectorAll('img.auto-clean-logo').forEach(function(img) {
                    if (img.complete && img.naturalWidth > 0) {
                        cleanLogoBackground(img);
                    } else {
                        img.addEventListener('load', function() { cleanLogoBackground(img); }, { once: true });
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', processAllLogos);
            } else {
                processAllLogos();
            }
        })();

        // ===== NAVBAR SCROLL =====
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 40) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // ===== HAMBURGER TOGGLE =====
        document.getElementById('hamburger').addEventListener('click', function() {
            document.getElementById('navbarMenu').classList.toggle('open');
        });

        // ===== DROPDOWN FOR MOBILE =====
        document.querySelectorAll('.navbar-menu > li.dropdown > a').forEach(function(dropdownLink) {
            dropdownLink.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    var parent = this.parentElement;
                    // Tutup dropdown lain
                    document.querySelectorAll('.navbar-menu > li.dropdown').forEach(function(other) {
                        if (other !== parent) other.classList.remove('open');
                    });
                    parent.classList.toggle('open');
                }
            });
        });

        // ===== CLOSE MOBILE MENU ON LINK CLICK =====
        document.querySelectorAll('.navbar-menu .dropdown-menu a').forEach(function(link) {
            link.addEventListener('click', function() {
                var menu = document.getElementById('navbarMenu');
                if (menu.classList.contains('open')) {
                    menu.classList.remove('open');
                }
                document.querySelectorAll('.navbar-menu > li.dropdown').forEach(function(d) {
                    d.classList.remove('open');
                });
            });
        });

        // ===== CLOSE DROPDOWN ON OUTSIDE CLICK (mobile) =====
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                document.querySelectorAll('.navbar-menu > li.dropdown').forEach(function(dropdown) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });
            }
        });

        // ===== CLOSE MOBILE MENU ON RESIZE =====
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                var menu = document.getElementById('navbarMenu');
                if (menu.classList.contains('open')) {
                    menu.classList.remove('open');
                }
                document.querySelectorAll('.navbar-menu > li.dropdown').forEach(function(d) {
                    d.classList.remove('open');
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>