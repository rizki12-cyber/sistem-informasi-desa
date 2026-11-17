@extends('layouts.app')

@section('title', 'Ajukan Surat - ' . ($profile->village_name ?? 'Desa'))
@section('description', 'Ajukan surat keterangan desa secara online')

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
    .page-header .breadcrumb a { color: rgba(255,255,255,0.6); text-decoration: none; }
    .page-header .breadcrumb a:hover { color: #d4af37; }
    .page-header .breadcrumb .separator { color: rgba(255,255,255,0.2); }
    .page-header .breadcrumb .current { color: #d4af37; }
    .page-header h1 { font-size: 42px; font-weight: 700; color: #fff; margin-bottom: 12px; line-height: 1.2; }
    .page-header h1 span { color: #d4af37; }
    .page-header p { color: rgba(255,255,255,0.7); font-size: 18px; max-width: 620px; line-height: 1.7; }

    .page-main { padding: 60px 0 80px; background: #f8faf8; }

    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
    .info-card { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid #eef3ee; transition: all 0.3s ease; }
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

    .form-section-title {
        font-size: 13px; font-weight: 800; color: #0a1a0a;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin: 20px 0 14px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #eef3ee;
        display: flex; align-items: center; gap: 8px;
    }
    .form-section-title i { color: #d4af37; font-size: 14px; }
    .form-section-title:first-of-type { margin-top: 0; }

    /* Dynamic fields wrapper */
    #dynamicFields {
        margin-top: 8px;
        padding: 20px 22px;
        background: linear-gradient(135deg, #fdf9ea, #fefcf2);
        border: 1px solid rgba(212,175,55,0.25);
        border-radius: 16px;
        margin-bottom: 20px;
        position: relative;
        animation: fadeInFields 0.4s ease;
    }
    #dynamicFields::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #d4af37, #f0d060);
        border-radius: 16px 16px 0 0;
    }
    @keyframes fadeInFields {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #dynamicFields .form-section-title {
        margin-top: 0;
        border-bottom: 1px dashed rgba(212,175,55,0.3);
        color: #b8912a;
    }
    #dynamicFields .form-section-title i { color: #d4af37; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-row.three { grid-template-columns: 1fr 1fr 1fr; }
    .form-group { margin-bottom: 18px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 700; color: #2d3a2d;
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-group label .req { color: #d32f2f; font-size: 14px; }
    .form-group label .opt {
        color: #b0bdb0; font-weight: 500; font-size: 10px;
        background: #f0f5f0; padding: 2px 8px; border-radius: 50px;
        text-transform: none; letter-spacing: 0;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%; padding: 13px 16px;
        border: 2px solid #eef3ee; border-radius: 12px;
        font-size: 14px; font-family: inherit;
        background: #fafcfa; color: #0a1a0a;
        transition: all 0.3s ease;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none; border-color: #d4af37;
        background: #fff; box-shadow: 0 0 0 4px rgba(212,175,55,0.08);
    }
    .form-group textarea { resize: vertical; min-height: 90px; line-height: 1.6; }
    .form-group .error { color: #d32f2f; font-size: 12px; margin-top: 6px; }

    .requirements-box {
        background: #fffbeb;
        border: 1px solid #fde047;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 20px;
        display: none;
    }
    .requirements-box.show { display: block; }
    .requirements-box h4 {
        font-size: 13px; font-weight: 700; color: #92400e;
        margin-bottom: 8px;
        display: flex; align-items: center; gap: 6px;
    }
    .requirements-box h4 i { color: #d97706; }
    .requirements-box pre {
        font-family: inherit;
        font-size: 13px;
        color: #78350f;
        line-height: 1.7;
        white-space: pre-wrap;
        margin: 0;
    }

    .file-upload-zone {
        border: 2px dashed #d4af37;
        border-radius: 14px;
        padding: 24px;
        background: #fffef5;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }
    .file-upload-zone:hover { border-color: #c5a031; background: #fffbe6; }
    .file-upload-zone input[type="file"] {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .file-upload-zone .upload-icon { font-size: 28px; color: #d4af37; margin-bottom: 8px; }
    .file-upload-zone .upload-text { font-size: 14px; font-weight: 600; color: #2d3a2d; margin-bottom: 4px; }
    .file-upload-zone .upload-hint { font-size: 12px; color: #8a9a8a; line-height: 1.5; }

    .file-preview-list {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px; margin-top: 14px;
    }
    .file-preview-item {
        position: relative; border-radius: 10px; overflow: hidden;
        background: #f0f5f0; aspect-ratio: 1;
        border: 2px solid #eef3ee;
    }
    .file-preview-item img {
        width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .file-preview-item .file-icon {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        width: 100%; height: 100%; color: #d4af37; font-size: 26px; gap: 4px;
    }
    .file-preview-item .file-icon span { font-size: 10px; color: #6a7a6a; font-weight: 700; }
    .file-preview-item .file-name {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.75));
        color: #fff; font-size: 9px; padding: 12px 5px 5px;
        text-overflow: ellipsis; overflow: hidden; white-space: nowrap;
    }
    .file-preview-item .remove-btn {
        position: absolute; top: 6px; right: 6px;
        width: 22px; height: 22px; border-radius: 50%;
        background: rgba(220, 38, 38, 0.9); color: #fff;
        border: none; cursor: pointer; font-size: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .file-preview-item .remove-btn:hover { background: #dc2626; transform: scale(1.1); }

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

    @media (max-width: 992px) { .info-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .page-header { padding: 100px 0 40px; }
        .page-header h1 { font-size: 26px; }
        .page-header p { font-size: 15px; }
        .form-card { padding: 24px 20px; border-radius: 18px; }
        .form-row, .form-row.three { grid-template-columns: 1fr; gap: 0; }
        #dynamicFields { padding: 16px 18px; }
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="separator">/</span>
            <span class="current">Ajukan Surat</span>
        </div>
        <h1>Ajukan <span>Surat</span></h1>
        <p>Ajukan surat keterangan desa secara online — tanpa perlu datang ke kantor</p>
    </div>
</div>

<div class="page-main">
    <div class="container">

        <div class="info-grid">
            <div class="info-card">
                <div class="icon"><i class="fas fa-clock"></i></div>
                <h4>Hemat Waktu</h4>
                <p>Isi form dari rumah, tidak perlu antri di kantor desa.</p>
            </div>
            <div class="info-card">
                <div class="icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Data Aman</h4>
                <p>Data pribadi Anda terlindungi dan hanya dipakai untuk proses surat.</p>
            </div>
            <div class="info-card">
                <div class="icon"><i class="fas fa-bell"></i></div>
                <h4>Cek Status Online</h4>
                <p>Pantau status permohonan Anda dengan nomor pengajuan.</p>
            </div>
        </div>

        <div class="form-card">
            <div class="form-head">
                <div class="icon-box"><i class="fas fa-file-signature"></i></div>
                <div>
                    <h2>Formulir Pengajuan Surat</h2>
                    <p>Isi data di bawah ini dengan lengkap dan benar</p>
                </div>
            </div>

            @if(session('letter_success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>{{ session('letter_success') }}</strong><br>
                        <span style="font-size:13px;opacity:0.9;">Simpan nomor permohonan Anda:</span>
                        <div class="ticket">{{ session('request_number') }}</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('public.letters.store') }}" method="POST" enctype="multipart/form-data" id="letterForm">
                @csrf

                {{-- JENIS SURAT --}}
                <div class="form-section-title">
                    <i class="fas fa-file-alt"></i> Jenis Surat
                </div>

                <div class="form-group full">
                    <label for="letter_type_id">Pilih Jenis Surat <span class="req">*</span></label>
                    <select id="letter_type_id" name="letter_type_id" required onchange="updateRequirements()">
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($letterTypes as $type)
                            <option value="{{ $type->id }}"
                                    {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('letter_type_id') <span class="error">{{ $message }}</span> @enderror
                </div>

                {{-- BOX SYARAT --}}
                <div class="requirements-box" id="requirementsBox">
                    <h4><i class="fas fa-info-circle"></i> Syarat Berkas</h4>
                    <pre id="requirementsText"></pre>
                </div>

                {{-- DATA PEMOHON --}}
                <div class="form-section-title">
                    <i class="fas fa-user"></i> Data Pemohon
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK <span class="req">*</span></label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit" maxlength="16" required>
                        @error('nik') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_place">Tempat Lahir <span class="opt">Opsional</span></label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}" placeholder="Kota/Kabupaten">
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir <span class="opt">Opsional</span></label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                    </div>
                </div>

                <div class="form-row three">
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin <span class="opt">Opsional</span></label>
                        <select id="gender" name="gender">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="religion">Agama <span class="opt">Opsional</span></label>
                        <input type="text" id="religion" name="religion" value="{{ old('religion') }}" placeholder="Islam, Kristen, dll">
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Status Kawin <span class="opt">Opsional</span></label>
                        <input type="text" id="marital_status" name="marital_status" value="{{ old('marital_status') }}" placeholder="Belum Kawin, Kawin, dll">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="occupation">Pekerjaan <span class="opt">Opsional</span></label>
                        <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}" placeholder="Petani, Karyawan, dll">
                    </div>
                    <div class="form-group">
                        <label for="phone">No. HP <span class="opt">Opsional</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0821-xxxx-xxxx">
                    </div>
                </div>

                <div class="form-group full">
                    <label for="address">Alamat Lengkap <span class="req">*</span></label>
                    <textarea id="address" name="address" placeholder="Jalan, RT/RW, Dusun, Desa" required>{{ old('address') }}</textarea>
                    @error('address') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label for="email">Email <span class="req">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                {{-- ============================================= --}}
                {{-- DATA DINAMIS PER JENIS SURAT                 --}}
                {{-- ============================================= --}}
                <div id="dynamicFields" style="display:none;">
                    <div class="form-section-title">
                        <i class="fas fa-list-alt"></i> Data Tambahan
                    </div>
                    <div id="dynamicFieldsInner"></div>
                </div>

                {{-- KEPERLUAN --}}
                <div class="form-section-title">
                    <i class="fas fa-bullseye"></i> Keperluan
                </div>

                <div class="form-group full">
                    <label for="purpose">Keperluan Surat <span class="req">*</span></label>
                    <textarea id="purpose" name="purpose" placeholder="Jelaskan keperluan Anda (min. 10 karakter)..." required>{{ old('purpose') }}</textarea>
                    @error('purpose') <span class="error">{{ $message }}</span> @enderror
                </div>

                {{-- BERKAS --}}
                <div class="form-section-title">
                    <i class="fas fa-paperclip"></i> Berkas Pendukung
                </div>

                <div class="form-group full">
                    <label>
                        Upload Berkas
                        <span class="opt">Maks. 5 berkas, 5MB/berkas</span>
                    </label>

                    <div class="file-upload-zone">
                        <input type="file" id="attachments" name="attachments[]" accept="image/*,application/pdf" multiple>
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="upload-text">Klik atau seret berkas ke sini</div>
                        <div class="upload-hint">
                            Format: JPG, PNG, WEBP, PDF — Maks 5MB per berkas<br>
                            Contoh: KTP, KK, Surat Pengantar RT/RW
                        </div>
                    </div>

                    <div class="file-preview-list" id="filePreviewList"></div>

                    @error('attachments') <span class="error">{{ $message }}</span> @enderror
                    @error('attachments.*') <span class="error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-paper-plane"></i> Kirim Permohonan
                </button>
            </form>
        </div>

        {{-- CTA CEK STATUS --}}
        <div style="text-align:center; margin-top:32px;">
            <div style="display:inline-flex; align-items:center; gap:14px; padding:18px 28px; background:#fff; border-radius:16px; border:1px solid #eef3ee; box-shadow:0 4px 20px rgba(0,0,0,0.04); flex-wrap:wrap; justify-content:center;">
                <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05)); color:#d4af37; font-size:20px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-search"></i>
                </div>
                <div style="text-align:left; min-width:200px;">
                    <div style="font-size:14px; font-weight:700; color:#0a1a0a; margin-bottom:2px;">Sudah pernah mengajukan?</div>
                    <div style="font-size:13px; color:#6a7a6a;">Cek status permohonan surat Anda.</div>
                </div>
                <a href="{{ route('public.letters.check') }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:linear-gradient(135deg, #f0d060, #d4af37); color:#0a1a0a; border-radius:50px; font-weight:700; font-size:13px; text-decoration:none; box-shadow:0 4px 12px rgba(212,175,55,0.25);">
                    <i class="fas fa-file-search"></i> Cek Status Surat
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    // =============================================
    // DATA SCHEMA dari server (jenis surat + form dinamis)
    // =============================================
    const LETTER_SCHEMAS = @json($letterTypes->mapWithKeys(function($t) {
        return [$t->id => [
            'requirements' => $t->requirements,
            'schema' => $t->form_schema ?? [],
        ]];
    }));

    // =============================================
    // Update syarat + render dynamic fields
    // =============================================
    function updateRequirements() {
        const select = document.getElementById('letter_type_id');
        const id = select.value;
        const box = document.getElementById('requirementsBox');
        const text = document.getElementById('requirementsText');
        const dynBox = document.getElementById('dynamicFields');
        const dynInner = document.getElementById('dynamicFieldsInner');

        // Reset
        dynInner.innerHTML = '';
        dynBox.style.display = 'none';

        if (!id || !LETTER_SCHEMAS[id]) {
            box.classList.remove('show');
            return;
        }

        const data = LETTER_SCHEMAS[id];

        // Tampilkan syarat berkas
        if (data.requirements && data.requirements.trim()) {
            text.textContent = data.requirements.trim();
            box.classList.add('show');
        } else {
            box.classList.remove('show');
        }

        // Render dynamic fields
        if (data.schema && data.schema.length > 0) {
            data.schema.forEach(function(field) {
                const wrap = document.createElement('div');
                wrap.className = 'form-group full';

                const req = field.required
                    ? '<span class="req">*</span>'
                    : '<span class="opt">Opsional</span>';

                const inputName = 'letter_data[' + field.name + ']';
                const inputId = 'field_' + field.name;
                const placeholder = field.placeholder || '';

                let inputHtml = '';

                if (field.type === 'textarea') {
                    inputHtml = `<textarea id="${inputId}" name="${inputName}" placeholder="${placeholder}" ${field.required ? 'required' : ''}></textarea>`;
                } else if (field.type === 'select' && field.options && field.options.length) {
                    let opts = '<option value="">-- Pilih --</option>';
                    field.options.forEach(function(opt) {
                        opts += `<option value="${opt}">${opt}</option>`;
                    });
                    inputHtml = `<select id="${inputId}" name="${inputName}" ${field.required ? 'required' : ''}>${opts}</select>`;
                } else {
                    const inputType = field.type === 'number'
                        ? 'number'
                        : (field.type === 'date' ? 'date' : 'text');
                    inputHtml = `<input type="${inputType}" id="${inputId}" name="${inputName}" placeholder="${placeholder}" ${field.required ? 'required' : ''}>`;
                }

                wrap.innerHTML = `<label for="${inputId}">${field.label} ${req}</label>${inputHtml}`;
                dynInner.appendChild(wrap);
            });
            dynBox.style.display = 'block';
        }
    }

    // Init saat load (untuk handle old() value)
    document.addEventListener('DOMContentLoaded', updateRequirements);

    // =============================================
    // FILE UPLOAD PREVIEW
    // =============================================
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('attachments');
        const previewList = document.getElementById('filePreviewList');
        const MAX_FILES = 5;
        const MAX_SIZE = 5 * 1024 * 1024;

        let selectedFiles = [];

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function isImage(file) { return file.type.startsWith('image/'); }
        function isPdf(file) { return file.type === 'application/pdf'; }

        function renderPreview() {
            previewList.innerHTML = '';

            selectedFiles.forEach(function (file, index) {
                const item = document.createElement('div');
                item.className = 'file-preview-item';

                if (isImage(file)) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    item.appendChild(img);
                } else if (isPdf(file)) {
                    const icon = document.createElement('div');
                    icon.className = 'file-icon';
                    icon.innerHTML = '<i class="fas fa-file-pdf"></i><span>PDF</span>';
                    item.appendChild(icon);
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
                    alert('Maksimal ' + MAX_FILES + ' berkas.');
                    return;
                }
                if (file.size > MAX_SIZE) {
                    alert('Berkas "' + file.name + '" melebihi 5 MB.');
                    return;
                }
                if (!isImage(file) && !isPdf(file)) {
                    alert('Berkas "' + file.name + '" harus berupa gambar atau PDF.');
                    return;
                }
                selectedFiles.push(file);
            });

            syncInput();
            renderPreview();
        });

        const form = document.getElementById('letterForm');
        const submitBtn = document.getElementById('submitBtn');
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        });
    });
</script>
@endsection