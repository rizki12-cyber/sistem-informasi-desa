{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Inter', sans-serif;
            position: relative;
            background: #0a1a0a;
            overflow: hidden;
        }

        /* ===== BACKGROUND FULL ===== */
        .bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            overflow: hidden;
            transition: filter 0.5s ease, transform 0.5s ease;
        }

        .bg video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bg .fallback {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
            display: none;
        }

        .bg .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(10, 26, 10, 0.7) 0%, rgba(10, 26, 10, 0.4) 100%);
        }

        .left {
            position: relative;
            z-index: 1;
            flex: 0 0 50%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            perspective: 1400px;
            transition: transform 0.5s cubic-bezier(0.55, 0, 1, 0.45), opacity 0.5s ease;
        }

        .right {
            flex: 1;
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* ===== CARD GLASSMORPHISM ===== */
        .card {
            width: 100%;
            max-width: 420px;
            padding: 48px 40px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px) saturate(140%);
            -webkit-backdrop-filter: blur(24px) saturate(140%);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 40px 80px rgba(0, 0, 0, 0.5),
                0 20px 40px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2),
                0 0 60px rgba(212, 175, 55, 0.06);
            transform-style: preserve-3d;
            transform: rotateX(0deg) rotateY(0deg) translateZ(0);
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
            will-change: transform;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            border-radius: 30px;
            background: linear-gradient(145deg, rgba(212, 175, 55, 0.35), transparent 30%, transparent 70%, rgba(212, 175, 55, 0.2));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        .card:hover::before { opacity: 1; }

        .card .glow {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            border-radius: 28px;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .card .glow::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            left: var(--mouse-x, 50%);
            top: var(--mouse-y, 50%);
            transition: left 0.08s ease, top 0.08s ease;
            pointer-events: none;
        }

        .card > *:not(.glow) {
            position: relative;
            z-index: 1;
        }

        /* ===== HEADER ===== */
        .card .header {
            text-align: center;
            margin-bottom: 36px;
            transform: translateZ(60px);
        }

        .card .header .icon {
            width: 72px; height: 72px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #d4af37, #b8942e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #0a1a0a;
            box-shadow:
                0 8px 24px rgba(212, 175, 55, 0.3),
                0 16px 48px rgba(0, 0, 0, 0.3),
                inset 0 -3px 6px rgba(0, 0, 0, 0.15),
                inset 0 2px 4px rgba(255, 255, 255, 0.2);
            transform: translateZ(20px);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .card:hover .header .icon {
            box-shadow:
                0 12px 32px rgba(212, 175, 55, 0.4),
                0 20px 56px rgba(0, 0, 0, 0.4),
                inset 0 -3px 6px rgba(0, 0, 0, 0.15),
                inset 0 2px 4px rgba(255, 255, 255, 0.2);
        }

        .card .header .icon img {
            width: 72px; height: 72px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card .header h1 {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            transform: translateZ(15px);
        }

        .card .header h1 span {
            color: #d4af37;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .card .header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            transform: translateZ(10px);
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 18px;
            transform: translateZ(40px);
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 6px;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.3px;
        }

        .form-group .input {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow:
                inset 0 3px 6px rgba(0, 0, 0, 0.15),
                inset 0 -1px 2px rgba(255, 255, 255, 0.03);
        }

        .form-group .input:focus-within {
            border-color: rgba(212, 175, 55, 0.5);
            background: rgba(255, 255, 255, 0.1);
            box-shadow:
                inset 0 3px 6px rgba(0, 0, 0, 0.15),
                inset 0 -1px 2px rgba(255, 255, 255, 0.03),
                0 0 0 4px rgba(212, 175, 55, 0.1),
                0 0 24px rgba(212, 175, 55, 0.15);
        }

        .form-group .input .icon-left {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.35);
            font-size: 15px;
            pointer-events: none;
            z-index: 1;
            transition: color 0.3s ease;
        }

        .form-group .input:focus-within .icon-left {
            color: rgba(212, 175, 55, 0.8);
        }

        .form-group .input input {
            width: 100%;
            padding: 13px 48px 13px 46px;
            background: transparent;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            position: relative;
            z-index: 2;
            letter-spacing: 0.2px;
        }

        .form-group .input input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-group .input .toggle {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            font-size: 15px;
            padding: 10px 12px;
            z-index: 2;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group .input .toggle:hover {
            color: rgba(212, 175, 55, 0.9);
            background: rgba(212, 175, 55, 0.1);
        }

        /* ===== OPTIONS ===== */
        .options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 20px 0 24px;
            transform: translateZ(30px);
        }

        .options label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
            transition: color 0.3s ease;
        }

        .options label:hover { color: rgba(255, 255, 255, 0.85); }

        .options label input {
            accent-color: #d4af37;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        /* ===== BUTTON ===== */
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #d4af37 0%, #b8942e 50%, #a07f1f 100%);
            border: none;
            border-radius: 12px;
            color: #0a1a0a;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow:
                0 6px 0 #7a5f15,
                0 8px 16px rgba(0, 0, 0, 0.3),
                0 12px 32px rgba(212, 175, 55, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -2px 4px rgba(0, 0, 0, 0.2);
            transform: translateZ(50px);
            position: relative;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
            border-radius: 12px;
        }

        .btn:hover::before { left: 100%; }

        .btn:hover {
            transform: translateZ(50px) translateY(-3px);
            box-shadow:
                0 9px 0 #7a5f15,
                0 12px 24px rgba(0, 0, 0, 0.35),
                0 16px 40px rgba(212, 175, 55, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: translateZ(50px) translateY(4px);
            box-shadow:
                0 2px 0 #7a5f15,
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ===== ALERT ===== */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateZ(40px);
            box-shadow:
                inset 0 2px 4px rgba(0, 0, 0, 0.15),
                0 2px 8px rgba(220, 53, 69, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .alert i { color: #ff6b6b; font-size: 16px; }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);
            transform: translateZ(20px);
            letter-spacing: 0.5px;
        }

        .footer span { color: rgba(212, 175, 55, 0.6); }

        /* ===== MUTE BTN ===== */
        .mute-btn {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 10;
            width: 44px; height: 44px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .mute-btn:hover {
            background: rgba(0, 0, 0, 0.6);
            color: rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .left { flex: 1; min-height: 100vh; }
            .right { display: none; }
        }

        @media (max-width: 480px) {
            .card { padding: 32px 24px; border-radius: 24px; }
            .card .header .icon { width: 60px; height: 60px; font-size: 26px; }
            .card .header .icon img { width: 60px; height: 60px; }
            .card .header h1 { font-size: 22px; }
            .form-group .input input { padding: 12px 44px 12px 44px; font-size: 13px; }
        }

        @media (max-width: 360px) {
            .card { padding: 24px 16px; border-radius: 20px; }
            .btn { font-size: 13px; padding: 12px; }
            .mute-btn { bottom: 16px; right: 16px; width: 38px; height: 38px; font-size: 14px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .card, .bg, .left, .btn { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body>

    @php
        $profile = App\Models\VillageProfile::first();
        $videoUrl = null;
        $fallback = 'https://images.pexels.com/photos/256490/pexels-photo-256490.jpeg?auto=compress&cs=tinysrgb&w=1600';
        $logo = null;

        if ($profile) {
            if (!empty($profile->video_background)) {
                $videoUrl = asset('storage/' . $profile->video_background);
            }
            if (!empty($profile->background_login)) {
                $fallback = asset('storage/' . $profile->background_login);
            }
            if (!empty($profile->logo)) {
                $logo = asset('storage/' . $profile->logo);
            }
        }
    @endphp

    <!-- ===== BACKGROUND FULL ===== -->
    <div class="bg" id="bgLayer">
        @if($videoUrl)
            <video id="bgVideo" autoplay muted loop playsinline>
                <source src="{{ $videoUrl }}" type="video/mp4">
            </video>
        @endif
        <div class="fallback" id="fallbackImg" style="background-image:url('{{ $fallback }}');"></div>
        <div class="overlay"></div>
    </div>

    <!-- ===== MUTE BUTTON ===== -->
    @if($videoUrl)
        <button class="mute-btn" id="muteBtn" title="Toggle suara">
            <i class="fas fa-volume-mute"></i>
        </button>
    @endif

    <!-- ===== KOLOM KIRI: FORM 3D ===== -->
    <div class="left" id="leftCol">
        <div class="card" id="card3d">
            <!-- Efek glow mengikuti mouse -->
            <div class="glow"></div>

            @if($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <div class="input">
                        <span class="icon-left"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="admin@desa.test" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input">
                        <span class="icon-left"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle" id="toggleBtn">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="options">
                    <label>
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="footer">
                <span>✦</span> {{ date('Y') }} Sistem Informasi Desa
            </div>
        </div>
    </div>

    <!-- ===== KOLOM KANAN: KOSONG ===== -->
    <div class="right"></div>

    <script>
        // ===== TOGGLE PASSWORD =====
        document.getElementById('toggleBtn').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            icon.classList.toggle('fa-eye-slash');
            icon.classList.toggle('fa-eye');
        });

        // ===== 3D EFFECT =====
        (function() {
            const card = document.getElementById('card3d');
            const maxTilt = 18;
            const scale = 1.02;

            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateY = ((x - centerX) / centerX) * maxTilt;
                const rotateX = ((centerY - y) / centerY) * maxTilt;

                card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(30px) scale(${scale})`;

                const percentX = (x / rect.width) * 100;
                const percentY = (y / rect.height) * 100;
                card.style.setProperty('--mouse-x', percentX + '%');
                card.style.setProperty('--mouse-y', percentY + '%');

                const shadowX = ((x - centerX) / centerX) * 20;
                const shadowY = ((y - centerY) / centerY) * 20;
                card.style.boxShadow = `
                    ${shadowX}px ${shadowY}px 80px rgba(0, 0, 0, 0.5),
                    ${shadowX * 0.5}px ${shadowY * 0.5}px 40px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15),
                    inset 0 -1px 0 rgba(0, 0, 0, 0.2),
                    0 0 60px rgba(212, 175, 55, 0.08)
                `;
            });

            card.addEventListener('mouseleave', function() {
                card.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0) scale(1)';
                card.style.boxShadow = `
                    0 40px 80px rgba(0, 0, 0, 0.5),
                    0 20px 40px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15),
                    inset 0 -1px 0 rgba(0, 0, 0, 0.2),
                    0 0 60px rgba(212, 175, 55, 0.06)
                `;
                card.style.setProperty('--mouse-x', '50%');
                card.style.setProperty('--mouse-y', '50%');
            });

            // Efek masuk saat load
            card.style.opacity = '0';
            card.style.transform = 'rotateX(15deg) rotateY(-10deg) translateZ(-50px) scale(0.9)';
            setTimeout(function() {
                card.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                card.style.opacity = '1';
                card.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0) scale(1)';
                setTimeout(function() {
                    card.style.transition = 'transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease, opacity 0.8s ease';
                }, 800);
            }, 150);
        })();

        // ===== VIDEO =====
        @if($videoUrl)
            const video = document.getElementById('bgVideo');
            const fallback = document.getElementById('fallbackImg');
            const muteBtn = document.getElementById('muteBtn');
            const muteIcon = muteBtn.querySelector('i');
            let muted = true;

            if (video) {
                video.addEventListener('error', function() {
                    video.style.display = 'none';
                    fallback.style.display = 'block';
                    muteBtn.style.display = 'none';
                });

                video.play().catch(function() {
                    video.style.display = 'none';
                    fallback.style.display = 'block';
                    muteBtn.style.display = 'none';
                });
            }

            muteBtn.addEventListener('click', function() {
                if (video && video.style.display !== 'none') {
                    muted = !muted;
                    video.muted = muted;
                    muteIcon.className = muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
                }
            });
        @else
            document.getElementById('fallbackImg').style.display = 'block';
        @endif

        // =============================================
        // ANIMASI KELUAR SAAT LOGIN (tanpa loading overlay)
        // Form tetap di-submit langsung, animasi hanya visual.
        // =============================================
        (function() {
            const form = document.getElementById('loginForm');
            const card = document.getElementById('card3d');
            const bg = document.getElementById('bgLayer');
            const leftCol = document.getElementById('leftCol');
            const loginBtn = document.getElementById('loginBtn');

            if (!form) return;

            form.addEventListener('submit', function(e) {
                // Cek validasi HTML5
                if (!form.checkValidity()) {
                    return;
                }

                // Prevent double submit (disable tombol)
                if (loginBtn) {
                    loginBtn.disabled = true;
                }

                // ===== ANIMASI KELUAR (visual saja) =====
                if (card) {
                    card.style.transition = 'all 0.5s cubic-bezier(0.55, 0, 1, 0.45)';
                    card.style.transform = 'translateY(-60px) scale(0.95)';
                    card.style.opacity = '0';
                    card.style.filter = 'blur(6px)';
                }

                if (bg) {
                    bg.style.filter = 'blur(10px) brightness(0.6)';
                    bg.style.transform = 'scale(1.05)';
                }

                if (leftCol) {
                    leftCol.style.transform = 'translateY(-100%)';
                    leftCol.style.opacity = '0';
                }

                // Form submit LANGSUNG — tidak di-prevent.
                // Redirect ke dashboard akan terjadi setelah server response.
                // Animasi di atas tetap jalan di background sambil browser berpindah halaman.
            });
        })();
    </script>
</body>
</html>