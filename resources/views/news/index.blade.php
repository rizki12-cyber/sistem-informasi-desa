@extends('layouts.app')

@section('title', 'Berita Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Berita terbaru dan informasi terkini dari ' . ($profile->village_name ?? 'desa'))

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .news-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .news-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .news-header .container {
        position: relative;
        z-index: 1;
    }

    .news-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .news-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .news-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .news-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .news-header .breadcrumb .current {
        color: #d4af37;
    }

    .news-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .news-header h1 span {
        color: #d4af37;
    }

    .news-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .news-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .news-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .news-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .news-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .news-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== SEARCH & FILTER ===== */
    .news-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 40px;
        padding: 16px 24px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #eef3ee;
    }

    .news-toolbar .search-box {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        max-width: 400px;
        position: relative;
    }

    .news-toolbar .search-box input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border: 2px solid #eef3ee;
        border-radius: 50px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #f8faf8;
        color: #0a1a0a;
    }

    .news-toolbar .search-box input:focus {
        outline: none;
        border-color: #d4af37;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.06);
    }

    .news-toolbar .search-box .icon {
        position: absolute;
        left: 16px;
        color: #8a9a8a;
        font-size: 14px;
    }

    .news-toolbar .total-news {
        font-size: 14px;
        color: #6a7a6a;
    }

    .news-toolbar .total-news strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    /* ===== NEWS GRID ===== */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .news-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef3ee;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .news-card .img-wrap {
        height: 220px;
        overflow: hidden;
        background: #eef3ee;
        position: relative;
    }

    .news-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-card:hover .img-wrap img {
        transform: scale(1.05);
    }

    .news-card .img-wrap .category-tag {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(212, 175, 55, 0.92);
        color: #0a1a0a;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    .news-card .img-wrap .date-badge {
        position: absolute;
        bottom: 16px;
        right: 16px;
        background: rgba(10, 26, 10, 0.75);
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 500;
    }

    .news-card .body {
        padding: 24px 28px 28px;
    }

    .news-card .body .meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #8a9a8a;
    }

    .news-card .body .meta i {
        color: #d4af37;
        width: 16px;
        font-size: 13px;
    }

    .news-card .body h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0a1a0a;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .news-card:hover .body h3 {
        color: #d4af37;
    }

    .news-card .body .excerpt {
        color: #5a6a5a;
        font-size: 14px;
        line-height: 1.8;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .news-card .body .read-more {
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

    .news-card .body .read-more:hover {
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
    @media (max-width: 1200px) {
        .news-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .news-header h1 {
            font-size: 34px;
        }

        .news-header p {
            font-size: 16px;
        }

        .news-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .news-header .header-stats .stat-item .number {
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .news-header {
            padding: 120px 0 40px;
        }

        .news-header h1 {
            font-size: 28px;
        }

        .news-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .news-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .news-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .news-page {
            padding: 40px 0 60px;
        }

        .news-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 16px 20px;
        }

        .news-toolbar .search-box {
            max-width: 100%;
        }

        .news-toolbar .total-news {
            text-align: center;
        }

        .news-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .news-card .img-wrap {
            height: 200px;
        }

        .news-card .body {
            padding: 20px 22px 24px;
        }

        .news-card .body h3 {
            font-size: 17px;
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
        .news-header h1 {
            font-size: 22px;
        }

        .news-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .news-toolbar {
            padding: 12px 16px;
        }

        .news-toolbar .search-box input {
            font-size: 13px;
            padding: 8px 14px 8px 38px;
        }

        .news-card .img-wrap {
            height: 160px;
        }

        .news-card .body {
            padding: 16px 18px 20px;
        }

        .news-card .body h3 {
            font-size: 15px;
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
<div class="news-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Berita Desa</span>
        </div>
        <h1>Berita <span>Desa</span></h1>
        <p>Informasi terbaru, kegiatan, dan perkembangan desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $news->total() }}</span>
                <span class="label">Total Berita</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $news->count() }}</span>
                <span class="label">Berita Ditampilkan</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="news-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="news-toolbar">
            <div class="search-box">
                <i class="fas fa-search icon"></i>
                <input type="text" id="searchInput" placeholder="Cari berita..." aria-label="Cari berita">
            </div>
            <div class="total-news">
                Menampilkan <strong>{{ $news->firstItem() ?? 0 }}</strong> - <strong>{{ $news->lastItem() ?? 0 }}</strong> dari <strong>{{ $news->total() }}</strong> berita
            </div>
        </div>

        @if($news->isNotEmpty())
            <div class="news-grid" id="newsGrid">
                @foreach($news as $item)
                    <div class="news-card">
                        <div class="img-wrap">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#eef3ee,#d5e0d5);display:flex;align-items:center;justify-content:center;font-size:48px;color:#8a9a8a;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            <span class="category-tag">Berita</span>
                            <span class="date-badge">
                                <i class="fas fa-calendar-alt" style="margin-right:4px;"></i>
                                {{ $item->formatted_date }}
                            </span>
                        </div>
                        <div class="body">
                            <div class="meta">
                                <span><i class="fas fa-calendar-alt"></i> {{ $item->formatted_date }}</span>
                                @if($item->published_at)
                                    <span><i class="fas fa-clock"></i> {{ $item->published_at->format('H:i') }} WIB</span>
                                @endif
                            </div>
                            <h3>{{ Str::limit($item->title, 55) }}</h3>
                            <div class="excerpt">{{ $item->excerpt }}</div>
                            <a href="{{ route('public.news.show', $item->slug) }}" class="read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $news->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Belum Ada Berita</h3>
                <p>Belum ada berita yang dipublikasikan. Pantau terus website ini untuk informasi terbaru dari desa kami.</p>
            </div>
        @endif
    </div>
</div>

<script>
    // ===== SEARCH FUNCTIONALITY =====
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.news-card');
        const grid = document.getElementById('newsGrid');
        let searchTimeout;

        if (!searchInput || cards.length === 0) return;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(function() {
                const query = this.value.toLowerCase().trim();
                let found = 0;

                cards.forEach(function(card) {
                    const title = card.querySelector('h3')?.textContent?.toLowerCase() || '';
                    const excerpt = card.querySelector('.excerpt')?.textContent?.toLowerCase() || '';
                    const date = card.querySelector('.meta')?.textContent?.toLowerCase() || '';
                    
                    if (title.includes(query) || excerpt.includes(query) || date.includes(query)) {
                        card.style.display = 'block';
                        found++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide empty state for search
                let noResults = document.querySelector('.no-search-results');
                if (found === 0 && query.length > 0) {
                    if (!noResults) {
                        const empty = document.createElement('div');
                        empty.className = 'empty-state no-search-results';
                        empty.innerHTML = `
                            <div class="icon-wrap">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Berita Tidak Ditemukan</h3>
                            <p>Tidak ada berita yang cocok dengan pencarian "<strong>${query}</strong>". Silakan coba kata kunci lain.</p>
                        `;
                        grid.parentNode.insertBefore(empty, grid.nextSibling);
                    } else {
                        noResults.style.display = 'block';
                        noResults.querySelector('p strong').textContent = query;
                    }
                    grid.style.display = 'none';
                } else {
                    if (noResults) {
                        noResults.style.display = 'none';
                    }
                    grid.style.display = 'grid';
                }
            }.bind(this), 300);
        });

        // Keyboard shortcut: Ctrl+F / Cmd+F focus search
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                if (!e.target.closest('input')) {
                    e.preventDefault();
                    searchInput.focus();
                }
            }
        });
    });
</script>
@endsection