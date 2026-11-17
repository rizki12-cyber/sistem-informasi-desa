<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Sistem Informasi Desa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-dark: #0a1a0a;
            --accent: #d4af37;
            --accent-light: #f0d060;
            --accent-hover: #c5a031;
            --bg-body: #f4f7f4;
            --sidebar-bg: linear-gradient(180deg, #0a1a0a 0%, #142a14 100%);
            --border-light: #f0f5f0;
            --text-primary: #0a1a0a;
            --text-secondary: #4a5a4a;
            --text-muted: #8a9a8a;
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --sidebar-width: 280px;
            --toggle-size: 42px;
            --toggle-offset: 16px;
            --topbar-height: 72px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ===== PAGE ENTRANCE ANIMATION ===== */
        @keyframes slideDownIn {
            0% { opacity: 0; transform: translateY(-40px); }
            60% { opacity: 1; }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ============================================= */
        /*  SIDEBAR — TANPA ANIMASI (fix bug toggle)   */
        /* ============================================= */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #c8dcc8;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
            transform: translateX(0);
        }

        .sidebar.closed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.4);
            border-radius: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        .sidebar-brand {
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            flex-shrink: 0;
        }

        .sidebar-brand::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 25%; right: 25%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.5;
        }

        .sidebar-brand .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent-light), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--primary-dark);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.25);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .sidebar-brand:hover .brand-icon {
            transform: rotate(-6deg) scale(1.05);
        }

        .sidebar-brand .brand-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .sidebar-brand .brand-text span { color: var(--accent); }

        .sidebar-brand .brand-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.35);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-nav { padding: 12px 0 20px; flex: 1; }

        .sidebar-nav .nav-label {
            padding: 18px 24px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.25);
            font-weight: 700;
        }

        .sidebar-nav .nav-label:first-child { padding-top: 10px; }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 24px;
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: all 0.25s ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            margin: 1px 0;
        }

        .sidebar-nav a::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 0;
            background: linear-gradient(180deg, var(--accent-light), var(--accent));
            border-radius: 0 3px 3px 0;
            transition: height 0.3s ease;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            padding-left: 28px;
        }

        .sidebar-nav a:hover::before { height: 60%; }

        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.12), rgba(212, 175, 55, 0.02));
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar-nav a.active::before { height: 100%; }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            opacity: 0.6;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .sidebar-nav a:hover i { opacity: 0.9; color: var(--accent); }
        .sidebar-nav a.active i {
            opacity: 1;
            color: var(--accent);
            transform: scale(1.05);
        }

        .sidebar-nav a .nav-badge {
            margin-left: auto;
            background: rgba(212, 175, 55, 0.15);
            color: var(--accent);
            font-size: 9px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-footer {
            padding: 18px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            flex-shrink: 0;
        }

        .sidebar-footer .version {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
            text-align: center;
            font-weight: 500;
        }

        .sidebar-footer .version span {
            color: var(--accent);
            opacity: 0.7;
            margin: 0 4px;
        }

        /* ============================================= */
        /*  MAIN CONTENT                               */
        /* ============================================= */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            width: 100%;
        }

        .main-content.full { margin-left: 0; }

        /* ============================================= */
        /*  TOPBAR — SLIDE DOWN ANIMATION              */
        /* ============================================= */
        .topbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 0 32px 0 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 999;
            min-height: var(--topbar-height);
            transform: translateY(0);
            opacity: 1;
            transition:
                transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                opacity 0.3s ease,
                padding-left 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            animation: slideDownIn 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }

        body.sidebar-collapsed .topbar {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
            animation: none;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 18px;
            flex: 1;
            min-width: 0;
        }

        .page-title-wrap { min-width: 0; flex: 1; }

        .topbar-left .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .topbar-left .breadcrumb .separator { color: #d0d8d0; font-weight: 400; }
        .topbar-left .breadcrumb .current { color: var(--accent); }

        .topbar-left h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .topbar-right .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 14px 5px 5px;
            border-radius: 50px;
            transition: var(--transition);
            cursor: default;
            border: 1px solid transparent;
        }

        .topbar-right .user-info:hover {
            background: #fafcfa;
            border-color: var(--border-light);
        }

        .topbar-right .user-info .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-light), var(--accent));
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
            position: relative;
        }

        .topbar-right .user-info .avatar::after {
            content: '';
            position: absolute;
            bottom: 0; right: 0;
            width: 10px; height: 10px;
            background: #4caf50;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .topbar-right .user-info .user-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 13px;
            line-height: 1.2;
        }

        .topbar-right .user-info .user-role {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            line-height: 1.2;
            margin-top: 1px;
        }

        .btn-logout {
            padding: 9px 18px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
        }

        .btn-logout:hover {
            background: #fee2e2;
            border-color: #fecaca;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.15);
            color: #7f1d1d;
        }

        /* ============================================= */
        /*  FLOATING TOGGLE BUTTON                     */
        /* ============================================= */
        .menu-toggle {
            position: fixed;
            top: 15px;
            left: calc(var(--sidebar-width) + var(--toggle-offset));
            width: var(--toggle-size);
            height: var(--toggle-size);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 12px;
            font-size: 17px;
            color: var(--text-secondary);
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition:
                left 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                background 0.3s ease,
                color 0.3s ease,
                border-color 0.3s ease,
                transform 0.25s ease,
                box-shadow 0.3s ease;
        }

        .menu-toggle:hover {
            background: rgba(212, 175, 55, 0.08);
            border-color: rgba(212, 175, 55, 0.35);
            color: var(--accent);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.2);
        }

        .menu-toggle:active { transform: scale(0.92); }

        body.sidebar-collapsed .menu-toggle {
            left: var(--toggle-offset);
        }

        .menu-toggle i {
            transform: rotate(0deg);
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        body.sidebar-collapsed .menu-toggle i {
            transform: rotate(180deg);
        }

        /* ============================================= */
        /*  CONTENT AREA — SLIDE DOWN ANIMATION        */
        /* ============================================= */
        .content-area {
            padding: 28px 32px 40px;
            flex: 1;
            transition: padding-top 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            animation: slideDownIn 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.15s both;
        }

        body.sidebar-collapsed .content-area {
            padding-top: 84px;
        }

        /* ===== OVERLAY (MOBILE) ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(10, 26, 10, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 999;
            animation: fadeIn 0.3s ease;
        }

        .sidebar-overlay.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ============================================= */
        /*  SWEETALERT2                                */
        /* ============================================= */
        .swal2-backdrop-show {
            background: rgba(10, 26, 10, 0.65) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
        }

        .swal2-popup {
            border-radius: 24px !important;
            padding: 36px 32px 28px !important;
            font-family: 'Inter', sans-serif !important;
            box-shadow: 0 32px 64px -16px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(212, 175, 55, 0.08) !important;
            border: none !important;
            position: relative !important;
            overflow: hidden !important;
            max-width: 480px !important;
        }

        .swal2-popup::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-light), var(--accent), var(--accent-hover));
            border-radius: 24px 24px 0 0;
        }

        .swal2-popup::after {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .swal2-title {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 22px !important;
            font-weight: 800 !important;
            color: var(--text-primary) !important;
            padding: 0 0 6px !important;
            letter-spacing: -0.4px !important;
        }

        .swal2-html-container {
            font-size: 14px !important;
            color: var(--text-secondary) !important;
            line-height: 1.7 !important;
            margin: 8px 0 0 !important;
        }

        .swal2-icon {
            margin: 0 auto 20px !important;
            border-width: 3px !important;
            width: 76px !important;
            height: 76px !important;
            animation: swalIconPop 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) !important;
        }

        @keyframes swalIconPop {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .swal2-icon.swal2-warning { border-color: #f0d060 !important; color: #d4af37 !important; background: rgba(240, 208, 96, 0.05) !important; }
        .swal2-icon.swal2-success { border-color: #4caf50 !important; color: #4caf50 !important; background: rgba(76, 175, 80, 0.05) !important; }
        .swal2-icon.swal2-error { border-color: #ef4444 !important; color: #ef4444 !important; background: rgba(239, 68, 68, 0.05) !important; }
        .swal2-icon.swal2-info { border-color: #3b82f6 !important; color: #3b82f6 !important; background: rgba(59, 130, 246, 0.05) !important; }
        .swal2-icon.swal2-question { border-color: #d4af37 !important; color: #d4af37 !important; background: rgba(212, 175, 55, 0.05) !important; }

        .swal2-actions {
            margin: 28px 0 0 !important;
            gap: 10px !important;
            width: 100% !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
        }

        .swal2-confirm,
        .swal2-cancel,
        .swal2-deny {
            padding: 12px 26px !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            font-family: inherit !important;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            border: none !important;
            min-width: 120px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            cursor: pointer !important;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, var(--accent-light), var(--accent)) !important;
            color: var(--primary-dark) !important;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.3) !important;
        }

        .swal2-confirm:hover {
            background: linear-gradient(135deg, var(--accent), var(--accent-hover)) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.4) !important;
        }

        .swal2-cancel {
            background: #f0f5f0 !important;
            color: #2d3a2d !important;
            border: 1px solid #e0e8e0 !important;
        }

        .swal2-cancel:hover {
            background: #e0e8e0 !important;
            transform: translateY(-2px) !important;
        }

        .swal2-popup .swal2-confirm.swal2-styled.btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.35) !important;
        }

        .swal2-popup .swal2-confirm.swal2-styled.btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.45) !important;
        }

        .swal2-close {
            color: var(--text-muted) !important;
            font-size: 22px !important;
            top: 16px !important;
            right: 16px !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 8px !important;
            transition: var(--transition) !important;
        }

        .swal2-close:hover {
            color: var(--accent) !important;
            background: rgba(212, 175, 55, 0.08) !important;
            transform: rotate(90deg) !important;
        }

        .swal2-toast {
            border-radius: 16px !important;
            padding: 14px 18px !important;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(212, 175, 55, 0.1) !important;
            background: #ffffff !important;
        }

        .swal2-toast::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--accent-light), var(--accent));
        }

        .swal2-toast .swal2-title {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: var(--text-primary) !important;
            padding: 0 !important;
            text-align: left !important;
        }

        .swal2-toast .swal2-html-container {
            font-size: 13px !important;
            color: var(--text-secondary) !important;
            margin: 2px 0 0 !important;
            text-align: left !important;
        }

        .swal2-toast .swal2-icon {
            width: 30px !important;
            height: 30px !important;
            margin: 0 14px 0 0 !important;
            border-width: 2px !important;
        }

        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, var(--accent), var(--accent-light)) !important;
            height: 3px !important;
        }

        /* ============================================= */
        /*  RESPONSIVE                                 */
        /* ============================================= */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(calc(-1 * var(--sidebar-width)));
                box-shadow: 0 0 60px rgba(0, 0, 0, 0.3);
            }

            .sidebar.open { transform: translateX(0); }

            .main-content { margin-left: 0; }

            body.sidebar-collapsed .topbar {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
                animation: none;
            }

            body.sidebar-collapsed .content-area { padding-top: 28px; }

            .topbar {
                padding: 0 20px 0 74px;
                min-height: 68px;
                animation: none;
            }

            .content-area {
                animation: slideDownIn 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
            }

            .menu-toggle { left: var(--toggle-offset) !important; }

            body.sidebar-mobile-open .menu-toggle {
                left: calc(var(--sidebar-width) + var(--toggle-offset)) !important;
            }

            body.sidebar-collapsed .menu-toggle i { transform: rotate(0deg); }

            body.sidebar-mobile-open .menu-toggle i { transform: rotate(180deg); }

            .topbar-left h2 { font-size: 16px; }
        }

        @media (max-width: 768px) {
            .topbar-left .breadcrumb { display: none; }

            .content-area { padding: 20px 16px 30px; }

            body.sidebar-collapsed .content-area { padding-top: 20px; }

            .topbar-right .user-info .user-name,
            .topbar-right .user-info .user-role { display: none; }

            .topbar-right .user-info { padding: 5px; border: none; }

            .btn-logout span { display: none; }

            .btn-logout { padding: 9px 12px; }

            .swal2-popup {
                padding: 28px 22px 22px !important;
                border-radius: 20px !important;
                max-width: 92vw !important;
            }

            .swal2-title { font-size: 18px !important; }
            .swal2-html-container { font-size: 13px !important; }
            .swal2-icon { width: 64px !important; height: 64px !important; }
            .swal2-confirm, .swal2-cancel, .swal2-deny {
                padding: 11px 20px !important;
                font-size: 13px !important;
                min-width: 100px !important;
            }
        }

        @media (max-width: 480px) {
            .topbar { padding: 0 14px 0 68px; min-height: 62px; }
            .topbar-left h2 { font-size: 15px; }
            .menu-toggle { width: 38px; height: 38px; font-size: 15px; top: 12px; }

            body.sidebar-mobile-open .menu-toggle {
                left: calc(var(--sidebar-width) + var(--toggle-offset)) !important;
            }

            .content-area { padding: 16px 12px 24px; }
            body.sidebar-collapsed .content-area { padding-top: 16px; }

            .swal2-popup { padding: 24px 18px 20px !important; border-radius: 18px !important; }
            .swal2-title { font-size: 17px !important; }
            .swal2-actions { margin: 22px 0 0 !important; gap: 8px !important; }
            .swal2-confirm, .swal2-cancel, .swal2-deny {
                padding: 10px 16px !important;
                font-size: 12px !important;
                min-width: 90px !important;
                flex: 1 !important;
            }
            .swal2-toast { padding: 12px 14px !important; border-radius: 12px !important; }
            .swal2-toast .swal2-title { font-size: 13px !important; }
            .swal2-toast .swal2-html-container { font-size: 12px !important; }
        }

        @media (prefers-reduced-motion: reduce) {
            .topbar, .content-area, .menu-toggle {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="sidebar-expanded">
    <!-- ===== FLOATING MENU TOGGLE ===== -->
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu" title="Tutup Menu">
        <i class="fas fa-bars" id="menuIcon"></i>
    </button>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-landmark"></i>
            </div>
            <div>
                <div class="brand-text">Desa<span>.</span></div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Navigasi Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
                <span class="nav-badge">Home</span>
            </a>

            <div class="nav-label">Manajemen Konten</div>
            <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i> Slider
            </a>
            <a href="{{ route('admin.profile.index') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Profil Desa
            </a>
            <a href="{{ route('admin.officials.index') }}" class="{{ request()->routeIs('admin.officials.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Perangkat Desa
            </a>
            <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Pengumuman
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="{{ request()->routeIs('admin.agendas.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Agenda
            </a>

            <div class="nav-label">Data &amp; Statistik</div>
            <a href="{{ route('admin.statistics.index') }}" class="{{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Statistik
            </a>
            <a href="{{ route('admin.potentials.index') }}" class="{{ request()->routeIs('admin.potentials.*') ? 'active' : '' }}">
                <i class="fas fa-seedling"></i> Potensi Desa
            </a>
            <a href="{{ route('admin.umkm.index') }}" class="{{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i> UMKM
            </a>

           <div class="nav-label">Media &amp; Pengaturan</div>
           <a href="{{ route('admin.letters.index') }}" class="{{ request()->routeIs('admin.letters.*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i> Surat Menyurat
                @php $newLetters = \App\Models\Letter::where('status', 'pending')->count(); @endphp
                @if($newLetters > 0)
                    <span class="nav-badge" style="background: rgba(59,130,246,0.2); color: #60a5fa;">
                        {{ $newLetters }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="{{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> Pengaduan
                @php
                    $newComplaints = \App\Models\Complaint::where('status', 'new')->count();
                @endphp
                @if($newComplaints > 0)
                    <span class="nav-badge" style="background: rgba(59,130,246,0.2); color: #60a5fa;">
                        {{ $newComplaints }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Galeri
            </a>
            <a href="{{ route('admin.contact.edit') }}" class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="fas fa-address-card"></i> Kontak
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="version">v1.0.0 <span>•</span> Sistem Informasi Desa</div>
        </div>
    </aside>

    <!-- ===== OVERLAY (MOBILE) ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content" id="mainContent">
        <!-- ===== TOPBAR ===== -->
        <header class="topbar">
            <div class="topbar-left">
                <div class="page-title-wrap">
                    <div class="breadcrumb">
                        <span>Admin</span>
                        <span class="separator">/</span>
                        <span class="current">@yield('page-title', 'Dashboard')</span>
                    </div>
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>
            </div>
            <div class="topbar-right">
                <div class="user-info">
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- ===== CONTENT ===== -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <script>
        // =============================================
        // SIDEBAR TOGGLE
        // =============================================
        (function() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuToggle = document.getElementById('menuToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const STORAGE_KEY = 'sidebar-state';

            function isMobile() {
                return window.innerWidth <= 992;
            }

            function applyState(isOpen) {
                if (menuToggle) {
                    menuToggle.setAttribute('title', isOpen ? 'Tutup Menu' : 'Buka Menu');
                }

                if (isOpen) {
                    body.classList.remove('sidebar-collapsed');
                    body.classList.add('sidebar-expanded');
                } else {
                    body.classList.add('sidebar-collapsed');
                    body.classList.remove('sidebar-expanded');
                }

                if (isMobile()) {
                    if (isOpen) {
                        sidebar.classList.add('open');
                        sidebar.classList.remove('closed');
                        overlay.classList.add('active');
                        body.classList.add('sidebar-mobile-open');
                        document.body.style.overflow = 'hidden';
                    } else {
                        sidebar.classList.remove('open');
                        sidebar.classList.add('closed');
                        overlay.classList.remove('active');
                        body.classList.remove('sidebar-mobile-open');
                        document.body.style.overflow = '';
                    }
                } else {
                    body.classList.remove('sidebar-mobile-open');
                    if (isOpen) {
                        sidebar.classList.remove('closed');
                        mainContent.classList.remove('full');
                    } else {
                        sidebar.classList.add('closed');
                        mainContent.classList.add('full');
                    }
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function isSidebarOpen() {
                if (isMobile()) {
                    return sidebar.classList.contains('open');
                }
                return !sidebar.classList.contains('closed');
            }

            function toggleSidebar() {
                const willOpen = !isSidebarOpen();
                applyState(willOpen);

                if (!isMobile()) {
                    localStorage.setItem(STORAGE_KEY, willOpen ? 'open' : 'closed');
                }
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    applyState(false);
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMobile() && sidebar.classList.contains('open')) {
                    applyState(false);
                }
            });

            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (isMobile()) {
                        sidebar.classList.remove('closed');
                        sidebar.classList.remove('open');
                        mainContent.classList.remove('full');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                        body.classList.add('sidebar-collapsed');
                        body.classList.remove('sidebar-expanded');
                        body.classList.remove('sidebar-mobile-open');
                    } else {
                        body.classList.remove('sidebar-mobile-open');
                        const saved = localStorage.getItem(STORAGE_KEY) || 'open';
                        applyState(saved === 'open');
                    }
                }, 150);
            });

            function init() {
                if (isMobile()) {
                    sidebar.classList.remove('open');
                    sidebar.classList.remove('closed');
                    mainContent.classList.remove('full');
                    overlay.classList.remove('active');
                    body.classList.add('sidebar-collapsed');
                    body.classList.remove('sidebar-expanded');
                    body.classList.remove('sidebar-mobile-open');
                } else {
                    const saved = localStorage.getItem(STORAGE_KEY) || 'open';
                    applyState(saved === 'open');
                }
            }

            init();
        })();

        // =============================================
        // SWEETALERT2 HELPER FUNCTIONS
        // =============================================

        function confirmDelete(formId, customName = null) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `
                    <div style="text-align:center;color:#6a7a6a;font-size:14px;line-height:1.7;">
                        Apakah Anda yakin ingin menghapus data ini?
                        ${customName ? `<br><strong style="color:#0a1a0a;font-size:15px;display:block;margin-top:10px;padding:10px 16px;background:#fafcfa;border-radius:10px;border:1px dashed #eef3ee;">"${customName}"</strong>` : ''}
                    </div>
                `,
                icon: 'warning',
                iconColor: '#f0d060',
              
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: { confirmButton: 'btn-danger' },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function showSuccess(message, title = 'Berhasil!') {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'success',
                title: title, html: message,
                showConfirmButton: false, timer: 3200, timerProgressBar: true,
                iconColor: '#4caf50',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        function showError(message, title = 'Gagal!') {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'error',
                title: title, html: message,
                showConfirmButton: false, timer: 4200, timerProgressBar: true,
                iconColor: '#ef4444',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        function showInfo(message, title = 'Info') {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: title, html: message,
                showConfirmButton: false, timer: 3200, timerProgressBar: true,
                iconColor: '#3b82f6'
            });
        }

        function showWarning(message, title = 'Perhatian') {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'warning',
                title: title, html: message,
                showConfirmButton: false, timer: 3600, timerProgressBar: true,
                iconColor: '#f0d060'
            });
        }

        function showSuccessModal(title, message) {
            Swal.fire({
                title: title, html: message, icon: 'success',
                iconColor: '#4caf50',
                confirmButtonText: '<i class="fas fa-check"></i> Oke',
                buttonsStyling: false
            });
        }

        function showLoading(message = 'Memproses...') {
            Swal.fire({
                title: message,
                html: '<span style="color:#8a9a8a;font-size:13px;">Mohon tunggu sebentar</span>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
        }

        function confirmAction(options) {
            const defaults = {
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin?',
                icon: 'question',
                iconColor: '#d4af37',
                confirmText: 'Ya, Lanjutkan',
                cancelText: 'Batal',
                onConfirm: null
            };
            const settings = { ...defaults, ...options };

            Swal.fire({
                title: settings.title,
                html: settings.text,
                icon: settings.icon,
                iconColor: settings.iconColor,
                showCancelButton: true,
                confirmButtonText: `<i class="fas fa-check"></i> ${settings.confirmText}`,
                cancelButtonText: `<i class="fas fa-times"></i> ${settings.cancelText}`,
                reverseButtons: true,
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed && typeof settings.onConfirm === 'function') {
                    settings.onConfirm();
                }
            });
        }

        // =============================================
        // FLASH MESSAGES
        // =============================================
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() { showSuccess(@json(session('success'))); });
        @endif
        @if(session('error'))   
            document.addEventListener('DOMContentLoaded', function() { showError(@json(session('error'))); });
        @endif
        @if(session('warning'))
            document.addEventListener('DOMContentLoaded', function() { showWarning(@json(session('warning'))); });
        @endif
        @if(session('info'))
            document.addEventListener('DOMContentLoaded', function() { showInfo(@json(session('info'))); });
        @endif
    </script>

    @yield('scripts')
</body>
</html>