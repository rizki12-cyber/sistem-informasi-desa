@extends('layouts.app')

@section('title', 'Beranda - ' . ($profile->village_name ?? 'Sistem Informasi Desa'))
@section('description', 'Website resmi ' . ($profile->village_name ?? 'Desa') . ' - Informasi desa, pemerintahan, berita, dan layanan masyarakat.')

@section('content')
<style>
    /* ============================================= */
    /*  DESIGN TOKENS                                */
    /* ============================================= */
    :root {
        --gold: #d4af37;
        --gold-dark: #c5a031;
        --gold-light: #f0d060;
        --gold-soft: rgba(212, 175, 55, 0.12);
        --green-deep: #0a1a0a;
        --green-mid: #1a3a1a;
        --green-text: #2a3a2a;
        --text-main: #0a1a0a;
        --text-body: #5a6a5a;
        --text-muted: #8a9a8a;
        --bg-alt: #f8faf8;
        --border-soft: #eef3ee;
        --radius-sm: 12px;
        --radius-md: 18px;
        --radius-lg: 24px;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.03);
        --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.08);
        --ease-smooth: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* ===== HERO SECTION ===== */
    .hero-section {
        position: relative;
        height: 100vh;
        min-height: 620px;
        max-height: 900px;
        overflow: hidden;
        background: var(--green-deep);
    }

    .hero-slider { width: 100%; height: 100%; position: relative; }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.2s var(--ease-smooth);
        will-change: opacity;
    }
    .hero-slide.active { opacity: 1; }

    .hero-slide .slide-bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1);
        transition: transform 8s ease;
    }
    .hero-slide.active .slide-bg { transform: scale(1.06); }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(10, 26, 10, 0.75) 0%, transparent 60%),
            linear-gradient(135deg, rgba(10, 26, 10, 0.75) 0%, rgba(10, 26, 10, 0.25) 60%, rgba(10, 26, 10, 0.15) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(212, 175, 55, 0.06) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        z-index: 2;
        opacity: 0.5;
    }

    .hero-content {
        color: #fff;
        max-width: 820px;
        padding: 0 20px;
        animation: fadeUp 1s ease forwards;
        opacity: 0;
        transform: translateY(30px);
        position: relative;
        z-index: 3;
    }
    .hero-slide.active .hero-content { animation: fadeUp 1s ease 0.3s forwards; }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-content .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(212, 175, 55, 0.15);
        border: 1px solid rgba(212, 175, 55, 0.35);
        color: var(--gold-light);
        padding: 8px 22px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.15);
    }
    .hero-content .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--gold);
        box-shadow: 0 0 12px var(--gold);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }

    .hero-content h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.12;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #ffffff 0%, #f5e6a8 50%, var(--gold) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        filter: drop-shadow(0 4px 20px rgba(0, 0, 0, 0.4))
                drop-shadow(0 0 40px rgba(212, 175, 55, 0.2));
    }
    .hero-content h1 span {
        background: linear-gradient(135deg, #ffffff 0%, var(--gold) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-content .typing-wrapper {
        min-height: 44px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-content .typing-text {
        font-size: clamp(0.95rem, 1.6vw, 1.2rem);
        color: rgba(255, 255, 255, 0.9);
        font-weight: 300;
        letter-spacing: 0.4px;
        line-height: 1.6;
    }
    .hero-content .typing-text .cursor {
        display: inline-block;
        width: 2px;
        height: 1.1em;
        background: var(--gold);
        margin-left: 4px;
        vertical-align: text-bottom;
        animation: blink 0.8s step-end infinite;
        box-shadow: 0 0 8px var(--gold);
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

    .hero-content .btn-hero {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: var(--green-deep);
        padding: 15px 42px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.3px;
        transition: all 0.4s var(--ease-smooth);
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }
    .hero-content .btn-hero::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s ease;
    }
    .hero-content .btn-hero:hover::before { left: 100%; }
    .hero-content .btn-hero:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 40px rgba(212, 175, 55, 0.5);
    }
    .hero-content .btn-hero i { transition: transform 0.3s ease; }
    .hero-content .btn-hero:hover i { transform: translateX(5px); }

    /* Slider Controls */
    .slider-controls {
        position: absolute;
        bottom: 46px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 16px;
        align-items: center;
        z-index: 10;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(12px);
        padding: 10px 18px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .slider-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        border: none;
        cursor: pointer;
        transition: all 0.4s ease;
        padding: 0;
    }
    .slider-dot.active {
        background: var(--gold);
        width: 28px;
        border-radius: 6px;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.6);
    }
    .slider-dot:hover { background: rgba(255, 255, 255, 0.6); }

    .slider-btn {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.8);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .slider-btn:hover {
        background: rgba(212, 175, 55, 0.25);
        border-color: rgba(212, 175, 55, 0.4);
        color: #fff;
        transform: scale(1.08);
    }

    .slider-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        width: 0%;
        z-index: 10;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        transition: width 0.1s linear;
    }

    /* ===== SECTION COMMON ===== */
    .section { padding: 100px 0; }
    .section-alt { background: var(--bg-alt); }

    .section-header {
        text-align: center;
        max-width: 660px;
        margin: 0 auto 60px;
        position: relative;
    }
    .section-header .subtitle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 12px;
    }
    .section-header .subtitle::before,
    .section-header .subtitle::after {
        content: '';
        width: 28px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold));
    }
    .section-header .subtitle::after {
        background: linear-gradient(90deg, var(--gold), transparent);
    }

    .section-header h2 {
        font-size: clamp(1.75rem, 3.5vw, 2.4rem);
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }
    .section-header h2 span { color: var(--gold); }
    .section-header p {
        color: var(--text-body);
        font-size: 16px;
        line-height: 1.7;
    }

    /* ===== SCROLL REVEAL ===== */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s var(--ease-smooth), transform 0.8s var(--ease-smooth);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ===== WELCOME / SAMBUTAN ===== */
    .welcome-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 70px;
        align-items: center;
    }

    .welcome-image { position: relative; display: flex; justify-content: center; }

    .welcome-image .img-wrapper {
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        position: relative;
        width: 100%;
        max-width: 340px;
        aspect-ratio: 1/1;
        background: transparent;
        border: 4px solid #fff;
    }
    .welcome-image .img-wrapper::before {
        content: '';
        position: absolute;
        inset: -12px;
        border-radius: 50%;
        border: 2px dashed rgba(212, 175, 55, 0.4);
        animation: rotateSlow 30s linear infinite;
        pointer-events: none;
        z-index: -1;
    }
    @keyframes rotateSlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .welcome-image .img-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }
    .welcome-image .img-wrapper:hover img { transform: scale(1.05); }

    .welcome-text h3 {
        font-size: clamp(1.5rem, 2.5vw, 1.9rem);
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 18px;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .welcome-text h3 span { color: var(--gold); }

    .welcome-text .message {
        font-size: 17px;
        color: var(--green-text);
        font-style: italic;
        line-height: 1.9;
        padding: 20px 24px;
        border-left: 4px solid var(--gold);
        background: linear-gradient(90deg, rgba(212, 175, 55, 0.05), transparent);
        border-radius: 0 12px 12px 0;
        margin: 20px 0;
        position: relative;
    }
    .welcome-text .message::before {
        content: '"';
        position: absolute;
        top: -8px;
        left: 12px;
        font-size: 48px;
        color: var(--gold);
        opacity: 0.25;
        font-family: Georgia, serif;
        line-height: 1;
    }

    .welcome-text p {
        color: var(--text-body);
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 10px;
    }

    /* ============================================= */
    /*  TENTANG DESA — CLEAN / RAPI                  */
    /* ============================================= */
    .about-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 56px;
        align-items: start;
    }

    /* --- Kolom Kiri --- */
    .about-info .about-title {
        font-size: clamp(1.5rem, 2.5vw, 1.9rem);
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 24px;
        letter-spacing: -0.02em;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--border-soft);
        position: relative;
    }
    .about-info .about-title::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0;
        width: 60px; height: 2px;
        background: var(--gold);
    }

    .about-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 28px;
    }
    .meta-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #fff;
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-sm);
        transition: all 0.3s ease;
    }
    .meta-row:hover {
        border-color: var(--gold-soft);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.04);
    }
    .meta-icon {
        width: 38px; height: 38px;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        background: var(--gold-soft);
        color: var(--gold);
        font-size: 15px;
    }
    .meta-text { display: flex; flex-direction: column; line-height: 1.3; }
    .meta-label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .meta-value {
        font-size: 14px;
        color: var(--text-main);
        font-weight: 600;
    }

    .about-history { margin-bottom: 24px; }
    .about-subtitle {
        font-size: 13px;
        font-weight: 700;
        color: var(--gold);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
    }
    .about-history p {
        color: var(--text-body);
        font-size: 15px;
        line-height: 1.85;
        text-align: justify;
    }

    /* --- Kolom Kanan: Visi Misi --- */
    .about-vm {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .vm-card {
        background: #fff;
        border-radius: var(--radius-md);
        padding: 26px 28px;
        border: 1px solid var(--border-soft);
        transition: all 0.4s var(--ease-smooth);
        position: relative;
        overflow: hidden;
    }
    .vm-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        background: linear-gradient(180deg, var(--gold), var(--gold-dark));
    }
    .vm-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 36px rgba(0,0,0,0.06);
        border-color: var(--gold-soft);
    }

    .vm-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }
    .vm-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        box-shadow: 0 6px 16px rgba(212,175,55,0.3);
    }
    .vm-header h4 {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    .vm-card p {
        color: #3a4a3a;
        font-size: 14.5px;
        line-height: 1.8;
    }

    /* ===== WELCOME BUTTON ===== */
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-main);
        font-weight: 600;
        font-size: 14px;
        padding: 13px 30px;
        border: 2px solid var(--gold);
        border-radius: 50px;
        transition: all 0.3s ease;
        margin-top: 12px;
        background: transparent;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .btn-outline::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--gold);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: -1;
    }
    .btn-outline:hover {
        color: #fff;
        border-color: var(--gold);
        transform: translateX(4px);
    }
    .btn-outline:hover::before { transform: translateX(0); }
    .btn-outline i { transition: transform 0.3s ease; }
    .btn-outline:hover i { transform: translateX(4px); }

    /* ===== STATISTICS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
    }

    .stat-card {
        background: #fff;
        border-radius: var(--radius-md);
        padding: 32px 22px;
        text-align: center;
        border: 1px solid var(--border-soft);
        transition: all 0.4s var(--ease-smooth);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s var(--ease-smooth);
    }
    .stat-card:hover::before { transform: scaleX(1); }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        border-color: var(--gold-soft);
    }

    .stat-card .icon-wrap {
        width: 60px;
        height: 60px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.12), rgba(212, 175, 55, 0.04));
        color: var(--gold);
        font-size: 24px;
        transition: all 0.4s ease;
    }
    .stat-card:hover .icon-wrap {
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #fff;
        transform: rotate(-8deg) scale(1.08);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.35);
    }

    .stat-card .number {
        font-size: 36px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
        letter-spacing: -0.02em;
        display: block;
    }
    .stat-card .label {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 6px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* ===== NEWS ===== */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 28px;
    }
    .news-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }

    .news-card {
        background: #fff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-soft);
        transition: all 0.45s var(--ease-smooth);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
    }
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--gold-soft);
    }

    .news-card .img-wrap {
        height: 210px;
        overflow: hidden;
        background: var(--border-soft);
        position: relative;
    }
    .news-card .img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 26, 10, 0.4), transparent 50%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .news-card:hover .img-wrap::after { opacity: 1; }

    .news-card .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s var(--ease-smooth);
    }
    .news-card:hover .img-wrap img { transform: scale(1.08); }

    .news-card .img-wrap .category-tag {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: var(--green-deep);
        padding: 5px 16px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .news-card .body {
        padding: 26px 28px 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .news-card .body .meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
        font-size: 13px;
        color: var(--text-muted);
    }
    .news-card .body .meta i { color: var(--gold); width: 16px; }
    .news-card .body h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-card .body p {
        color: var(--text-body);
        font-size: 14px;
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 18px;
        flex: 1;
    }
    .news-card .body .read-more {
        color: var(--text-main);
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        align-self: flex-start;
    }
    .news-card .body .read-more i { transition: transform 0.3s ease; }
    .news-card .body .read-more:hover { color: var(--gold); }
    .news-card .body .read-more:hover i { transform: translateX(6px); }

    /* ===== AGENDA (Timeline) ===== */
    .agenda-wrapper {
        max-width: 820px;
        margin: 0 auto;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-soft);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        padding: 12px;
    }

    .agenda-item {
        display: flex;
        gap: 22px;
        padding: 22px 24px;
        border-radius: var(--radius-sm);
        transition: background 0.3s ease;
        align-items: center;
        position: relative;
    }
    .agenda-item:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 24px;
        right: 24px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-soft), transparent);
    }
    .agenda-item:hover { background: #fafcfa; }

    .agenda-item .date-box {
        min-width: 84px;
        text-align: center;
        background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
        border-radius: 14px;
        padding: 14px 8px;
        flex-shrink: 0;
        color: #fff;
        box-shadow: 0 6px 18px rgba(10, 26, 10, 0.15);
        position: relative;
        overflow: hidden;
    }
    .agenda-item .date-box::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
    }
    .agenda-item .date-box .day {
        font-size: 26px;
        font-weight: 800;
        line-height: 1;
        color: var(--gold);
        letter-spacing: -0.02em;
    }
    .agenda-item .date-box .month {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.75);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-top: 4px;
    }

    .agenda-item .info { flex: 1; }
    .agenda-item .info h4 {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
        line-height: 1.4;
    }
    .agenda-item .info .details {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 14px;
        color: var(--text-body);
    }
    .agenda-item .info .details span { display: flex; align-items: center; gap: 6px; }
    .agenda-item .info .details i { color: var(--gold); width: 16px; font-size: 13px; }

    .agenda-item .status-badge {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .agenda-item .status-badge.upcoming { background: #e8f5e9; color: #2e7d32; }
    .agenda-item .status-badge.ongoing { background: #fff3e0; color: #e65100; }
    .agenda-item .status-badge.completed { background: #f0f0f0; color: #7a7a7a; }

    /* ===== POTENSI ===== */
    .potential-card {
        background: #fff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-soft);
        transition: all 0.45s var(--ease-smooth);
        box-shadow: var(--shadow-sm);
    }
    .potential-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--gold-soft);
    }
    .potential-card .img-wrap {
        height: 200px;
        overflow: hidden;
        position: relative;
        background: var(--border-soft);
    }
    .potential-card .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s var(--ease-smooth);
    }
    .potential-card:hover .img-wrap img { transform: scale(1.08); }
    .potential-card .img-wrap .category-tag {
        position: absolute;
        bottom: 14px;
        left: 14px;
        background: rgba(10, 26, 10, 0.85);
        backdrop-filter: blur(8px);
        color: var(--gold);
        padding: 5px 16px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }
    .potential-card .body { padding: 24px 26px 28px; }
    .potential-card .body h3 {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .potential-card .body p {
        color: var(--text-body);
        font-size: 14px;
        line-height: 1.7;
    }

    /* ===== UMKM ===== */
    .umkm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 24px;
    }
    .umkm-card {
        background: #fff;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border-soft);
        transition: all 0.4s var(--ease-smooth);
        box-shadow: var(--shadow-sm);
    }
    .umkm-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        border-color: var(--gold-soft);
    }
    .umkm-card .img-wrap {
        height: 180px;
        overflow: hidden;
        background: var(--border-soft);
        position: relative;
    }
    .umkm-card .img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s var(--ease-smooth);
    }
    .umkm-card:hover .img-wrap img { transform: scale(1.08); }
    .umkm-card .img-wrap .category-tag {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(6px);
        color: #fff;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
    }
    .umkm-card .body { padding: 20px 22px 24px; }
    .umkm-card .body h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 2px;
    }
    .umkm-card .body .owner {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
    .umkm-card .body .description {
        font-size: 13px;
        color: var(--text-body);
        margin: 8px 0 14px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .umkm-card .body .btn-wa {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #25D366, #1da851);
        color: #fff;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
    }
    .umkm-card .body .btn-wa:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
    }

    /* ===== GALLERY ===== */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 200px;
        gap: 14px;
    }
    .gallery-item {
        position: relative;
        border-radius: var(--radius-md);
        overflow: hidden;
        cursor: pointer;
        background: var(--border-soft);
    }
    .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    .gallery-item:nth-child(4) { grid-row: span 2; }
    .gallery-item:nth-child(7) { grid-column: span 2; }

    .gallery-item img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s var(--ease-smooth);
    }
    .gallery-item:hover img { transform: scale(1.1); }

    .gallery-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 26, 10, 0.85), transparent 60%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .gallery-item:hover::after { opacity: 1; }

    .gallery-item .overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 20px;
        color: #fff;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s ease;
        z-index: 2;
    }
    .gallery-item:hover .overlay { opacity: 1; transform: translateY(0); }
    .gallery-item .overlay h4 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .gallery-item .overlay p {
        font-size: 12px;
        opacity: 0.85;
    }
    .gallery-item .view-icon {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: var(--gold);
        color: var(--green-deep);
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.4s var(--ease-smooth);
        z-index: 2;
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.4);
    }
    .gallery-item:hover .view-icon { transform: translate(-50%, -50%) scale(1); }

    /* ===== CTA ===== */
    .cta-section {
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        color: #fff;
        text-align: center;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -50%; left: -20%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .cta-section .container { position: relative; z-index: 2; }

    .cta-section h2 {
        font-size: clamp(1.5rem, 3.5vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 14px;
        letter-spacing: -0.02em;
    }
    .cta-section h2 span { color: var(--gold); }
    .cta-section p {
        font-size: 17px;
        opacity: 0.85;
        max-width: 580px;
        margin: 0 auto 36px;
        line-height: 1.7;
    }
    .cta-section .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: var(--green-deep);
        padding: 16px 46px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.4s ease;
        text-decoration: none;
        box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
    }
    .cta-section .btn-cta:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 45px rgba(212, 175, 55, 0.55);
    }
    .cta-section .btn-cta i { transition: transform 0.3s ease; }
    .cta-section .btn-cta:hover i { transform: translateX(5px); }

    /* ===== LIGHTBOX ===== */
    #lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(10, 26, 10, 0.96);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 40px;
        backdrop-filter: blur(10px);
    }
    #lightbox.active { display: flex; animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    #lightbox .close-btn {
        position: absolute;
        top: 24px; right: 32px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 28px;
        cursor: pointer;
        z-index: 10;
        width: 52px; height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    #lightbox .close-btn:hover {
        background: var(--gold);
        color: var(--green-deep);
        transform: rotate(90deg);
    }
    #lightbox img {
        max-width: 90%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    #lightbox .caption {
        color: rgba(255, 255, 255, 0.85);
        text-align: center;
        margin-top: 20px;
        font-size: 15px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
        .umkm-grid { grid-template-columns: repeat(3, 1fr); }
        .gallery-grid { grid-template-columns: repeat(3, 1fr); grid-auto-rows: 180px; }
        .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
        .gallery-item:nth-child(4), .gallery-item:nth-child(7) { grid-column: auto; grid-row: auto; }
        .news-grid.cols-3 { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 992px) {
        .welcome-grid { grid-template-columns: 1fr; gap: 40px; }
        .welcome-image { order: -1; }
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
        .news-grid.cols-3 { grid-template-columns: repeat(2, 1fr); }
        .gallery-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 160px; }
        .gallery-item:nth-child(1), .gallery-item:nth-child(4), .gallery-item:nth-child(7) {
            grid-column: auto; grid-row: auto;
        }
    }

    @media (max-width: 768px) {
        .hero-section { height: 78vh; min-height: 520px; }
        .slider-controls { bottom: 26px; padding: 8px 14px; gap: 10px; }
        .slider-btn { width: 32px; height: 32px; font-size: 12px; }
        .slider-dot { width: 8px; height: 8px; }
        .slider-dot.active { width: 22px; }

        .section { padding: 64px 0; }
        .section-header { margin-bottom: 44px; }

        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .stat-card { padding: 22px 14px; }
        .stat-card .icon-wrap { width: 48px; height: 48px; font-size: 20px; margin-bottom: 10px; }
        .stat-card .number { font-size: 26px; }

        .news-grid.cols-3 { grid-template-columns: 1fr; }

        .umkm-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .umkm-card .body { padding: 16px 18px 20px; }
        .umkm-card .body h4 { font-size: 15px; }

        .gallery-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 140px; gap: 10px; }

        .agenda-item { flex-direction: column; align-items: stretch; gap: 12px; padding: 18px; }
        .agenda-item .date-box {
            min-width: auto;
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
        }
        .agenda-item .date-box .day { font-size: 22px; }
        .agenda-item .status-badge { align-self: flex-start; }

        #lightbox { padding: 20px; }
        #lightbox .close-btn { width: 44px; height: 44px; font-size: 22px; top: 16px; right: 20px; }
    }

    @media (max-width: 480px) {
        .stats-grid { gap: 10px; }
        .stat-card { padding: 18px 10px; }
        .stat-card .number { font-size: 22px; }
        .stat-card .label { font-size: 11px; }

        .umkm-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .umkm-card .body { padding: 12px 14px 16px; }
        .umkm-card .body h4 { font-size: 13px; }
        .umkm-card .body .btn-wa { padding: 6px 12px; font-size: 11px; }

        .gallery-grid { gap: 8px; grid-auto-rows: 120px; }
        .gallery-item .overlay h4 { font-size: 12px; }

        .about-meta { grid-template-columns: 1fr; }
        .vm-card { padding: 22px 22px; }

        .cta-section { padding: 64px 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<!-- ===== HERO SECTION ===== -->
<section class="hero-section">
    <div class="hero-slider" id="heroSlider">
        @if($sliders->isNotEmpty())
            @foreach($sliders as $index => $slider)
                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="slide-bg" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    <div class="hero-overlay">
                        <div class="hero-content">
                            <span class="badge">✦ Pemerintah Desa</span>
                            <h1>{{ $slider->title }}</h1>
                            @if($slider->description)
                                <div class="typing-wrapper">
                                    <span class="typing-text" data-text="{{ $slider->description }}">
                                        <span class="cursor"></span>
                                    </span>
                                </div>
                            @endif
                            @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn-hero">
                                    {{ $slider->button_text }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="hero-slide active">
                <div style="background:linear-gradient(135deg,#0a1a0a,#1a3a1a);width:100%;height:100%;display:flex;align-items:center;justify-content:center;text-align:center;padding:20px;">
                    <div class="hero-content">
                        <span class="badge">✦ Pemerintah Desa</span>
                        <h1>Selamat Datang di <span>Desa Digital</span></h1>
                        <div class="typing-wrapper">
                            <span class="typing-text" data-text="Website resmi desa. Silakan tambahkan slider melalui admin panel.">
                                <span class="cursor"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="slider-progress" id="sliderProgress"></div>

    @if($sliders->count() > 1)
        <div class="slider-controls">
            <button class="slider-btn" id="prevSlide" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div id="sliderDots" style="display:flex;gap:10px;align-items:center;">
                @foreach($sliders as $index => $slider)
                    <button class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <button class="slider-btn" id="nextSlide" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    @endif
</section>

<!-- ===== SAMBUTAN KEPALA DESA ===== -->
@if($profile && $profile->head_message)
<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Sambutan</span>
            <h2>Kepala <span>Desa</span></h2>
            <p>Kata sambutan dari pemimpin desa kami</p>
        </div>
        <div class="welcome-grid">
            <div class="welcome-image reveal">
                <div class="img-wrapper">
                    @if($profile->head_photo)
                        <img src="{{ asset('storage/' . $profile->head_photo) }}"
                             alt="Kepala Desa {{ $profile->village_name }}"
                             loading="lazy">
                    @else
                        <div style="background:linear-gradient(135deg,#eef3ee,#d5e0d5);width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:64px;color:#8a9a8a;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="welcome-text reveal">
                <h3>{{ $profile->village_name }}</h3>
                <div class="message">{{ $profile->head_message }}</div>
                <p style="font-weight:700;font-size:17px;color:var(--text-main);margin-top:14px;">{{ $profile->head_name }}</p>
                <p style="color:var(--text-muted);font-size:14px;">Kepala Desa {{ $profile->village_name }}</p>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ===== TENTANG DESA (RAPI) ===== -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Profil</span>
            <h2>Tentang <span>Desa</span></h2>
            <p>Mengenal lebih dekat desa kami</p>
        </div>

        <div class="about-grid">
            <!-- Kolom Kiri: Info Desa -->
            <div class="about-info reveal">
                <h3 class="about-title">{{ $profile->village_name ?? 'Desa' }}</h3>

                <div class="about-meta">
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-map-pin"></i></div>
                        <div class="meta-text">
                            <span class="meta-label">Kecamatan</span>
                            <span class="meta-value">{{ $profile->district ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-city"></i></div>
                        <div class="meta-text">
                            <span class="meta-label">Kabupaten</span>
                            <span class="meta-value">{{ $profile->regency ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-globe"></i></div>
                        <div class="meta-text">
                            <span class="meta-label">Provinsi</span>
                            <span class="meta-value">{{ $profile->province ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                @if($profile && $profile->history)
                    <div class="about-history">
                        <h4 class="about-subtitle">Sejarah Singkat</h4>
                        <p>{{ Str::limit($profile->history, 400) }}</p>
                    </div>
                @endif

                <a href="{{ route('profile') }}" class="btn-outline">
                    Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Kolom Kanan: Visi & Misi -->
            <div class="about-vm reveal">
                @if($profile && $profile->vision)
                    <div class="vm-card vm-vision">
                        <div class="vm-header">
                            <div class="vm-icon"><i class="fas fa-eye"></i></div>
                            <h4>Visi</h4>
                        </div>
                        <p>{{ $profile->vision }}</p>
                    </div>
                @endif

                @if($profile && $profile->mission)
                    <div class="vm-card vm-mission">
                        <div class="vm-header">
                            <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                            <h4>Misi</h4>
                        </div>
                        <p>{{ $profile->mission }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ===== STATISTIK ===== -->
@if($statistics->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Data</span>
            <h2>Statistik <span>Desa</span></h2>
            <p>Data terkini desa kami</p>
        </div>
        <div class="stats-grid">
            @foreach($statistics as $stat)
                <div class="stat-card reveal">
                    @if($stat->icon)
                        <div class="icon-wrap"><i class="fas fa-{{ $stat->icon }}"></i></div>
                    @endif
                    <span class="number" data-count="{{ $stat->value }}">{{ $stat->value }}</span>
                    <div class="label">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== BERITA TERBARU ===== -->
@if($news->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Informasi</span>
            <h2>Berita <span>Terbaru</span></h2>
            <p>Informasi terkini dari desa kami</p>
        </div>
        <div class="news-grid cols-3">
            @foreach($news as $item)
                <div class="news-card reveal">
                    <div class="img-wrap">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#eef3ee,#d5e0d5);display:flex;align-items:center;justify-content:center;font-size:48px;color:#8a9a8a;">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                        <span class="category-tag">Berita</span>
                    </div>
                    <div class="body">
                        <div class="meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ $item->formatted_date }}</span>
                        </div>
                        <h3>{{ Str::limit($item->title, 55) }}</h3>
                        <p>{{ $item->excerpt }}</p>
                        <a href="{{ route('public.news.show', $item->slug) }}" class="read-more">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== AGENDA ===== -->
@if($agendas->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Kegiatan</span>
            <h2>Agenda <span>Desa</span></h2>
            <p>Kegiatan dan acara yang akan datang</p>
        </div>
        <div class="agenda-wrapper reveal">
            @foreach($agendas as $agenda)
                <div class="agenda-item">
                    <div class="date-box">
                        <div class="day">{{ $agenda->event_date->format('d') }}</div>
                        <div class="month">{{ $agenda->event_date->format('M Y') }}</div>
                    </div>
                    <div class="info">
                        <h4>{{ $agenda->title }}</h4>
                        <div class="details">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $agenda->location }}</span>
                            @if($agenda->start_time)
                                <span><i class="fas fa-clock"></i> {{ $agenda->formatted_time }}</span>
                            @endif
                        </div>
                    </div>
                    <span class="status-badge {{ $agenda->status }}">
                        @if($agenda->status === 'upcoming') Akan Datang
                        @elseif($agenda->status === 'ongoing') Berlangsung
                        @else Selesai @endif
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== POTENSI DESA ===== -->
@if($potentials->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Kekayaan</span>
            <h2>Potensi <span>Desa</span></h2>
            <p>Kekayaan dan potensi yang dimiliki desa</p>
        </div>
        <div class="news-grid cols-3">
            @foreach($potentials as $potential)
                <div class="potential-card reveal">
                    <div class="img-wrap">
                        @if($potential->image)
                            <img src="{{ asset('storage/' . $potential->image) }}" alt="{{ $potential->title }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);display:flex;align-items:center;justify-content:center;font-size:48px;color:#6a9a6a;">
                                <i class="fas fa-seedling"></i>
                            </div>
                        @endif
                        <span class="category-tag">{{ $potential->category }}</span>
                    </div>
                    <div class="body">
                        <h3>{{ Str::limit($potential->title, 50) }}</h3>
                        <p>{{ Str::limit($potential->description, 90) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== UMKM ===== -->
@if($umkm->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Produk</span>
            <h2>UMKM <span>Desa</span></h2>
            <p>Produk unggulan dari warga desa</p>
        </div>
        <div class="umkm-grid">
            @foreach($umkm as $item)
                <div class="umkm-card reveal">
                    <div class="img-wrap">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#eef3ee,#d5e0d5);display:flex;align-items:center;justify-content:center;font-size:40px;color:#8a9a8a;">
                                <i class="fas fa-store"></i>
                            </div>
                        @endif
                        <span class="category-tag">{{ $item->category }}</span>
                    </div>
                    <div class="body">
                        <h4>{{ $item->name }}</h4>
                        <div class="owner">Oleh: {{ $item->owner }}</div>
                        <div class="description">{{ Str::limit($item->description, 60) }}</div>
                        @if($item->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" rel="noopener" class="btn-wa">
                                <i class="fab fa-whatsapp"></i> Hubungi
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== GALERI ===== -->
@if($galleries->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="subtitle">Dokumentasi</span>
            <h2>Galeri <span>Desa</span></h2>
            <p>Dokumentasi kegiatan dan keindahan desa</p>
        </div>
        <div class="gallery-grid">
            @foreach($galleries as $item)
                <div class="gallery-item reveal" onclick="openLightbox('{{ asset('storage/' . $item->image) }}', '{{ $item->title ?? '' }}', '{{ $item->description ?? '' }}')">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? 'Galeri' }}" loading="lazy">
                    <div class="view-icon"><i class="fas fa-search-plus"></i></div>
                    @if($item->title)
                        <div class="overlay">
                            <h4>{{ Str::limit($item->title, 30) }}</h4>
                            @if($item->description)
                                <p>{{ Str::limit($item->description, 50) }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox">
    <button class="close-btn" onclick="closeLightbox()" aria-label="Close">&times;</button>
    <div>
        <img id="lightboxImg" src="" alt="Lightbox">
        <div class="caption" id="lightboxCaption"></div>
    </div>
</div>
@endif

<!-- ===== CTA SECTION ===== -->
<section class="cta-section">
    <div class="container">
        <h2 class="reveal">Mari Kenali Lebih Dekat <span>Desa Kami</span></h2>
        <p class="reveal">Temukan informasi lengkap tentang desa, potensi, dan layanan yang tersedia untuk masyarakat.</p>
        <a href="{{ route('profile') }}" class="btn-cta reveal">
            Jelajahi Desa <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<script>
    // ===== SCROLL REVEAL =====
    (function() {
        const revealEls = document.querySelectorAll('.reveal');
        if (!revealEls.length) return;

        if (!('IntersectionObserver' in window)) {
            revealEls.forEach(el => el.classList.add('visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    const delay = Math.min(i * 60, 300);
                    setTimeout(() => entry.target.classList.add('visible'), delay);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(el => observer.observe(el));
    })();

    // ===== TYPING EFFECT =====
    document.addEventListener('DOMContentLoaded', function() {
        const typingElements = document.querySelectorAll('.typing-text');

        typingElements.forEach(function(element) {
            const text = element.getAttribute('data-text') || '';
            if (!text) return;

            let index = 0;
            let isDeleting = false;

            element.innerHTML = '<span class="cursor"></span>';

            function typeEffect() {
                if (!isDeleting) {
                    if (index < text.length) {
                        element.innerHTML = text.substring(0, index + 1) + '<span class="cursor"></span>';
                        index++;
                        setTimeout(typeEffect, 45 + Math.random() * 40);
                    } else {
                        isDeleting = true;
                        setTimeout(typeEffect, 3200);
                    }
                } else {
                    if (index > 0) {
                        element.innerHTML = text.substring(0, index - 1) + '<span class="cursor"></span>';
                        index--;
                        setTimeout(typeEffect, 25 + Math.random() * 20);
                    } else {
                        isDeleting = false;
                        setTimeout(typeEffect, 500);
                    }
                }
            }
            setTimeout(typeEffect, 600);
        });
    });

    // ===== SLIDER =====
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        const progress = document.getElementById('sliderProgress');
        let currentSlide = 0;
        let autoplayInterval;
        let progressInterval;
        let isPaused = false;
        const SLIDE_DURATION = 6000;

        if (slides.length <= 1) return;

        function goToSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
            resetProgress();
        }
        function nextSlide() { goToSlide(currentSlide + 1); }
        function prevSlide() { goToSlide(currentSlide - 1); }

        function startAutoplay() {
            stopAutoplay();
            if (!isPaused) {
                autoplayInterval = setInterval(nextSlide, SLIDE_DURATION);
                startProgress();
            }
        }
        function stopAutoplay() {
            if (autoplayInterval) { clearInterval(autoplayInterval); autoplayInterval = null; }
            if (progressInterval) { clearInterval(progressInterval); progressInterval = null; }
        }

        function startProgress() {
            if (!progress) return;
            let width = 0;
            const step = 30;
            const increment = (step / SLIDE_DURATION) * 100;
            progress.style.width = '0%';
            progress.style.transition = 'none';
            if (progressInterval) clearInterval(progressInterval);
            progressInterval = setInterval(function() {
                width += increment;
                if (width >= 100) {
                    width = 100;
                    progress.style.width = width + '%';
                    clearInterval(progressInterval);
                    progressInterval = null;
                } else {
                    progress.style.width = width + '%';
                }
            }, step);
        }
        function resetProgress() {
            if (progressInterval) { clearInterval(progressInterval); progressInterval = null; }
            if (progress) {
                progress.style.width = '0%';
                progress.style.transition = 'none';
                setTimeout(function() {
                    if (!isPaused && autoplayInterval) startProgress();
                }, 100);
            }
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.stopPropagation(); prevSlide(); resetAutoplay();
            });
            nextBtn.addEventListener('click', function(e) {
                e.stopPropagation(); nextSlide(); resetAutoplay();
            });
        }
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() { goToSlide(index); resetAutoplay(); });
        });
        function resetAutoplay() {
            stopAutoplay();
            setTimeout(() => { if (!isPaused) startAutoplay(); }, 300);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') { prevSlide(); resetAutoplay(); }
            if (e.key === 'ArrowRight') { nextSlide(); resetAutoplay(); }
        });

        startAutoplay();

        const slider = document.getElementById('heroSlider');
        if (slider) {
            slider.addEventListener('mouseenter', function() { isPaused = true; stopAutoplay(); });
            slider.addEventListener('mouseleave', function() { isPaused = false; startAutoplay(); });
        }

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) stopAutoplay();
            else if (!isPaused) startAutoplay();
        });
    });

    // ===== COUNTER ANIMATION =====
    (function() {
        const counters = document.querySelectorAll('.stat-card .number[data-count]');
        if (!counters.length || !('IntersectionObserver' in window)) return;

        const animate = (el) => {
            const raw = el.getAttribute('data-count');
            const num = parseFloat(String(raw).replace(/[^\d.-]/g, ''));
            if (isNaN(num)) return;
            const suffix = String(raw).replace(/[\d.,-]/g, '');
            const decimals = (String(raw).split('.')[1] || '').replace(/[^\d]/g, '').length;
            const duration = 1400;
            const start = performance.now();

            function tick(now) {
                const t = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - t, 3);
                const value = num * eased;
                el.textContent = value.toLocaleString('id-ID', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }) + suffix;
                if (t < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(el => observer.observe(el));
    })();

    // ===== LIGHTBOX =====
    function openLightbox(src, title, description) {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox) return;
        const img = document.getElementById('lightboxImg');
        const cap = document.getElementById('lightboxCaption');
        img.src = src;
        let captionText = title || '';
        if (description) captionText += captionText ? ' — ' + description : description;
        cap.textContent = captionText;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        if (lightbox) {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
    });
    document.getElementById('lightbox')?.addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href.length < 2) return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endsection