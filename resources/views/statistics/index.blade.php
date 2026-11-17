@extends('layouts.app')

@section('title', 'Statistik Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Data statistik dan informasi demografi ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .statistics-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .statistics-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .statistics-header .container {
        position: relative;
        z-index: 1;
    }

    .statistics-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .statistics-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .statistics-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .statistics-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .statistics-header .breadcrumb .current {
        color: #d4af37;
    }

    .statistics-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .statistics-header h1 span {
        color: #d4af37;
    }

    .statistics-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .statistics-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .statistics-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .statistics-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .statistics-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .statistics-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== TOOLBAR ===== */
    .statistics-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 36px;
        padding: 14px 24px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #eef3ee;
    }

    .statistics-toolbar .total {
        font-size: 14px;
        color: #6a7a6a;
    }

    .statistics-toolbar .total strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    .statistics-toolbar .info {
        font-size: 13px;
        color: #8a9a8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .statistics-toolbar .info .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d4af37;
    }

    /* ===== STATISTICS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        max-width: 960px;
        margin: 0 auto;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 20px 28px;
        text-align: center;
        border: 1px solid #eef3ee;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, #d4af37, transparent);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .stat-card .icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: rgba(212, 175, 55, 0.08);
        margin-bottom: 14px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .icon-wrapper {
        background: rgba(212, 175, 55, 0.15);
        transform: scale(1.05);
    }

    .stat-card .icon-wrapper .icon {
        font-size: 28px;
        color: #d4af37;
    }

    .stat-card .number {
        font-size: 38px;
        font-weight: 700;
        color: #0a1a0a;
        line-height: 1.1;
        letter-spacing: -0.5px;
        display: block;
    }

    .stat-card .number .prefix,
    .stat-card .number .suffix {
        font-size: 18px;
        font-weight: 400;
        color: #6a7a6a;
    }

    .stat-card .label {
        font-size: 14px;
        color: #6a7a6a;
        margin-top: 4px;
        font-weight: 500;
    }

    .stat-card .label i {
        color: #d4af37;
        font-size: 12px;
        margin-right: 4px;
    }

    .stat-card .order-badge {
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 11px;
        color: #c8dcc8;
        font-weight: 600;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .statistics-header h1 {
            font-size: 34px;
        }

        .statistics-header p {
            font-size: 16px;
        }

        .statistics-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .statistics-header .header-stats .stat-item .number {
            font-size: 22px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 640px;
        }
    }

    @media (max-width: 768px) {
        .statistics-header {
            padding: 120px 0 40px;
        }

        .statistics-header h1 {
            font-size: 28px;
        }

        .statistics-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .statistics-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .statistics-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .statistics-page {
            padding: 40px 0 60px;
        }

        .statistics-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
        }

        .statistics-toolbar .total {
            text-align: center;
        }

        .statistics-toolbar .info {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            max-width: 100%;
        }

        .stat-card {
            padding: 24px 16px 20px;
        }

        .stat-card .icon-wrapper {
            width: 52px;
            height: 52px;
        }

        .stat-card .icon-wrapper .icon {
            font-size: 22px;
        }

        .stat-card .number {
            font-size: 30px;
        }

        .stat-card .number .prefix,
        .stat-card .number .suffix {
            font-size: 15px;
        }

        .stat-card .label {
            font-size: 13px;
        }

        .stat-card .order-badge {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .statistics-header h1 {
            font-size: 22px;
        }

        .statistics-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-card {
            padding: 18px 12px 16px;
            border-radius: 14px;
        }

        .stat-card .icon-wrapper {
            width: 44px;
            height: 44px;
            margin-bottom: 10px;
        }

        .stat-card .icon-wrapper .icon {
            font-size: 18px;
        }

        .stat-card .number {
            font-size: 24px;
        }

        .stat-card .number .prefix,
        .stat-card .number .suffix {
            font-size: 13px;
        }

        .stat-card .label {
            font-size: 11px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="statistics-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Statistik Desa</span>
        </div>
        <h1>Statistik <span>Desa</span></h1>
        <p>Data terkini, informasi demografi, dan profil desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $statistics->count() }}</span>
                <span class="label">Total Data</span>
            </div>
            <div class="stat-item">
                <span class="number">
                    @php
                        $totalPenduduk = $statistics->where('label', 'Penduduk')->first();
                    @endphp
                    {{ $totalPenduduk ? $totalPenduduk->value : '-' }}
                </span>
                <span class="label">Total Penduduk</span>
            </div>
            <div class="stat-item">
                <span class="number">
                    @php
                        $totalKK = $statistics->where('label', 'Kepala Keluarga')->first();
                    @endphp
                    {{ $totalKK ? $totalKK->value : '-' }}
                </span>
                <span class="label">Kepala Keluarga</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="statistics-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="statistics-toolbar">
            <div class="total">
                Menampilkan <strong>{{ $statistics->count() }}</strong> data statistik desa
            </div>
            <div class="info">
                <span class="dot"></span>
                <span>Data terkini {{ date('F Y') }}</span>
            </div>
        </div>

        @if($statistics->isNotEmpty())
            <div class="stats-grid">
                @foreach($statistics as $stat)
                    <div class="stat-card">
                        <div class="order-badge">#{{ $loop->iteration }}</div>
                        
                        @if($stat->icon)
                            <div class="icon-wrapper">
                                <div class="icon"><i class="fas fa-{{ $stat->icon }}"></i></div>
                            </div>
                        @endif
                        
                        <span class="number">
                            @php
                                $number = $stat->value;
                                // Cek apakah angka mengandung tanda baca seperti titik atau koma
                                if (preg_match('/^[\d.,]+$/', $number)) {
                                    echo $number;
                                } else {
                                    echo $number;
                                }
                            @endphp
                        </span>
                        <div class="label">
                            <i class="fas fa-chevron-right"></i> 
                            {{ $stat->label }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Belum Ada Data Statistik</h3>
                <p>Data statistik desa belum tersedia. Silakan hubungi administrator untuk menambahkan informasi statistik desa.</p>
            </div>
        @endif
    </div>
</div>

<style>
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

    @media (max-width: 768px) {
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
</style>

<script>
    // ===== ANIMASI COUNTER =====
    document.addEventListener('DOMContentLoaded', function() {
        const numberElements = document.querySelectorAll('.stat-card .number');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const text = el.textContent.trim();
                        
                        // Cek apakah teks adalah angka (dengan atau tanpa titik/koma)
                        const numStr = text.replace(/[.,]/g, '');
                        if (!isNaN(numStr) && numStr.length > 0) {
                            const target = parseInt(numStr);
                            if (target > 0 && target < 1000000) {
                                animateNumber(el, target, 1000);
                            }
                        }
                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.3 });
            
            numberElements.forEach(function(el) {
                observer.observe(el);
            });
        }
        
        function animateNumber(element, target, duration) {
            const startTime = performance.now();
            const startValue = 0;
            
            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (easeOutQuart)
                const eased = 1 - Math.pow(1 - progress, 4);
                const current = Math.round(startValue + (target - startValue) * eased);
                
                // Format dengan titik ribuan
                element.textContent = current.toLocaleString('id-ID');
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }
            
            requestAnimationFrame(update);
        }
    });
</script>
@endsection