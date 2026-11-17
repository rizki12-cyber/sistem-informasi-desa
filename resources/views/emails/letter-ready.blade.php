<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f4; margin: 0; padding: 0; }
    .wrap { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .head { background: linear-gradient(135deg, #0f2310, #1b431c); padding: 40px 32px; text-align: center; color: #fff; position: relative; }
    .head::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f0d060, #d4af37); }
    .head .icon { width: 70px; height: 70px; margin: 0 auto 16px; border-radius: 50%; background: linear-gradient(135deg, #22c55e, #16a34a); display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 8px 24px rgba(34,197,94,0.35); }
    .head h1 { margin: 0; font-size: 22px; letter-spacing: -0.3px; }
    .head h1 span { color: #d4af37; }
    .head p { margin: 8px 0 0; font-size: 14px; opacity: 0.85; }
    .body { padding: 32px; color: #2d3a2d; line-height: 1.7; }
    .body p { margin: 0 0 14px; font-size: 15px; }
    .ticket { display: block; padding: 16px 20px; background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(212,175,55,0.02)); border: 1px dashed rgba(212,175,55,0.4); border-radius: 12px; text-align: center; margin: 20px 0; }
    .ticket .label { font-size: 11px; font-weight: 700; color: #b8912a; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px; }
    .ticket .code { font-family: 'Courier New', monospace; font-size: 22px; font-weight: 800; color: #0f2310; letter-spacing: 2px; }
    .info-box { background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 8px; padding: 16px 20px; margin: 20px 0; }
    .info-box .label { font-size: 11px; font-weight: 700; color: #16a34a; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .info-box p { margin: 0; color: #065f46; font-size: 14px; }
    .steps { margin: 24px 0; }
    .step { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 14px; }
    .step .num { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step .txt { font-size: 14px; color: #2d3a2d; line-height: 1.6; }
    .btn { display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a !important; text-decoration: none; border-radius: 50px; font-weight: 800; font-size: 14px; letter-spacing: 0.5px; box-shadow: 0 4px 16px rgba(212,175,55,0.3); margin: 8px 0; }
    .btn:hover { opacity: 0.9; }
    .cta { text-align: center; margin: 24px 0 8px; }
    .foot { padding: 24px; background: #f8faf8; text-align: center; font-size: 12px; color: #8a9a8a; border-top: 1px solid #eef3ee; }
    .foot strong { color: #b8912a; }
    .attach-note { background: #fafcfa; border: 1px solid #eef3ee; border-radius: 10px; padding: 14px 18px; margin: 20px 0; font-size: 13px; color: #6a7a6a; display: flex; align-items: center; gap: 10px; }
    .attach-note i { color: #d4af37; font-size: 20px; }
</style>
</head>
<body>
    <div class="wrap">
        <div class="head">
            <div class="icon">✓</div>
            <h1>Surat Anda <span>Siap Diambil</span></h1>
            <p>Nomor Permohonan: {{ $letter->request_number }}</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $letter->name }}</strong>,</p>
            <p>Kabar baik! Permohonan surat Anda sudah selesai diproses dan <strong>siap diambil</strong> di kantor desa.</p>

            <div class="ticket">
                <div class="label">Nomor Permohonan</div>
                <div class="code">{{ $letter->request_number }}</div>
            </div>

            <div class="info-box">
                <div class="label">Jenis Surat</div>
                <p>{{ $letter->letterType->name }}</p>
            </div>

            <div class="attach-note">
                <i>📎</i>
                <span>File surat dalam format PDF juga terlampir di email ini. Silakan download dan cetak sebagai arsip Anda.</span>
            </div>

            <p style="font-weight:700; margin-top:24px;">Langkah selanjutnya:</p>
            <div class="steps">
                <div class="step">
                    <div class="num">1</div>
                    <div class="txt">Datang ke kantor desa pada <strong>jam kerja</strong> (Senin-Jumat, 08:00-16:00 WIB).</div>
                </div>
                <div class="step">
                    <div class="num">2</div>
                    <div class="txt">Tunjukkan <strong>nomor permohonan</strong> dan <strong>KTP asli</strong> Anda kepada petugas.</div>
                </div>
                <div class="step">
                    <div class="num">3</div>
                    <div class="txt">Tanda tangan buku penerimaan surat, dan surat resmi bisa Anda bawa pulang.</div>
                </div>
            </div>

            <div class="cta">
                <a href="{{ route('public.letters.check') }}" class="btn">Cek Status Surat</a>
            </div>
        </div>
        <div class="foot">
            Email ini dikirim otomatis oleh <strong>Sistem Informasi Desa {{ $profile->village_name ?? '' }}</strong>.<br>
            Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>