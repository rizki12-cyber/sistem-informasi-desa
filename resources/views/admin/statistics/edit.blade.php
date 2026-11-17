@extends('layouts.admin')

@section('title', 'Edit Statistik')
@section('page-title', 'Edit Statistik')

@section('content')
<style>
    /* ============================================= */
    /*  PAGE HEAD                                  */
    /* ============================================= */
    .page-head {
        margin-bottom: 28px;
    }

    .page-head .breadcrumb {
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

    .page-head .breadcrumb a {
        color: #8a9a8a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .page-head .breadcrumb a:hover {
        color: #d4af37;
    }

    .page-head .breadcrumb .sep {
        color: #d0d8d0;
    }

    .page-head .breadcrumb .current {
        color: #d4af37;
    }

    .page-head h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .page-head p {
        font-size: 14px;
        color: #6a7a6a;
        margin: 0;
    }

    /* ============================================= */
    /*  LAYOUT GRID                                */
    /* ============================================= */
    .form-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    /* ============================================= */
    /*  FORM CARD                                  */
    /* ============================================= */
    .form-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #eef3ee;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
    }

    .form-card .card-head {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px 24px;
        border-bottom: 1px solid #f0f5f0;
        background: linear-gradient(180deg, #fafcfa, #ffffff);
    }

    .form-card .card-head .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
        font-size: 18px;
        flex-shrink: 0;
    }

    .form-card .card-head h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0a1a0a;
        margin: 0;
    }

    .form-card .card-head p {
        font-size: 12px;
        color: #8a9a8a;
        margin: 2px 0 0;
    }

    .form-card .card-body {
        padding: 28px 24px;
    }

    /* ============================================= */
    /*  FORM GROUP                                 */
    /* ============================================= */
    .form-group {
        margin-bottom: 22px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #2d3a2d;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group label .req {
        color: #d32f2f;
        font-size: 14px;
    }

    .form-group label .opt {
        color: #b0bdb0;
        font-weight: 500;
        font-size: 10px;
        background: #f0f5f0;
        padding: 2px 8px;
        border-radius: 50px;
        text-transform: none;
        letter-spacing: 0;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #eef3ee;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #fafcfa;
        color: #0a1a0a;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #d4af37;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.08);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    .form-group .help {
        font-size: 12px;
        color: #8a9a8a;
        margin-top: 8px;
        display: flex;
        align-items: flex-start;
        gap: 6px;
        line-height: 1.5;
    }

    .form-group .help i {
        color: #d4af37;
        font-size: 13px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .form-group .help code {
        background: #f0f5f0;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 11px;
        color: #2d3a2d;
        font-weight: 600;
    }

    .form-group .error {
        color: #d32f2f;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-group .error::before {
        content: '\f071';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 10px;
    }

    /* ============================================= */
    /*  ICON PREVIEW                               */
    /* ============================================= */
    .icon-preview {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border: 2px dashed #eef3ee;
        border-radius: 12px;
        background: #fafcfa;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .icon-preview:hover {
        border-color: #d4af37;
        background: #fffef5;
    }

    .icon-preview .icon-display {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
        font-size: 22px;
        flex-shrink: 0;
    }

    .icon-preview .icon-info .icon-label {
        font-size: 10px;
        font-weight: 700;
        color: #8a9a8a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .icon-preview .icon-info .icon-name {
        font-size: 13px;
        font-weight: 600;
        color: #2d3a2d;
    }

    /* ============================================= */
    /*  FORM ROW                                   */
    /* ============================================= */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* ============================================= */
    /*  SIDEBAR CARD                               */
    /* ============================================= */
    .side-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #eef3ee;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
    }

    .side-card .card-head {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f5f0;
        background: linear-gradient(180deg, #fafcfa, #ffffff);
    }

    .side-card .card-head h4 {
        font-size: 13px;
        font-weight: 700;
        color: #0a1a0a;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .side-card .card-head h4 i {
        color: #d4af37;
        font-size: 14px;
    }

    .side-card .card-body {
        padding: 18px 20px;
    }

    .info-box {
        padding: 12px 14px;
        background: #fafcfa;
        border: 1px solid #eef3ee;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .info-box:last-child {
        margin-bottom: 0;
    }

    .info-box .info-box-label {
        font-size: 10px;
        font-weight: 700;
        color: #8a9a8a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-box .info-box-value {
        font-size: 13px;
        font-weight: 600;
        color: #2d3a2d;
        word-break: break-word;
    }

    /* ============================================= */
    /*  ACTION BUTTONS                             */
    /* ============================================= */
    .form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
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
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.35);
        color: #0a1a0a;
    }

    .btn-secondary {
        background: #f0f5f0;
        color: #2d3a2d;
    }

    .btn-secondary:hover {
        background: #e0e8e0;
        color: #0a1a0a;
        transform: translateY(-2px);
    }

    /* ============================================= */
    /*  RESPONSIVE                                 */
    /* ============================================= */
    @media (max-width: 992px) {
        .form-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .form-card .card-body {
            padding: 20px 18px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .form-card .card-head {
            padding: 16px 18px;
        }
    }

    @media (max-width: 480px) {
        .form-card .card-head .icon-box {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .form-card .card-head h3 {
            font-size: 14px;
        }

        .icon-preview .icon-display {
            width: 42px;
            height: 42px;
            font-size: 18px;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <a href="{{ route('admin.statistics.index') }}">Statistik</a>
        <span class="sep">/</span>
        <span class="current">Edit</span>
    </div>
    <h1>Edit Statistik</h1>
    <p>Perbarui data statistik yang sudah ada</p>
</div>

<form action="{{ route('admin.statistics.update', $statistic) }}" method="POST" id="statisticForm">
    @csrf
    @method('PUT')

    <div class="form-layout">
        <!-- ===== LEFT COLUMN: FORM ===== -->
        <div class="form-card">
            <div class="card-head">
                <div class="icon-box">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h3>Informasi Statistik</h3>
                    <p>Perbarui data statistik di bawah ini</p>
                </div>
            </div>

            <div class="card-body">
                <!-- LABEL -->
                <div class="form-group">
                    <label for="label">
                        Label Statistik
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="label"
                           name="label"
                           value="{{ old('label', $statistic->label) }}"
                           placeholder="Misal: Penduduk"
                           required>
                    <div class="help">
                        <i class="fas fa-tag"></i>
                        <span>Nama dari data statistik yang akan ditampilkan.</span>
                    </div>
                    @error('label')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NILAI -->
                <div class="form-group">
                    <label for="value">
                        Nilai
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="value"
                           name="value"
                           value="{{ old('value', $statistic->value) }}"
                           placeholder="Misal: 8.245"
                           required>
                    <div class="help">
                        <i class="fas fa-hashtag"></i>
                        <span>Angka atau nilai dari data statistik.</span>
                    </div>
                    @error('value')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ICON -->
                <div class="form-group">
                    <label for="icon">
                        Icon (Font Awesome)
                        <span class="opt">Opsional</span>
                    </label>
                    <input type="text"
                           id="icon"
                           name="icon"
                           value="{{ old('icon', $statistic->icon) }}"
                           placeholder="Misal: users, home, map-marker-alt">
                    <div class="help">
                        <i class="fas fa-icons"></i>
                        <span>Masukkan nama icon Font Awesome tanpa prefix <code>fa-</code>.</span>
                    </div>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Contoh: <code>users</code>, <code>home</code>, <code>map-marker-alt</code></span>
                    </div>

                    @if($statistic->icon)
                        <div class="icon-preview">
                            <div class="icon-display">
                                <i class="fas fa-{{ $statistic->icon }}"></i>
                            </div>
                            <div class="icon-info">
                                <div class="icon-label">Preview Icon Saat Ini</div>
                                <div class="icon-name">fa-{{ $statistic->icon }}</div>
                            </div>
                        </div>
                    @endif

                    @error('icon')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- URUTAN -->
                <div class="form-group" style="margin-bottom:0;">
                    <label for="order">
                        Urutan Tampil
                        <span class="opt">Opsional</span>
                    </label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', $statistic->order) }}"
                           min="0">
                    <div class="help">
                        <i class="fas fa-sort-numeric-up"></i>
                        <span>Semakin kecil angka, semakin depan statistik ditampilkan.</span>
                    </div>
                    @error('order')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: SIDEBAR ===== -->
        <div>
            <!-- INFO STATISTIK -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-info-circle"></i> Info Statistik</h4>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <div class="info-box-label">ID Statistik</div>
                        <div class="info-box-value">#{{ $statistic->id }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Dibuat</div>
                        <div class="info-box-value">{{ $statistic->created_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Diperbarui</div>
                        <div class="info-box-value">{{ $statistic->updated_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- AKSI -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-cog"></i> Aksi</h4>
                </div>
                <div class="card-body">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui
                        </button>
                        <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection