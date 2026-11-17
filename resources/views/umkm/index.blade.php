@extends('layouts.app')

@section('title', 'UMKM Desa - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Produk UMKM unggulan dari ' . ($profile->village_name ?? 'desa') . ' - Makanan, minuman, kerajinan, dan produk lokal')

@section('content')
<style>
    /* ===== PAGE HEADER ===== */
    .umkm-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .umkm-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .umkm-header .container {
        position: relative;
        z-index: 1;
    }

    .umkm-header .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .umkm-header .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .umkm-header .breadcrumb a:hover {
        color: #d4af37;
    }

    .umkm-header .breadcrumb .separator {
        color: rgba(255, 255, 255, 0.2);
    }

    .umkm-header .breadcrumb .current {
        color: #d4af37;
    }

    .umkm-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .umkm-header h1 span {
        color: #d4af37;
    }

    .umkm-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 18px;
        max-width: 560px;
        line-height: 1.7;
    }

    .umkm-header .header-stats {
        display: flex;
        gap: 40px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .umkm-header .header-stats .stat-item {
        color: rgba(255, 255, 255, 0.6);
    }

    .umkm-header .header-stats .stat-item .number {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        display: block;
        line-height: 1.2;
    }

    .umkm-header .header-stats .stat-item .label {
        font-size: 13px;
        opacity: 0.7;
    }

    /* ===== MAIN CONTENT ===== */
    .umkm-page {
        padding: 60px 0 80px;
        background: #f8faf8;
    }

    /* ===== TOOLBAR ===== */
    .umkm-toolbar {
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

    .umkm-toolbar .total {
        font-size: 14px;
        color: #6a7a6a;
    }

    .umkm-toolbar .total strong {
        color: #0a1a0a;
        font-weight: 600;
    }

    .umkm-toolbar .filter-label {
        font-size: 13px;
        color: #8a9a8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .umkm-toolbar .filter-label .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d4af37;
    }

    /* ===== SEARCH BAR ===== */
    .search-section {
        max-width: 600px;
        margin: 0 auto 32px;
        position: relative;
    }

    .search-section .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #8a9a8a;
        font-size: 16px;
        z-index: 1;
    }

    .search-section input {
        width: 100%;
        padding: 14px 20px 14px 48px;
        border: 2px solid #eef3ee;
        border-radius: 50px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #ffffff;
        color: #0a1a0a;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .search-section input:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.06);
    }

    .search-section input::placeholder {
        color: #aabaaa;
    }

    /* ===== CATEGORY FILTER ===== */
    .category-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 36px;
    }

    .category-filter .btn-cat {
        padding: 8px 22px;
        border: 2px solid #eef3ee;
        border-radius: 50px;
        background: #ffffff;
        color: #4a5a4a;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
    }

    .category-filter .btn-cat:hover {
        border-color: #d4af37;
        color: #0a1a0a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .category-filter .btn-cat.active {
        background: #d4af37;
        color: #0a1a0a;
        border-color: #d4af37;
        box-shadow: 0 4px 16px rgba(212, 175, 55, 0.2);
    }

    .category-filter .btn-cat .count {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        font-size: 10px;
        font-weight: 600;
        padding: 0 8px;
        border-radius: 50px;
        margin-left: 4px;
    }

    .category-filter .btn-cat.active .count {
        background: rgba(10, 26, 10, 0.12);
    }

    /* ===== UMKM GRID ===== */
    .umkm-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .umkm-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef3ee;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .umkm-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.06);
        border-color: #d4af37;
    }

    .umkm-card .img-wrap {
        height: 200px;
        overflow: hidden;
        background: #eef3ee;
        position: relative;
    }

    .umkm-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .umkm-card:hover .img-wrap img {
        transform: scale(1.05);
    }

    .umkm-card .img-wrap .category-tag {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(10, 26, 10, 0.7);
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
    }

    .umkm-card .img-wrap .icon-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.9);
        color: #0a1a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .umkm-card:hover .img-wrap .icon-overlay {
        transform: scale(1.1);
    }

    .umkm-card .body {
        padding: 20px 22px 24px;
    }

    .umkm-card .body .name-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .umkm-card .body h4 {
        font-size: 17px;
        font-weight: 600;
        color: #0a1a0a;
        margin-bottom: 2px;
        transition: color 0.3s ease;
        flex: 1;
    }

    .umkm-card:hover .body h4 {
        color: #d4af37;
    }

    .umkm-card .body .owner {
        font-size: 13px;
        color: #6a7a6a;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .umkm-card .body .owner i {
        color: #d4af37;
        font-size: 12px;
    }

    .umkm-card .body .category-badge {
        display: inline-block;
        background: #f8faf8;
        color: #6a7a6a;
        padding: 2px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        margin: 8px 0 10px;
        border: 1px solid #eef3ee;
    }

    .umkm-card .body .description {
        color: #5a6a5a;
        font-size: 14px;
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .umkm-card .body .btn-wa {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25D366;
        color: #ffffff;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 12px rgba(37, 211, 102, 0.2);
    }

    .umkm-card .body .btn-wa:hover {
        background: #1da851;
        transform: scale(1.03);
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
    }

    .umkm-card .body .btn-wa i {
        font-size: 16px;
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
        .umkm-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .umkm-header h1 {
            font-size: 34px;
        }

        .umkm-header p {
            font-size: 16px;
        }

        .umkm-header .header-stats {
            gap: 24px;
            flex-wrap: wrap;
        }

        .umkm-header .header-stats .stat-item .number {
            font-size: 22px;
        }

        .umkm-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .umkm-header {
            padding: 120px 0 40px;
        }

        .umkm-header h1 {
            font-size: 28px;
        }

        .umkm-header .header-stats {
            gap: 16px;
            margin-top: 20px;
            padding-top: 16px;
        }

        .umkm-header .header-stats .stat-item .number {
            font-size: 18px;
        }

        .umkm-header .header-stats .stat-item .label {
            font-size: 11px;
        }

        .umkm-page {
            padding: 40px 0 60px;
        }

        .umkm-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
        }

        .umkm-toolbar .total {
            text-align: center;
        }

        .umkm-toolbar .filter-label {
            justify-content: center;
        }

        .search-section {
            margin-bottom: 24px;
        }

        .search-section input {
            padding: 12px 16px 12px 44px;
            font-size: 14px;
        }

        .category-filter {
            gap: 8px;
            margin-bottom: 28px;
        }

        .category-filter .btn-cat {
            padding: 6px 16px;
            font-size: 12px;
        }

        .umkm-grid {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .umkm-card .img-wrap {
            height: 160px;
        }

        .umkm-card .body {
            padding: 16px 18px 20px;
        }

        .umkm-card .body h4 {
            font-size: 15px;
        }

        .umkm-card .body .description {
            font-size: 13px;
        }

        .umkm-card .body .btn-wa {
            padding: 6px 14px;
            font-size: 12px;
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
        .umkm-header h1 {
            font-size: 22px;
        }

        .umkm-header .header-stats .stat-item .number {
            font-size: 16px;
        }

        .umkm-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .umkm-card .img-wrap {
            height: 130px;
        }

        .umkm-card .body {
            padding: 12px 14px 16px;
        }

        .umkm-card .body h4 {
            font-size: 13px;
        }

        .umkm-card .body .owner {
            font-size: 11px;
        }

        .umkm-card .body .description {
            font-size: 12px;
            -webkit-line-clamp: 1;
        }

        .umkm-card .body .category-badge {
            font-size: 10px;
            padding: 1px 10px;
            margin: 4px 0 6px;
        }

        .umkm-card .body .btn-wa {
            padding: 4px 12px;
            font-size: 11px;
            gap: 4px;
        }

        .umkm-card .body .btn-wa i {
            font-size: 13px;
        }

        .category-filter .btn-cat {
            padding: 4px 12px;
            font-size: 11px;
        }

        .pagination-container nav a,
        .pagination-container nav span {
            padding: 6px 12px;
            font-size: 13px;
            min-width: 34px;
        }

        .no-results {
            padding: 40px 20px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="umkm-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">UMKM Desa</span>
        </div>
        <h1>UMKM <span>Desa</span></h1>
        <p>Produk unggulan, kerajinan, dan kuliner khas dari warga desa kami</p>
        <div class="header-stats">
            <div class="stat-item">
                <span class="number">{{ $umkm->total() }}</span>
                <span class="label">Total UMKM</span>
            </div>
            <div class="stat-item">
                <span class="number">{{ $umkm->count() }}</span>
                <span class="label">Ditampilkan</span>
            </div>
            @php
                $categories = App\Models\Umkm::distinct()->pluck('category');
            @endphp
            <div class="stat-item">
                <span class="number">{{ $categories->count() }}</span>
                <span class="label">Kategori</span>
            </div>
        </div>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="umkm-page">
    <div class="container">
        <!-- Toolbar -->
        <div class="umkm-toolbar">
            <div class="total">
                Menampilkan <strong>{{ $umkm->firstItem() ?? 0 }}</strong> - <strong>{{ $umkm->lastItem() ?? 0 }}</strong> dari <strong>{{ $umkm->total() }}</strong> UMKM
            </div>
            <div class="filter-label">
                <span class="dot"></span>
                <span>Filter berdasarkan kategori</span>
            </div>
        </div>

        <!-- Search -->
        <div class="search-section">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" placeholder="Cari UMKM berdasarkan nama, pemilik, atau kategori...">
        </div>

        <!-- Category Filter -->
        @php
            $allCategories = App\Models\Umkm::distinct()->pluck('category');
            $categoryCounts = App\Models\Umkm::selectRaw('category, count(*) as total')->groupBy('category')->pluck('total', 'category');
        @endphp
        @if($allCategories->isNotEmpty())
            <div class="category-filter" id="categoryFilter">
                <button class="btn-cat active" data-category="all">
                    Semua
                    <span class="count">{{ $umkm->total() }}</span>
                </button>
                @foreach($allCategories as $cat)
                    <button class="btn-cat" data-category="{{ $cat }}">
                        {{ $cat }}
                        <span class="count">{{ $categoryCounts[$cat] ?? 0 }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        @if($umkm->isNotEmpty())
            <div class="umkm-grid" id="umkmGrid">
                @foreach($umkm as $item)
                    <div class="umkm-card" 
                         data-name="{{ strtolower($item->name) }}" 
                         data-owner="{{ strtolower($item->owner) }}" 
                         data-category="{{ strtolower($item->category) }}">
                        <div class="img-wrap">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#eef3ee,#d5e0d5);display:flex;align-items:center;justify-content:center;font-size:40px;color:#8a9a8a;">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                            <span class="category-tag">{{ $item->category }}</span>
                            <span class="icon-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                        <div class="body">
                            <div class="name-row">
                                <h4>{{ Str::limit($item->name, 25) }}</h4>
                            </div>
                            <div class="owner">
                                <i class="fas fa-user"></i> {{ $item->owner }}
                            </div>
                            <span class="category-badge">{{ $item->category }}</span>
                            <div class="description">{{ Str::limit($item->description, 70) }}</div>
                            @if($item->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" class="btn-wa">
                                    <i class="fab fa-whatsapp"></i> Hubungi UMKM
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results -->
            <div class="no-results" id="noResults">
                <div class="icon-wrap">
                    <i class="fas fa-search"></i>
                </div>
                <h4>UMKM Tidak Ditemukan</h4>
                <p>Tidak ada UMKM yang cocok dengan pencarian atau filter yang dipilih.</p>
            </div>

            <div class="pagination-container">
                {{ $umkm->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon-wrap">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Belum Ada UMKM</h3>
                <p>Data UMKM desa belum tersedia. Silakan hubungi administrator untuk menambahkan informasi UMKM.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categoryButtons = document.querySelectorAll('.btn-cat');
        const cards = document.querySelectorAll('.umkm-card');
        const noResults = document.getElementById('noResults');
        let activeCategory = 'all';
        let searchQuery = '';

        function filterCards() {
            let found = 0;

            cards.forEach(function(card) {
                const name = card.dataset.name || '';
                const owner = card.dataset.owner || '';
                const category = card.dataset.category || '';
                
                const matchesSearch = name.includes(searchQuery) || 
                                      owner.includes(searchQuery) || 
                                      category.includes(searchQuery);
                
                const matchesCategory = activeCategory === 'all' || category === activeCategory;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                    found++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results
            if (found === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }

        // ===== SEARCH =====
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchQuery = this.value.toLowerCase().trim();
                filterCards();
            });

            // Keyboard shortcut: Ctrl+F / Cmd+F
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    if (!e.target.closest('input')) {
                        e.preventDefault();
                        searchInput.focus();
                    }
                }
            });
        }

        // ===== CATEGORY FILTER =====
        categoryButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                categoryButtons.forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                
                activeCategory = this.dataset.category;
                filterCards();
            });
        });

        // ===== INITIAL FILTER =====
        filterCards();
    });
</script>
@endsection