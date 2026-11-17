@extends('layouts.app')

@section('title', 'Kontak Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Informasi kontak, alamat, dan peta lokasi ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .contact-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .contact-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .contact-header .container {
        position: relative;
        z-index: 1;
    }

    .contact-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .contact-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .contact-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .contact-header .breadcrumb .current {
        color: #d4af37;
    }

    .contact-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .contact-header h1 span {
        color: #d4af37;
    }

    .contact-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .contact-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .contact-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .contact-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .contact-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .contact-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== CONTACT GRID ===== */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        align-items: start;
    }

    /* ===== CONTACT CARD ===== */
    .contact-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 36px 40px;
        border: 1px solid #eef3ee;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-color: #d4af37;
    }

    .contact-card .card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f5f0;
    }

    .contact-card .card-header .icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(212, 175, 55, 0.1);
        color: #d4af37;
        font-size: 22px;
        flex-shrink: 0;
    }

    .contact-card .card-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0;
    }

    .contact-card .card-header h3 span {
        color: #d4af37;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid #f5f8f5;
        color: #4a5a4a;
        transition: all 0.3s ease;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item:hover {
        padding-left: 8px;
    }

    .contact-item .icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f8faf8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #d4af37;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .contact-item:hover .icon {
        background: rgba(212, 175, 55, 0.1);
        color: #d4af37;
    }

    .contact-item .content {
        flex: 1;
        padding-top: 2px;
    }

    .contact-item .content .label {
        font-size: 12px;
        font-weight: 600;
        color: #8a9a8a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 1px;
    }

    .contact-item .content .value {
        font-size: 15px;
        color: #0a1a0a;
        line-height: 1.5;
        font-weight: 500;
    }

    .contact-item .content .value a {
        color: #0a1a0a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-item .content .value a:hover {
        color: #d4af37;
    }

    .contact-item .content .value .wa-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25D366;
        color: #ffffff;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .contact-item .content .value .wa-link:hover {
        background: #1da851;
        transform: scale(1.03);
        color: #ffffff;
    }

    /* ===== MAP CARD ===== */
    .map-card {
        padding: 0;
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid #eef3ee;
        background: #ffffff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .map-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-color: #d4af37;
    }

    .map-card .map-header {
        padding: 20px 28px 16px;
        border-bottom: 1px solid #f0f5f0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .map-card .map-header .icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(212, 175, 55, 0.1);
        color: #d4af37;
        font-size: 18px;
    }

    .map-card .map-header h3 {
        font-size: 17px;
        font-weight: 600;
        color: #0a1a0a;
        margin: 0;
    }

    .map-container {
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: #f0f5f0;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        transition: transform 0.6s ease;
    }

    .map-container:hover iframe {
        transform: scale(1.01);
    }

    /* ===== WHATSAPP FLOATING BUTTON ===== */
    .wa-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .wa-float .wa-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #25D366;
        color: #ffffff;
        padding: 14px 24px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        animation: wa-pulse 2s ease-in-out infinite;
    }

    .wa-float .wa-btn:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 8px 32px rgba(37, 211, 102, 0.4);
        color: #ffffff;
    }

    .wa-float .wa-btn i {
        font-size: 22px;
    }

    @keyframes wa-pulse {
        0%, 100% { box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3); }
        50% { box-shadow: 0 4px 40px rgba(37, 211, 102, 0.5); }
    }

    .wa-float .wa-label {
        font-size: 11px;
        color: #8a9a8a;
        background: rgba(255, 255, 255, 0.9);
        padding: 2px 12px;
        border-radius: 50px;
        backdrop-filter: blur(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: #ffffff;
        border-radius: 20px;
        border: 2px dashed #eef3ee;
        max-width: 600px;
        margin: 0 auto;
    }

    .empty-state .icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f8faf8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 36px;
        color: #c8dcc8;
    }

    .empty-state h3 {
        font-size: 22px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #7a8a7a;
        font-size: 15px;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .contact-header h1 {
            font-size: 34px;
        }

        .contact-header p {
            font-size: 16px;
        }

        .contact-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .contact-header .header-stats .stat-item .number {
            font-size: 22px;
        }

        .contact-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .contact-card {
            padding: 28px 30px;
        }
    }

    @media (max-width: 768px) {
        .contact-header {
            padding: 120px 0 40px;
        }

        .contact-header h1 {
            font-size: 28px;
        }

        .contact-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .contact-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .contact-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .contact-page {
            padding: 40px 0 80px;
        }

        .contact-card {
            padding: 24px 22px;
        }

        .contact-card .card-header h3 {
            font-size: 17px;
        }

        .map-container {
            height: 250px;
        }

        .wa-float {
            bottom: 20px;
            right: 20px;
        }

        .wa-float .wa-btn {
            padding: 12px 18px;
            font-size: 13px;
            border-radius: 50px;
        }

        .wa-float .wa-btn i {
            font-size: 18px;
        }

        .wa-float .wa-label {
            display: none;
        }

        .empty-state {
            padding: 50px 24px;
        }

        .empty-state .icon-wrap {
            width: 60px;
            height: 60px;
            font-size: 28px;
        }

        .empty-state h3 {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .contact-header h1 {
            font-size: 22px;
        }

        .contact-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .contact-card {
            padding: 20px 16px;
        }

        .contact-card .card-header {
            gap: 10px;
        }

        .contact-card .card-header .icon-wrap {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .contact-card .card-header h3 {
            font-size: 15px;
        }

        .contact-item {
            padding: 10px 0;
            gap: 12px;
        }

        .contact-item .icon {
            width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .contact-item .content .value {
            font-size: 13px;
        }

        .map-container {
            height: 200px;
        }

        .wa-float .wa-btn {
            padding: 10px 14px;
            font-size: 12px;
        }

        .wa-float .wa-btn i {
            font-size: 16px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="contact-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Kontak Desa</span>
        </div>
        <h1>Kontak <span>Desa</span></h1>
        <p>Hubungi kami untuk informasi, pertanyaan, atau layanan masyarakat</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">
                    @if($contact)
                        <i class="fas fa-check-circle" style="color:#2e7d32;font-size:20px;"></i>
                    @else
                        <i class="fas fa-clock" style="color:#d4af37;font-size:20px;"></i>
                    @endif
                </span>
                <span class="label">
                    @if($contact)
                        Informasi Tersedia
                    @else
                      Sedang Disiapkan
                    @endif
                </span>
            </div>
            <div class="stat-item">
                <span class="number">
                    @if($contact && $contact->phone)
                        <i class="fas fa-phone" style="color:#d4af37;font-size:20px;"></i>
                    @else
                        <i class="fas fa-times" style="color:#8a8a8a;font-size:20px;"></i>
                    @endif
                </span>
                <span class="label">
                    @if($contact && $contact->phone)
                        Aktif
                    @else
                        Belum Tersedia
                    @endif
                </span>
            </div>
            <div class="stat-item">
                <span class="number">
                    @if($contact && $contact->map_embed)
                        <i class="fas fa-map-marked-alt" style="color:#d4af37;font-size:20px;"></i>
                    @else
                        <i class="fas fa-times" style="color:#8a8a8a;font-size:20px;"></i>
                    @endif
                </span>
                <span class="label">
                    @if($contact && $contact->map_embed)
                        Peta Tersedia
                    @else
                        Belum Tersedia
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="contact-page">
    <div class="container">
        @if($contact)
            <div class="contact-grid">
                <!-- ===== CONTACT INFO ===== -->
                <div>
                    <div class="contact-card">
                        <div class="card-header">
                            <div class="icon-wrap">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <h3>Informasi <span>Kontak</span></h3>
                        </div>

                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="content">
                                <span class="label">Alamat</span>
                                <div class="value">{{ $contact->address }}</div>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="content">
                                <span class="label">Telepon</span>
                                <div class="value">
                                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="content">
                                <span class="label">Email</span>
                                <div class="value">
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </div>
                            </div>
                        </div>

                        @if($contact->whatsapp)
                            <div class="contact-item">
                                <div class="icon" style="background:rgba(37,211,102,0.1);color:#25D366;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="content">
                                    <span class="label">WhatsApp</span>
                                    <div class="value">
                                        <a href="{{ $contact->whatsapp_link }}" target="_blank" class="wa-link">
                                            <i class="fab fa-whatsapp"></i>
                                            {{ $contact->whatsapp }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($contact->working_hours)
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="content">
                                    <span class="label">Jam Pelayanan</span>
                                    <div class="value">{{ $contact->working_hours }}</div>
                                </div>
                            </div>
                        @endif

                        <div style="margin-top:20px;padding-top:16px;border-top:1px solid #f0f5f0;">
                            <div style="display:flex;align-items:center;gap:12px;font-size:13px;color:#8a9a8a;">
                                <i class="fas fa-info-circle" style="color:#d4af37;"></i>
                                <span>Senin - Jumat: 08:00 - 16:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== MAP ===== -->
                <div>
                    @if($contact->map_embed)
                        <div class="map-card">
                            <div class="map-header">
                                <div class="icon-wrap">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <h3>Lokasi Desa</h3>
                            </div>
                            <div class="map-container">
                                {!! $contact->map_embed !!}
                            </div>
                        </div>
                    @else
                        <div class="contact-card" style="text-align:center;padding:60px 40px;">
                            <div style="font-size:48px;color:#c8dcc8;margin-bottom:16px;">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h4 style="font-size:18px;color:#0a1a0a;margin-bottom:6px;">Peta Belum Tersedia</h4>
                            <p style="color:#7a8a7a;font-size:14px;">Peta lokasi desa sedang dalam persiapan.</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-address-card"></i>
                </div>
                <h3>Informasi Kontak Belum Tersedia</h3>
                <p>Data kontak desa belum ditambahkan. Silakan hubungi administrator untuk menambahkan informasi kontak desa.</p>
            </div>
        @endif
    </div>
</div>

<!-- ===== WHATSAPP FLOATING BUTTON ===== -->
@if($contact && $contact->whatsapp)
    <div class="wa-float">
        <a href="{{ $contact->whatsapp_link }}" target="_blank" class="wa-btn" aria-label="Hubungi via WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>Hubungi Kami</span>
        </a>
        <span class="wa-label">Chat via WhatsApp</span>
    </div>
@endif

<script>
    // ===== SMOOTH SCROLL =====
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scroll to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                var target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    });
</script>
@endsection