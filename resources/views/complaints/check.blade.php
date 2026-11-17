@extends('layouts.app')

@section('title', 'Cek Status Pengaduan - ' . ($profile->village_name ?? 'Desa'))
@section('description', 'Cek status pengaduan Anda dengan nomor tiket')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #0a1a0a 0%, #1a3a1a 100%);
        padding: 140px 0 60px;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -30%; right: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%);
        border-radius: 50%;
    }
    .page-header .container { position: relative; z-index: 1; }
    .page-header .breadcrumb {
        display: flex; align-items: center; gap: 8px;
        color: rgba(255,255,255,0.4); font-size: 14px; margin-bottom: 16px;
    }
    .page-header .breadcrumb a { color: rgba(255,255,255,0.6); text-decoration: none; transition: color 0.3s ease; }
    .page-header .breadcrumb a:hover { color: #d4af37; }
    .page-header .breadcrumb .separator { color: rgba(255,255,255,0.2); }
    .page-header .breadcrumb .current { color: #d4af37; }
    .page-header h1 { font-size: 42px; font-weight: 700; color: #fff; margin-bottom: 12px; line-height: 1.2; }
    .page-header h1 span { color: #d4af37; }
    .page-header p { color: rgba(255,255,255,0.7); font-size: 18px; max-width: 620px; line-height: 1.7; }

    .page-main { padding: 60px 0 80px; background: #f8faf8; }

    .search-card {
        background: #fff; border-radius: 24px;
        padding: 36px 40px; max-width: 720px; margin: 0 auto 32px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        border: 1px solid #eef3ee;
    }
    .search-card .card-head {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 24px; padding-bottom: 18px;
        border-bottom: 2px solid #f0f5f0;
    }
    .search-card .card-head .icon-box {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a; font-size: 22px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(212,175,55,0.25);
    }
    .search-card .card-head h2 { font-size: 20px; font-weight: 700; color: #0a1a0a; margin: 0; }
    .search-card .card-head p { font-size: 14px; color: #8a9a8a; margin: 2px 0 0; }

    .search-form-2 { display: flex; flex-direction: column; gap: 16px; }
    .search-form-2 .form-field { display: flex; flex-direction: column; gap: 8px; }
    .search-form-2 .form-field label {
        font-size: 12px; font-weight: 700; color: #2d3a2d;
        text-transform: uppercase; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 6px;
    }
    .search-form-2 .form-field label i { color: #d4af37; font-size: 12px; }
    .search-form-2 .form-field input {
        width: 100%; padding: 14px 18px;
        border: 2px solid #eef3ee; border-radius: 12px;
        font-size: 15px; font-family: 'Courier New', monospace;
        font-weight: 700; letter-spacing: 1px;
        background: #fafcfa; color: #0a1a0a;
        transition: all 0.3s ease;
    }
    .search-form-2 .form-field input[type="email"] {
        font-family: 'Inter', sans-serif; font-weight: 500;
        letter-spacing: 0.3px; text-transform: none;
    }
    .search-form-2 .form-field input:focus {
        outline: none; border-color: #d4af37;
        background: #fff; box-shadow: 0 0 0 4px rgba(212,175,55,0.08);
    }
    .search-form-2 .form-field input::placeholder {
        color: #b0bdb0; font-family: 'Inter', sans-serif;
        font-weight: 400; letter-spacing: 0; text-transform: none;
    }
    .search-form-2 .form-field .field-error {
        color: #d32f2f; font-size: 12px; font-weight: 500;
    }
    .search-form-2 .btn-check {
        padding: 15px 32px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a; border: none; border-radius: 12px;
        font-size: 15px; font-weight: 800; cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(212,175,55,0.3);
        text-transform: uppercase; letter-spacing: 0.5px;
        display: inline-flex; align-items: center; justify-content: center;
        gap: 8px; margin-top: 4px;
    }
    .search-form-2 .btn-check:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212,175,55,0.4);
    }

    .alert-error {
        background: #fef2f2; border: 1px solid #fecaca;
        color: #991b1b; padding: 14px 18px;
        border-radius: 12px; font-size: 14px;
        margin-top: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    .alert-error i { color: #dc2626; font-size: 18px; }

    .security-notice {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; background: #f0fdf4;
        border: 1px solid #bbf7d0; border-radius: 10px;
        font-size: 12px; color: #166534;
        line-height: 1.5; margin-top: 14px;
    }
    .security-notice i {
        color: #22c55e; font-size: 14px;
        flex-shrink: 0; margin-top: 2px;
    }

    /* ===== HASIL ===== */
    .result-card {
        background: #fff; border-radius: 24px;
        padding: 36px 40px; max-width: 860px; margin: 0 auto;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        border: 1px solid #eef3ee;
    }

    .ticket-banner {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; flex-wrap: wrap;
        background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(212,175,55,0.03));
        border: 1px dashed rgba(212,175,55,0.4);
        padding: 18px 24px; border-radius: 16px;
        margin-bottom: 28px;
    }
    .ticket-banner .left { display: flex; align-items: center; gap: 14px; }
    .ticket-banner .left .icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a; font-size: 20px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ticket-banner .label { font-size: 11px; font-weight: 700; color: #8a9a8a; text-transform: uppercase; letter-spacing: 0.5px; }
    .ticket-banner .code {
        font-family: 'Courier New', monospace;
        font-size: 20px; font-weight: 800; color: #b8912a;
        letter-spacing: 1.5px; margin-top: 2px;
    }

    .status-badge-large {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 12px 24px; border-radius: 50px;
        font-size: 14px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .status-badge-large .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }

    .badge-new { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
    .badge-new .dot { background: #3b82f6; animation: pulse-dot 2s infinite; }
    .badge-progress { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
    .badge-progress .dot { background: #f59e0b; }
    .badge-resolved { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
    .badge-resolved .dot { background: #22c55e; }
    .badge-rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
    .badge-rejected .dot { background: #ef4444; }
    @keyframes pulse-dot { 0%,100% { opacity:1; } 50% { opacity:0.5; } }

    .info-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
    .info-box {
        padding: 16px 18px; background: #fafcfa;
        border: 1px solid #eef3ee; border-radius: 12px;
    }
    .info-box .label { font-size: 11px; font-weight: 700; color: #8a9a8a; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .info-box .value { font-size: 15px; color: #0a1a0a; font-weight: 600; word-break: break-word; }

    .section-title {
        display: flex; align-items: center; gap: 10px;
        font-size: 14px; font-weight: 800; color: #0a1a0a;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin: 28px 0 14px; padding-bottom: 10px;
        border-bottom: 2px solid #f0f5f0;
    }
    .section-title i { color: #d4af37; font-size: 16px; }

    .message-box {
        background: #fafcfa; border: 1px solid #eef3ee;
        border-radius: 12px; padding: 18px 20px;
        font-size: 14px; line-height: 1.8;
        color: #2d3a2d; white-space: pre-line;
    }

    /* ============================================= */
    /*  TIMELINE RIWAYAT STATUS                     */
    /* ============================================= */
    .timeline {
        position: relative;
        padding-left: 32px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 11px; top: 8px; bottom: 8px;
        width: 2px;
        background: linear-gradient(180deg, #22c55e, #d4af37, #e5e7eb);
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item .dot {
        position: absolute;
        left: -32px; top: 2px;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #d4af37;
        display: flex; align-items: center; justify-content: center;
        font-size: 10px;
        color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212,175,55,0.08);
    }
    .timeline-item .dot.done {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        border-color: #22c55e;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(34,197,94,0.12);
    }
    .timeline-item .dot.done i { color: #fff; }
    .timeline-item .dot.active {
        background: linear-gradient(135deg, #f0d060, #d4af37);
        border-color: #d4af37;
        color: #0a1a0a;
        animation: pulse-timeline 2s infinite;
    }
    @keyframes pulse-timeline {
        0%,100% { box-shadow: 0 0 0 4px rgba(212,175,55,0.15); }
        50% { box-shadow: 0 0 0 8px rgba(212,175,55,0.05); }
    }
    .timeline-item .content { padding-top: 1px; }
    .timeline-item .title {
        font-size: 14px; font-weight: 700; color: #0a1a0a;
        margin-bottom: 3px;
        display: flex; align-items: center; gap: 8px;
        flex-wrap: wrap;
    }
    .timeline-item .title .mini-badge {
        font-size: 9px; font-weight: 700;
        padding: 2px 8px; border-radius: 50px;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .timeline-item .time {
        font-size: 12px; color: #8a9a8a;
        display: flex; align-items: center; gap: 6px;
    }
    .timeline-item .time i { color: #d4af37; font-size: 11px; }

    /* ============================================= */
    /*  REPLY BOX — border rata 2px, TANPA ::before */
    /*  CLEAN, tidak ada garis dobel / tebal        */
    /* ============================================= */
    .reply-box {
        border-radius: 16px;
        padding: 22px 24px;
        border: 2px solid;
    }

    .reply-box .reply-head {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 14px; padding-bottom: 14px;
        border-bottom: 1px solid;
        flex-wrap: wrap;
    }
    .reply-box .reply-head .avatar {
        width: 44px; height: 44px; border-radius: 50%;
        color: #fff; font-size: 18px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .reply-box .reply-head .who { flex: 1; min-width: 0; }
    .reply-box .reply-head .who .name {
        font-size: 15px; font-weight: 700;
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .reply-box .reply-head .who .name .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 10px; font-weight: 800;
        padding: 3px 10px; border-radius: 50px;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .reply-box .reply-head .who .name .status-pill .pill-dot {
        width: 6px; height: 6px; border-radius: 50%; display: inline-block;
    }
    .reply-box .reply-head .who .time {
        font-size: 12px; font-weight: 500; margin-top: 3px;
        display: flex; align-items: center; gap: 6px;
    }
    .reply-box .reply-body {
        font-size: 14px; line-height: 1.8;
        white-space: pre-line;
    }

    /* ===== BIRU — Menunggu (new) ===== */
    .reply-box.reply-new {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-color: #93c5fd;
    }
    .reply-box.reply-new .reply-head { border-bottom-color: rgba(59,130,246,0.2); }
    .reply-box.reply-new .reply-head .avatar {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }
    .reply-box.reply-new .reply-head .who .name { color: #1e40af; }
    .reply-box.reply-new .reply-head .who .name .status-pill {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }
    .reply-box.reply-new .reply-head .who .name .status-pill .pill-dot {
        background: #3b82f6;
        animation: pulse-dot 2s infinite;
    }
    .reply-box.reply-new .reply-head .who .time { color: #2563eb; }
    .reply-box.reply-new .reply-head .who .time i { color: #3b82f6; }
    .reply-box.reply-new .reply-body { color: #1e40af; }

    /* ===== KUNING — Diproses (in_progress) ===== */
    .reply-box.reply-in_progress {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-color: #fcd34d;
    }
    .reply-box.reply-in_progress .reply-head { border-bottom-color: rgba(245,158,11,0.2); }
    .reply-box.reply-in_progress .reply-head .avatar {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        box-shadow: 0 4px 12px rgba(245,158,11,0.3);
    }
    .reply-box.reply-in_progress .reply-head .who .name { color: #92400e; }
    .reply-box.reply-in_progress .reply-head .who .name .status-pill {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    .reply-box.reply-in_progress .reply-head .who .name .status-pill .pill-dot {
        background: #f59e0b;
    }
    .reply-box.reply-in_progress .reply-head .who .time { color: #b45309; }
    .reply-box.reply-in_progress .reply-head .who .time i { color: #f59e0b; }
    .reply-box.reply-in_progress .reply-body { color: #92400e; }

    /* ===== HIJAU — Selesai (resolved) ===== */
    .reply-box.reply-resolved {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-color: #86efac;
    }
    .reply-box.reply-resolved .reply-head { border-bottom-color: rgba(34,197,94,0.2); }
    .reply-box.reply-resolved .reply-head .avatar {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        box-shadow: 0 4px 12px rgba(34,197,94,0.3);
    }
    .reply-box.reply-resolved .reply-head .who .name { color: #065f46; }
    .reply-box.reply-resolved .reply-head .who .name .status-pill {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }
    .reply-box.reply-resolved .reply-head .who .name .status-pill .pill-dot {
        background: #22c55e;
    }
    .reply-box.reply-resolved .reply-head .who .time { color: #16a34a; }
    .reply-box.reply-resolved .reply-head .who .time i { color: #22c55e; }
    .reply-box.reply-resolved .reply-body { color: #065f46; }

    /* ===== MERAH — Ditolak (rejected) ===== */
    .reply-box.reply-rejected {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-color: #fca5a5;
    }
    .reply-box.reply-rejected .reply-head { border-bottom-color: rgba(239,68,68,0.2); }
    .reply-box.reply-rejected .reply-head .avatar {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }
    .reply-box.reply-rejected .reply-head .who .name { color: #991b1b; }
    .reply-box.reply-rejected .reply-head .who .name .status-pill {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }
    .reply-box.reply-rejected .reply-head .who .name .status-pill .pill-dot {
        background: #ef4444;
    }
    .reply-box.reply-rejected .reply-head .who .time { color: #b91c1c; }
    .reply-box.reply-rejected .reply-head .who .time i { color: #ef4444; }
    .reply-box.reply-rejected .reply-body { color: #991b1b; }

    .attachment-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; }
    .attachment-item {
        position: relative; border-radius: 12px; overflow: hidden;
        background: #f0f5f0; aspect-ratio: 1;
        border: 2px solid #eef3ee; transition: all 0.3s ease;
        display: block; text-decoration: none;
    }
    .attachment-item:hover { border-color: #d4af37; transform: scale(1.02); }
    .attachment-item img, .attachment-item video { width: 100%; height: 100%; object-fit: cover; display: block; }
    .attachment-item .badge-type {
        position: absolute; top: 6px; left: 6px;
        background: rgba(212,175,55,0.95); color: #0a1a0a;
        font-size: 10px; font-weight: 700; padding: 2px 8px;
        border-radius: 50px; text-transform: uppercase;
    }

    .cta-back {
        display: inline-flex; align-items: center; gap: 8px;
        margin-top: 24px; padding: 12px 24px;
        background: #f0f5f0; color: #2d3a2d;
        border-radius: 12px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: all 0.3s ease;
    }
    .cta-back:hover { background: #e0e8e0; color: #0a1a0a; }

    @media (max-width: 768px) {
        .page-header { padding: 120px 0 40px; }
        .page-header h1 { font-size: 26px; }
        .search-card, .result-card { padding: 24px 20px; border-radius: 18px; }
        .info-grid-2 { grid-template-columns: 1fr; }
        .ticket-banner { flex-direction: column; align-items: flex-start; }
        .ticket-banner .code { font-size: 16px; }
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <a href="{{ route('public.complaints.create') }}">Pengaduan</a>
            <span class="separator">/</span>
            <span class="current">Cek Status</span>
        </div>
        <h1>Cek Status <span>Pengaduan</span></h1>
        <p>Masukkan nomor tiket dan email Anda untuk melihat status dan balasan dari pihak desa</p>
    </div>
</div>

<div class="page-main">
    <div class="container">

        {{-- FORM CARI --}}
        <div class="search-card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-search"></i></div>
                <div>
                    <h2>Cek Status Tiket</h2>
                    <p>Masukkan nomor tiket & email yang Anda gunakan saat mengirim pengaduan</p>
                </div>
            </div>

            <form action="{{ route('public.complaints.check.result') }}" method="POST" class="search-form-2">
                @csrf
                <div class="form-field">
                    <label><i class="fas fa-ticket-alt"></i> Nomor Tiket</label>
                    <input type="text"
                           name="ticket_number"
                           value="{{ old('ticket_number') }}"
                           placeholder="Contoh: ADU-K8J2M9P4-X7Q1"
                           autocomplete="off"
                           maxlength="30"
                           required
                           style="text-transform:uppercase;">
                    @error('ticket_number')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label><i class="fas fa-envelope"></i> Email Pengadu</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Email yang Anda gunakan saat mengirim"
                           autocomplete="off"
                           maxlength="100"
                           required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-check">
                    <i class="fas fa-search"></i> Cek Status
                </button>
            </form>

            @if(session('ticket_error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('ticket_error') }}</span>
                </div>
            @endif

            <div class="security-notice">
                <i class="fas fa-shield-alt"></i>
                <span>
                    <strong>Keamanan:</strong> Untuk melindungi privasi Anda, cek status memerlukan <strong>2 data</strong> — nomor tiket + email yang Anda gunakan saat mengirim pengaduan. Data pribadi Anda akan disamarkan.
                </span>
            </div>
        </div>

        {{-- HASIL --}}
        @isset($complaint)
            <div class="result-card">

                {{-- TICKET BANNER --}}
                <div class="ticket-banner">
                    <div class="left">
                        <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                        <div>
                            <div class="label">Nomor Tiket</div>
                            <div class="code">{{ $complaint->ticket_number }}</div>
                        </div>
                    </div>
                    <div>
                        <span class="status-badge-large {{ $complaint->status_badge }}">
                            <span class="dot"></span>
                            {{ $complaint->status_label }}
                        </span>
                    </div>
                </div>

                {{-- INFO DASAR --}}
                <div class="info-grid-2">
                    <div class="info-box">
                        <div class="label">Nama Pengadu</div>
                        <div class="value">{{ $complaint->name }}</div>
                    </div>
                    <div class="info-box">
                        <div class="label">Tanggal Dikirim</div>
                        <div class="value">{{ $complaint->created_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                </div>

                {{-- INFO KONTAK (MASKED) --}}
                <div class="info-grid-2" style="margin-bottom:24px;">
                    <div class="info-box">
                        <div class="label">Email</div>
                        <div class="value" style="font-size:14px;font-weight:500;">
                            {{ $complaint->masked_email }}
                            <i class="fas fa-lock" style="color:#8a9a8a;font-size:11px;margin-left:6px;" title="Disamarkan untuk keamanan"></i>
                        </div>
                    </div>
                    @if($complaint->phone)
                        <div class="info-box">
                            <div class="label">No. HP</div>
                            <div class="value" style="font-size:14px;font-weight:500;">
                                {{ $complaint->masked_phone }}
                                <i class="fas fa-lock" style="color:#8a9a8a;font-size:11px;margin-left:6px;" title="Disamarkan untuk keamanan"></i>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- SUBJEK --}}
                <div class="section-title">
                    <i class="fas fa-heading"></i> Subjek
                </div>
                <div class="message-box">{{ $complaint->subject }}</div>

                {{-- ISI PENGADUAN --}}
                <div class="section-title">
                    <i class="fas fa-comment-alt"></i> Isi Pengaduan Anda
                </div>
                <div class="message-box">{{ $complaint->message }}</div>

                {{-- LAMPIRAN --}}
                @if($complaint->attachments && count($complaint->attachments) > 0)
                    <div class="section-title">
                        <i class="fas fa-paperclip"></i> Lampiran Anda
                    </div>
                    <div class="attachment-grid">
                        @foreach($complaint->attachments as $file)
                            @php
                                $url = asset('storage/' . $file);
                                $isVideo = \App\Models\Complaint::isVideo($file);
                            @endphp
                            @if($isVideo)
                                <div class="attachment-item">
                                    <video controls preload="metadata">
                                        <source src="{{ $url }}">
                                    </video>
                                    <span class="badge-type">Video</span>
                                </div>
                            @else
                                <a href="{{ $url }}" target="_blank" class="attachment-item">
                                    <img src="{{ $url }}" alt="Bukti">
                                    <span class="badge-type">Foto</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- TIMELINE RIWAYAT STATUS --}}
                <div class="section-title">
                    <i class="fas fa-stream"></i> Riwayat Status
                </div>
                <div class="timeline">

                    {{-- Step 1: Pengaduan Dikirim --}}
                    <div class="timeline-item">
                        <div class="dot done"><i class="fas fa-check"></i></div>
                        <div class="content">
                            <div class="title">
                                Pengaduan Dikirim
                                <span class="mini-badge" style="background:#dbeafe;color:#1e40af;">Terkirim</span>
                            </div>
                            <div class="time">
                                <i class="fas fa-clock"></i>
                                {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Sedang Diproses --}}
                    @if(in_array($complaint->status, ['in_progress', 'resolved', 'rejected']))
                        <div class="timeline-item">
                            <div class="dot {{ $complaint->status === 'in_progress' ? 'active' : 'done' }}">
                                <i class="fas {{ $complaint->status === 'in_progress' ? 'fa-spinner' : 'fa-check' }}"></i>
                            </div>
                            <div class="content">
                                <div class="title">
                                    Sedang Diproses
                                    <span class="mini-badge" style="background:#fef3c7;color:#92400e;">
                                        {{ $complaint->status === 'in_progress' ? 'Sedang Berlangsung' : 'Selesai' }}
                                    </span>
                                </div>
                                <div class="time">
                                    <i class="fas fa-clock"></i>
                                    @if($complaint->replied_at)
                                        {{ $complaint->replied_at->translatedFormat('d F Y, H:i') }}
                                    @else
                                        Dalam penanganan
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Step 3: Selesai / Ditolak --}}
                    @if(in_array($complaint->status, ['resolved', 'rejected']))
                        <div class="timeline-item">
                            <div class="dot done">
                                <i class="fas {{ $complaint->status === 'resolved' ? 'fa-check-double' : 'fa-times' }}"></i>
                            </div>
                            <div class="content">
                                <div class="title">
                                    {{ $complaint->status === 'resolved' ? 'Pengaduan Selesai' : 'Pengaduan Ditolak' }}
                                    <span class="mini-badge" style="{{ $complaint->status === 'resolved' ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">
                                        {{ $complaint->status === 'resolved' ? 'Selesai' : 'Ditolak' }}
                                    </span>
                                </div>
                                <div class="time">
                                    <i class="fas fa-clock"></i>
                                    {{ $complaint->updated_at->translatedFormat('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- BALASAN ADMIN (DINAMIS WARNA) --}}
                <div class="section-title">
                    <i class="fas fa-reply-all"></i> Balasan dari Desa
                </div>

                @php
                    $replyClass = 'reply-' . $complaint->status;
                @endphp

                <div class="reply-box {{ $replyClass }}">
                    <div class="reply-head">
                        <div class="avatar">
                            @if($complaint->status === 'new')
                                <i class="fas fa-clock"></i>
                            @elseif($complaint->status === 'in_progress')
                                <i class="fas fa-spinner"></i>
                            @elseif($complaint->status === 'resolved')
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas fa-times"></i>
                            @endif
                        </div>
                        <div class="who">
                            <div class="name">
                                Pemerintah Desa
                                <span class="status-pill">
                                    <span class="pill-dot"></span>
                                    {{ $complaint->status_label }}
                                </span>
                            </div>
                            <div class="time">
                                <i class="fas fa-clock"></i>
                                @if($complaint->replied_at)
                                    Dibalas pada {{ $complaint->replied_at->translatedFormat('d F Y, H:i') }}
                                @else
                                    Menunggu balasan dari desa
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="reply-body">
                        @if($complaint->admin_notes)
                            {{ $complaint->admin_notes }}
                        @else
                            @if($complaint->status === 'new')
                                <em style="opacity:0.85;">
                                    Pengaduan Anda sudah kami terima dan sedang dalam antrian untuk ditindaklanjuti oleh petugas terkait. Mohon tunggu, ya. Kami akan segera memproses.
                                </em>
                            @elseif($complaint->status === 'in_progress')
                                <em style="opacity:0.85;">
                                    Pengaduan Anda sedang kami tangani. Kami akan menginformasikan perkembangan selanjutnya.
                                </em>
                            @else
                                <em style="opacity:0.85;">Tidak ada catatan dari desa.</em>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- BACK --}}
                <div style="text-align:center;">
                    <a href="{{ route('public.complaints.create') }}" class="cta-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Form Pengaduan
                    </a>
                </div>

            </div>
        @endisset

    </div>
</div>
@endsection