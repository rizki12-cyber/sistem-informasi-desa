@php
    $profile = \App\Models\VillageProfile::first();
    $contact = \App\Models\Contact::first();

    // Logo — coba base64 dulu, fallback ke asset URL
    $logoSrc = null;
    if ($profile && $profile->logo) {
        $path = public_path('storage/' . $profile->logo);

        if (file_exists($path)) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = in_array($ext, ['jpg','jpeg']) ? 'image/jpeg'
                   : ($ext === 'png' ? 'image/png'
                   : ($ext === 'webp' ? 'image/webp' : 'image/png'));
            $logoSrc = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
        } else {
            $logoSrc = asset('storage/' . $profile->logo);
        }
    }

    $jumlahLampiran = is_array($letter->attachments) ? count($letter->attachments) : 0;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ $letter->letterType->name }}</title>
<style>
    /* ============================================= */
    /*  PAGE SETUP                                    */
    /* ============================================= */
    @page { margin: 18mm 20mm 20mm 20mm; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 11.5pt;
        color: #1a1a1a;
        line-height: 1.6;
    }

    /* ============================================= */
    /*  WATERMARK LOGO                                */
    /* ============================================= */
    .watermark {
        position: fixed;
        top: 32%;
        left: 50%;
        margin-left: -160px;
        width: 320px;
        opacity: 0.05;
        z-index: -100;
    }

    /* ============================================= */
    /*  KOP SURAT                                     */
    /* ============================================= */
    .kop {
        width: 100%;
        padding-bottom: 6pt;
        border-bottom: 2pt solid #0f2310;
        margin-bottom: 0;
    }
    .kop table { width: 100%; border-collapse: collapse; }
    .kop td { vertical-align: middle; padding: 0; }
    .kop .logo-cell { width: 90pt; text-align: center; }
    .kop .logo-cell img { width: 68pt; height: auto; }
    .kop .text-cell { text-align: center; padding: 0 12pt; }
    .kop .text-cell .line1 {
        font-size: 11pt;
        font-weight: normal;
        letter-spacing: 0.4pt;
        color: #2a2a2a;
        line-height: 1.35;
    }
    .kop .text-cell .line3 {
        font-size: 17pt;
        font-weight: bold;
        letter-spacing: 1.5pt;
        color: #0f2310;
        margin: 3pt 0;
        line-height: 1.1;
    }
    .kop .text-cell .line4 {
        font-size: 8.5pt;
        font-style: italic;
        color: #555;
        line-height: 1.45;
    }
    .kop-gold-line {
        width: 100%;
        height: 1.2pt;
        background: #d4af37;
        margin-top: 2pt;
        margin-bottom: 16pt;
    }

    /* ============================================= */
    /*  META (Nomor / Lampiran / Perihal / Tujuan)   */
    /* ============================================= */
    .meta { width: 100%; margin-bottom: 18pt; border-collapse: collapse; table-layout: fixed; }
    .meta td { vertical-align: top; font-size: 11pt; line-height: 1.55; }
    .meta .left { width: 55%; }
    .meta .right { width: 45%; padding-left: 20pt; text-align: left; }
    .meta .left table { border-collapse: collapse; width: 100%; }
    .meta .left td { padding: 1.5pt 0; vertical-align: top; }
    .meta .left td.label { width: 62pt; }
    .meta .left td.colon { width: 10pt; }

    /* ============================================= */
    /*  JUDUL SURAT                                   */
    /* ============================================= */
    .judul-wrap { text-align: center; margin-bottom: 22pt; }
    .judul {
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
        letter-spacing: 1.2pt;
        color: #0f2310;
        margin-bottom: 3pt;
        text-transform: uppercase;
    }
    .nomor-surat { font-size: 11pt; color: #444; letter-spacing: 0.3pt; }

    /* ============================================= */
    /*  BODY TEXT — refined                           */
    /* ============================================= */
    .body-text {
        text-align: justify;
        text-align-last: left;
        text-indent: 30pt;
        margin: 0 0 12pt 0;
        padding: 0 1pt;
        font-size: 11.5pt;
        line-height: 1.7;
        word-spacing: -0.15pt;
        text-justify: inter-word;
        color: #1a1a1a;
    }

    /* ============================================= */
    /*  DATA PEMOHON                                  */
    /* ============================================= */
    .data-table {
        width: calc(100% - 30pt);
        margin: 12pt 0 14pt 30pt;
        border-collapse: collapse;
    }
    .data-table tr { vertical-align: top; }
    .data-table td { padding: 3pt 0; font-size: 11.5pt; line-height: 1.55; }
    .data-table td:nth-child(1) { width: 135pt; }
    .data-table td:nth-child(2) { width: 12pt; }

    /* ============================================= */
    /*  PURPOSE BOX                                   */
    /* ============================================= */
    .purpose-box {
        background: #fdf9ea;
        border-left: 3pt solid #d4af37;
        padding: 10pt 16pt;
        margin: 14pt 0;
        font-size: 11pt;
    }
    .purpose-box .label {
        font-size: 8.5pt;
        text-transform: uppercase;
        color: #b8912a;
        font-weight: bold;
        letter-spacing: 0.8pt;
        margin-bottom: 4pt;
    }
    .purpose-box .value { line-height: 1.6; color: #1a1a1a; }

    /* ============================================= */
    /*  TANDA TANGAN                                  */
    /* ============================================= */
    .ttd-wrap {
        width: 100%;
        margin-top: 24pt;
        border-collapse: collapse;
        page-break-inside: avoid !important;
    }
    .ttd-wrap tr, .ttd-wrap td { page-break-inside: avoid !important; }
    .ttd-wrap td { vertical-align: top; }
    .ttd-wrap td.spacer { width: 52%; }
    .ttd {
        text-align: center;
        font-size: 11.5pt;
        line-height: 1.5;
        padding-right: 15pt;
    }
    .ttd .tanggal { line-height: 1.5; }
    .ttd .jabatan { font-weight: bold; margin-top: 3pt; }
    .ttd .space { height: 55pt; }
    .ttd .nama {
        font-weight: bold;
        text-decoration: underline;
        font-size: 12pt;
        line-height: 1.35;
    }
    .ttd .nip { font-size: 9.5pt; color: #555; margin-top: 2pt; }

    /* ============================================= */
    /*  ANTI PAGE-BREAK WRAPPER                       */
    /* ============================================= */
    .no-break { page-break-inside: avoid; }

    /* ============================================= */
    /*  FOOTER                                        */
    /* ============================================= */
    .footer {
        position: fixed;
        bottom: 6mm;
        left: 20mm;
        right: 20mm;
        text-align: center;
        font-size: 7.5pt;
        color: #999;
        border-top: 0.6pt solid #e8e8e8;
        padding-top: 5pt;
        line-height: 1.5;
    }
    .footer .code {
        font-family: 'Courier New', monospace;
        letter-spacing: 1pt;
        color: #b8912a;
        font-weight: bold;
    }
</style>
</head>
<body>

{{-- ============================================= --}}
{{-- WATERMARK LOGO                                --}}
{{-- ============================================= --}}
@if($logoSrc)
    <img class="watermark" src="{{ $logoSrc }}" alt="">
@endif

{{-- ============================================= --}}
{{-- KOP SURAT                                     --}}
{{-- ============================================= --}}
<div class="kop">
    <table>
        <tr>
            <td class="logo-cell">
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="Logo">
                @else
                    &nbsp;
                @endif
            </td>
            <td class="text-cell">
                <div class="line1">PEMERINTAH KABUPATEN {{ strtoupper($profile->regency ?? '') }}</div>
                <div class="line1">KECAMATAN {{ strtoupper($profile->district ?? '') }}</div>
                <div class="line3">DESA {{ strtoupper($profile->village_name ?? '') }}</div>
                <div class="line4">
                    {{ $profile->address ?? '' }}@if($contact) &nbsp;|&nbsp; Telp. {{ $contact->phone ?? '-' }} &nbsp;|&nbsp; Email: {{ $contact->email ?? '-' }}@endif
                </div>
            </td>
            <td class="logo-cell">&nbsp;</td>
        </tr>
    </table>
</div>
<div class="kop-gold-line"></div>

{{-- ============================================= --}}
{{-- META                                          --}}
{{-- ============================================= --}}
<table class="meta">
    <tr>
        <td class="left">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $letter->request_number }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $jumlahLampiran > 0 ? $jumlahLampiran . ' berkas' : '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td>{{ $letter->letterType->name }}</td>
                </tr>
            </table>
        </td>
        <td class="right">
            {{ $profile->village_name ?? '' }}, {{ now()->translatedFormat('d F Y') }}<br><br>
            Kepada Yth.<br>
            <strong>{{ $letter->name }}</strong><br>
            di Tempat
        </td>
    </tr>
</table>

{{-- ============================================= --}}
{{-- JUDUL                                         --}}
{{-- ============================================= --}}
<div class="judul-wrap">
    <div class="judul">{{ $letter->letterType->name }}</div>
    <div class="nomor-surat">Nomor: {{ $letter->request_number }}</div>
</div>

{{-- ============================================= --}}
{{-- BODY PEMBUKA                                  --}}
{{-- ============================================= --}}
<div class="body-text">
    Yang bertanda tangan di bawah ini, Kepala Desa {{ $profile->village_name ?? '' }}, Kecamatan {{ $profile->district ?? '' }}, Kabupaten {{ $profile->regency ?? '' }}, dengan ini menerangkan dengan sebenarnya bahwa:
</div>

{{-- ============================================= --}}
{{-- DATA PEMOHON                                  --}}
{{-- ============================================= --}}
<table class="data-table">
    <tr><td>Nama Lengkap</td><td>:</td><td><strong>{{ $letter->name }}</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>{{ $letter->nik }}</td></tr>
    @if($letter->birth_place || $letter->birth_date)
        <tr>
            <td>Tempat / Tgl. Lahir</td><td>:</td>
            <td>{{ $letter->birth_place ?? '' }}@if($letter->birth_place && $letter->birth_date), @endif{{ $letter->birth_date ? $letter->birth_date->translatedFormat('d F Y') : '' }}</td>
        </tr>
    @endif
    @if($letter->gender)<tr><td>Jenis Kelamin</td><td>:</td><td>{{ $letter->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>@endif
    @if($letter->religion)<tr><td>Agama</td><td>:</td><td>{{ $letter->religion }}</td></tr>@endif
    @if($letter->marital_status)<tr><td>Status Perkawinan</td><td>:</td><td>{{ $letter->marital_status }}</td></tr>@endif
    @if($letter->occupation)<tr><td>Pekerjaan</td><td>:</td><td>{{ $letter->occupation }}</td></tr>@endif
    <tr><td>Alamat</td><td>:</td><td>{{ $letter->address }}</td></tr>

    @if($letter->letter_data && is_array($letter->letter_data))
        @foreach($letter->letter_data as $key => $value)
            @if($value !== null && $value !== '')
                @php $label = \App\Models\LetterType::getFieldLabel($letter->letterType->slug, $key); @endphp
                <tr><td>{{ $label }}</td><td>:</td><td>{{ $value }}</td></tr>
            @endif
        @endforeach
    @endif
</table>

{{-- ============================================= --}}
{{-- WRAPPER ANTI PAGE-BREAK                       --}}
{{-- (body penutup + purpose + ttd)                --}}
{{-- ============================================= --}}
<div class="no-break">

    {{-- BODY PENUTUP --}}
    <div class="body-text">
        Adalah benar warga yang berdomisili di wilayah Desa {{ $profile->village_name ?? '' }}, dan berdasarkan data yang ada, orang tersebut di atas adalah benar warga kami.
    </div>

    {{-- KEPERLUAN --}}
    <div class="purpose-box">
        <div class="label">Keperluan</div>
        <div class="value">{{ $letter->purpose }}</div>
    </div>

    {{-- PENUTUP --}}
    <div class="body-text">
        Demikian Surat Keterangan ini dibuat dengan sebenarnya dan untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-wrap">
        <tr>
            <td class="spacer"></td>
            <td>
                <div class="ttd">
                    <div class="tanggal">{{ $profile->village_name ?? '' }}, {{ now()->translatedFormat('d F Y') }}</div>
                    <div class="jabatan">Kepala Desa {{ $profile->village_name ?? '' }}</div>
                    <div class="space"></div>
                    <div class="nama">{{ $profile->head_name ?? '..............................' }}</div>
                    <div class="nip">NIP. {{ $profile->head_nip ?? '..............................' }}</div>
                </div>
            </td>
        </tr>
    </table>

</div>

{{-- ============================================= --}}
{{-- FOOTER                                        --}}
{{-- ============================================= --}}
<div class="footer">
    Surat ini sah dan diterbitkan secara elektronik oleh Sistem Informasi Desa {{ $profile->village_name ?? '' }}.<br>
    <span class="code">{{ $letter->request_number }}</span> &nbsp;—&nbsp; Diverifikasi pada {{ now()->translatedFormat('d F Y H:i') }} WIB
</div>

</body>
</html>