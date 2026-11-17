@extends('layouts.admin')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')

@section('content')
<style>
    .page-head { margin-bottom: 28px; }
    .page-head .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #8a9a8a; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }
    .page-head .breadcrumb a { color: #8a9a8a; text-decoration: none; transition: color 0.3s ease; }
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

    .ticket-banner {
        display: inline-flex; align-items: center; gap: 10px;
        background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05));
        border: 1px dashed rgba(212,175,55,0.4);
        padding: 10px 20px; border-radius: 12px;
        font-family: 'Courier New', monospace;
        font-size: 16px; font-weight: 700; color: #b8912a;
        letter-spacing: 1px; margin-bottom: 20px;
    }

    .info-row { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px dashed #f0f5f0; }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label { min-width: 110px; font-size: 11px; font-weight: 700; color: #8a9a8a; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 3px; }
    .info-row .info-value { flex: 1; font-size: 14px; color: #0a1a0a; font-weight: 500; word-break: break-word; }
    .info-row .info-value a { color: #d4af37; text-decoration: none; }
    .info-row .info-value a:hover { text-decoration: underline; }

    .message-box { background: #fafcfa; border: 1px solid #eef3ee; border-radius: 12px; padding: 18px 20px; font-size: 14px; line-height: 1.8; color: #2d3a2d; white-space: pre-line; }

    /* Attachments */
    .attachment-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 14px;
    }
    .attachment-item {
        position: relative; border-radius: 12px; overflow: hidden;
        background: #f0f5f0; aspect-ratio: 1;
        border: 2px solid #eef3ee; transition: all 0.3s ease;
        display: block; text-decoration: none;
    }
    .attachment-item:hover { border-color: #d4af37; transform: scale(1.02); box-shadow: 0 8px 24px rgba(212,175,55,0.2); }
    .attachment-item img,
    .attachment-item video {
        width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .attachment-item .badge-type {
        position: absolute; top: 8px; left: 8px;
        background: rgba(212,175,55,0.95); color: #0a1a0a;
        font-size: 10px; font-weight: 700; padding: 3px 10px;
        border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .attachment-item .overlay-link {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.5); color: #fff;
        opacity: 0; transition: opacity 0.3s ease;
        font-size: 24px;
    }
    .attachment-item:hover .overlay-link { opacity: 1; }

    /* Form */
    .form-group { margin-bottom: 22px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group label { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #2d3a2d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group label .req { color: #d32f2f; font-size: 14px; }
    .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #eef3ee; border-radius: 12px; font-size: 14px; font-family: inherit; transition: all 0.3s ease; background: #fafcfa; color: #0a1a0a; }
    .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #d4af37; background: #fff; box-shadow: 0 0 0 4px rgba(212,175,55,0.08); }
    .form-group textarea { resize: vertical; min-height: 120px; line-height: 1.6; }

    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .badge-new { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
    .badge-new .dot { background: #3b82f6; animation: pulse-dot 2s infinite; }
    .badge-progress { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
    .badge-progress .dot { background: #f59e0b; }
    .badge-resolved { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
    .badge-resolved .dot { background: #22c55e; }
    .badge-rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
    .badge-rejected .dot { background: #ef4444; }
    @keyframes pulse-dot { 0%,100% { opacity:1; } 50% { opacity:0.5; } }

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

    @media (max-width: 992px) { .layout { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .card .card-body { padding: 20px 18px; }
        .info-row { flex-direction: column; gap: 4px; }
        .info-row .info-label { min-width: 0; }
    }
</style>

<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <a href="{{ route('admin.complaints.index') }}">Pengaduan</a>
        <span class="sep">/</span>
        <span class="current">Detail</span>
    </div>
    <h1>Detail Pengaduan</h1>
    <p>Baca dan tindak lanjuti pengaduan warga</p>
</div>

<div class="layout">
    <!-- LEFT -->
    <div>
        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-file-alt"></i></div>
                <div>
                    <h3>Isi Pengaduan</h3>
                    <p>Dikirim pada {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
            <div class="card-body">
                <div class="ticket-banner">
                    <i class="fas fa-ticket-alt"></i>
                    {{ $complaint->ticket_number }}
                </div>

                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $complaint->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value"><a href="mailto:{{ $complaint->email }}">{{ $complaint->email }}</a></div>
                </div>
                @if($complaint->phone)
                    <div class="info-row">
                        <div class="info-label">No. HP</div>
                        <div class="info-value"><a href="tel:{{ $complaint->phone }}">{{ $complaint->phone }}</a></div>
                    </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Subjek</div>
                    <div class="info-value">{{ $complaint->subject }}</div>
                </div>
                <div class="info-row" style="flex-direction: column; gap: 12px;">
                    <div class="info-label" style="padding-top: 0;">Pesan</div>
                    <div class="message-box">{{ $complaint->message }}</div>
                </div>
            </div>
        </div>

        {{-- ATTACHMENTS --}}
        @if($complaint->attachments && count($complaint->attachments) > 0)
            <div class="card">
                <div class="card-head">
                    <div class="icon-box"><i class="fas fa-paperclip"></i></div>
                    <div>
                        <h3>Bukti Lampiran</h3>
                        <p>{{ count($complaint->attachments) }} file diunggah warga</p>
                    </div>
                </div>
                <div class="card-body">
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
                                    <div class="overlay-link">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- RIGHT -->
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
                    <div class="info-box-label">Status Pengaduan</div>
                    <div class="info-box-value">
                        <span class="badge {{ $complaint->status_badge }}">
                            <span class="dot"></span>
                            {{ $complaint->status_label }}
                        </span>
                    </div>
                </div>
                @if($complaint->replied_at)
                    <div class="info-box">
                        <div class="info-box-label">Terakhir Dibalas</div>
                        <div class="info-box-value">{{ $complaint->replied_at->translatedFormat('d F Y, H:i') }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="icon-box"><i class="fas fa-cog"></i></div>
                <div>
                    <h3>Update Pengaduan</h3>
                    <p>Ubah status & tulis catatan</p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.complaints.update', $complaint) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="status">Status <span class="req">*</span></label>
                        <select id="status" name="status" required>
                            <option value="new" {{ old('status', $complaint->status) === 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="in_progress" {{ old('status', $complaint->status) === 'in_progress' ? 'selected' : '' }}>Diproses</option>
                            <option value="resolved" {{ old('status', $complaint->status) === 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ old('status', $complaint->status) === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status') <span style="color:#d32f2f;font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Catatan Admin</label>
                        <textarea id="admin_notes" name="admin_notes" placeholder="Tulis catatan internal atau tindak lanjut...">{{ old('admin_notes', $complaint->admin_notes) }}</textarea>
                        @error('admin_notes') <span style="color:#d32f2f;font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection