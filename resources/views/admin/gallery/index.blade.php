@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri')

@section('content')
<style>
    /* ============================================= */
    /*  PAGE HEAD                                  */
    /* ============================================= */
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .page-head .head-left .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #8a9a8a;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .page-head .head-left .breadcrumb a {
        color: #8a9a8a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .page-head .head-left .breadcrumb a:hover {
        color: #d4af37;
    }

    .page-head .head-left .breadcrumb .sep {
        color: #d0d8d0;
    }

    .page-head .head-left .breadcrumb .current {
        color: #d4af37;
    }

    .page-head .head-left h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .page-head .head-left p {
        font-size: 14px;
        color: #6a7a6a;
        margin: 0;
    }

    /* ============================================= */
    /*  BUTTONS                                    */
    /* ============================================= */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        font-family: inherit;
        line-height: 1;
    }

    .btn-primary {
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a;
        box-shadow: 0 4px 16px rgba(212, 175, 55, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.35);
        color: #0a1a0a;
    }

    /* ============================================= */
    /*  CARD CONTAINER                             */
    /* ============================================= */
    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #eef3ee;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .card:hover {
        border-color: rgba(212, 175, 55, 0.4);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    /* ============================================= */
    /*  CARD TOOLBAR                               */
    /* ============================================= */
    .card-toolbar {
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid #f0f5f0;
        background: linear-gradient(180deg, #fafcfa, #ffffff);
    }

    .card-toolbar .toolbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .card-toolbar .toolbar-left .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
        font-size: 18px;
    }

    .card-toolbar .toolbar-left h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-toolbar .toolbar-left h3 .count {
        background: #f0f5f0;
        color: #6a7a6a;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 50px;
        letter-spacing: 0.5px;
    }

    .card-toolbar .toolbar-left p {
        font-size: 12px;
        color: #8a9a8a;
        margin: 2px 0 0;
    }

    /* ============================================= */
    /*  GALLERY GRID                               */
    /* ============================================= */
    .gallery-body {
        padding: 24px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 18px;
    }

    .gallery-item {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        aspect-ratio: 1;
        background: #f0f5f0;
        border: 2px solid #eef3ee;
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .gallery-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        border-color: #d4af37;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
        display: block;
    }

    .gallery-item:hover img {
        transform: scale(1.06);
    }

    .gallery-item .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 16px;
        background: linear-gradient(transparent, rgba(10, 26, 10, 0.85));
        color: #ffffff;
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    .gallery-item .overlay .title {
        font-size: 13px;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .gallery-item .overlay .title .no-title {
        color: rgba(255, 255, 255, 0.5);
        font-style: italic;
        font-weight: 400;
    }

    .gallery-item .overlay .actions {
        display: flex;
        gap: 6px;
    }

    /* ============================================= */
    /*  ACTION BUTTONS (DI OVERLAY)                */
    /* ============================================= */
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 12px;
        text-decoration: none;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.9);
    }

    .action-btn.edit {
        color: #1565c0;
    }

    .action-btn.edit:hover {
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.25);
    }

    .action-btn.delete {
        color: #991b1b;
    }

    .action-btn.delete:hover {
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(153, 27, 27, 0.25);
    }

    /* ============================================= */
    /*  EMPTY STATE                                */
    /* ============================================= */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
    }

    .empty-state .icon-circle {
        width: 100px;
        height: 100px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0f5f0, #e8efe8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        color: #c8dcc8;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #7a8a7a;
        margin-bottom: 24px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    /* ============================================= */
    /*  PAGINATION                                 */
    /* ============================================= */
    .pagination-wrap {
        padding: 20px 24px;
        border-top: 1px solid #f0f5f0;
        display: flex;
        justify-content: center;
    }

    .pagination-wrap nav {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-wrap nav a,
    .pagination-wrap nav span {
        padding: 8px 14px;
        border: 1px solid #eef3ee;
        border-radius: 10px;
        color: #4a5a4a;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 13px;
        font-weight: 600;
        min-width: 38px;
        text-align: center;
        background: #ffffff;
    }

    .pagination-wrap nav a:hover {
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a;
        border-color: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }

    .pagination-wrap nav span[aria-current="page"] {
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a;
        border-color: #d4af37;
    }

    /* ============================================= */
    /*  RESPONSIVE                                 */
    /* ============================================= */
    @media (max-width: 768px) {
        .page-head {
            flex-direction: column;
            align-items: stretch;
        }

        .page-head .btn {
            width: 100%;
            justify-content: center;
        }

        .card-toolbar {
            flex-direction: column;
            align-items: stretch;
            padding: 16px 18px;
        }

        .card-toolbar .btn {
            width: 100%;
            justify-content: center;
        }

        .gallery-body {
            padding: 16px;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .card-toolbar .toolbar-left .icon-box {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .card-toolbar .toolbar-left h3 {
            font-size: 14px;
        }

        .gallery-body {
            padding: 12px;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .gallery-item .overlay {
            padding: 10px;
        }

        .gallery-item .overlay .title {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .action-btn {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="head-left">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Galeri</span>
        </div>
        <h1>Kelola Galeri</h1>
        <p>Kelola dokumentasi foto kegiatan desa</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Foto
    </a>
</div>

<!-- ===== MAIN CARD ===== -->
<div class="card">
    <!-- TOOLBAR -->
    <div class="card-toolbar">
        <div class="toolbar-left">
            <div class="icon-box">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h3>
                    Galeri Foto
                    <span class="count">{{ $galleries->total() }} foto</span>
                </h3>
                <p>Semua foto yang terdaftar di sistem</p>
            </div>
        </div>
    </div>

    <!-- GALLERY / EMPTY STATE -->
    @if($galleries->isNotEmpty())
        <div class="gallery-body">
            <div class="gallery-grid">
                @foreach($galleries as $item)
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $item->image) }}"
                             alt="{{ $item->title ?? 'Galeri' }}"
                             loading="lazy">
                        <div class="overlay">
                            <div class="title">
                                @if($item->title)
                                    {{ Str::limit($item->title, 30) }}
                                @else
                                    <span class="no-title">Tanpa Judul</span>
                                @endif
                            </div>
                            <div class="actions">
                                <a href="{{ route('admin.gallery.edit', $item) }}"
                                   class="action-btn edit"
                                   title="Edit foto">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $item) }}"
                                      method="POST"
                                      style="display:inline;"
                                      id="delete-form-{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="action-btn delete"
                                            onclick="confirmDelete('delete-form-{{ $item->id }}')"
                                            title="Hapus foto">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrap">
            {{ $galleries->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="icon-circle">
                <i class="fas fa-images"></i>
            </div>
            <h3>Belum Ada Foto Galeri</h3>
            <p>Tambahkan foto pertama untuk ditampilkan di website desa.</p>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Foto Pertama
            </a>
        </div>
    @endif
</div>
@endsection