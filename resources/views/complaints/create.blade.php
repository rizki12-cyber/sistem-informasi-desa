@extends('layouts.app')

@section('title', 'Pengaduan Warga - ' . ($profile->village_name ?? 'Desa'))
@section('description', 'Sampaikan pengaduan, saran, atau aspirasi Anda kepada pemerintah desa')

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

    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
    .info-card {
        background: #fff; border-radius: 16px; padding: 24px;
        border: 1px solid #eef3ee; transition: all 0.3s ease;
    }
    .info-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.05); border-color: rgba(212,175,55,0.3); }
    .info-card .icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05));
        color: #d4af37; font-size: 20px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
    }
    .info-card h4 { font-size: 15px; font-weight: 700; color: #0a1a0a; margin-bottom: 6px; }
    .info-card p { font-size: 13px; color: #6a7a6a; line-height: 1.6; margin: 0; }

    .form-card {
        background: #fff; border-radius: 24px;
        padding: 40px; max-width: 900px; margin: 0 auto;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        border: 1px solid #eef3ee;
    }
    .form-card .form-head {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 28px; padding-bottom: 20px;
        border-bottom: 2px solid #f0f5f0;
    }
    .form-card .form-head .icon-box {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a; font-size: 22px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(212,175,55,0.25);
    }
    .form-card .form-head h2 { font-size: 22px; font-weight: 700; color: #0a1a0a; margin: 0; }
    .form-card .form-head p { font-size: 14px; color: #8a9a8a; margin: 2px 0 0; }

    .alert-success {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border: 1px solid #a5d6a7;
        color: #1b5e20; padding: 16px 20px;
        border-radius: 14px; font-size: 14px;
        margin-bottom: 24px;
        display: flex; align-items: flex-start; gap: 12px;
    }
    .alert-success i { font-size: 20px; color: #2e7d32; flex-shrink: 0; margin-top: 1px; }
    .alert-success .ticket {
        display: inline-block; margin-top: 8px;
        background: rgba(255,255,255,0.7);
        padding: 6px 14px; border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 15px; font-weight: 700;
        color: #1b5e20; letter-spacing: 1px;
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-group { margin-bottom: 20px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 700; color: #2d3a2d;
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-group label .req { color: #d32f2f; font-size: 14px; }
    .form-group label .opt {
        color: #b0bdb0; font-weight: 500; font-size: 10px;
        background: #f0f5f0; padding: 2px 8px; border-radius: 50px;
        text-transform: none; letter-spacing: 0;
    }
    .form-group input,
    .form-group textarea {
        width: 100%; padding: 13px 16px;
        border: 2px solid #eef3ee; border-radius: 12px;
        font-size: 14px; font-family: inherit;
        background: #fafcfa; color: #0a1a0a;
        transition: all 0.3s ease;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none; border-color: #d4af37;
        background: #fff; box-shadow: 0 0 0 4px rgba(212,175,55,0.08);
    }
    .form-group textarea { resize: vertical; min-height: 140px; line-height: 1.7; }
    .form-group .error { color: #d32f2f; font-size: 12px; margin-top: 6px; }

    .file-upload-zone {
        border: 2px dashed #d4af37;
        border-radius: 14px;
        padding: 28px 24px;
        background: #fffef5;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .file-upload-zone:hover { border-color: #c5a031; background: #fffbe6; }
    .file-upload-zone input[type="file"] {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .file-upload-zone .upload-icon { font-size: 32px; color: #d4af37; margin-bottom: 10px; }
    .file-upload-zone .upload-text { font-size: 14px; font-weight: 600; color: #2d3a2d; margin-bottom: 4px; }
    .file-upload-zone .upload-hint { font-size: 12px; color: #8a9a8a; line-height: 1.5; }

    .file-preview-list {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px; margin-top: 14px;
    }
    .file-preview-item {
        position: relative; border-radius: 12px; overflow: hidden;
        background: #f0f5f0; aspect-ratio: 1;
        border: 2px solid #eef3ee;
    }
    .file-preview-item img,
    .file-preview-item video { width: 100%; height: 100%; object-fit: cover; display: block; }
    .file-preview-item .file-icon { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; color: #8a9a8a; font-size: 32px; }
    .file-preview-item .file-name {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.75));
        color: #fff; font-size: 10px; padding: 14px 6px 6px;
        text-overflow: ellipsis; overflow: hidden; white-space: nowrap;
    }
    .file-preview-item .remove-btn {
        position: absolute; top: 6px; right: 6px;
        width: 24px; height: 24px; border-radius: 50%;
        background: rgba(220, 38, 38, 0.9); color: #fff;
        border: none; cursor: pointer; font-size: 11px;
        display: flex; align-items: center; justify-content: center;
    }
    .file-preview-item .remove-btn:hover { background: #dc2626; transform: scale(1.1); }
    .file-preview-item .file-badge {
        position: absolute; top: 6px; left: 6px;
        background: rgba(212,175,55,0.95); color: #0a1a0a;
        font-size: 10px; font-weight: 700; padding: 2px 8px;
        border-radius: 50px; text-transform: uppercase;
    }

    .btn-submit {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 15px 32px;
        background: linear-gradient(135deg, #f0d060, #d4af37);
        color: #0a1a0a; border: none; border-radius: 14px;
        font-size: 15px; font-weight: 800;
        cursor: pointer; transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(212,175,55,0.3);
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-top: 12px;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,175,55,0.4); }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    @media (max-width: 992px) {
        .info-grid { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 32px; }
    }
    @media (max-width: 768px) {
        .page-header { padding: 120px 0 40px; }
        .page-header h1 { font-size: 26px; }
        .form-card { padding: 24px 20px; border-radius: 18px; }
        .form-row { grid-template-columns: 1fr; gap: 0; }
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Pengaduan Warga</span>
        </div>
        <h1>Pengaduan <span>Warga</span></h1>
        <p>Sampaikan keluhan, saran, atau aspirasi Anda kepada pemerintah desa. Kami akan menindaklanjuti setiap laporan.</p>
    </div>
</div>

<div class="page-main">
    <div class="container">

        <div class="info-grid">
            <div class="info-card">
                <div class="icon"><i class="fas fa-bolt"></i></div>
                <h4>Respon Cepat</h4>
                <p>Pengaduan Anda akan kami proses maksimal 3 hari kerja.</p>
            </div>
            <div class="info-card">
                <div class="icon"><i class="fas fa-lock"></i></div>
                <h4>Data Terlindungi</h4>
                <p>Identitas Anda dijaga kerahasiaannya dan hanya digunakan untuk tindak lanjut.</p>
            </div>
            <div class="info-card">
                <div class="icon"><i class="fas fa-camera"></i></div>
                <h4>Lampirkan Bukti</h4>
                <p>Sertakan foto atau video agar laporan Anda lebih jelas dan cepat ditangani.</p>
            </div>
        </div>

        <div class="form-card">
            <div class="form-head">
                <div class="icon-box"><i class="fas fa-paper-plane"></i></div>
                <div>
                    <h2>Formulir Pengaduan</h2>
                    <p>Isi data di bawah ini dengan lengkap dan benar</p>
                </div>
            </div>

            @if(session('complaint_success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>{{ session('complaint_success') }}</strong><br>
                        <span style="font-size:13px;opacity:0.9;">Simpan nomor tiket Anda untuk cek status:</span>
                        <div class="ticket">{{ session('ticket_number') }}</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('public.complaints.store') }}" method="POST" enctype="multipart/form-data" id="complaintForm">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Anda" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">No. HP <span class="opt">Opsional</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0821-xxxx-xxxx">
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="subject">Subjek <span class="req">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Contoh: Lampu jalan mati" required>
                        @error('subject') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Isi Pengaduan <span class="req">*</span></label>
                    <textarea id="message" name="message" placeholder="Tuliskan pengaduan Anda secara detail (min. 20 karakter)..." required>{{ old('message') }}</textarea>
                    @error('message') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>
                        Bukti Foto / Video
                        <span class="opt">Maks. 3 file, 20MB/file</span>
                    </label>

                    <div class="file-upload-zone" id="uploadZone">
                        <input type="file" id="attachments" name="attachments[]" accept="image/*,video/*" multiple>
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="upload-text">Klik atau seret file ke sini</div>
                        <div class="upload-hint">
                            Format: JPG, PNG, WEBP, GIF, MP4, WEBM, MOV, OGG<br>
                            Maksimal 3 file, masing-masing maks 20 MB
                        </div>
                    </div>

                    <div class="file-preview-list" id="filePreviewList"></div>

                    @error('attachments') <span class="error">{{ $message }}</span> @enderror
                    @error('attachments.*') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('attachments');
        const previewList = document.getElementById('filePreviewList');
        const MAX_FILES = 3;
        const MAX_SIZE = 20 * 1024 * 1024;

        let selectedFiles = [];

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function isImage(file) { return file.type.startsWith('image/'); }
        function isVideo(file) { return file.type.startsWith('video/'); }

        function renderPreview() {
            previewList.innerHTML = '';

            selectedFiles.forEach(function (file, index) {
                const item = document.createElement('div');
                item.className = 'file-preview-item';

                if (isImage(file)) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    item.appendChild(img);
                    const badge = document.createElement('span');
                    badge.className = 'file-badge';
                    badge.textContent = 'Foto';
                    item.appendChild(badge);
                } else if (isVideo(file)) {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.muted = true;
                    item.appendChild(video);
                    const badge = document.createElement('span');
                    badge.className = 'file-badge';
                    badge.textContent = 'Video';
                    item.appendChild(badge);
                }

                const nameEl = document.createElement('div');
                nameEl.className = 'file-name';
                nameEl.textContent = file.name + ' (' + formatSize(file.size) + ')';
                item.appendChild(nameEl);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    selectedFiles.splice(index, 1);
                    syncInput();
                    renderPreview();
                });
                item.appendChild(removeBtn);

                previewList.appendChild(item);
            });
        }

        function syncInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(function (file) { dt.items.add(file); });
            input.files = dt.files;
        }

        input.addEventListener('change', function () {
            const newFiles = Array.from(input.files);

            newFiles.forEach(function (file) {
                if (selectedFiles.length >= MAX_FILES) {
                    alert('Maksimal ' + MAX_FILES + ' file.');
                    return;
                }
                if (file.size > MAX_SIZE) {
                    alert('File "' + file.name + '" melebihi 20 MB.');
                    return;
                }
                if (!isImage(file) && !isVideo(file)) {
                    alert('File "' + file.name + '" bukan gambar atau video.');
                    return;
                }
                selectedFiles.push(file);
            });

            syncInput();
            renderPreview();
        });

        const form = document.getElementById('complaintForm');
        const submitBtn = document.getElementById('submitBtn');
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        });
    });
</script>
@endsection