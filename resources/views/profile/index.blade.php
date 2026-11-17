@extends('layouts.app')

@section('title', 'Profil Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Profil desa, sejarah, visi, misi, dan informasi lengkap tentang ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .profile-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-header .container {
        position: relative;
        z-index: 1;
    }

    .profile-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .profile-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .profile-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .profile-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .profile-header .breadcrumb .current {
        color: #d4af37;
    }

    .profile-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .profile-header h1 span {
        color: #d4af37;
    }

    .profile-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    /* ===== MAIN CONTENT ===== */
    .profile-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
        align-items: start;
    }

    /* ===== CARDS ===== */
    .card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 36px;
        border: 1px solid #eef3ee;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        margin-bottom: 24px;
    }

    .card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-color: #d4af37;
    }

    .card:last-child {
        margin-bottom: 0;
    }

    .card .card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(212, 175, 55, 0.1);
        color: #d4af37;
        font-size: 20px;
        margin-bottom: 12px;
    }

    .card h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }

    .card .subtitle {
        font-size: 13px;
        color: #8a9a8a;
        font-weight: 500;
        margin-bottom: 16px;
        display: block;
    }

    .card p {
        color: #4a5a4a;
        line-height: 1.9;
        font-size: 15px;
    }

    .card .divider {
        height: 1px;
        background: #eef3ee;
        margin: 20px 0;
    }

    /* ===== LIST MISION ===== */
    .mission-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mission-list li {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f5f0;
        color: #4a5a4a;
        font-size: 15px;
        line-height: 1.7;
    }

    .mission-list li:last-child {
        border-bottom: none;
    }

    .mission-list li .number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.12);
        color: #d4af37;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ===== SIDE CARD ===== */
    .side-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 28px;
        border: 1px solid #eef3ee;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        margin-bottom: 24px;
        text-align: center;
    }

    .side-card:last-child {
        margin-bottom: 0;
    }

    .side-card .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #eef3ee;
        margin: 0 auto 16px;
        display: block;
        transition: all 0.3s ease;
    }

    .side-card .avatar:hover {
        border-color: #d4af37;
        transform: scale(1.02);
    }

    .side-card .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef3ee, #d5e0d5);
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #8a9a8a;
        border: 4px solid #eef3ee;
    }

    .side-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 2px;
    }

    .side-card .position {
        font-size: 14px;
        color: #d4af37;
        font-weight: 500;
    }

    .side-card .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f5f0;
        font-size: 14px;
        color: #4a5a4a;
        text-align: left;
    }

    .side-card .info-item:last-child {
        border-bottom: none;
    }

    .side-card .info-item i {
        width: 20px;
        color: #d4af37;
        font-size: 15px;
    }

    .side-card .info-item strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-header h1 {
            font-size: 34px;
        }

        .profile-header p {
            font-size: 16px;
        }
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 120px 0 40px;
        }

        .profile-header h1 {
            font-size: 28px;
        }

        .profile-page {
            padding: 40px 0 60px;
        }

        .card {
            padding: 24px 20px;
        }

        .card h3 {
            font-size: 18px;
        }

        .side-card {
            padding: 24px 20px;
        }

        .side-card .avatar,
        .side-card .avatar-placeholder {
            width: 100px;
            height: 100px;
        }

        .profile-grid {
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .profile-header h1 {
            font-size: 24px;
        }

        .profile-header .breadcrumb {
            font-size: 12px;
            flex-wrap: wrap;
        }

        .card {
            padding: 20px 16px;
        }

        .mission-list li {
            font-size: 14px;
        }

        .side-card .avatar,
        .side-card .avatar-placeholder {
            width: 80px;
            height: 80px;
            font-size: 32px;
        }

        .side-card h4 {
            font-size: 16px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="profile-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Profil Desa</span>
        </div>
        <h1>Profil <span>Desa</span></h1>
        <p>Informasi lengkap tentang desa, sejarah, visi, misi, dan pemerintahan desa.</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="profile-page">
    <div class="container">
        <div class="profile-grid">
            <!-- ===== MAIN COLUMN ===== -->
            <div>
                <!-- Informasi Dasar -->
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Informasi Desa</h3>
                    <span class="subtitle">Data dasar desa</span>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 24px;margin-top:8px;">
                        <div>
                            <span style="font-size:13px;color:#8a9a8a;font-weight:500;">Nama Desa</span>
                            <p style="font-weight:600;color:#0a1a0a;font-size:16px;margin:0;">{{ $profile->village_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span style="font-size:13px;color:#8a9a8a;font-weight:500;">Kecamatan</span>
                            <p style="font-weight:500;color:#0a1a0a;font-size:15px;margin:0;">{{ $profile->district ?? '-' }}</p>
                        </div>
                        <div>
                            <span style="font-size:13px;color:#8a9a8a;font-weight:500;">Kabupaten</span>
                            <p style="font-weight:500;color:#0a1a0a;font-size:15px;margin:0;">{{ $profile->regency ?? '-' }}</p>
                        </div>
                        <div>
                            <span style="font-size:13px;color:#8a9a8a;font-weight:500;">Provinsi</span>
                            <p style="font-weight:500;color:#0a1a0a;font-size:15px;margin:0;">{{ $profile->province ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Sejarah -->
                @if($profile && $profile->history)
                    <div class="card">
                        <div class="card-icon">
                            <i class="fas fa-scroll"></i>
                        </div>
                        <h3>Sejarah Desa</h3>
                        <span class="subtitle">Perjalanan desa dari masa ke masa</span>
                        <p>{{ $profile->history }}</p>
                    </div>
                @endif

                <!-- Visi & Misi -->
                <div class="card">
                    <div class="card-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h3>Visi &amp; Misi</h3>
                    <span class="subtitle">Arah dan tujuan pembangunan desa</span>

                    @if($profile && $profile->vision)
                        <div style="background:#f8faf8;border-radius:12px;padding:20px 24px;margin-bottom:20px;border-left:3px solid #d4af37;">
                            <h4 style="font-weight:700;color:#0a1a0a;font-size:16px;margin-bottom:4px;">Visi</h4>
                            <p style="color:#4a5a4a;font-size:15px;line-height:1.7;margin:0;">{{ $profile->vision }}</p>
                        </div>
                    @endif

                    @if($profile && $profile->mission)
                        <div>
                            <h4 style="font-weight:700;color:#0a1a0a;font-size:16px;margin-bottom:8px;">Misi</h4>
                            <ul class="mission-list">
                                @php $missions = explode("\n", $profile->mission); @endphp
                                @foreach($missions as $index => $mission)
                                    @if(trim($mission))
                                        <li>
                                            <span class="number">{{ $index + 1 }}</span>
                                            <span>{{ trim($mission) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p style="color:#8a9a8a;font-style:italic;">Belum ada data misi yang diisi.</p>
                    @endif
                </div>
            </div>

            <!-- ===== SIDE COLUMN ===== -->
            <div>
                <!-- Kepala Desa -->
                <div class="side-card">
                    <div style="position:relative;display:inline-block;">
                        @if($profile && $profile->head_photo)
                            <img src="{{ asset('storage/' . $profile->head_photo) }}" alt="Kepala Desa {{ $profile->village_name ?? '' }}" class="avatar">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        @endif
                    </div>
                    <h4>{{ $profile->head_name ?? 'Belum diisi' }}</h4>
                    <div class="position">Kepala Desa</div>
                    <div style="margin-top:12px;padding-top:12px;border-top:1px solid #eef3ee;">
                        <div class="info-item">
                            <i class="fas fa-flag"></i>
                            <div>
                                <strong>Desa</strong><br>
                                <span style="font-size:13px;color:#6a7a6a;">{{ $profile->village_name ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-pin"></i>
                            <div>
                                <strong>Alamat</strong><br>
                                <span style="font-size:13px;color:#6a7a6a;">
                                    {{ $profile->district ?? '' }}, {{ $profile->regency ?? '' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <strong>Periode</strong><br>
                                <span style="font-size:13px;color:#6a7a6a;">2021 - 2026</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Quick Info -->
                @php $contact = App\Models\Contact::first(); @endphp
                @if($contact)
                    <div class="side-card" style="text-align:left;">
                        <h4 style="text-align:center;margin-bottom:12px;font-size:16px;">
                            <i class="fas fa-phone" style="color:#d4af37;margin-right:8px;"></i>
                            Kontak Desa
                        </h4>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span style="font-size:13px;color:#6a7a6a;">{{ Str::limit($contact->address, 60) }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span style="font-size:13px;color:#6a7a6a;">{{ $contact->phone }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span style="font-size:13px;color:#6a7a6a;">{{ $contact->email }}</span>
                            </div>
                        </div>
                        @if($contact->whatsapp)
                            <div class="info-item" style="border-bottom:none;">
                                <i class="fab fa-whatsapp" style="color:#25D366;"></i>
                                <div>
                                    <a href="{{ $contact->whatsapp_link }}" target="_blank" style="color:#25D366;font-size:13px;font-weight:500;text-decoration:none;">
                                        Hubungi via WhatsApp
                                    </a>
                                </div>
                            </div>
                        @endif
                        <div style="margin-top:12px;text-align:center;">
                            <a href="{{ route('public.contact') }}" class="btn-outline" style="display:inline-flex;align-items:center;gap:8px;color:#0a1a0a;font-weight:600;font-size:14px;padding:10px 24px;border:2px solid #d4af37;border-radius:50px;transition:all 0.3s ease;background:transparent;text-decoration:none;">
                                Lihat Kontak Lengkap <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Quick Links -->
                <div class="side-card" style="text-align:left;">
                    <h4 style="text-align:center;margin-bottom:12px;font-size:16px;">
                        <i class="fas fa-link" style="color:#d4af37;margin-right:8px;"></i>
                        Navigasi Cepat
                    </h4>
                    <a href="{{ route('government') }}" class="info-item" style="text-decoration:none;color:#4a5a4a;border-bottom:1px solid #f0f5f0;">
                        <i class="fas fa-users"></i>
                        <span>Pemerintahan Desa</span>
                    </a>
                    <a href="{{ route('public.news.index') }}" class="info-item" style="text-decoration:none;color:#4a5a4a;border-bottom:1px solid #f0f5f0;">
                        <i class="fas fa-newspaper"></i>
                        <span>Berita Desa</span>
                    </a>
                    <a href="{{ route('public.potentials') }}" class="info-item" style="text-decoration:none;color:#4a5a4a;border-bottom:1px solid #f0f5f0;">
                        <i class="fas fa-seedling"></i>
                        <span>Potensi Desa</span>
                    </a>
                    <a href="{{ route('public.gallery') }}" class="info-item" style="text-decoration:none;color:#4a5a4a;border-bottom:none;">
                        <i class="fas fa-images"></i>
                        <span>Galeri Foto</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline:hover {
        background: #d4af37;
        color: #ffffff !important;
    }

    .btn-outline:hover i {
        transform: translateX(4px);
    }

    .btn-outline i {
        transition: transform 0.3s ease;
    }

    /* Smooth hover for side card links */
    .side-card .info-item {
        transition: background 0.3s ease, padding-left 0.3s ease;
        cursor: pointer;
        padding: 10px 12px;
        border-radius: 8px;
    }

    .side-card .info-item:hover {
        background: #f8faf8;
        padding-left: 16px;
    }

    .side-card a.info-item {
        text-decoration: none;
        color: #4a5a4a;
    }
</style>
@endsection