@extends('layouts.app')

@section('title', 'Galeri Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Dokumentasi foto kegiatan dan keindahan ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .gallery-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .gallery-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .gallery-header .container {
        position: relative;
        z-index: 1;
    }

    .gallery-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .gallery-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .gallery-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .gallery-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .gallery-header .breadcrumb .current {
        color: #d4af37;
    }

    .gallery-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .gallery-header h1 span {
        color: #d4af37;
    }

    .gallery-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .gallery-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .gallery-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .gallery-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .gallery-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .gallery-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== TOOLBAR ===== */
    .gallery-toolbar {
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

    .gallery-toolbar .total {
        font-size: 14px;
        color: #6a7a6a;
    }

    .gallery-toolbar .total strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    .gallery-toolbar .view-options {
        display: flex;
        gap: 8px;
    }

    .gallery-toolbar .view-options button {
        padding: 6px 12px;
        border: 1px solid #eef3ee;
        border-radius: 8px;
        background: #ffffff;
        color: #8a9a8a;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px;
    }

    .gallery-toolbar .view-options button:hover {
        border-color: #d4af37;
        color: #0a1a0a;
    }

    .gallery-toolbar .view-options button.active {
        background: #d4af37;
        color: #0a1a0a;
        border-color: #d4af37;
    }

    /* ===== GALLERY GRID ===== */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .gallery-grid.list-view {
        grid-template-columns: 1fr;
    }

    .gallery-grid.list-view .gallery-item {
        aspect-ratio: 16/9;
        display: flex;
        flex-direction: row;
    }

    .gallery-grid.list-view .gallery-item img {
        width: 40%;
        height: 100%;
    }

    .gallery-grid.list-view .gallery-item .overlay {
        position: relative;
        opacity: 1;
        background: #ffffff;
        color: #0a1a0a;
        padding: 20px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .gallery-grid.list-view .gallery-item .overlay h4 {
        color: #0a1a0a;
        font-size: 18px;
    }

    .gallery-grid.list-view .gallery-item .overlay p {
        color: #6a7a6a;
        opacity: 1;
    }

    .gallery-grid.list-view .gallery-item .view-icon {
        display: none;
    }

    .gallery-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 1;
        cursor: pointer;
        background: #eef3ee;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        border: 1px solid #eef3ee;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .gallery-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.06);
    }

    .gallery-item .view-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: rgba(212, 175, 55, 0.9);
        color: #0a1a0a;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        z-index: 2;
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
    }

    .gallery-item:hover .view-icon {
        transform: translate(-50%, -50%) scale(1);
    }

    .gallery-item .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px 20px 18px;
        background: linear-gradient(transparent, rgba(10, 26, 10, 0.75));
        color: #ffffff;
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    .gallery-item .overlay h4 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-item .overlay p {
        font-size: 12px;
        opacity: 0.75;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-item .overlay .meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
        opacity: 0.6;
        margin-top: 4px;
    }

    .gallery-item .overlay .meta i {
        font-size: 10px;
    }

    /* ===== MASONRY VARIANT ===== */
    .gallery-grid.masonry {
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: 280px;
    }

    .gallery-grid.masonry .gallery-item:nth-child(3n+1) {
        grid-row: span 2;
        height: auto;
    }

    .gallery-grid.masonry .gallery-item:nth-child(5n+2) {
        grid-row: span 1.5;
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

    /* ===== LIGHTBOX ===== */
    #lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(10, 26, 10, 0.94);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 40px;
        backdrop-filter: blur(12px);
    }

    #lightbox.active {
        display: flex;
    }

    #lightbox .close-btn {
        position: absolute;
        top: 28px;
        right: 36px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.6);
        font-size: 28px;
        cursor: pointer;
        z-index: 10;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    #lightbox .close-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        transform: rotate(90deg);
    }

    #lightbox .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.4);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    #lightbox .nav-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
    }

    #lightbox .nav-btn.prev {
        left: 24px;
    }

    #lightbox .nav-btn.next {
        right: 24px;
    }

    #lightbox img {
        max-width: 90%;
        max-height: 78vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    #lightbox .caption {
        color: rgba(255, 255, 255, 0.7);
        text-align: center;
        margin-top: 20px;
        font-size: 16px;
        font-weight: 400;
        max-width: 600px;
    }

    #lightbox .caption strong {
        color: #ffffff;
        font-weight: 600;
    }

    #lightbox .counter {
        position: absolute;
        bottom: 28px;
        right: 36px;
        color: rgba(255, 255, 255, 0.2);
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .gallery-grid.masonry {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .gallery-header h1 {
            font-size: 34px;
        }

        .gallery-header p {
            font-size: 16px;
        }

        .gallery-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .gallery-header .header-stats .stat-item .number {
            font-size: 22px;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .gallery-grid.masonry {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 220px;
        }
    }

    @media (max-width: 768px) {
        .gallery-header {
            padding: 120px 0 40px;
        }

        .gallery-header h1 {
            font-size: 28px;
        }

        .gallery-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .gallery-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .gallery-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .gallery-page {
            padding: 40px 0 60px;
        }

        .gallery-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
        }

        .gallery-toolbar .total {
            text-align: center;
        }

        .gallery-toolbar .view-options {
            justify-content: center;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .gallery-grid.masonry {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 180px;
        }

        .gallery-grid.list-view .gallery-item {
            flex-direction: column;
            aspect-ratio: auto;
        }

        .gallery-grid.list-view .gallery-item img {
            width: 100%;
            height: 200px;
        }

        .gallery-grid.list-view .gallery-item .overlay {
            padding: 16px 18px;
        }

        .gallery-grid.list-view .gallery-item .overlay h4 {
            font-size: 16px;
        }

        .gallery-item .view-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .gallery-item .overlay {
            padding: 14px 16px 12px;
        }

        .gallery-item .overlay h4 {
            font-size: 13px;
        }

        #lightbox {
            padding: 20px;
        }

        #lightbox .close-btn {
            width: 44px;
            height: 44px;
            font-size: 22px;
            top: 16px;
            right: 20px;
        }

        #lightbox .nav-btn {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        #lightbox .nav-btn.prev {
            left: 12px;
        }

        #lightbox .nav-btn.next {
            right: 12px;
        }

        #lightbox .counter {
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
        .gallery-header h1 {
            font-size: 22px;
        }

        .gallery-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .gallery-grid {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .gallery-grid.masonry {
            grid-template-columns: 1fr 1fr;
            grid-auto-rows: 140px;
        }

        .gallery-item .view-icon {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }

        .gallery-item .overlay h4 {
            font-size: 11px;
        }

        .gallery-item .overlay p {
            font-size: 10px;
        }

        .pagination-container nav a,
        .pagination-container nav span {
            padding: 6px 12px;
            font-size: 13px;
            min-width: 34px;
        }

        #lightbox .nav-btn {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        #lightbox .nav-btn.prev {
            left: 8px;
        }

        #lightbox .nav-btn.next {
            right: 8px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="gallery-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Galeri Desa</span>
        </div>
        <h1>Galeri <span>Desa</span></h1>
        <p>Dokumentasi kegiatan, keindahan alam, dan potret kehidupan desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $galleries->total() }}</span>
                <span class="label">Total Foto</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $galleries->count() }}</span>
                <span class="label">Foto Ditampilkan</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="gallery-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="gallery-toolbar">
            <div class="total">
                Menampilkan <strong>{{ $galleries->firstItem() ?? 0 }}</strong> - <strong>{{ $galleries->lastItem() ?? 0 }}</strong> dari <strong>{{ $galleries->total() }}</strong> foto
            </div>
            <div class="view-options">
                <button class="active" data-view="grid" title="Tampilan Grid">
                    <i class="fas fa-th"></i>
                </button>
                <button data-view="masonry" title="Tampilan Masonry">
                    <i class="fas fa-th-large"></i>
                </button>
                <button data-view="list" title="Tampilan Daftar">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        @if($galleries->isNotEmpty())
            <div class="gallery-grid" id="galleryGrid">
                @foreach($galleries as $index => $item)
                    <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $item->image) }}', '{{ addslashes($item->title ?? '') }}', '{{ addslashes($item->description ?? '') }}', {{ $index }})">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? 'Galeri' }}" loading="lazy">
                        <div class="view-icon">
                            <i class="fas fa-search-plus"></i>
                        </div>
                        @if($item->title || $item->description)
                            <div class="overlay">
                                @if($item->title)
                                    <h4>{{ Str::limit($item->title, 30) }}</h4>
                                @endif
                                @if($item->description)
                                    <p>{{ Str::limit($item->description, 50) }}</p>
                                @endif
                                <div class="meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $galleries->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-images"></i>
                </div>
                <h3>Belum Ada Foto Galeri</h3>
                <p>Belum ada foto yang ditambahkan ke galeri. Pantau terus website ini untuk melihat dokumentasi kegiatan desa.</p>
            </div>
        @endif
    </div>
</div>

<!-- ===== LIGHTBOX ===== -->
<div id="lightbox">
    <button class="close-btn" onclick="closeLightbox()" aria-label="Tutup">&times;</button>
    <button class="nav-btn prev" id="lightboxPrev" aria-label="Sebelumnya">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="nav-btn next" id="lightboxNext" aria-label="Berikutnya">
        <i class="fas fa-chevron-right"></i>
    </button>
    <img id="lightboxImg" src="" alt="Lightbox">
    <div class="caption" id="lightboxCaption"></div>
    <div class="counter" id="lightboxCounter"></div>
</div>

<script>
    (function() {
        'use strict';

        // ===== GALLERY DATA =====
        var galleryItems = [];
        @foreach($galleries as $index => $item)
            galleryItems.push({
                src: '{{ asset('storage/' . $item->image) }}',
                title: '{{ addslashes($item->title ?? '') }}',
                description: '{{ addslashes($item->description ?? '') }}'
            });
        @endforeach

        var currentIndex = 0;
        var lightbox = document.getElementById('lightbox');
        var lightboxImg = document.getElementById('lightboxImg');
        var lightboxCaption = document.getElementById('lightboxCaption');
        var lightboxCounter = document.getElementById('lightboxCounter');
        var lightboxPrev = document.getElementById('lightboxPrev');
        var lightboxNext = document.getElementById('lightboxNext');

        // ===== OPEN LIGHTBOX =====
        window.openLightbox = function(src, title, description, index) {
            currentIndex = index || 0;
            updateLightbox(currentIndex);
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        // ===== CLOSE LIGHTBOX =====
        window.closeLightbox = function() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        };

        // ===== UPDATE LIGHTBOX =====
        function updateLightbox(index) {
            var item = galleryItems[index];
            if (!item) return;

            lightboxImg.src = item.src;
            lightboxImg.alt = item.title || 'Galeri';

            var captionText = item.title || '';
            if (item.description) {
                captionText += captionText ? ' — ' + item.description : item.description;
            }
            lightboxCaption.innerHTML = captionText ? '<strong>' + item.title + '</strong>' + (item.description ? ' — ' + item.description : '') : '';

            // Counter
            if (galleryItems.length > 1) {
                lightboxCounter.textContent = (index + 1) + ' / ' + galleryItems.length;
                lightboxCounter.style.display = 'block';
            } else {
                lightboxCounter.style.display = 'none';
            }

            // Navigation buttons
            lightboxPrev.style.display = galleryItems.length > 1 ? 'flex' : 'none';
            lightboxNext.style.display = galleryItems.length > 1 ? 'flex' : 'none';
        }

        // ===== NAVIGATION =====
        function goToPrev() {
            if (galleryItems.length <= 1) return;
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            updateLightbox(currentIndex);
        }

        function goToNext() {
            if (galleryItems.length <= 1) return;
            currentIndex = (currentIndex + 1) % galleryItems.length;
            updateLightbox(currentIndex);
        }

        // ===== EVENT LISTENERS =====
        if (lightboxPrev) {
            lightboxPrev.addEventListener('click', function(e) {
                e.stopPropagation();
                goToPrev();
            });
        }

        if (lightboxNext) {
            lightboxNext.addEventListener('click', function(e) {
                e.stopPropagation();
                goToNext();
            });
        }

        // Close on overlay click
        lightbox.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;

            switch (e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    goToPrev();
                    break;
                case 'ArrowRight':
                    goToNext();
                    break;
            }
        });

        // Touch support for lightbox
        var touchStartX = 0;
        var touchEndX = 0;

        lightbox.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        lightbox.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            var swipeThreshold = 50;
            var diff = touchStartX - touchEndX;

            if (Math.abs(diff) < swipeThreshold) return;

            if (diff > 0) {
                goToNext();
            } else {
                goToPrev();
            }
        }

        // ===== VIEW OPTIONS =====
        var viewButtons = document.querySelectorAll('.view-options button');
        var galleryGrid = document.getElementById('galleryGrid');

        viewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                viewButtons.forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                var view = this.dataset.view;
                galleryGrid.className = 'gallery-grid';

                if (view === 'masonry') {
                    galleryGrid.classList.add('masonry');
                } else if (view === 'list') {
                    galleryGrid.classList.add('list-view');
                }
            });
        });

        // ===== LAZY LOAD OBSERVER =====
        if ('IntersectionObserver' in window) {
            var lazyImages = document.querySelectorAll('.gallery-item img[loading="lazy"]');
            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.loading = 'eager';
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }

        // ===== KEYBOARD SHORTCUT: ESCAPE =====
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    })();
</script>
@endsection