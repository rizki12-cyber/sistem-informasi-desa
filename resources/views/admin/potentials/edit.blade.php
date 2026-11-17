@extends('layouts.admin')

@section('title', 'Edit Potensi Desa')
@section('page-title', 'Edit Potensi Desa')

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
        min-height: 120px;
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
        width: 160px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #eef3ee;
        display: block;
        transition: all 0.3s ease;
    }

    .current-image img:hover {
        border-color: #d4af37;
        transform: scale(1.02);
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

        .current-image {
            flex-direction: column;
            align-items: flex-start;
        }

        .current-image img {
            width: 100%;
            height: auto;
            max-height: 140px;
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
        <a href="{{ route('admin.potentials.index') }}">Potensi Desa</a>
        <span class="sep">/</span>
        <span class="current">Edit</span>
    </div>
    <h1>Edit Potensi Desa</h1>
    <p>Perbarui informasi potensi desa yang sudah ada</p>
</div>

<form action="{{ route('admin.potentials.update', $potential) }}" method="POST" enctype="multipart/form-data" id="potentialForm">
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
                    <h3>Informasi Potensi</h3>
                    <p>Perbarui data potensi desa di bawah ini</p>
                </div>
            </div>

            <div class="card-body">
                <!-- JUDUL -->
                <div class="form-group">
                    <label for="title">
                        Judul Potensi
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $potential->title) }}"
                           placeholder="Masukkan judul potensi"
                           required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- KATEGORI -->
                <div class="form-group">
                    <label for="category">
                        Kategori
                        <span class="req">*</span>
                    </label>
                    <select id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $potential->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <div class="help">
                        <i class="fas fa-tag"></i>
                        <span>Pilih kategori yang sesuai dengan potensi desa.</span>
                    </div>
                    @error('category')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- DESKRIPSI -->
                <div class="form-group">
                    <label for="description">
                        Deskripsi
                        <span class="req">*</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Tuliskan deskripsi potensi desa secara lengkap..."
                              required>{{ old('description', $potential->description) }}</textarea>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Jelaskan secara detail tentang potensi yang dimiliki desa.</span>
                    </div>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- GAMBAR -->
                <div class="form-group" style="margin-bottom:0;">
                    <label for="image">
                        Gambar
                        <span class="opt">Biarkan kosong jika tidak diganti</span>
                    </label>

                    @if($potential->image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $potential->image) }}"
                                 alt="{{ $potential->title }}">
                            <span class="current-label">
                                <i class="fas fa-check-circle"></i> Gambar Saat Ini
                            </span>
                        </div>
                    @endif

                    <div class="file-input">
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/*"
                               onchange="previewImage(event, 'imagePreview')">
                    </div>
                    <div class="help">
                        <i class="fas fa-image"></i>
                        <span>Format: JPG, PNG, WEBP. Maks: 2MB. Rekomendasi: 800×600 px.</span>
                    </div>

                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <span class="preview-label">Gambar Baru</span>
                        <img id="imagePreviewImg" src="#" alt="Preview">
                    </div>

                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: SIDEBAR ===== -->
        <div>
            <!-- INFO POTENSI -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-info-circle"></i> Info Potensi</h4>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <div class="info-box-label">ID Potensi</div>
                        <div class="info-box-value">#{{ $potential->id }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Kategori</div>
                        <div class="info-box-value">{{ $potential->category }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Dibuat</div>
                        <div class="info-box-value">{{ $potential->created_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Diperbarui</div>
                        <div class="info-box-value">{{ $potential->updated_at->translatedFormat('d F Y, H:i') }}</div>
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
                        <a href="{{ route('admin.potentials.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
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
</script>
@endsection