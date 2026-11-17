@extends('layouts.admin')

@section('title', 'Tambah Slider')
@section('page-title', 'Tambah Slider')

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
    /*  FILE INPUT                                 */
    /* ============================================= */
    .file-input {
        position: relative;
    }

    .file-input input[type="file"] {
        width: 100%;
        padding: 12px 16px;
        cursor: pointer;
        border: 2px dashed #eef3ee;
        border-radius: 12px;
        background: #fafcfa;
        transition: all 0.3s ease;
        font-size: 13px;
        color: #6a7a6a;
    }

    .file-input input[type="file"]:hover {
        border-color: #d4af37;
        background: #fffef5;
    }

    .file-input input[type="file"]::file-selector-button {
        padding: 8px 18px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .file-input input[type="file"]::file-selector-button:hover {
        background: linear-gradient(135deg, #d4af37, #c5a031);
    }

    /* ============================================= */
    /*  IMAGE PREVIEW                              */
    /* ============================================= */
    .image-preview {
        margin-top: 16px;
        border-radius: 12px;
        border: 2px dashed #eef3ee;
        padding: 12px;
        background: #fafcfa;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .image-preview:hover {
        border-color: #d4af37;
    }

    .image-preview img {
        width: 100%;
        height: auto;
        max-height: 240px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }

    .image-preview .preview-label {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    /*  CHECKBOX SWITCH                            */
    /* ============================================= */
    .switch-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 16px;
        border: 2px solid #eef3ee;
        border-radius: 12px;
        background: #fafcfa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .switch-group:hover {
        border-color: #d4af37;
        background: #fffef5;
    }

    .switch-group .switch-info {
        flex: 1;
    }

    .switch-group .switch-info .switch-title {
        font-size: 13px;
        font-weight: 700;
        color: #2d3a2d;
        margin-bottom: 2px;
    }

    .switch-group .switch-info .switch-desc {
        font-size: 11px;
        color: #8a9a8a;
        line-height: 1.4;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 26px;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #d0d8d0;
        border-radius: 26px;
        transition: all 0.3s ease;
    }

    .switch .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background: #ffffff;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .switch input:checked + .slider {
        background: linear-gradient(135deg, #d4af37, #c5a031);
    }

    .switch input:checked + .slider:before {
        transform: translateX(20px);
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

    .side-card .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .side-card .info-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        font-size: 13px;
        color: #4a5a4a;
        line-height: 1.5;
        border-bottom: 1px solid #f5f8f5;
    }

    .side-card .info-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .side-card .info-list li:first-child {
        padding-top: 0;
    }

    .side-card .info-list li i {
        color: #d4af37;
        font-size: 14px;
        margin-top: 2px;
        flex-shrink: 0;
        width: 16px;
        text-align: center;
    }

    .side-card .info-list li .list-content {
        flex: 1;
    }

    .side-card .info-list li .list-content strong {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #2d3a2d;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .side-card .info-list li .list-content span {
        font-size: 12px;
        color: #8a9a8a;
        line-height: 1.5;
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
        <a href="{{ route('admin.sliders.index') }}">Slider</a>
        <span class="sep">/</span>
        <span class="current">Tambah</span>
    </div>
    <h1>Tambah Slider Baru</h1>
    <p>Tambahkan gambar slider untuk ditampilkan di halaman utama website</p>
</div>

<form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" id="sliderForm">
    @csrf

    <div class="form-layout">
        <!-- ===== LEFT COLUMN: FORM ===== -->
        <div class="form-card">
            <div class="card-head">
                <div class="icon-box">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h3>Informasi Slider</h3>
                    <p>Isi data slider di bawah ini</p>
                </div>
            </div>

            <div class="card-body">
                <!-- JUDUL -->
                <div class="form-group">
                    <label for="title">
                        Judul Slider
                        <span class="opt">Opsional</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="Contoh: Selamat Datang di Desa Kami">
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Judul tidak wajib diisi. Kosongkan jika hanya ingin menampilkan gambar.</span>
                    </div>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- DESKRIPSI -->
                <div class="form-group">
                    <label for="description">
                        Deskripsi
                        <span class="opt">Opsional</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              placeholder="Tulis deskripsi slider di sini...">{{ old('description') }}</textarea>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Deskripsi akan muncul di bawah judul pada slider.</span>
                    </div>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- FOTO -->
                <div class="form-group">
                    <label for="image">
                        Foto Slider
                        <span class="req">*</span>
                    </label>
                    <div class="file-input">
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/*"
                               onchange="previewImage(event)"
                               required>
                    </div>
                    <div class="help">
                        <i class="fas fa-image"></i>
                        <span>Format: JPG, PNG, WEBP. Ukuran maksimal: 2MB. Rekomendasi: 1920×1080 px.</span>
                    </div>
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <span class="preview-label">Preview</span>
                        <img id="previewImg" src="#" alt="Preview">
                    </div>
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- TOMBOL CTA -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="button_text">
                            Teks Tombol
                            <span class="opt">Opsional</span>
                        </label>
                        <input type="text"
                               id="button_text"
                               name="button_text"
                               value="{{ old('button_text') }}"
                               placeholder="Jelajahi Desa">
                        @error('button_text')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="button_link">
                            Link Tombol
                            <span class="opt">Opsional</span>
                        </label>
                        <input type="text"
                               id="button_link"
                               name="button_link"
                               value="{{ old('button_link') }}"
                               placeholder="/profil">
                        @error('button_link')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- URUTAN -->
                <div class="form-group">
                    <label for="order">
                        Urutan Tampil
                        <span class="opt">Opsional</span>
                    </label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', 0) }}"
                           min="0">
                    <div class="help">
                        <i class="fas fa-sort-numeric-up"></i>
                        <span>Semakin kecil angka, semakin depan slider ditampilkan.</span>
                    </div>
                    @error('order')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- STATUS AKTIF -->
                <div class="form-group" style="margin-bottom:0;">
                    <label class="switch-group" for="is_active">
                        <div class="switch-info">
                            <div class="switch-title">Status Aktif</div>
                            <div class="switch-desc">Aktifkan untuk menampilkan slider di website</div>
                        </div>
                        <div class="switch">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: SIDEBAR ===== -->
        <div>
            <!-- PANDUAN -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-lightbulb"></i> Panduan</h4>
                </div>
                <div class="card-body">
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-image"></i>
                            <div class="list-content">
                                <strong>Ukuran Foto</strong>
                                <span>Gunakan foto landscape minimal 1920×1080 px untuk hasil terbaik.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-file"></i>
                            <div class="list-content">
                                <strong>Format File</strong>
                                <span>Format yang didukung: JPG, PNG, dan WEBP dengan maksimal 2MB.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-text-width"></i>
                            <div class="list-content">
                                <strong>Judul Singkat</strong>
                                <span>Gunakan judul singkat maksimal 60 karakter agar tampil rapi.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-mouse-pointer"></i>
                            <div class="list-content">
                                <strong>Tombol CTA</strong>
                                <span>Isi teks tombol dan link untuk mengarahkan pengunjung.</span>
                            </div>
                        </li>
                    </ul>
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
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('previewImg');
            img.src = reader.result;
            preview.style.display = 'block';
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection