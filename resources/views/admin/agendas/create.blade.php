@extends('layouts.admin')

@section('title', 'Tambah Agenda')
@section('page-title', 'Tambah Agenda')

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
        <a href="{{ route('admin.agendas.index') }}">Agenda</a>
        <span class="sep">/</span>
        <span class="current">Tambah</span>
    </div>
    <h1>Tambah Agenda Baru</h1>
    <p>Buat jadwal kegiatan dan acara desa</p>
</div>

<form action="{{ route('admin.agendas.store') }}" method="POST" id="agendaForm">
    @csrf

    <div class="form-layout">
        <!-- ===== LEFT COLUMN: FORM ===== -->
        <div class="form-card">
            <div class="card-head">
                <div class="icon-box">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h3>Informasi Agenda</h3>
                    <p>Isi data agenda di bawah ini</p>
                </div>
            </div>

            <div class="card-body">
                <!-- JUDUL -->
                <div class="form-group">
                    <label for="title">
                        Judul Agenda
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="Masukkan judul agenda"
                           required>
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
                              placeholder="Tuliskan deskripsi kegiatan...">{{ old('description') }}</textarea>
                    <div class="help">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi tambahan tentang kegiatan.</span>
                    </div>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- LOKASI -->
                <div class="form-group">
                    <label for="location">
                        Lokasi
                        <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="location"
                           name="location"
                           value="{{ old('location') }}"
                           placeholder="Masukkan lokasi kegiatan"
                           required>
                    <div class="help">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Tempat pelaksanaan kegiatan.</span>
                    </div>
                    @error('location')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- TANGGAL & STATUS -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date">
                            Tanggal
                            <span class="req">*</span>
                        </label>
                        <input type="date"
                               id="event_date"
                               name="event_date"
                               value="{{ old('event_date') }}"
                               required>
                        @error('event_date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">
                            Status
                            <span class="req">*</span>
                        </label>
                        <select id="status" name="status" required>
                            <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <div class="help">
                            <i class="fas fa-info-circle"></i>
                            <span>Status kegiatan saat ini.</span>
                        </div>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- WAKTU -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_time">
                            Waktu Mulai
                            <span class="opt">Opsional</span>
                        </label>
                        <input type="time"
                               id="start_time"
                               name="start_time"
                               value="{{ old('start_time') }}">
                        <div class="help">
                            <i class="fas fa-clock"></i>
                            <span>Waktu dimulainya kegiatan.</span>
                        </div>
                        @error('start_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_time">
                            Waktu Selesai
                            <span class="opt">Opsional</span>
                        </label>
                        <input type="time"
                               id="end_time"
                               name="end_time"
                               value="{{ old('end_time') }}">
                        <div class="help">
                            <i class="fas fa-clock"></i>
                            <span>Harus setelah waktu mulai.</span>
                        </div>
                        @error('end_time')
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
                            <i class="fas fa-heading"></i>
                            <div class="list-content">
                                <strong>Judul Singkat</strong>
                                <span>Gunakan judul singkat maksimal 70 karakter agar tampil rapi.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="list-content">
                                <strong>Lokasi Jelas</strong>
                                <span>Tuliskan lokasi kegiatan dengan detail agar mudah ditemukan.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <div class="list-content">
                                <strong>Waktu Kegiatan</strong>
                                <span>Isi waktu mulai dan selesai agar masyarakat tahu jadwalnya.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-info-circle"></i>
                            <div class="list-content">
                                <strong>Status</strong>
                                <span>Sesuaikan status dengan kondisi kegiatan saat ini.</span>
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
                        <a href="{{ route('admin.agendas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection