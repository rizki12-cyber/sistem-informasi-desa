@extends('layouts.admin')

@section('title', 'Perangkat Desa')
@section('page-title', 'Perangkat Desa')

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
    /*  HIERARCHY INFO                             */
    /* ============================================= */
    .hierarchy-info {
        font-size: 13px;
        color: #6a7a6a;
        padding: 12px 24px;
        border-bottom: 1px solid #f0f5f0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        background: #fafcfa;
    }

    .hierarchy-info i {
        color: #d4af37;
    }

    .hierarchy-info .tag {
        background: #f0f5f0;
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        color: #4a5a4a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    /*  AVATAR                                     */
    /* ============================================= */
    .thumb-wrap {
        width: 50px;
        height: 50px;
        border-radius: 50%;
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
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .info-muted {
        font-size: 13px;
        color: #8a9a8a;
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
    }

    .badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-success {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #1b5e20;
    }

    .badge-success .dot {
        background: #2e7d32;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    .badge-danger {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
    }

    .badge-danger .dot {
        background: #991b1b;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.85); }
    }

    .level-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid transparent;
    }

    .level-badge.level-1 {
        background: rgba(212, 175, 55, 0.15);
        color: #b8912a;
        border-color: rgba(212, 175, 55, 0.3);
    }

    .level-badge.level-2 {
        background: rgba(46, 125, 50, 0.1);
        color: #2e7d32;
        border-color: rgba(46, 125, 50, 0.2);
    }

    .level-badge.level-3 {
        background: rgba(33, 150, 243, 0.1);
        color: #1565c0;
        border-color: rgba(33, 150, 243, 0.2);
    }

    .level-badge.level-4 {
        background: rgba(156, 39, 176, 0.1);
        color: #6a1b9a;
        border-color: rgba(156, 39, 176, 0.2);
    }

    /* ============================================= */
    /*  PARENT NAME                                */
    /* ============================================= */
    .parent-name {
        font-size: 13px;
        font-weight: 600;
        color: #0a1a0a;
        display: block;
    }

    .parent-position {
        font-size: 11px;
        color: #8a9a8a;
        display: block;
        margin-top: 2px;
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

    .action-btn.toggle-active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .action-btn.toggle-active:hover {
        background: #c8e6c9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
    }

    .action-btn.toggle-inactive {
        background: #f5f5f5;
        color: #6a7a6a;
    }

    .action-btn.toggle-inactive:hover {
        background: #e0e0e0;
        transform: translateY(-2px);
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
            width: 40px;
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

        .badge {
            font-size: 9px;
            padding: 3px 10px;
        }

        .level-badge {
            font-size: 9px;
            padding: 2px 8px;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="head-left">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Perangkat Desa</span>
        </div>
        <h1>Perangkat Desa</h1>
        <p>Kelola struktur organisasi dan perangkat desa</p>
    </div>
    <a href="{{ route('admin.officials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Perangkat
    </a>
</div>

<!-- ===== MAIN CARD ===== -->
<div class="card">
    <!-- TOOLBAR -->
    <div class="card-toolbar">
        <div class="toolbar-left">
            <div class="icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h3>
                    Daftar Perangkat Desa
                    <span class="count">{{ $officials->count() }} item</span>
                </h3>
                <p>Semua perangkat desa yang terdaftar di sistem</p>
            </div>
        </div>
    </div>

    <!-- HIERARCHY INFO -->
    <div class="hierarchy-info">
        <i class="fas fa-sitemap"></i>
        Setiap perangkat bisa menjadi atasan bagi perangkat lain.
        <span class="tag">Hierarki Fleksibel</span>
    </div>

    <!-- TABLE / EMPTY STATE -->
    @if($officials->isNotEmpty())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Foto</th>
                        <th>Nama &amp; Deskripsi</th>
                        <th>Jabatan</th>
                        <th>Atasan</th>
                        <th style="width: 100px;">Level</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 140px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officials as $official)
                        @php
                            $level = 0;
                            $temp = $official;
                            while ($temp->parent) {
                                $level++;
                                $temp = $temp->parent;
                            }
                            $levelClass = $level <= 1 ? 'level-1' : ($level <= 2 ? 'level-2' : ($level <= 3 ? 'level-3' : 'level-4'));
                        @endphp
                        <tr>
                            <!-- FOTO -->
                            <td>
                                <div class="thumb-wrap">
                                    @if($official->photo)
                                        <img src="{{ asset('storage/' . $official->photo) }}"
                                             alt="{{ $official->name }}"
                                             loading="lazy">
                                    @else
                                        <span class="placeholder"><i class="fas fa-user"></i></span>
                                    @endif
                                </div>
                            </td>

                            <!-- INFO -->
                            <td>
                                <div class="info-title">{{ $official->name }}</div>
                                @if($official->description)
                                    <div class="info-desc">{{ Str::limit($official->description, 50) }}</div>
                                @else
                                    <div class="info-desc" style="color:#c8dcc8;font-style:italic;">Tidak ada deskripsi</div>
                                @endif
                            </td>

                            <!-- JABATAN -->
                            <td>{{ $official->position }}</td>

                            <!-- ATASAN -->
                            <td>
                                @if($official->parent)
                                    <span class="parent-name">{{ $official->parent->name }}</span>
                                    <span class="parent-position">{{ $official->parent->position }}</span>
                                @else
                                    <span class="info-muted">-</span>
                                @endif
                            </td>

                            <!-- LEVEL -->
                            <td>
                                <span class="level-badge {{ $levelClass }}">
                                    Level {{ $level + 1 }}
                                </span>
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="badge {{ $official->is_active ? 'badge-success' : 'badge-danger' }}">
                                    <span class="dot"></span>
                                    {{ $official->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <div class="actions">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.officials.edit', $official) }}"
                                       class="action-btn edit"
                                       title="Edit perangkat">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Toggle Active -->
                                    <form action="{{ route('admin.officials.toggle', $official) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="action-btn {{ $official->is_active ? 'toggle-active' : 'toggle-inactive' }}"
                                                title="{{ $official->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $official->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.officials.destroy', $official) }}"
                                          method="POST"
                                          style="display:inline;"
                                          id="delete-form-{{ $official->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="action-btn delete"
                                                onclick="confirmDelete('delete-form-{{ $official->id }}')"
                                                title="Hapus perangkat">
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
    @else
        <div class="empty-state">
            <div class="icon-circle">
                <i class="fas fa-users"></i>
            </div>
            <h3>Belum Ada Perangkat Desa</h3>
            <p>Tambahkan perangkat desa pertama untuk membangun struktur organisasi desa.</p>
            <a href="{{ route('admin.officials.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Perangkat Pertama
            </a>
        </div>
    @endif
</div>
@endsection