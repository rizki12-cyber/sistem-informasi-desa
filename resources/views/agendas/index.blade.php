@extends('layouts.app')

@section('title', 'Agenda Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Agenda kegiatan dan acara ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .agenda-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .agenda-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .agenda-header .container {
        position: relative;
        z-index: 1;
    }

    .agenda-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .agenda-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .agenda-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .agenda-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .agenda-header .breadcrumb .current {
        color: #d4af37;
    }

    .agenda-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .agenda-header h1 span {
        color: #d4af37;
    }

    .agenda-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .agenda-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .agenda-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .agenda-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .agenda-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .agenda-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== SECTION ===== */
    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef3ee;
    }

    .section-title .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(212, 175, 55, 0.12);
        color: #d4af37;
        font-size: 18px;
    }

    .section-title h2 {
        font-size: 22px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0;
    }

    .section-title .count {
        margin-left: auto;
        font-size: 14px;
        color: #8a9a8a;
        font-weight: 500;
    }

    .section-title .count strong {
        color: #0a1a0a;
    }

    /* ===== AGENDA LIST ===== */
    .agenda-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 40px;
    }

    .agenda-item {
        display: flex;
        gap: 20px;
        padding: 20px 24px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #eef3ee;
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        align-items: center;
    }

    .agenda-item:hover {
        transform: translateX(6px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-color: #d4af37;
    }

    .agenda-item .date-box {
        min-width: 70px;
        text-align: center;
        background: #f8faf8;
        border-radius: 14px;
        padding: 12px 8px;
        flex-shrink: 0;
        border: 1px solid #eef3ee;
        transition: all 0.3s ease;
    }

    .agenda-item:hover .date-box {
        background: rgba(212, 175, 55, 0.06);
        border-color: #d4af37;
    }

    .agenda-item .date-box .day {
        font-size: 26px;
        font-weight: 700;
        color: #0a1a0a;
        line-height: 1;
    }

    .agenda-item .date-box .month {
        font-size: 11px;
        color: #6a7a6a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .agenda-item .info {
        flex: 1;
        min-width: 0;
    }

    .agenda-item .info h4 {
        font-size: 17px;
        font-weight: 600;
        color: #0a1a0a;
        margin-bottom: 4px;
        transition: color 0.3s ease;
    }

    .agenda-item:hover .info h4 {
        color: #d4af37;
    }

    .agenda-item .info .details {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 14px;
        color: #6a7a6a;
    }

    .agenda-item .info .details span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .agenda-item .info .details i {
        color: #d4af37;
        width: 16px;
        font-size: 13px;
    }

    .agenda-item .status-badge {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .agenda-item .status-badge.upcoming {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .agenda-item .status-badge.ongoing {
        background: #fff3e0;
        color: #e65100;
        animation: pulse-badge 2s ease-in-out infinite;
    }

    .agenda-item .status-badge.completed {
        background: #f5f5f5;
        color: #8a8a8a;
    }

    @keyframes pulse-badge {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    /* ===== COMPLETED AGENDA ===== */
    .agenda-item.completed {
        opacity: 0.7;
    }

    .agenda-item.completed:hover {
        opacity: 0.9;
    }

    .agenda-item.completed .date-box {
        background: #f5f5f5;
    }

    .agenda-item.completed .date-box .day,
    .agenda-item.completed .date-box .month {
        color: #8a8a8a;
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

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: #ffffff;
        border-radius: 20px;
        border: 2px dashed #eef3ee;
        margin-bottom: 40px;
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
        .agenda-header h1 {
            font-size: 34px;
        }

        .agenda-header p {
            font-size: 16px;
        }

        .agenda-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .agenda-header .header-stats .stat-item .number {
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .agenda-header {
            padding: 120px 0 40px;
        }

        .agenda-header h1 {
            font-size: 28px;
        }

        .agenda-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .agenda-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .agenda-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .agenda-page {
            padding: 40px 0 60px;
        }

        .section-title h2 {
            font-size: 18px;
        }

        .agenda-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 18px;
        }

        .agenda-item .date-box {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: auto;
            padding: 8px 16px;
            width: 100%;
        }

        .agenda-item .date-box .day {
            font-size: 20px;
        }

        .agenda-item .info h4 {
            font-size: 15px;
        }

        .agenda-item .info .details {
            gap: 10px;
            font-size: 13px;
        }

        .agenda-item .status-badge {
            font-size: 11px;
            padding: 4px 12px;
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
        .agenda-header h1 {
            font-size: 22px;
        }

        .agenda-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .agenda-item {
            padding: 14px 14px;
        }

        .agenda-item .info h4 {
            font-size: 14px;
        }

        .agenda-item .info .details {
            font-size: 12px;
            gap: 8px;
            flex-direction: column;
            align-items: flex-start;
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
<div class="agenda-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Agenda Desa</span>
        </div>
        <h1>Agenda <span>Desa</span></h1>
        <p>Kegiatan, acara, dan jadwal penting di desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $agendas->total() + $pastAgendas->count() }}</span>
                <span class="label">Total Agenda</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $agendas->count() }}</span>
                <span class="label">Akan Datang</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $pastAgendas->count() }}</span>
                <span class="label">Telah Terlaksana</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="agenda-page">
    <div class="container">
        <!-- AGENDA MENDATANG -->
        @if($agendas->isNotEmpty())
            <div class="section-title">
                <span class="icon"><i class="fas fa-calendar-check"></i></span>
                <h2>Agenda Mendatang</h2>
                <span class="count"><strong>{{ $agendas->count() }}</strong> kegiatan</span>
            </div>

            <div class="agenda-list">
                @foreach($agendas as $item)
                    <div class="agenda-item">
                        <div class="date-box">
                            <div class="day">{{ $item->event_date->format('d') }}</div>
                            <div class="month">{{ $item->event_date->format('M Y') }}</div>
                        </div>
                        <div class="info">
                            <h4>{{ $item->title }}</h4>
                            <div class="details">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $item->location }}</span>
                                @if($item->start_time)
                                    <span><i class="fas fa-clock"></i> {{ $item->formatted_time }}</span>
                                @endif
                                @if($item->description)
                                    <span><i class="fas fa-info-circle"></i> {{ Str::limit($item->description, 60) }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="status-badge {{ $item->status === 'ongoing' ? 'ongoing' : 'upcoming' }}">
                            @if($item->status === 'upcoming') Akan Datang
                            @elseif($item->status === 'ongoing') Berlangsung
                            @else Selesai @endif
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $agendas->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Belum Ada Agenda</h3>
                <p>Belum ada agenda kegiatan yang direncanakan. Pantau terus website ini untuk informasi jadwal kegiatan desa.</p>
            </div>
        @endif

        <!-- AGENDA TERLAKSANA -->
        @if($pastAgendas->isNotEmpty())
            <div class="section-title" style="margin-top: 48px;">
                <span class="icon" style="background: rgba(138, 138, 138, 0.12); color: #8a8a8a;">
                    <i class="fas fa-check-circle"></i>
                </span>
                <h2 style="color: #6a7a6a;">Agenda Terlaksana</h2>
                <span class="count"><strong>{{ $pastAgendas->count() }}</strong> kegiatan</span>
            </div>

            <div class="agenda-list">
                @foreach($pastAgendas as $item)
                    <div class="agenda-item completed">
                        <div class="date-box">
                            <div class="day">{{ $item->event_date->format('d') }}</div>
                            <div class="month">{{ $item->event_date->format('M Y') }}</div>
                        </div>
                        <div class="info">
                            <h4>{{ $item->title }}</h4>
                            <div class="details">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $item->location }}</span>
                                @if($item->start_time)
                                    <span><i class="fas fa-clock"></i> {{ $item->formatted_time }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="status-badge completed">Selesai</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection