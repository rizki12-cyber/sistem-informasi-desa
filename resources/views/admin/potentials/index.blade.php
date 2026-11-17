@extends('layouts.admin')

@section('title', 'Kelola Potensi Desa')
@section('page-title', 'Kelola Potensi Desa')

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
    /*  TABLE                                      */
    /* ============================================= */
    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background: #f8faf8;
    }

    table th {
        padding: 14px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #6a7a6a;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #eef3ee;
        white-space: nowrap;
    }

    table td {
        padding: 16px 24px;
        border-bottom: 1px solid #f5f8f5;
        vertical-align: middle;
        font-size: 14px;
        color: #2d3a2d;
    }

    table tbody tr {
        transition: background 0.2s ease;
    }

    table tbody tr:hover td {
        background: #fafcfa;
    }

    table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ============================================= */
    /*  THUMBNAIL                                  */
    /* ============================================= */
    .thumb-wrap {
        width: 72px;
        height: 50px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #eef3ee;
        background: #f0f5f0;
        position: relative;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thumb-wrap:hover {
        border-color: #d4af37;
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(212, 175, 55, 0.2);
    }

    .thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .thumb-wrap .placeholder {
        color: #c8dcc8;
        font-size: 20px;
    }

    /* ============================================= */
    /*  INFO CELL                                  */
    /* ============================================= */
    .info-title {
        font-size: 14px;
        font-weight: 600;
        color: #0a1a0a;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .info-desc {
        font-size: 12px;
        color: #8a9a8a;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ============================================= */
    /*  BADGES                                     */
    /* ============================================= */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #1b5e20;
    }

    .badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        background: #2e7d32;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.85); }
    }

    /* ============================================= */
    /*  ACTION BUTTONS                             */
    /* ============================================= */
    .actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 13px;
        text-decoration: none;
    }

    .action-btn.edit {
        background: #e3f2fd;
        color: #1565c0;
    }

    .action-btn.edit:hover {
        background: #bbdefb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.15);
    }

    .action-btn.delete {
        background: #fef2f2;
        color: #991b1b;
    }

    .action-btn.delete:hover {
        background: #fee2e2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(153, 27, 27, 0.15);
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
    @media (max-width: 992px) {
        table th, table td {
            padding: 12px 16px;
        }
    }

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

        table th, table td {
            padding: 10px 12px;
            font-size: 12px;
        }

        .thumb-wrap {
            width: 56px;
            height: 40px;
        }

        .info-title {
            font-size: 13px;
        }

        .actions {
            gap: 4px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            font-size: 11px;
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

        table th, table td {
            padding: 8px 10px;
            font-size: 11px;
        }

        .thumb-wrap {
            width: 48px;
            height: 34px;
        }

        .badge {
            font-size: 9px;
            padding: 3px 10px;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="head-left">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Potensi Desa</span>
        </div>
        <h1>Kelola Potensi Desa</h1>
        <p>Kelola potensi dan kekayaan desa yang tampil di website</p>
    </div>
    <a href="{{ route('admin.potentials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Potensi
    </a>
</div>

<!-- ===== MAIN CARD ===== -->
<div class="card">
    <!-- TOOLBAR -->
    <div class="card-toolbar">
        <div class="toolbar-left">
            <div class="icon-box">
                <i class="fas fa-seedling"></i>
            </div>
            <div>
                <h3>
                    Daftar Potensi Desa
                    <span class="count">{{ $potentials->total() }} item</span>
                </h3>
                <p>Semua potensi yang terdaftar di sistem</p>
            </div>
        </div>
    </div>

    <!-- TABLE / EMPTY STATE -->
    @if($potentials->isNotEmpty())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">Gambar</th>
                        <th>Judul &amp; Deskripsi</th>
                        <th style="width: 180px;">Kategori</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($potentials as $item)
                        <tr>
                            <!-- GAMBAR -->
                            <td>
                                <div class="thumb-wrap">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}"
                                             alt="{{ $item->title }}"
                                             loading="lazy">
                                    @else
                                        <span class="placeholder"><i class="fas fa-seedling"></i></span>
                                    @endif
                                </div>
                            </td>

                            <!-- INFO -->
                            <td>
                                <div class="info-title">{{ Str::limit($item->title, 60) }}</div>
                                <div class="info-desc">{{ Str::limit($item->description, 90) }}</div>
                            </td>

                            <!-- KATEGORI -->
                            <td>
                                <span class="badge">
                                    <span class="dot"></span>
                                    {{ $item->category }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.potentials.edit', $item) }}"
                                       class="action-btn edit"
                                       title="Edit potensi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.potentials.destroy', $item) }}"
                                          method="POST"
                                          style="display:inline;"
                                          id="delete-form-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="action-btn delete"
                                                onclick="confirmDelete('delete-form-{{ $item->id }}')"
                                                title="Hapus potensi">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrap">
            {{ $potentials->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="icon-circle">
                <i class="fas fa-seedling"></i>
            </div>
            <h3>Belum Ada Data Potensi</h3>
            <p>Tambahkan potensi desa pertama untuk ditampilkan di website desa.</p>
            <a href="{{ route('admin.potentials.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Potensi Pertama
            </a>
        </div>
    @endif
</div>
@endsection