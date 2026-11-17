@extends('layouts.app')

@section('title', 'Pengumuman Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Pengumuman resmi dan informasi penting dari ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .announcement-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .announcement-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .announcement-header .container {
        position: relative;
        z-index: 1;
    }

    .announcement-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .announcement-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .announcement-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .announcement-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .announcement-header .breadcrumb .current {
        color: #d4af37;
    }

    .announcement-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .announcement-header h1 span {
        color: #d4af37;
    }

    .announcement-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .announcement-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .announcement-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .announcement-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .announcement-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .announcement-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== TOOLBAR ===== */
    .announcement-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
        padding: 14px 24px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #eef3ee;
    }

    .announcement-toolbar .total {
        font-size: 14px;
        color: #6a7a6a;
    }

    .announcement-toolbar .total strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    .announcement-toolbar .filter-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #8a9a8a;
    }

    .announcement-toolbar .filter-info .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d4af37;
    }

    /* ===== ANNOUNCEMENT LIST ===== */
    .announcement-list {
        max-width: 820px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .announcement-item {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 32px;
        border: 1px solid #eef3ee;
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .announcement-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #d4af37, rgba(212, 175, 55, 0.2));
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .announcement-item:hover::before {
        opacity: 1;
    }

    .announcement-item:hover {
        transform: translateX(6px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-color: #d4af37;
    }

    .announcement-item .top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }

    .announcement-item .date {
        font-size: 13px;
        color: #8a9a8a;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        background: #f8faf8;
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 500;
    }

    .announcement-item .date i {
        color: #d4af37;
        font-size: 12px;
    }

    .announcement-item .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #e8f5e9;
        color: #2e7d32;
        flex-shrink: 0;
    }

    .announcement-item .badge-status .dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #2e7d32;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.8); }
    }

    .announcement-item h3 {
        font-size: 20px;
        font-weight: 600;
        color: #0a1a0a;
        margin: 12px 0 8px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .announcement-item:hover h3 {
        color: #d4af37;
    }

    .announcement-item .excerpt {
        color: #5a6a5a;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .announcement-item .bottom-row {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f0f5f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .announcement-item .bottom-row .meta {
        font-size: 13px;
        color: #8a9a8a;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .announcement-item .bottom-row .meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .announcement-item .bottom-row .meta i {
        color: #d4af37;
        font-size: 12px;
        width: 16px;
    }

    .announcement-item .bottom-row .read-more {
        color: #0a1a0a;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        padding-bottom: 2px;
    }

    .announcement-item .bottom-row .read-more:hover {
        color: #d4af37;
        border-bottom-color: #d4af37;
        gap: 10px;
    }

    /* ===== PAGINATION ===== */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination-container nav {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-container nav a,
    .pagination-container nav span {
        padding: 8px 16px;
        border: 1px solid #eef3ee;
        border-radius: 8px;
        color: #4a5a4a;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        min-width: 40px;
        text-align: center;
    }

    .pagination-container nav a:hover {
        background: #d4af37;
        color: #0a1a0a;
        border-color: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }

    .pagination-container nav span {
        background: #d4af37;
        color: #0a1a0a;
        border-color: #d4af37;
    }

    .pagination-container nav .disabled {
        opacity: 0.4;
        pointer-events: none;
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
        .announcement-header h1 {
            font-size: 34px;
        }

        .announcement-header p {
            font-size: 16px;
        }

        .announcement-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .announcement-header .header-stats .stat-item .number {
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .announcement-header {
            padding: 120px 0 40px;
        }

        .announcement-header h1 {
            font-size: 28px;
        }

        .announcement-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .announcement-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .announcement-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .announcement-page {
            padding: 40px 0 60px;
        }

        .announcement-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
            gap: 8px;
        }

        .announcement-toolbar .total {
            text-align: center;
        }

        .announcement-toolbar .filter-info {
            justify-content: center;
        }

        .announcement-item {
            padding: 20px 20px;
        }

        .announcement-item .top-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .announcement-item h3 {
            font-size: 17px;
            margin-top: 8px;
        }

        .announcement-item .excerpt {
            font-size: 14px;
        }

        .announcement-item .bottom-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .announcement-item .bottom-row .meta {
            flex-wrap: wrap;
            gap: 12px;
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
        .announcement-header h1 {
            font-size: 22px;
        }

        .announcement-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .announcement-item {
            padding: 16px 16px;
        }

        .announcement-item h3 {
            font-size: 15px;
        }

        .announcement-item .excerpt {
            font-size: 13px;
        }

        .announcement-item .date {
            font-size: 12px;
            padding: 2px 12px;
        }

        .pagination-container nav a,
        .pagination-container nav span {
            padding: 6px 12px;
            font-size: 13px;
            min-width: 34px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="announcement-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Pengumuman Desa</span>
        </div>
        <h1>Pengumuman <span>Desa</span></h1>
        <p>Informasi penting, pengumuman resmi, dan pemberitahuan dari desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $announcements->total() }}</span>
                <span class="label">Total Pengumuman</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $announcements->count() }}</span>
                <span class="label">Pengumuman Terbaru</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="announcement-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="announcement-toolbar">
            <div class="total">
                Menampilkan <strong>{{ $announcements->firstItem() ?? 0 }}</strong> - <strong>{{ $announcements->lastItem() ?? 0 }}</strong> dari <strong>{{ $announcements->total() }}</strong> pengumuman
            </div>
            <div class="filter-info">
                <span class="dot"></span>
                <span>Pengumuman resmi pemerintah desa</span>
            </div>
        </div>

        @if($announcements->isNotEmpty())
            <div class="announcement-list">
                @foreach($announcements as $item)
                    <div class="announcement-item">
                        <div class="top-row">
                            <div class="date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $item->formatted_date }}
                            </div>
                            <span class="badge-status">
                                <span class="dot"></span>
                                Terbaru
                            </span>
                        </div>

                        <h3>{{ $item->title }}</h3>
                        <p class="excerpt">{{ $item->excerpt }}</p>

                        <div class="bottom-row">
                            <div class="meta">
                                <span>
                                    <i class="fas fa-clock"></i>
                                    {{ $item->published_at ? $item->published_at->format('H:i') . ' WIB' : '-' }}
                                </span>
                                @if($item->status === 'published')
                                    <span>
                                        <i class="fas fa-check-circle" style="color:#2e7d32;"></i>
                                        Dipublikasikan
                                    </span>
                                @endif
                            </div>
                            <a href="#" class="read-more" onclick="event.preventDefault(); alert('Pengumuman: {{ $item->title }}');">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h3>Belum Ada Pengumuman</h3>
                <p>Belum ada pengumuman yang dipublikasikan. Pantau terus website ini untuk informasi penting dari desa kami.</p>
            </div>
        @endif
    </div>
</div>
@endsection