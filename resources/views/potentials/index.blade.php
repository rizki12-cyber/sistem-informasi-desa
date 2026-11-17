@extends('layouts.app')

@section('title', 'Potensi Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Potensi dan kekayaan ' . ($profile->village_name ?? 'desa') . ' - Pertanian, perkebunan, wisata, dan produk unggulan')

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .potentials-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .potentials-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .potentials-header .container {
        position: relative;
        z-index: 1;
    }

    .potentials-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .potentials-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .potentials-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .potentials-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .potentials-header .breadcrumb .current {
        color: #d4af37;
    }

    .potentials-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .potentials-header h1 span {
        color: #d4af37;
    }

    .potentials-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .potentials-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .potentials-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .potentials-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .potentials-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .potentials-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== TOOLBAR ===== */
    .potentials-toolbar {
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

    .potentials-toolbar .total {
        font-size: 14px;
        color: #6a7a6a;
    }

    .potentials-toolbar .total strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    .potentials-toolbar .filter-label {
        font-size: 13px;
        color: #8a9a8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .potentials-toolbar .filter-label .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d4af37;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin-bottom: 32px;
    }

    .filter-bar .btn-filter {
        padding: 8px 22px;
        border: 2px solid #eef3ee;
        border-radius: 50px;
        background: #ffffff;
        color: #4a5a4a;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
    }

    .filter-bar .btn-filter:hover {
        border-color: #d4af37;
        color: #0a1a0a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .filter-bar .btn-filter.active {
        background: #d4af37;
        color: #0a1a0a;
        border-color: #d4af37;
        box-shadow: 0 4px 16px rgba(212, 175, 55, 0.2);
    }

    .filter-bar .btn-filter .count-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        font-size: 11px;
        font-weight: 600;
        padding: 0 8px;
        border-radius: 50px;
        margin-left: 4px;
    }

    .filter-bar .btn-filter.active .count-badge {
        background: rgba(10, 26, 10, 0.15);
    }

    /* ===== POTENTIALS GRID ===== */
    .potentials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .potential-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef3ee;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .potential-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .potential-card .img-wrap {
        height: 220px;
        overflow: hidden;
        background: #eef3ee;
        position: relative;
    }

    .potential-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .potential-card:hover .img-wrap img {
        transform: scale(1.05);
    }

    .potential-card .img-wrap .category-tag {
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

    .potential-card .img-wrap .icon-overlay {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(10, 26, 10, 0.6);
        backdrop-filter: blur(4px);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .potential-card:hover .img-wrap .icon-overlay {
        background: #d4af37;
        color: #0a1a0a;
        transform: scale(1.1);
    }

    .potential-card .body {
        padding: 24px 28px 28px;
    }

    .potential-card .body .category-label {
        display: inline-block;
        background: #f8faf8;
        color: #6a7a6a;
        padding: 2px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 10px;
        border: 1px solid #eef3ee;
    }

    .potential-card .body h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0a1a0a;
        margin-bottom: 10px;
        line-height: 1.4;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .potential-card:hover .body h3 {
        color: #d4af37;
    }

    .potential-card .body p {
        color: #5a6a5a;
        font-size: 14px;
        line-height: 1.8;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0;
    }

    .potential-card .body .read-more {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 14px;
        color: #0a1a0a;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        padding-bottom: 2px;
    }

    .potential-card .body .read-more:hover {
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

    /* ===== NO RESULTS ===== */
    .no-results {
        display: none;
        text-align: center;
        padding: 60px 40px;
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #eef3ee;
        max-width: 500px;
        margin: 0 auto;
    }

    .no-results .icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f8faf8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 28px;
        color: #c8dcc8;
    }

    .no-results h4 {
        font-size: 18px;
        color: #0a1a0a;
        margin-bottom: 4px;
    }

    .no-results p {
        color: #7a8a7a;
        font-size: 14px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .potentials-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .potentials-header h1 {
            font-size: 34px;
        }

        .potentials-header p {
            font-size: 16px;
        }

        .potentials-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .potentials-header .header-stats .stat-item .number {
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .potentials-header {
            padding: 120px 0 40px;
        }

        .potentials-header h1 {
            font-size: 28px;
        }

        .potentials-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .potentials-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .potentials-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .potentials-page {
            padding: 40px 0 60px;
        }

        .potentials-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
        }

        .potentials-toolbar .total {
            text-align: center;
        }

        .potentials-toolbar .filter-label {
            justify-content: center;
        }

        .filter-bar {
            gap: 6px;
            margin-bottom: 24px;
        }

        .filter-bar .btn-filter {
            padding: 6px 16px;
            font-size: 13px;
        }

        .potentials-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .potential-card .img-wrap {
            height: 200px;
        }

        .potential-card .body {
            padding: 20px 22px 24px;
        }

        .potential-card .body h3 {
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
        .potentials-header h1 {
            font-size: 22px;
        }

        .potentials-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .filter-bar .btn-filter {
            padding: 4px 12px;
            font-size: 12px;
        }

        .potential-card .img-wrap {
            height: 160px;
        }

        .potential-card .body {
            padding: 16px 18px 20px;
        }

        .potential-card .body h3 {
            font-size: 15px;
        }

        .potential-card .body p {
            font-size: 13px;
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
<div class="potentials-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Potensi Desa</span>
        </div>
        <h1>Potensi <span>Desa</span></h1>
        <p>Kekayaan alam, budaya, dan potensi unggulan desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $potentials->total() }}</span>
                <span class="label">Total Potensi</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $categories->count() }}</span>
                <span class="label">Kategori</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="potentials-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="potentials-toolbar">
            <div class="total">
                Menampilkan <strong>{{ $potentials->firstItem() ?? 0 }}</strong> - <strong>{{ $potentials->lastItem() ?? 0 }}</strong> dari <strong>{{ $potentials->total() }}</strong> potensi
            </div>
            <div class="filter-label">
                <span class="dot"></span>
                <span>Filter berdasarkan kategori</span>
            </div>
        </div>

        <!-- Filter Bar -->
        @if($categories->isNotEmpty())
            <div class="filter-bar" id="filterBar">
                <button class="btn-filter active" data-category="all">
                    Semua
                    <span class="count-badge">{{ $potentials->total() }}</span>
                </button>
                @foreach($categories as $cat)
                    @php
                        $count = App\Models\VillagePotential::where('category', $cat)->count();
                    @endphp
                    <button class="btn-filter" data-category="{{ $cat }}">
                        {{ $cat }}
                        <span class="count-badge">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        @if($potentials->isNotEmpty())
            <div class="potentials-grid" id="potentialsGrid">
                @foreach($potentials as $item)
                    <div class="potential-card" data-category="{{ $item->category }}">
                        <div class="img-wrap">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#eef3ee,#d5e0d5);display:flex;align-items:center;justify-content:center;font-size:48px;color:#8a9a8a;">
                                    <i class="fas fa-seedling"></i>
                                </div>
                            @endif
                            <span class="category-tag">{{ $item->category }}</span>
                            <span class="icon-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                        <div class="body">
                            <span class="category-label">
                                <i class="fas fa-tag" style="margin-right:4px;font-size:10px;"></i>
                                {{ $item->category }}
                            </span>
                            <h3>{{ Str::limit($item->title, 50) }}</h3>
                            <p>{{ Str::limit($item->description, 100) }}</p>
                            <a href="#" class="read-more" onclick="event.preventDefault(); alert('{{ $item->title }}');">
                                Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div class="no-results" id="noResults">
                <div class="icon-wrap">
                    <i class="fas fa-search"></i>
                </div>
                <h4>Tidak Ada Potensi</h4>
                <p>Tidak ada potensi desa pada kategori yang dipilih.</p>
            </div>

            <div class="pagination-container">
                {{ $potentials->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-seedling"></i>
                </div>
                <h3>Belum Ada Data Potensi</h3>
                <p>Data potensi desa belum tersedia. Silakan hubungi administrator untuk menambahkan informasi potensi desa.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.btn-filter');
        const cards = document.querySelectorAll('.potential-card');
        const noResults = document.getElementById('noResults');
        let activeCategory = 'all';

        if (!filterButtons.length || !cards.length) return;

        function filterCards(category) {
            let visibleCount = 0;

            cards.forEach(card => {
                const cardCategory = card.dataset.category;
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (noResults) {
                if (visibleCount === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;
                activeCategory = category;

                // Animate cards out
                cards.forEach(card => {
                    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                });

                // Filter and animate in
                setTimeout(function() {
                    filterCards(category);
                    cards.forEach(card => {
                        if (card.style.display !== 'none') {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }
                    });
                }, 200);
            });
        });

        // Initial filter (all)
        setTimeout(function() {
            cards.forEach(card => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            });
        }, 100);
    });
</script>
@endsection