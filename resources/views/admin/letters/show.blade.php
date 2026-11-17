@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')
@section('page-title', 'Detail Permohonan Surat')

@section('content')
<style>
    .page-head { margin-bottom: 28px; }
    .page-head .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #8a9a8a; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }
    .page-head .breadcrumb a { color: #8a9a8a; text-decoration: none; }
    .page-head .breadcrumb a:hover { color: #d4af37; }
    .page-head .breadcrumb .sep { color: #d0d8d0; }
    .page-head .breadcrumb .current { color: #d4af37; }
    .page-head h1 { font-size: 24px; font-weight: 700; color: #0a1a0a; margin: 0 0 4px; }
    .page-head p { font-size: 14px; color: #6a7a6a; margin: 0; }

    .layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
    .card { background: #fff; border-radius: 18px; border: 1px solid #eef3ee; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.03); margin-bottom: 24px; }
    .card .card-head { display: flex; align-items: center; gap: 14px; padding: 20px 24px; border-bottom: 1px solid #f0f5f0; background: linear-gradient(180deg, #fafcfa, #fff); }
    .card .card-head .icon-box { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05)); display: flex; align-items: center; justify-content: center; color: #d4af37; font-size: 18px; flex-shrink: 0; }
    .card .card-head h3 { font-size: 16px; font-weight: 700; color: #0a1a0a; margin: 0; }
    .card .card-head p { font-size: 12px; color: #8a9a8a; margin: 2px 0 0; }
    .card .card-body { padding: 28px 24px; }

    .ticket-banner { display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05)); border: 1px dashed rgba(212,175,55,0.4); padding: 10px 20px; border-radius: 12px; font-family: 'Courier New', monospace; font-size: 16px; font-weight: 700; color: #b8912a; letter-spacing: 1px; margin-bottom: 20px; }

    .info-row { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px dashed #f0f5f0; }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label { min-width: 130px; font-size: 11px; font-weight: 700; color: #8a9a8a; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 3px; }
    .info-row .info-value { flex: 1; font-size: 14px; color: #0a1a0a; font-weight: 500; word-break: break-word; }

    .info-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
    .info-grid-2 .info-row { min-height: 50px; }

    /* Data dinamis — kotak tersendiri */
    .dynamic-data {
        background: linear-gradient(135deg, #fdf9ea, #fefcf2);
        border: 1px solid rgba(212,175,55,0.25);
        border-radius: 14px;
        padding: 20px 22px;
        margin-top: 16px;
        position: relative;
    }
    .dynamic-data::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #d4af37, #f0d060);
        border-radius: 14px 14px 0 0;
    }
    .dynamic-data .head {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px dashed rgba(212,175,55,0.3);
    }
    .dynamic-data .head i {
        color: #d4af37;
        font-size: 16px;
    }
    .dynamic-data .head h4 {
        font-size: 13px; font-weight: 800; color: #0a1a0a;
        text-transform: uppercase; letter-spacing: 0.5px; margin: 0;
    }

    .message-box { background: #fafcfa; border: 1px solid #eef3ee; border-radius: 12px; padding: 18px 20px; font-size: 14px; line-height: 1.8; color: #2d3a2d; white-space: pre-line; }

    .attachment-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; }
    .attachment-item { position: relative; border-radius: 12px; overflow: hidden; background: #f0f5f0; aspect-ratio: 1; border: 2px solid #eef3ee; display: block; text-decoration: none; transition: all 0.3s ease; }
    .attachment-item:hover { border-color: #d4af37; transform: scale(1.02); box-shadow: 0 8px 24px rgba(212,175,55,0.2); }
    .attachment-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .attachment-item .pdf-view {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        width: 100%; height: 100%; color: #d4af37; gap: 6px;
    }
    .attachment-item .pdf-view i { font-size: 40px; }
    .attachment-item .pdf-view span { font-size: 11px; color: #6a7a6a; font-weight: 700; }
    .attachment-item .badge-type { position: absolute; top: 6px; left: 6px; background: rgba(212,175,55,0.95); color: #0a1a0a; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 50px; text-transform: uppercase; }
    .attachment-item .overlay-link { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); color: #fff; opacity: 0; font-size: 24px; transition: opacity 0.3s; }
    .attachment-item:hover .overlay-link { opacity: 1; }

    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .badge-pending { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
    .badge-pending .dot { background: #3b82f6; animation: pulse-dot 2s infinite; }
    .badge-processing { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
    .badge-processing .dot { background: #f59e0b; }
    .badge-ready { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
    .badge-ready .dot { background: #22c55e; }
    .badge-rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
    .badge-rejected .dot { background: #ef4444; }
    @keyframes pulse-dot { 0%,100% { opacity:1; } 50% { opacity:0.5; } }

    .form-group { margin-bottom: 22px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group label { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #2d3a2d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group label .req { color: #d32f2f; font-size: 14px; }
    .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #eef3ee; border-radius: 12px; font-size: 14px; font-family: inherit; transition: all 0.3s ease; background: #fafcfa; color: #0a1a0a; }
    .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #d4af37; background: #fff; box-shadow: 0 0 0 4px rgba(212,175,55,0.08); }
    .form-group textarea { resize: vertical; min-height: 120px; line-height: 1.6; }

    .form-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.3s ease; font-family: inherit; line-height: 1; }
    .btn-primary { background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; box-shadow: 0 4px 16px rgba(212,175,55,0.25); flex: 1; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,175,55,0.35); color: #0a1a0a; }
    .btn-secondary { background: #f0f5f0; color: #2d3a2d; }
    .btn-secondary:hover { background: #e0e8e0; color: #0a1a0a; transform: translateY(-2px); }

    .info-box { padding: 12px 14px; background: #fafcfa; border: 1px solid #eef3ee; border-radius: 10px; margin-bottom: 12px; }
    .info-box:last-child { margin-bottom: 0; }
    .info-box .info-box-label { font-size: 10px; font-weight: 700; color: #8a9a8a; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .info-box .info-box-value { font-size: 13px; font-weight: 600; color: #2d3a2d; }

    /* ============================================= */
    /*  PDF PREVIEW CARD (kalau status ready)       */
    /* ============================================= */
    .pdf-card {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 2px solid #86efac;
        border-radius: 16px;
        padding: 20px 22px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .pdf-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, #22c55e, #4ade80);
    }
    .pdf-card .pdf-head {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 14px;
    }
    .pdf-card .pdf-head .avatar {
        width: 48px; height: 48px; border-radius: 12px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff; font-size: 22px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(34,197,94,0.35);
    }
    .pdf-card .pdf-head .info { flex: 1; }
    .pdf-card .pdf-head .info h4 {
        font-size: 15px; font-weight: 800; color: #065f46;
        margin: 0 0 2px;
        display: flex; align-items: center; gap: 8px;
    }
    .pdf-card .pdf-head .info h4 i { font-size: 12px; color: #16a34a; }
    .pdf-card .pdf-head .info p {
        font-size: 12px; color: #16a34a; margin: 0; font-weight: 500;
    }
    .pdf-card .pdf-actions {
        display: flex; gap: 10px; flex-wrap: wrap;
    }
    .pdf-card .pdf-actions .btn {
        padding: 10px 20px;
        font-size: 13px;
    }
    .btn-pdf {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(34,197,94,0.3);
    }
    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34,197,94,0.4);
    }
    .btn-pdf-outline {
        background: rgba(255,255,255,0.7);
        color: #065f46 !important;
        border: 1px solid #86efac;
    }
    .btn-pdf-outline:hover {
        background: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) { .layout { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .card .card-body { padding: 20px 18px; }
        .info-row { flex-direction: column; gap: 4px; }
        .info-row .info-label { min-width: 0; }
        .info-grid-2 { grid-template-columns: 1fr; }
        .dynamic-data { padding: 16px 18px; }
    }
</style>

<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <a href="{{ route('admin.letters.index') }}">Surat Menyurat</a>
        <span class="sep">/</span>
        <span class="current">Detail</span>
    </div>
    <h1>Detail Permohonan Surat</h1>
    <p>Review dan proses permohonan surat dari warga</p>
</div>

<div class="layout">
    <div>
        {{-- ============================================= --}}
        {{-- PDF READY CARD (tampil kalau status ready) --}}
        {{-- ============================================= --}}
        @if($letter->status === 'ready')
            <div class="pdf-card">
                <div class="pdf-head">
                    <div class="avatar"><i class="fas fa-file-pdf"></i></div>
                    <div class="info">
                        <h4>
                            PDF Surat Tersedia
                            @if($letter->pdf_generated_at)
                                <i class="fas fa-check-circle" title="Sudah digenerate"></i>
                            @endif
                        </h4>
                        <p>
                            @if($letter->pdf_generated_at)
                                Digenerate pada {{ $letter->pdf_generated_at->translatedFormat('d F Y, H:i') }}
                            @else
                                Belum digenerate — klik tombol untuk generate
                            @endif
                        </p>
                    </div>
                </div>
                <div class="pdf-actions">
                    <a href="{{ route('admin.letters.downloadPdf', $letter) }}" class="btn btn-pdf">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    <a href="{{ route('admin.letters.downloadPdf', $letter) }}" target="_blank" class="btn btn-pdf-outline">
                        <i class="fas fa-eye"></i> Preview PDF
                    </a>
                </div>
            </div>
        @endif

        {{-- ============================================= --}}
        {{-- DATA PEMOHON --}}
        {{-- ============================================= --}}
        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-user"></i></div>
                <div>
                    <h3>Data Pemohon</h3>
                    <p>Diajukan pada {{ $letter->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
            <div class="card-body">
                <div class="ticket-banner">
                    <i class="fas fa-ticket-alt"></i>
                    {{ $letter->request_number }}
                </div>

                <div class="info-grid-2">
                    <div class="info-row">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $letter->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NIK</div>
                        <div class="info-value" style="font-family: 'Courier New', monospace;">{{ $letter->nik }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tempat Lahir</div>
                        <div class="info-value">{{ $letter->birth_place ?: '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">{{ $letter->birth_date ? $letter->birth_date->translatedFormat('d F Y') : '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">{{ $letter->gender === 'L' ? 'Laki-laki' : ($letter->gender === 'P' ? 'Perempuan' : '-') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Agama</div>
                        <div class="info-value">{{ $letter->religion ?: '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status Kawin</div>
                        <div class="info-value">{{ $letter->marital_status ?: '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Pekerjaan</div>
                        <div class="info-value">{{ $letter->occupation ?: '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value"><a href="mailto:{{ $letter->email }}" style="color:#d4af37;text-decoration:none;">{{ $letter->email }}</a></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">No. HP</div>
                        <div class="info-value">
                            @if($letter->phone)
                                <a href="tel:{{ $letter->phone }}" style="color:#d4af37;text-decoration:none;">{{ $letter->phone }}</a>
                            @else - @endif
                        </div>
                    </div>
                </div>

                <div class="info-row" style="flex-direction: column; gap: 8px; border-bottom: none; margin-top: 8px;">
                    <div class="info-label" style="padding-top: 0;">Alamat</div>
                    <div class="info-value">{{ $letter->address }}</div>
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- DETAIL PERMOHONAN --}}
        {{-- ============================================= --}}
        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-file-alt"></i></div>
                <div>
                    <h3>Detail Permohonan</h3>
                    <p>Jenis surat & keperluan</p>
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <div class="info-label">Jenis Surat</div>
                    <div class="info-value" style="font-weight:700;color:#b8912a;">{{ $letter->letterType->name ?? '-' }}</div>
                </div>

                {{-- ============================================= --}}
                {{-- DATA DINAMIS (per jenis surat)               --}}
                {{-- ============================================= --}}
                @if($letter->letter_data && is_array($letter->letter_data) && count(array_filter($letter->letter_data)) > 0)
                    <div class="dynamic-data">
                        <div class="head">
                            <i class="fas fa-list-alt"></i>
                            <h4>Data Tambahan ({{ $letter->letterType->name }})</h4>
                        </div>

                        @foreach($letter->letter_data as $key => $value)
                            @if($value !== null && $value !== '')
                                @php
                                    $label = \App\Models\LetterType::getFieldLabel($letter->letterType->slug, $key);
                                @endphp
                                <div class="info-row" style="border-bottom: 1px dashed rgba(212,175,55,0.2); padding: 10px 0;">
                                    <div class="info-label" style="min-width: 180px; color: #b8912a;">{{ $label }}</div>
                                    <div class="info-value">{{ $value }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="info-row" style="flex-direction: column; gap: 12px; margin-top: 16px;">
                    <div class="info-label" style="padding-top: 0;">Keperluan</div>
                    <div class="message-box">{{ $letter->purpose }}</div>
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- BERKAS PENDUKUNG --}}
        {{-- ============================================= --}}
        @if($letter->attachments && count($letter->attachments) > 0)
            <div class="card">
                <div class="card-head">
                    <div class="icon-box"><i class="fas fa-paperclip"></i></div>
                    <div>
                        <h3>Berkas Pendukung</h3>
                        <p>{{ count($letter->attachments) }} berkas diupload</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="attachment-grid">
                        @foreach($letter->attachments as $file)
                            @php $url = asset('storage/' . $file); @endphp
                            @if($letter->isImage($file))
                                <a href="{{ $url }}" target="_blank" class="attachment-item">
                                    <img src="{{ $url }}" alt="Berkas">
                                    <span class="badge-type">Foto</span>
                                    <div class="overlay-link"><i class="fas fa-search-plus"></i></div>
                                </a>
                            @else
                                <a href="{{ $url }}" target="_blank" class="attachment-item">
                                    <div class="pdf-view">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>Buka PDF</span>
                                    </div>
                                    <span class="badge-type">PDF</span>
                                    <div class="overlay-link"><i class="fas fa-external-link-alt"></i></div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h3>Status</h3>
                    <p>Saat ini</p>
                </div>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <div class="info-box-label">Status Permohonan</div>
                    <div class="info-box-value">
                        <span class="badge {{ $letter->status_badge }}">
                            <span class="dot"></span>
                            {{ $letter->status_label }}
                        </span>
                    </div>
                </div>
                @if($letter->processed_at)
                    <div class="info-box">
                        <div class="info-box-label">Terakhir Diproses</div>
                        <div class="info-box-value">{{ $letter->processed_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-cog"></i></div>
                <div>
                    <h3>Update Status</h3>
                    <p>Ubah status & tulis catatan</p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.letters.update', $letter) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="status">Status <span class="req">*</span></label>
                        <select id="status" name="status" required>
                            <option value="pending" {{ old('status', $letter->status) === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="processing" {{ old('status', $letter->status) === 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="ready" {{ old('status', $letter->status) === 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                            <option value="rejected" {{ old('status', $letter->status) === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Catatan untuk Warga</label>
                        <textarea id="admin_notes" name="admin_notes" placeholder="Tulis catatan atau instruksi untuk warga...">{{ old('admin_notes', $letter->admin_notes) }}</textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.letters.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection