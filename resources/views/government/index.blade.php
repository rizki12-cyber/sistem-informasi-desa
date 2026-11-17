@extends('layouts.app')

@section('title', 'Pemerintahan Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Struktur pemerintahan dan perangkat desa ' . ($profile->village_name ?? ''))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .gov-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .gov-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .gov-header::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.04) 0%, transparent 70%);
        border-radius: 50%;
    }

    .gov-header .container {
        position: relative;
        z-index: 1;
    }

    .gov-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .gov-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .gov-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .gov-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .gov-header .breadcrumb .current {
        color: #d4af37;
    }

    .gov-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .gov-header h1 span {
        color: #d4af37;
    }

    .gov-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .gov-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .gov-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .gov-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .gov-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .gov-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    .gov-page .section-intro {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 48px;
    }

    .gov-page .section-intro h2 {
        font-size: 28px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 8px;
    }

    .gov-page .section-intro h2 span {
        color: #d4af37;
    }

    .gov-page .section-intro p {
        color: #6a7a6a;
        font-size: 16px;
        line-height: 1.8;
    }

    /* ===== ORGANIZATION CHART ===== */
    .org-chart-wrapper {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #eef3ee;
        padding: 40px 20px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .org-chart {
        overflow-x: auto;
        overflow-y: visible;
        padding: 10px 0;
        -webkit-overflow-scrolling: touch;
    }

    .org-chart::-webkit-scrollbar {
        height: 6px;
    }

    .org-chart::-webkit-scrollbar-track {
        background: #f0f5f0;
        border-radius: 10px;
    }

    .org-chart::-webkit-scrollbar-thumb {
        background: #d4af37;
        border-radius: 10px;
    }

    .org-chart .org-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: fit-content;
        padding: 0 20px;
        min-width: 100%;
    }

    /* ===== TREE LEVEL ===== */
    .org-level {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
        padding: 0 10px;
        width: 100%;
    }

    .org-level:not(:last-child) {
        padding-bottom: 36px;
    }

    /* ===== NODE WRAPPER ===== */
    .org-node-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 12px;
        position: relative;
        flex-shrink: 0;
    }

    /* ===== NODE CARD ===== */
    .org-node {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 24px;
        text-align: center;
        border: 2px solid #eef3ee;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        min-width: 140px;
        max-width: 200px;
        position: relative;
        z-index: 2;
        cursor: default;
    }

    .org-node::before {
        content: '';
        position: absolute;
        top: -2px;
        left: 20%;
        right: 20%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #d4af37, transparent);
        border-radius: 0 0 4px 4px;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .org-node:hover::before {
        opacity: 1;
    }

    .org-node:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .org-node .photo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 10px;
        border: 3px solid #eef3ee;
        display: block;
        background: #f8faf8;
        transition: border-color 0.3s ease, transform 0.3s ease;
    }

    .org-node:hover .photo {
        border-color: #d4af37;
        transform: scale(1.03);
    }

    .org-node .photo-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0f5f0, #e0e8e0);
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #8a9a8a;
        border: 3px solid #eef3ee;
        transition: border-color 0.3s ease;
    }

    .org-node:hover .photo-placeholder {
        border-color: #d4af37;
    }

    .org-node .name {
        font-size: 15px;
        font-weight: 600;
        color: #0a1a0a;
        margin-bottom: 2px;
        letter-spacing: -0.2px;
    }

    .org-node .position {
        font-size: 13px;
        color: #d4af37;
        font-weight: 500;
    }

    .org-node .badge-level {
        display: inline-block;
        margin-top: 6px;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f0f5f0;
        color: #6a7a6a;
    }

    .org-node .badge-level.level-1 {
        background: rgba(212, 175, 55, 0.15);
        color: #d4af37;
    }

    .org-node .badge-level.level-2 {
        background: rgba(46, 125, 50, 0.1);
        color: #2e7d32;
    }

    /* ===== CONNECTOR LINES ===== */
    .connector-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        position: relative;
    }

    .vertical-line {
        width: 2px;
        height: 28px;
        background: linear-gradient(180deg, #d4af37, rgba(212, 175, 55, 0.3));
        position: relative;
        margin: 0 auto;
        opacity: 0.5;
    }

    .vertical-line::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d4af37;
        opacity: 0.6;
    }

    .children-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
        padding-top: 18px;
        width: 100%;
    }

    .children-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 8%;
        right: 8%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), rgba(212, 175, 55, 0.5), rgba(212, 175, 55, 0.3), transparent);
        opacity: 0.6;
    }

    .child-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        margin: 0 8px;
        flex: 0 1 auto;
    }

    .child-wrapper::before {
        content: '';
        position: absolute;
        top: -18px;
        left: 50%;
        width: 2px;
        height: 18px;
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.3), rgba(212, 175, 55, 0.5));
        opacity: 0.5;
    }

    .child-wrapper:first-child::before {
        left: 50%;
    }

    .child-wrapper:last-child::before {
        left: 50%;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: #ffffff;
        border-radius: 20px;
        border: 2px dashed #eef3ee;
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
        .gov-header h1 {
            font-size: 34px;
        }

        .gov-header p {
            font-size: 16px;
        }

        .gov-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .gov-header .header-stats .stat-item .number {
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .gov-header {
            padding: 120px 0 40px;
        }

        .gov-header h1 {
            font-size: 28px;
        }

        .gov-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .gov-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .gov-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .gov-page {
            padding: 40px 0 60px;
        }

        .gov-page .section-intro h2 {
            font-size: 22px;
        }

        .org-chart-wrapper {
            padding: 24px 12px;
            border-radius: 16px;
        }

        .org-node {
            padding: 14px 16px;
            min-width: 100px;
            max-width: 140px;
        }

        .org-node .photo,
        .org-node .photo-placeholder {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .org-node .name {
            font-size: 13px;
        }

        .org-node .position {
            font-size: 11px;
        }

        .org-node .badge-level {
            font-size: 9px;
            padding: 1px 8px;
        }

        .org-node-wrapper {
            margin: 0 6px;
        }

        .children-container::before {
            left: 4%;
            right: 4%;
        }

        .child-wrapper {
            margin: 0 4px;
        }

        .org-level:not(:last-child) {
            padding-bottom: 24px;
        }

        .vertical-line {
            height: 18px;
        }

        .child-wrapper::before {
            top: -18px;
            height: 18px;
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
        .gov-header h1 {
            font-size: 22px;
        }

        .gov-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .org-node {
            min-width: 80px;
            max-width: 110px;
            padding: 10px 10px;
        }

        .org-node .photo,
        .org-node .photo-placeholder {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .org-node .name {
            font-size: 11px;
        }

        .org-node .position {
            font-size: 10px;
        }

        .org-node-wrapper {
            margin: 0 4px;
        }

        .org-level:not(:last-child) {
            padding-bottom: 16px;
        }

        .children-container::before {
            left: 2%;
            right: 2%;
        }

        .child-wrapper::before {
            top: -16px;
            height: 16px;
        }

        .vertical-line {
            height: 16px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="gov-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Pemerintahan Desa</span>
        </div>
        <h1>Struktur <span>Pemerintahan</span></h1>
        <p>Perangkat desa yang bertugas melayani dan membangun masyarakat</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $allOfficials->count() ?? 0 }}</span>
                <span class="label">Total Perangkat</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $topOfficials->count() ?? 0 }}</span>
                <span class="label">Pimpinan</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ ($allOfficials->count() ?? 0) - ($topOfficials->count() ?? 0) }}</span>
                <span class="label">Staf Pendukung</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="gov-page">
    <div class="container">
        <div class="section-intro">
            <h2>Bagan <span>Organisasi</span></h2>
            <p>Struktur hierarki perangkat desa yang menunjukkan alur kepemimpinan dan koordinasi dalam pemerintahan desa.</p>
        </div>

        @if($topOfficials->isNotEmpty())
            <div class="org-chart-wrapper">
                <div class="org-chart">
                    <div class="org-wrapper">
                        @php
                            function renderOrgChart($nodes, $level = 0) {
                                if (empty($nodes)) {
                                    return '';
                                }

                                $html = '<div class="org-level">';

                                foreach ($nodes as $node) {
                                    $official = $node['official'];
                                    $children = $node['children'];
                                    $currentLevel = $level + 1;

                                    $html .= '<div class="org-node-wrapper">';

                                    // Node card
                                    $html .= '<div class="org-node">';
                                    if ($official->photo) {
                                        $html .= '<img src="' . asset('storage/' . $official->photo) . '" alt="' . e($official->name) . '" class="photo" loading="lazy">';
                                    } else {
                                        $html .= '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
                                    }
                                    $html .= '<div class="name">' . e($official->name) . '</div>';
                                    $html .= '<div class="position">' . e($official->position) . '</div>';
                                    
                                    // Level badge
                                    $badgeClass = $currentLevel <= 2 ? 'level-' . $currentLevel : '';
                                    $html .= '<span class="badge-level ' . $badgeClass . '">';
                                    if ($currentLevel == 1) {
                                        $html .= 'Pimpinan';
                                    } elseif ($currentLevel == 2) {
                                        $html .= 'Koordinator';
                                    } else {
                                        $html .= 'Pelaksana';
                                    }
                                    $html .= '</span>';
                                    
                                    $html .= '</div>';

                                    // Children with connectors
                                    if (!empty($children)) {
                                        $html .= '<div class="connector-wrapper">';
                                        $html .= '<div class="vertical-line"></div>';
                                        $html .= '<div class="children-container">';

                                        foreach ($children as $child) {
                                            $html .= '<div class="child-wrapper">';
                                            $html .= renderOrgChart([$child], $currentLevel);
                                            $html .= '</div>';
                                        }

                                        $html .= '</div>';
                                        $html .= '</div>';
                                    }

                                    $html .= '</div>';
                                }

                                $html .= '</div>';

                                return $html;
                            }
                        @endphp
                        {!! renderOrgChart($hierarchy, 0) !!}
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Belum Ada Perangkat Desa</h3>
                <p>Data perangkat desa belum tersedia. Silakan hubungi administrator untuk menambahkan struktur organisasi desa.</p>
            </div>
        @endif
    </div>
</div>

<!-- ===== LEGEND ===== -->
<div style="padding: 0 0 60px; background: #f8faf8;">
    <div class="container">
        <div style="display:flex;flex-wrap:wrap;gap:20px;justify-content:center;padding:20px 0;border-top:1px solid #eef3ee;">
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#4a5a4a;">
                <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:rgba(212,175,55,0.2);border:2px solid #d4af37;"></span>
                Pimpinan
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#4a5a4a;">
                <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:rgba(46,125,50,0.15);border:2px solid #2e7d32;"></span>
                Koordinator
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#4a5a4a;">
                <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#f0f5f0;border:2px solid #c8dcc8;"></span>
                Pelaksana
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#4a5a4a;padding-left:20px;border-left:1px solid #eef3ee;">
                <span style="display:inline-block;width:20px;height:2px;background:rgba(212,175,55,0.4);"></span>
                Garis Hierarki
            </div>
        </div>
    </div>
</div>

<script>
    // ===== SMOOTH SCROLL FOR CHART =====
    document.addEventListener('DOMContentLoaded', function() {
        // Add touch support for chart scrolling
        const chart = document.querySelector('.org-chart');
        if (chart) {
            let isDown = false;
            let startX;
            let scrollLeft;

            chart.addEventListener('mousedown', function(e) {
                isDown = true;
                startX = e.pageX - chart.offsetLeft;
                scrollLeft = chart.scrollLeft;
                chart.style.cursor = 'grabbing';
            });

            chart.addEventListener('mouseleave', function() {
                isDown = false;
                chart.style.cursor = 'grab';
            });

            chart.addEventListener('mouseup', function() {
                isDown = false;
                chart.style.cursor = 'grab';
            });

            chart.addEventListener('mousemove', function(e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - chart.offsetLeft;
                const walk = (x - startX) * 1.5;
                chart.scrollLeft = scrollLeft - walk;
            });

            chart.style.cursor = 'grab';
        }
    });
</script>

@php
    // Override render function untuk digunakan di view
    $renderOrgChart = function($nodes, $level = 0) use (&$renderOrgChart) {
        if (empty($nodes)) {
            return '';
        }

        $html = '<div class="org-level">';

        foreach ($nodes as $node) {
            $official = $node['official'];
            $children = $node['children'];
            $currentLevel = $level + 1;

            $html .= '<div class="org-node-wrapper">';

            // Node card
            $html .= '<div class="org-node">';
            if ($official->photo) {
                $html .= '<img src="' . asset('storage/' . $official->photo) . '" alt="' . e($official->name) . '" class="photo" loading="lazy">';
            } else {
                $html .= '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
            }
            $html .= '<div class="name">' . e($official->name) . '</div>';
            $html .= '<div class="position">' . e($official->position) . '</div>';
            
            // Level badge
            $badgeClass = $currentLevel <= 2 ? 'level-' . $currentLevel : '';
            $html .= '<span class="badge-level ' . $badgeClass . '">';
            if ($currentLevel == 1) {
                $html .= 'Pimpinan';
            } elseif ($currentLevel == 2) {
                $html .= 'Koordinator';
            } else {
                $html .= 'Pelaksana';
            }
            $html .= '</span>';
            
            $html .= '</div>';

            // Children with connectors
            if (!empty($children)) {
                $html .= '<div class="connector-wrapper">';
                $html .= '<div class="vertical-line"></div>';
                $html .= '<div class="children-container">';

                foreach ($children as $child) {
                    $html .= '<div class="child-wrapper">';
                    $html .= $renderOrgChart([$child], $currentLevel);
                    $html .= '</div>';
                }

                $html .= '</div>';
                $html .= '</div>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    };
@endphp
@endsection