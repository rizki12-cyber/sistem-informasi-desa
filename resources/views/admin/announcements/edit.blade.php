@extends('layouts.admin')

@section('title', 'Edit Pengumuman')
@section('page-title', 'Edit Pengumuman')

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
        min-height: 150px;
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
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <a href="{{ route('admin.announcements.index') }}">Pengumuman</a>
        <span class="sep">/</span>
        <span class="current">Edit</span>
    </div>
    <h1>Edit Pengumuman</h1>
    <p>Perbarui informasi pengumuman yang sudah ada</p>
</div>

<form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" id="announcementForm">
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
                    <h3>Informasi Pengumuman</h3>
                    <p>Perbarui data pengumuman di bawah ini</p>
                </div>
            </div>

            <div class="card-body">
                <!-- JUDUL -->
                <div class="form-group">
                    <label for="title">
                        Judul Pengumuman
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $announcement->title) }}"
                           placeholder="Masukkan judul pengumuman"
                           required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ISI -->
                <div class="form-group">
                    <label for="content">
                        Isi Pengumuman
                        <span class="req">*</span>
                    </label>
                    <textarea id="content"
                              name="content"
                              rows="6"
                              placeholder="Tuliskan isi pengumuman di sini..."
                              required>{{ old('content', $announcement->content) }}</textarea>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Gunakan paragraf untuk memisahkan bagian-bagian pengumuman.</span>
                    </div>
                    @error('content')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- STATUS & TANGGAL -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="status">
                            Status
                            <span class="req">*</span>
                        </label>
                        <select id="status" name="status" required>
                            <option value="draft" {{ old('status', $announcement->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $announcement->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Draft: hanya terlihat di admin. Published: tampil di website.</span>
                        </div>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="published_at">
                            Tanggal Publikasi
                            <span class="opt">Opsional</span>
                        </label>
                        <input type="datetime-local"
                               id="published_at"
                               name="published_at"
                               value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="help">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Kosongkan untuk menggunakan waktu sekarang.</span>
                        </div>
                        @error('published_at')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: SIDEBAR ===== -->
        <div>
            <!-- INFO PENGUMUMAN -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-info-circle"></i> Info Pengumuman</h4>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <div class="info-box-label">ID Pengumuman</div>
                        <div class="info-box-value">#{{ $announcement->id }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Status Saat Ini</div>
                        <div class="info-box-value">
                            {{ $announcement->status === 'published' ? 'Published' : 'Draft' }}
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Dibuat</div>
                        <div class="info-box-value">{{ $announcement->created_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Diperbarui</div>
                        <div class="info-box-value">{{ $announcement->updated_at->translatedFormat('d F Y, H:i') }}</div>
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
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection