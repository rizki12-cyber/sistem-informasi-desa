@extends('layouts.admin')

@section('title', 'Kelola Kontak')
@section('page-title', 'Kelola Kontak')

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
    .form-group textarea {
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
    .form-group textarea:focus {
        outline: none;
        border-color: #d4af37;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.08);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 110px;
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

    .form-group .help i.fa-whatsapp {
        color: #25D366;
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
    /*  INPUT WITH ICON                            */
    /* ============================================= */
    .input-icon {
        position: relative;
    }

    .input-icon .icon-left {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #b0bdb0;
        font-size: 15px;
        z-index: 1;
        transition: color 0.3s ease;
        pointer-events: none;
    }

    .input-icon .icon-left.wa {
        color: #25D366;
    }

    .input-icon input,
    .input-icon textarea {
        padding-left: 46px;
    }

    .input-icon input:focus + .icon-left,
    .input-icon textarea:focus + .icon-left {
        color: #d4af37;
    }

    .input-icon .icon-left.textarea-icon {
        top: 20px;
        transform: none;
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
    /*  MAP PREVIEW                                */
    /* ============================================= */
    .map-preview {
        margin-top: 14px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #eef3ee;
        background: #fafcfa;
        transition: all 0.3s ease;
        position: relative;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-preview:hover {
        border-color: #d4af37;
    }

    .map-preview iframe {
        width: 100%;
        height: 240px;
        border: none;
        display: block;
    }

    .map-preview .placeholder {
        padding: 40px 30px;
        text-align: center;
        color: #8a9a8a;
    }

    .map-preview .placeholder .icon-circle {
        width: 70px;
        height: 70px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0f5f0, #e8efe8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #c8dcc8;
    }

    .map-preview .placeholder h4 {
        font-size: 15px;
        font-weight: 700;
        color: #2d3a2d;
        margin-bottom: 4px;
        text-transform: none;
        letter-spacing: 0;
    }

    .map-preview .placeholder p {
        font-size: 12px;
        color: #8a9a8a;
        margin: 0;
        line-height: 1.5;
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

    .side-card .info-list li i.fa-whatsapp {
        color: #25D366;
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

    /* Info Box */
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
        line-height: 1.5;
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

        .map-preview {
            min-height: 180px;
        }

        .map-preview iframe {
            height: 200px;
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

        .map-preview {
            min-height: 160px;
        }

        .map-preview iframe {
            height: 180px;
        }

        .map-preview .placeholder {
            padding: 30px 20px;
        }

        .map-preview .placeholder .icon-circle {
            width: 56px;
            height: 56px;
            font-size: 22px;
        }
    }
</style>

<!-- ===== PAGE HEAD ===== -->
<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <span class="current">Kontak</span>
    </div>
    <h1>Kelola Kontak</h1>
    <p>Kelola informasi kontak dan lokasi desa yang tampil di website</p>
</div>

<form action="{{ route('admin.contact.update') }}" method="POST" id="contactForm">
    @csrf
    @method('PUT')

    <div class="form-layout">
        <!-- ===== LEFT COLUMN: FORM ===== -->
        <div class="form-card">
            <div class="card-head">
                <div class="icon-box">
                    <i class="fas fa-address-card"></i>
                </div>
                <div>
                    <h3>Informasi Kontak Desa</h3>
                    <p>Kelola data kontak dan lokasi desa</p>
                </div>
            </div>

            <div class="card-body">
                <!-- ALAMAT -->
                <div class="form-group">
                    <label for="address">
                        Alamat Lengkap
                        <span class="req">*</span>
                    </label>
                    <div class="input-icon">
                        <span class="icon-left"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text"
                               id="address"
                               name="address"
                               value="{{ old('address', $contact->address ?? '') }}"
                               placeholder="Jl. Desa No. 1, Desa Sukamaju"
                               required>
                    </div>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Alamat lengkap kantor desa.</span>
                    </div>
                    @error('address')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- TELEPON & EMAIL -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">
                            Nomor Telepon
                            <span class="req">*</span>
                        </label>
                        <div class="input-icon">
                            <span class="icon-left"><i class="fas fa-phone"></i></span>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $contact->phone ?? '') }}"
                                   placeholder="(021) 1234-5678"
                                   required>
                        </div>
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            Email
                            <span class="req">*</span>
                        </label>
                        <div class="input-icon">
                            <span class="icon-left"><i class="fas fa-envelope"></i></span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $contact->email ?? '') }}"
                                   placeholder="desa@email.test"
                                   required>
                        </div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- WHATSAPP & JAM PELAYANAN -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="whatsapp">
                            Nomor WhatsApp
                            <span class="opt">Opsional</span>
                        </label>
                        <div class="input-icon">
                            <span class="icon-left wa"><i class="fab fa-whatsapp"></i></span>
                            <input type="text"
                                   id="whatsapp"
                                   name="whatsapp"
                                   value="{{ old('whatsapp', $contact->whatsapp ?? '') }}"
                                   placeholder="0821-xxxx-xxxx">
                        </div>
                        <div class="help">
                            <i class="fab fa-whatsapp"></i>
                            <span>Nomor untuk link WhatsApp.</span>
                        </div>
                        @error('whatsapp')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="working_hours">
                            Jam Pelayanan
                            <span class="opt">Opsional</span>
                        </label>
                        <div class="input-icon">
                            <span class="icon-left"><i class="fas fa-clock"></i></span>
                            <input type="text"
                                   id="working_hours"
                                   name="working_hours"
                                   value="{{ old('working_hours', $contact->working_hours ?? '') }}"
                                   placeholder="Senin - Jumat: 08:00 - 16:00 WIB">
                        </div>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Jam operasional pelayanan kantor desa.</span>
                        </div>
                        @error('working_hours')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- MAP EMBED -->
                <div class="form-group" style="margin-bottom:0;">
                    <label for="map_embed">
                        Embed Google Maps
                        <span class="opt">Opsional</span>
                    </label>
                    <div class="input-icon">
                        <span class="icon-left textarea-icon"><i class="fas fa-map"></i></span>
                        <textarea id="map_embed"
                                  name="map_embed"
                                  rows="4"
                                  placeholder="<iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...></iframe>">{{ old('map_embed', $contact->map_embed ?? '') }}</textarea>
                    </div>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Salin kode embed dari Google Maps untuk menampilkan peta lokasi desa.</span>
                    </div>
                    @error('map_embed')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- MAP PREVIEW -->
                    <div class="map-preview" id="mapPreview">
                        @if($contact && $contact->map_embed)
                            {!! $contact->map_embed !!}
                        @else
                            <div class="placeholder">
                                <div class="icon-circle">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <h4>Belum Ada Peta</h4>
                                <p>Tambahkan embed Google Maps di atas untuk melihat preview</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: SIDEBAR ===== -->
        <div>
            <!-- INFO KONTAK -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-info-circle"></i> Info Kontak</h4>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <div class="info-box-label">Alamat</div>
                        <div class="info-box-value {{ $contact && $contact->address ? '' : 'empty' }}">
                            {{ $contact && $contact->address ? $contact->address : 'Belum diisi' }}
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Telepon</div>
                        <div class="info-box-value {{ $contact && $contact->phone ? '' : 'empty' }}">
                            {{ $contact && $contact->phone ? $contact->phone : 'Belum diisi' }}
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Email</div>
                        <div class="info-box-value {{ $contact && $contact->email ? '' : 'empty' }}">
                            {{ $contact && $contact->email ? $contact->email : 'Belum diisi' }}
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">WhatsApp</div>
                        <div class="info-box-value {{ $contact && $contact->whatsapp ? '' : 'empty' }}">
                            {{ $contact && $contact->whatsapp ? $contact->whatsapp : 'Belum diisi' }}
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-label">Peta</div>
                        <div class="info-box-value {{ $contact && $contact->map_embed ? '' : 'empty' }}">
                            {{ $contact && $contact->map_embed ? 'Tersedia' : 'Belum diisi' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANDUAN -->
            <div class="side-card">
                <div class="card-head">
                    <h4><i class="fas fa-lightbulb"></i> Panduan</h4>
                </div>
                <div class="card-body">
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="list-content">
                                <strong>Alamat</strong>
                                <span>Tuliskan alamat lengkap kantor desa.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <div class="list-content">
                                <strong>Telepon</strong>
                                <span>Nomor telepon yang bisa dihubungi.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fab fa-whatsapp"></i>
                            <div class="list-content">
                                <strong>WhatsApp</strong>
                                <span>Nomor ini akan ditautkan ke tombol WhatsApp.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-map"></i>
                            <div class="list-content">
                                <strong>Peta</strong>
                                <span>Salin embed code dari Google Maps.</span>
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
                            <i class="fas fa-save"></i> Perbarui
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // ===== LIVE MAP PREVIEW =====
    document.addEventListener('DOMContentLoaded', function() {
        const mapInput = document.getElementById('map_embed');
        const mapPreview = document.getElementById('mapPreview');

        if (mapInput && mapPreview) {
            mapInput.addEventListener('input', function() {
                const value = this.value.trim();

                if (value && value.includes('<iframe')) {
                    mapPreview.innerHTML = value;
                } else if (!value) {
                    mapPreview.innerHTML = `
                        <div class="placeholder">
                            <div class="icon-circle">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h4>Belum Ada Peta</h4>
                            <p>Tambahkan embed Google Maps di atas untuk melihat preview</p>
                        </div>
                    `;
                }
            });
        }
    });
</script>
@endsection