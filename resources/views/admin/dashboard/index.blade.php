@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    /* ============================================= */
    /*  CSS VARIABLES                              */
    /* ============================================= */
    :root {
        --dash-primary: #0a1a0a;
        --dash-primary-light: #1a3a1a;
        --dash-accent: #d4af37;
        --dash-accent-light: #f0d060;
        --dash-bg: #f4f7f4;
        --dash-card: #ffffff;
        --dash-border: #eef3ee;
        --dash-text: #0a1a0a;
        --dash-text-muted: #6a7a6a;
        --dash-text-light: #9aa89a;
        --dash-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        --dash-shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.06);
        --dash-radius: 16px;
        --dash-transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* ============================================= */
    /*  WELCOME BANNER                             */
    /* ============================================= */
    .dash-welcome {
        position: relative;
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 50%, #0f2310 100%);
        border-radius: 20px;
        padding: 36px 40px;
        margin-bottom: 28px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(10, 26, 10, 0.15);
    }

    .dash-welcome::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -5%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dash-welcome::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dash-welcome .welcome-inner {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .dash-welcome .welcome-left {
        color: #ffffff;
        flex: 1;
        min-width: 280px;
    }

    .dash-welcome .welcome-left .greeting {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--dash-accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 8px;
        padding: 4px 14px;
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 50px;
    }

    .dash-welcome .welcome-left h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .dash-welcome .welcome-left h1 span {
        color: var(--dash-accent);
    }

    .dash-welcome .welcome-left p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
    }

    .dash-welcome .welcome-right {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dash-welcome .welcome-right .info-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        backdrop-filter: blur(8px);
        color: #ffffff;
    }

    .dash-welcome .welcome-right .info-pill i {
        color: var(--dash-accent);
        font-size: 18px;
    }

    .dash-welcome .welcome-right .info-pill .label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .dash-welcome .welcome-right .info-pill .value {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.2;
        margin-top: 3px;
    }

    /* ============================================= */
    /*  SECTION LABEL                              */
    /* ============================================= */
    .section-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-label h2 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dash-text);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label h2::before {
        content: '';
        width: 4px;
        height: 18px;
        background: linear-gradient(180deg, var(--dash-accent), #b8942e);
        border-radius: 4px;
    }

    .section-label .link {
        font-size: 13px;
        font-weight: 500;
        color: var(--dash-text-muted);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: var(--dash-transition);
    }

    .section-label .link:hover {
        color: var(--dash-accent);
        gap: 8px;
    }

    /* ============================================= */
    /*  STATS GRID                                 */
    /* ============================================= */
    .dash-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .dash-stat {
        position: relative;
        background: var(--dash-card);
        border-radius: var(--dash-radius);
        padding: 24px 24px 22px;
        border: 1px solid var(--dash-border);
        transition: var(--dash-transition);
        overflow: hidden;
        cursor: default;
    }

    .dash-stat:hover {
        transform: translateY(-4px);
        box-shadow: var(--dash-shadow-hover);
        border-color: transparent;
    }

    .dash-stat::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--dash-accent), var(--dash-accent-light));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .dash-stat:hover::after {
        transform: scaleX(1);
    }

    .dash-stat .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .dash-stat .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: var(--dash-transition);
    }

    .dash-stat:hover .stat-icon {
        transform: scale(1.08) rotate(-3deg);
    }

    .dash-stat .stat-icon.green {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
    }
    .dash-stat .stat-icon.orange {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #e65100;
    }
    .dash-stat .stat-icon.blue {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1565c0;
    }
    .dash-stat .stat-icon.purple {
        background: linear-gradient(135deg, #f3e5f5, #e1bee7);
        color: #6a1b9a;
    }
    .dash-stat .stat-icon.teal {
        background: linear-gradient(135deg, #e0f2f1, #b2dfdb);
        color: #00695c;
    }
    .dash-stat .stat-icon.indigo {
        background: linear-gradient(135deg, #e8eaf6, #c5cae9);
        color: #283593;
    }
    .dash-stat .stat-icon.yellow {
        background: linear-gradient(135deg, #fff8e1, #ffecb3);
        color: #f57f17;
    }
    .dash-stat .stat-icon.gold {
        background: linear-gradient(135deg, #fff8e1, #f0d060);
        color: #8a6d1f;
    }

    .dash-stat .stat-badge {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .dash-stat .stat-badge.up {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .dash-stat .stat-badge.plain {
        background: #f0f5f0;
        color: #6a7a6a;
    }

    .dash-stat .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--dash-text);
        line-height: 1;
        letter-spacing: -1px;
        margin-bottom: 6px;
    }

    .dash-stat .stat-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--dash-text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .dash-stat .stat-name i {
        color: var(--dash-accent);
        font-size: 11px;
    }

    /* ============================================= */
    /*  MAIN GRID                                  */
    /* ============================================= */
    .dash-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }

    /* ============================================= */
    /*  CARD COMMON                                */
    /* ============================================= */
    .dash-card {
        background: var(--dash-card);
        border-radius: var(--dash-radius);
        border: 1px solid var(--dash-border);
        overflow: hidden;
        transition: var(--dash-transition);
    }

    .dash-card:hover {
        border-color: rgba(212, 175, 55, 0.4);
        box-shadow: var(--dash-shadow);
    }

    .dash-card .card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid var(--dash-border);
        background: linear-gradient(180deg, #fafcfa, #ffffff);
    }

    .dash-card .card-head h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dash-text);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dash-card .card-head h3 .icon-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(212, 175, 55, 0.1);
        color: var(--dash-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .dash-card .card-head .view-link {
        font-size: 12px;
        font-weight: 600;
        color: var(--dash-text-muted);
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 50px;
        background: #f0f5f0;
        transition: var(--dash-transition);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dash-card .card-head .view-link:hover {
        background: var(--dash-accent);
        color: var(--dash-primary);
    }

    .dash-card .card-body {
        padding: 8px 0;
    }

    /* ============================================= */
    /*  NEWS LIST ITEM                             */
    /* ============================================= */
    .news-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 24px;
        border-bottom: 1px solid #f5f8f5;
        transition: var(--dash-transition);
        text-decoration: none;
        color: inherit;
    }

    .news-item:last-child {
        border-bottom: none;
    }

    .news-item:hover {
        background: #fafcfa;
        padding-left: 28px;
    }

    .news-item .news-thumb {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2e7d32;
        font-size: 18px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .news-item .news-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-item .news-info {
        flex: 1;
        min-width: 0;
    }

    .news-item .news-info .news-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dash-text);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-item .news-info .news-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 12px;
        color: var(--dash-text-light);
    }

    .news-item .news-info .news-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .news-item .news-info .news-meta i {
        font-size: 10px;
        color: var(--dash-accent);
    }

    .news-item .news-status {
        flex-shrink: 0;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 12px;
        border-radius: 50px;
    }

    .news-item .news-status.published {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .news-item .news-status.draft {
        background: #fff3e0;
        color: #e65100;
    }

    /* ============================================= */
    /*  QUICK ACTIONS GRID                         */
    /* ============================================= */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 16px;
    }

    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 18px 12px;
        background: #fafcfa;
        border: 1px solid var(--dash-border);
        border-radius: 12px;
        text-decoration: none;
        color: var(--dash-text);
        font-size: 12px;
        font-weight: 600;
        transition: var(--dash-transition);
        text-align: center;
    }

    .quick-btn:hover {
        background: #ffffff;
        border-color: var(--dash-accent);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .quick-btn .quick-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: var(--dash-transition);
    }

    .quick-btn:hover .quick-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .quick-btn .quick-icon.green { background: #e8f5e9; color: #2e7d32; }
    .quick-btn .quick-icon.blue { background: #e3f2fd; color: #1565c0; }
    .quick-btn .quick-icon.orange { background: #fff3e0; color: #e65100; }
    .quick-btn .quick-icon.purple { background: #f3e5f5; color: #6a1b9a; }
    .quick-btn .quick-icon.teal { background: #e0f2f1; color: #00695c; }
    .quick-btn .quick-icon.indigo { background: #e8eaf6; color: #283593; }
    .quick-btn .quick-icon.gold { background: #fff8e1; color: #8a6d1f; }
    .quick-btn .quick-icon.red { background: #fef2f2; color: #991b1b; }

    /* ============================================= */
    /*  SYSTEM INFO BAR                            */
    /* ============================================= */
    .sys-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .sys-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: var(--dash-card);
        border-radius: 14px;
        border: 1px solid var(--dash-border);
        transition: var(--dash-transition);
    }

    .sys-card:hover {
        border-color: var(--dash-accent);
        transform: translateY(-2px);
        box-shadow: var(--dash-shadow);
    }

    .sys-card .sys-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f0f5f0, #e0e8e0);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4a5a4a;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sys-card .sys-info .sys-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--dash-text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .sys-card .sys-info .sys-value {
        font-size: 14px;
        font-weight: 700;
        color: var(--dash-text);
    }

    /* ============================================= */
    /*  EMPTY STATE                                */
    /* ============================================= */
    .dash-empty {
        text-align: center;
        padding: 40px 20px;
        color: var(--dash-text-light);
    }

    .dash-empty i {
        font-size: 40px;
        opacity: 0.15;
        display: block;
        margin-bottom: 12px;
        color: var(--dash-accent);
    }

    .dash-empty h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--dash-text-muted);
        margin-bottom: 4px;
    }

    .dash-empty p {
        font-size: 13px;
    }

    /* ============================================= */
    /*  RESPONSIVE                                 */
    /* ============================================= */
    @media (max-width: 1200px) {
        .dash-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .dash-grid {
            grid-template-columns: 1fr;
        }

        .dash-welcome {
            padding: 28px 24px;
        }

        .dash-welcome .welcome-left h1 {
            font-size: 22px;
        }

        .sys-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .dash-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .dash-stat {
            padding: 18px 16px;
        }

        .dash-stat .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }

        .dash-stat .stat-value {
            font-size: 24px;
        }

        .dash-welcome {
            padding: 24px 20px;
            border-radius: 16px;
        }

        .dash-welcome .welcome-left h1 {
            font-size: 20px;
        }

        .dash-welcome .welcome-right {
            width: 100%;
        }

        .dash-welcome .welcome-right .info-pill {
            flex: 1;
            padding: 10px 14px;
        }

        .dash-welcome .welcome-right .info-pill .value {
            font-size: 12px;
        }

        .sys-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .dash-stats {
            grid-template-columns: 1fr;
        }

        .dash-stat .stat-value {
            font-size: 28px;
        }

        .dash-welcome .welcome-left h1 {
            font-size: 18px;
        }

        .dash-welcome .welcome-left p {
            font-size: 13px;
        }

        .dash-card .card-head {
            padding: 16px 18px;
        }

        .news-item {
            padding: 12px 18px;
        }

        .news-item:hover {
            padding-left: 22px;
        }

        .quick-grid {
            padding: 12px;
        }
    }
</style>

<!-- ============================================= -->
<!-- WELCOME BANNER                             -->
<!-- ============================================= -->
<div class="dash-welcome">
    <div class="welcome-inner">
        <div class="welcome-left">
            <div class="greeting">
                <i class="fas fa-hand-sparkles"></i>
                Selamat Datang
            </div>
            <h1>Halo, <span>{{ Auth::user()->name }}</span></h1>
            <p>Kelola konten dan informasi desa dengan mudah melalui dashboard ini</p>
        </div>
        <div class="welcome-right">
            <div class="info-pill">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <div class="label">Hari Ini</div>
                    <div class="value">{{ now()->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>
            <div class="info-pill">
                <i class="fas fa-clock"></i>
                <div>
                    <div class="label">Waktu</div>
                    <div class="value">{{ now()->format('H:i') }} WIB</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================= -->
<!-- STATISTICS                                  -->
<!-- ============================================= -->
<div class="section-label">
    <h2>Ringkasan Statistik</h2>
    <a href="{{ route('admin.dashboard') }}" class="link">
        Refresh <i class="fas fa-sync-alt"></i>
    </a>
</div>

<div class="dash-stats">
    <!-- Berita -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon green">
                <i class="fas fa-newspaper"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_news'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Total Berita
        </div>
    </div>

    <!-- Pengumuman -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon orange">
                <i class="fas fa-bullhorn"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_announcements'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Pengumuman
        </div>
    </div>

    <!-- Agenda -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_agendas'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Agenda
        </div>
    </div>

    <!-- Galeri -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon purple">
                <i class="fas fa-images"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_gallery'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Galeri
        </div>
    </div>

    <!-- UMKM -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon teal">
                <i class="fas fa-store"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_umkm'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> UMKM
        </div>
    </div>

    <!-- Perangkat Desa -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon indigo">
                <i class="fas fa-users"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-chart-line"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_officials'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Perangkat Desa
        </div>
    </div>

    <!-- Slider Aktif -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon gold">
                <i class="fas fa-sliders-h"></i>
            </div>
            <span class="stat-badge up">
                <i class="fas fa-check-circle"></i> Aktif
            </span>
        </div>
        <div class="stat-value">{{ number_format($stats['total_sliders_active'], 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Slider Aktif
        </div>
    </div>

    <!-- Total Konten -->
    <div class="dash-stat">
        <div class="stat-top">
            <div class="stat-icon yellow">
                <i class="fas fa-folder-open"></i>
            </div>
            <span class="stat-badge plain">
                <i class="fas fa-layer-group"></i> Semua
            </span>
        </div>
        @php
            $totalContent = $stats['total_news'] + $stats['total_announcements'] + $stats['total_agendas'] + $stats['total_gallery'];
        @endphp
        <div class="stat-value">{{ number_format($totalContent, 0, ',', '.') }}</div>
        <div class="stat-name">
            <i class="fas fa-circle"></i> Total Konten
        </div>
    </div>
</div>

<!-- ============================================= -->
<!-- MAIN GRID                                   -->
<!-- ============================================= -->
<div class="dash-grid">
    <!-- RECENT NEWS -->
    <div class="dash-card">
        <div class="card-head">
            <h3>
                <span class="icon-box"><i class="fas fa-clock"></i></span>
                Berita Terbaru
            </h3>
            <a href="{{ route('admin.news.index') }}" class="view-link">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card-body">
            @if($recentNews->isNotEmpty())
                @foreach($recentNews as $news)
                    <a href="{{ route('admin.news.edit', $news) }}" class="news-item">
                        <div class="news-thumb">
                            @if($news->thumbnail)
                                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}">
                            @else
                                <i class="fas fa-newspaper"></i>
                            @endif
                        </div>
                        <div class="news-info">
                            <div class="news-title">{{ $news->title }}</div>
                            <div class="news-meta">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    {{ $news->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-clock"></i>
                                    {{ $news->created_at->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>
                        <span class="news-status {{ $news->status === 'published' ? 'published' : 'draft' }}">
                            {{ $news->status === 'published' ? 'Published' : 'Draft' }}
                        </span>
                    </a>
                @endforeach
            @else
                <div class="dash-empty">
                    <i class="fas fa-newspaper"></i>
                    <h4>Belum Ada Berita</h4>
                    <p>Mulai tambahkan berita pertama Anda</p>
                </div>
            @endif
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="dash-card">
        <div class="card-head">
            <h3>
                <span class="icon-box"><i class="fas fa-bolt"></i></span>
                Akses Cepat
            </h3>
        </div>

        <div class="quick-grid">
            <a href="{{ route('admin.news.create') }}" class="quick-btn">
                <div class="quick-icon green"><i class="fas fa-newspaper"></i></div>
                Berita
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="quick-btn">
                <div class="quick-icon orange"><i class="fas fa-bullhorn"></i></div>
                Pengumuman
            </a>
            <a href="{{ route('admin.agendas.create') }}" class="quick-btn">
                <div class="quick-icon blue"><i class="fas fa-calendar-plus"></i></div>
                Agenda
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="quick-btn">
                <div class="quick-icon purple"><i class="fas fa-image"></i></div>
                Galeri
            </a>
            <a href="{{ route('admin.sliders.create') }}" class="quick-btn">
                <div class="quick-icon gold"><i class="fas fa-sliders-h"></i></div>
                Slider
            </a>
            <a href="{{ route('admin.officials.create') }}" class="quick-btn">
                <div class="quick-icon indigo"><i class="fas fa-user-plus"></i></div>
                Perangkat
            </a>
            <a href="{{ route('admin.umkm.create') }}" class="quick-btn">
                <div class="quick-icon teal"><i class="fas fa-store"></i></div>
                UMKM
            </a>
            <a href="{{ route('admin.potentials.create') }}" class="quick-btn">
                <div class="quick-icon red"><i class="fas fa-seedling"></i></div>
                Potensi
            </a>
        </div>
    </div>
</div>

<!-- ============================================= -->
<!-- SYSTEM INFO                                 -->
<!-- ============================================= -->
<div class="section-label">
    <h2>Informasi Sistem</h2>
</div>

<div class="sys-grid">
    <div class="sys-card">
        <div class="sys-icon">
            <i class="fas fa-code"></i>
        </div>
        <div class="sys-info">
            <div class="sys-label">Framework</div>
            <div class="sys-value">Laravel v{{ app()->version() }}</div>
        </div>
    </div>

    <div class="sys-card">
        <div class="sys-icon">
            <i class="fas fa-database"></i>
        </div>
        <div class="sys-info">
            <div class="sys-label">Database</div>
            <div class="sys-value">MySQL</div>
        </div>
    </div>

    <div class="sys-card">
        <div class="sys-icon">
            <i class="fab fa-php"></i>
        </div>
        <div class="sys-info">
            <div class="sys-label">PHP Version</div>
            <div class="sys-value">v{{ PHP_VERSION }}</div>
        </div>
    </div>
</div>
@endsection