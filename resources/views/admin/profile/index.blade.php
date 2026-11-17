@extends('layouts.admin')

@section('title', 'Profil Desa')
@section('page-title', 'Profil Desa')

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
    /*  SUB SECTION                                */
    /* ============================================= */
    .sub-section {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid #f0f5f0;
    }

    .sub-section:first-of-type {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
    }

    .sub-section .sub-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        font-weight: 700;
        color: #0a1a0a;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sub-section .sub-title .icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sub-section .sub-title .sub-label {
        font-size: 11px;
        color: #8a9a8a;
        font-weight: 500;
        margin-left: 6px;
        text-transform: none;
        letter-spacing: 0;
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
    /*  CURRENT IMAGE                              */
    /* ============================================= */
    .current-image {
        margin-bottom: 16px;
        border-radius: 12px;
        border: 2px solid #eef3ee;
        padding: 12px;
        background: #fafcfa;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .current-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #eef3ee;
        display: block;
        transition: all 0.3s ease;
    }

    .current-image img.rounded {
        border-radius: 50%;
    }

    .current-image img:hover {
        border-color: #d4af37;
        transform: scale(1.02);
    }

    .current-image video {
        max-width: 300px;
        border-radius: 8px;
        border: 2px solid #eef3ee;
        background: #000;
        max-height: 170px;
    }

    .current-image .current-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(46, 125, 50, 0.1);
        color: #2e7d32;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================= */
    /*  IMAGE PREVIEW                              */
    /* ============================================= */
    .image-preview {
        margin-top: 16px;
        border-radius: 12px;
        border: 2px dashed #d4af37;
        padding: 12px;
        background: #fffef5;
        position: relative;
        overflow: hidden;
        max-width: 320px;
    }

    .image-preview img {
        width: 100%;
        height: auto;
        max-height: 240px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }

    .image-preview video {
        width: 100%;
        border-radius: 8px;
        background: #000;
        max-height: 200px;
    }

    .image-preview .preview-label {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(212, 175, 55, 0.95);
        color: #0a1a0a;
        font-size: 11px;
        font-weight: 700;
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

    /* Info Box in sidebar */
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

    .info-box .info-box-value.empty {
        color: #c8dcc8;
        font-style: italic;
        font-weight: 400;
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

        .current-image {
            flex-direction: column;
            align-items: flex-start;
        }

        .current-image video {
            max-width: 100%;
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

        .current-image img {
            width: 80px;
            height: 80px;
        }

        .sub-section .sub-title {
            font-size: 13px;
            flex-wrap: wrap;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <span class="current">Profil Desa</span>
    </div>
    <h1>Profil Desa</h1>
    <p>Kelola data dan informasi profil desa yang tampil di website</p>
</div>

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
    @csrf
    @method('PUT')

    <div class="form-layout">
        <!-- ===== LEFT COLUMN: FORM ===== -->
        <div class="form-card">
            <div class="card-head">
                <div class="icon-box">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3>Informasi Profil Desa</h3>
                    <p>Kelola data dan informasi desa</p>
                </div>
            </div>

            <div class="card-body">
                <!-- ===== INFORMASI DASAR ===== -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="village_name">
                            Nama Desa
                            <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="village_name"
                               name="village_name"
                               value="{{ old('village_name', $profile->village_name ?? '') }}"
                               placeholder="Masukkan nama desa"
                               required>
                        @error('village_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="district">
                            Kecamatan
                            <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="district"
                               name="district"
                               value="{{ old('district', $profile->district ?? '') }}"
                               placeholder="Masukkan nama kecamatan"
                               required>
                        @error('district')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="regency">
                            Kabupaten
                            <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="regency"
                               name="regency"
                               value="{{ old('regency', $profile->regency ?? '') }}"
                               placeholder="Masukkan nama kabupaten"
                               required>
                        @error('regency')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province">
                            Provinsi
                            <span class="req">*</span>
                        </label>
                        <input type="text"
                               id="province"
                               name="province"
                               value="{{ old('province', $profile->province ?? '') }}"
                               placeholder="Masukkan nama provinsi"
                               required>
                        @error('province')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- ===== SEJARAH ===== -->
                <div class="form-group">
                    <label for="history">
                        Sejarah Desa
                        <span class="opt">Opsional</span>
                    </label>
                    <textarea id="history"
                              name="history"
                              rows="4"
                              placeholder="Tuliskan sejarah desa...">{{ old('history', $profile->history ?? '') }}</textarea>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Ceritakan latar belakang dan perjalanan desa.</span>
                    </div>
                    @error('history')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ===== VISI MISI ===== -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="vision">
                            Visi
                            <span class="opt">Opsional</span>
                        </label>
                        <textarea id="vision"
                                  name="vision"
                                  rows="3"
                                  placeholder="Tuliskan visi desa...">{{ old('vision', $profile->vision ?? '') }}</textarea>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Visi adalah tujuan jangka panjang desa.</span>
                        </div>
                        @error('vision')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mission">
                            Misi
                            <span class="opt">Opsional</span>
                        </label>
                        <textarea id="mission"
                                  name="mission"
                                  rows="3"
                                  placeholder="Tuliskan misi desa...">{{ old('mission', $profile->mission ?? '') }}</textarea>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Misi adalah langkah untuk mencapai visi.</span>
                        </div>
                        @error('mission')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- ===== KEPALA DESA ===== -->
                <div class="sub-section">
                    <div class="sub-title">
                        <div class="icon-wrap">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        Kepala Desa
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="head_name">
                                Nama Kepala Desa
                                <span class="req">*</span>
                            </label>
                            <input type="text"
                                   id="head_name"
                                   name="head_name"
                                   value="{{ old('head_name', $profile->head_name ?? '') }}"
                                   placeholder="Masukkan nama kepala desa"
                                   required>
                            @error('head_name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="head_message">
                                Sambutan Kepala Desa
                                <span class="opt">Opsional</span>
                            </label>
                            <textarea id="head_message"
                                      name="head_message"
                                      rows="3"
                                      placeholder="Tuliskan sambutan kepala desa...">{{ old('head_message', $profile->head_message ?? '') }}</textarea>
                            <div class="help">
                                <i class="fas fa-info-circle"></i>
                                <span>Akan ditampilkan di halaman utama.</span>
                            </div>
                            @error('head_message')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="head_photo">
                            Foto Kepala Desa
                            <span class="opt">Opsional</span>
                        </label>
                        @if($profile && $profile->head_photo)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $profile->head_photo) }}"
                                     alt="Foto Kepala Desa"
                                     class="rounded">
                                <span class="current-label">
                                    <i class="fas fa-check-circle"></i> Foto Saat Ini
                                </span>
                            </div>
                        @endif
                        <div class="file-input">
                            <input type="file"
                                   id="head_photo"
                                   name="head_photo"
                                   accept="image/*"
                                   onchange="previewImage(event, 'headPreview')">
                        </div>
                        <div class="help">
                            <i class="fas fa-image"></i>
                            <span>Format: JPG, PNG, WEBP. Maks: 2MB.</span>
                        </div>
                        <div class="image-preview" id="headPreview" style="display: none;">
                            <span class="preview-label">Foto Baru</span>
                            <img id="headPreviewImg" src="#" alt="Preview">
                        </div>
                        @error('head_photo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- ===== LOGO ===== -->
                <div class="sub-section">
                    <div class="sub-title">
                        <div class="icon-wrap">
                            <i class="fas fa-image"></i>
                        </div>
                        Logo Desa
                    </div>

                    <div class="form-group">
                        <label for="logo">
                            Logo Desa
                            <span class="opt">Opsional</span>
                        </label>
                        @if($profile && $profile->logo)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Desa">
                                <span class="current-label">
                                    <i class="fas fa-check-circle"></i> Logo Saat Ini
                                </span>
                            </div>
                        @endif
                        <div class="file-input">
                            <input type="file"
                                   id="logo"
                                   name="logo"
                                   accept="image/*"
                                   onchange="previewImage(event, 'logoPreview')">
                        </div>
                        <div class="help">
                            <i class="fas fa-image"></i>
                            <span>Format: JPG, PNG, WEBP. Maks: 1MB.</span>
                        </div>
                        <div class="image-preview" id="logoPreview" style="display: none;">
                            <span class="preview-label">Logo Baru</span>
                            <img id="logoPreviewImg" src="#" alt="Preview">
                        </div>
                        @error('logo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- ===== BACKGROUND LOGIN ===== -->
                <div class="sub-section">
                    <div class="sub-title">
                        <div class="icon-wrap">
                            <i class="fas fa-video"></i>
                        </div>
                        Background Login
                        <span class="sub-label">(Tampilan halaman login)</span>
                    </div>

                    <!-- Video Background -->
                    <div class="form-group">
                        <label for="video_background">
                            Video Background
                            <span class="opt">Opsional</span>
                        </label>
                        @if($profile && $profile->video_background)
                            <div class="current-image">
                                <video controls>
                                    <source src="{{ asset('storage/' . $profile->video_background) }}" type="video/mp4">
                                    Browser tidak mendukung video.
                                </video>
                                <span class="current-label">
                                    <i class="fas fa-check-circle"></i> Video Saat Ini
                                </span>
                            </div>
                        @endif
                        <div class="file-input">
                            <input type="file"
                                   id="video_background"
                                   name="video_background"
                                   accept="video/*"
                                   onchange="previewVideo(event)">
                        </div>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Format: MP4, WEBM, OGG. Maks: 50MB.</span>
                        </div>
                        <div class="image-preview" id="videoPreview" style="display: none;">
                            <span class="preview-label">Video Baru</span>
                            <video controls>
                                <source id="videoPreviewSrc" src="#" type="video/mp4">
                            </video>
                        </div>
                        @error('video_background')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gambar Fallback -->
                    <div class="form-group">
                        <label for="background_login">
                            Gambar Fallback
                            <span class="opt">Jika video tidak muncul</span>
                        </label>
                        @if($profile && $profile->background_login)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $profile->background_login) }}"
                                     alt="Background Login">
                                <span class="current-label">
                                    <i class="fas fa-check-circle"></i> Gambar Saat Ini
                                </span>
                            </div>
                        @endif
                        <div class="file-input">
                            <input type="file"
                                   id="background_login"
                                   name="background_login"
                                   accept="image/*"
                                   onchange="previewImage(event, 'bgPreview')">
                        </div>
                        <div class="help">
                            <i class="fas fa-image"></i>
                            <span>Format: JPG, PNG, WEBP. Maks: 5MB.</span>
                        </div>
                        <div class="image-preview" id="bgPreview" style="display: none;">
                            <span class="preview-label">Gambar Baru</span>
                            <img id="bgPreviewImg" src="#" alt="Preview">
                        </div>
                        @error('background_login')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
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
                                <span>Format yang didukung: JPG, PNG, WEBP maks 2MB, dan MP4 maks 50MB.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-user-tie"></i>
                            <div class="list-content">
                                <strong>Foto Kepala Desa</strong>
                                <span>Gunakan foto formal dengan rasio 1:1 agar tampil rapi.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-video"></i>
                            <div class="list-content">
                                <strong>Video Background</strong>
                                <span>Sediakan gambar fallback jika video gagal dimuat.</span>
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
                            <i class="fas fa-save"></i> Perbarui Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById(previewId);
            const img = document.getElementById(previewId + 'Img');
            img.src = reader.result;
            preview.style.display = 'block';
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function previewVideo(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('videoPreview');
            const source = document.getElementById('videoPreviewSrc');
            source.src = reader.result;
            preview.style.display = 'block';
            const video = preview.querySelector('video');
            video.load();
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection