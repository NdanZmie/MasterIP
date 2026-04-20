<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterIP — Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #080b10;
            --surface: #0e1218;
            --surface2: #141a22;
            --border: rgba(99, 179, 237, 0.12);
            --border-hover: rgba(99, 179, 237, 0.35);
            --accent: #63b3ed;
            --accent2: #4299e1;
            --accent-glow: rgba(99, 179, 237, 0.15);
            --text: #e8edf5;
            --text-muted: #8899aa;
            --danger: #fc8181;
            --danger-bg: rgba(252, 129, 129, 0.08);
            --success: #68d391;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ── CANVAS BACKGROUND ── */
        #canvas-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            opacity: 0.6;
        }

        /* ── GRID OVERLAY ── */
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background-image:
                linear-gradient(rgba(99,179,237,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,179,237,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* ── GLOW ORBS ── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 1;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: rgba(66, 153, 225, 0.07);
            top: -100px; left: -150px;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: rgba(99, 179, 237, 0.05);
            bottom: -80px; right: -100px;
        }

        /* ── MAIN WRAPPER ── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 24px;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(32px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 44px 40px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.4s;
            box-shadow:
                0 0 0 1px rgba(99,179,237,0.04),
                0 32px 64px rgba(0,0,0,0.5),
                0 0 100px rgba(99,179,237,0.03) inset;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(99,179,237,0.4) 30%,
                rgba(99,179,237,0.6) 50%,
                rgba(99,179,237,0.4) 70%,
                transparent 100%);
        }

        .card:hover {
            border-color: var(--border-hover);
        }

        /* ── LOGO / BRAND ── */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }

        .brand-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2b6cb0, #63b3ed);
            display: flex; align-items: center; justify-content: center;
            position: relative;
            box-shadow: 0 0 20px rgba(99,179,237,0.3);
        }

        .brand-icon svg {
            width: 22px; height: 22px;
            stroke: white;
        }

        .brand-icon::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 11px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-name {
            font-size: 20px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .brand-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: var(--accent);
            background: rgba(99,179,237,0.1);
            border: 1px solid rgba(99,179,237,0.2);
            border-radius: 4px;
            padding: 2px 6px;
            letter-spacing: 0.5px;
        }

        /* ── HEADING ── */
        .login-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .login-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 32px;
            line-height: 1.5;
        }

        /* ── FORM GROUP ── */
        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-family: 'JetBrains Mono', monospace;
            transition: color 0.2s;
        }

        .form-group:focus-within .form-label {
            color: var(--accent);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            stroke: var(--text-muted);
            transition: stroke 0.2s;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            background: var(--surface2);
            border: 1px solid rgba(99,179,237,0.1);
            border-radius: 10px;
            padding: 13px 14px 13px 42px;
            font-size: 14px;
            font-family: 'Space Grotesk', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            caret-color: var(--accent);
        }

        .form-input::placeholder {
            color: rgba(136,153,170,0.4);
        }

        .form-input:focus {
            border-color: rgba(99,179,237,0.5);
            box-shadow: 0 0 0 3px rgba(99,179,237,0.08);
            background: var(--bg);
        }

        .form-input:focus + .input-line {
            width: 100%;
        }

        .form-group:focus-within .input-icon {
            stroke: var(--accent);
        }

        /* EYE TOGGLE */
        .eye-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--text-muted);
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }
        .eye-toggle:hover { color: var(--accent); }
        .eye-toggle svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── CAPSLOCK WARNING ── */
        .capslock-warn {
            font-size: 11px;
            color: #f6ad55;
            margin-top: 5px;
            display: none;
            align-items: center;
            gap: 4px;
            font-family: 'JetBrains Mono', monospace;
        }
        .capslock-warn.show { display: flex; }

        /* ── ERROR ALERT ── */
        .error-alert {
            background: var(--danger-bg);
            border: 1px solid rgba(252,129,129,0.2);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s cubic-bezier(0.36,0.07,0.19,0.97);
        }
        .error-alert svg { width: 15px; height: 15px; stroke: var(--danger); flex-shrink: 0; }
        .error-alert span { font-size: 13px; color: var(--danger); line-height: 1.4; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* ── SUBMIT BUTTON ── */
        .btn-login {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            background: linear-gradient(135deg, #2b6cb0 0%, #4299e1 100%);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
            color: white;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s, box-shadow 0.3s, opacity 0.2s;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 24px rgba(66,153,225,0.25);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(66,153,225,0.35);
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-login .btn-content {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: opacity 0.2s;
        }

        .btn-login .spinner {
            display: none;
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        .btn-login.loading .btn-text { display: none; }
        .btn-login.loading .spinner { display: block; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── DIVIDER ── */
        .divider-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 16px;
        }
        .divider-line {
            flex: 1;
            height: 1px;
            background: rgba(99,179,237,0.1);
        }
        .divider-text {
            font-size: 11px;
            color: var(--text-muted);
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 1px;
        }

        /* ── REGISTER BUTTON ── */
        .btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background: transparent;
            border: 1px solid rgba(38, 125, 187, 0.2);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Space Grotesk', sans-serif;
            color: var(--accent);
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: border-color 0.25s, background 0.25s, transform 0.15s;
        }
        .btn-register::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(99,179,237,0.06);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .btn-register:hover::before { opacity: 1; }
        .btn-register:hover {
            border-color: rgba(99,179,237,0.5);
            transform: translateY(-1px);
        }
        .btn-register:active { transform: translateY(0); }

        /* ── PAGE TRANSITION OVERLAY ── */
        #page-transition {
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .transition-circle {
            width: 0; height: 0;
            border-radius: 50%;
            background: radial-gradient(circle, #1a2a3a 0%, #080b10 100%);
            transition: width 0.65s cubic-bezier(0.87,0,0.13,1),
                        height 0.65s cubic-bezier(0.87,0,0.13,1);
            position: absolute;
        }
        .transition-circle.expand {
            width: 200vmax;
            height: 200vmax;
        }
        .transition-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: rgba(99,179,237,0.8);
            letter-spacing: 3px;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s 0.25s;
            text-transform: uppercase;
        }
        .transition-label.show { opacity: 1; }

        /* ── RIPPLE ── */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            transform: scale(0);
            animation: ripple 0.5s linear;
            pointer-events: none;
        }
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }

        /* ── FOOTER ── */
        .card-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(99,179,237,0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sys-info {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            color: rgba(136,153,170,0.5);
            letter-spacing: 0.3px;
        }

        .status-dot {
            display: flex; align-items: center; gap: 5px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            color: var(--success);
        }

        .status-dot::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 6px var(--success);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%,100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* ── TYPING INDICATOR ── */
        .nik-display {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            color: rgba(99,179,237,0.5);
            margin-top: 5px;
            height: 14px;
            letter-spacing: 0.5px;
            transition: opacity 0.2s;
        }
    </style>
</head>

{{-- MODAL PASSWORD REGISTER --}}
<div id="regPasswordModal" style="
    display:none; position:fixed; inset:0; z-index:99999;
    background:rgba(0,0,0,0.7); backdrop-filter:blur(6px);
    align-items:center; justify-content:center;">

    <div style="
        background:#0e1218; border:1px solid rgba(99,179,237,0.2);
        border-radius:16px; padding:36px 32px; width:100%; max-width:360px;
        position:relative; box-shadow:0 32px 64px rgba(0,0,0,0.6);
        animation:fadeUp 0.35s cubic-bezier(0.16,1,0.3,1) forwards;">

        {{-- top glow line --}}
        <div style="position:absolute;top:0;left:0;right:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(99,179,237,0.5),transparent);
            border-radius:16px 16px 0 0;"></div>

        <div style="margin-bottom:6px;">
            <span style="font-family:'JetBrains Mono',monospace;font-size:10px;
                color:rgba(99,179,237,0.6);letter-spacing:2px;">AKSES TERBATAS</span>
        </div>
        <div style="font-size:17px;font-weight:700;color:#e8edf5;margin-bottom:6px;">
            Konfirmasi Password
        </div>
        <div style="font-size:12.5px;color:#8899aa;margin-bottom:24px;line-height:1.5;">
            Masukkan password EDP untuk mengakses halaman registrasi.
        </div>

        {{-- Input --}}
        <div style="position:relative;margin-bottom:8px;">
            <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);
                width:15px;height:15px;stroke:#8899aa;pointer-events:none;"
                viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input type="password" id="regPassInput" placeholder="••••••••"
                style="width:100%;background:#141a22;border:1px solid rgba(99,179,237,0.12);
                border-radius:10px;padding:12px 14px 12px 40px;font-size:14px;
                font-family:'Space Grotesk',sans-serif;color:#e8edf5;outline:none;
                caret-color:#63b3ed;transition:border-color 0.2s,box-shadow 0.2s;"
                onkeydown="if(event.key==='Enter') confirmRegPass()"
                onfocus="this.style.borderColor='rgba(99,179,237,0.5)';this.style.boxShadow='0 0 0 3px rgba(99,179,237,0.08)'"
                onblur="this.style.borderColor='rgba(99,179,237,0.12)';this.style.boxShadow='none'">
        </div>

        {{-- Error text --}}
        <div id="regPassError" style="font-size:11.5px;color:#fc8181;
            min-height:18px;margin-bottom:16px;display:none;
            font-family:'JetBrains Mono',monospace;">
            ✕ Password salah. Coba lagi.
        </div>

        {{-- Buttons --}}
        <div style="display:flex;gap:10px;">
            <button onclick="closeRegModal()" style="
                flex:1;padding:11px;background:transparent;
                border:1px solid rgba(99,179,237,0.15);border-radius:10px;
                font-size:13px;font-weight:500;font-family:'Space Grotesk',sans-serif;
                color:#8899aa;cursor:pointer;transition:background 0.2s,color 0.2s;"
                onmouseover="this.style.background='rgba(99,179,237,0.06)';this.style.color='#e8edf5'"
                onmouseout="this.style.background='transparent';this.style.color='#8899aa'">
                Batal
            </button>
            <button onclick="confirmRegPass()" style="
                flex:2;padding:11px;
                background:linear-gradient(135deg,#2b6cb0,#4299e1);
                border:none;border-radius:10px;
                font-size:13px;font-weight:600;font-family:'Space Grotesk',sans-serif;
                color:white;cursor:pointer;
                box-shadow:0 4px 16px rgba(66,153,225,0.25);
                transition:transform 0.15s,box-shadow 0.2s;"
                onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 24px rgba(66,153,225,0.35)'"
                onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(66,153,225,0.25)'">
                Konfirmasi →
            </button>
        </div>
    </div>
</div>

<body>

<canvas id="canvas-bg"></canvas>
<div class="grid-overlay"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

{{-- PAGE TRANSITION OVERLAY --}}
<div id="page-transition">
    <div class="transition-circle" id="tc"></div>
    <span class="transition-label" id="tl">MEMUAT REGISTRASI...</span>
</div>

<div class="login-wrapper">
    <div class="card" id="login-card">

        {{-- BRAND --}}
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <path d="M8 21h8M12 17v4"/>
                    <path d="M6 8h.01M6 11h.01"/>
                    <rect x="10" y="7" width="8" height="6" rx="1"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">MasterIP</div>
                <div class="brand-badge">By ZMIE_V1.0 BETA</div>
            </div>
        </div>

        {{-- HEADING --}}
        {{-- <div class="login-title">Selamat datang</div> --}}
        <div class="login-sub">WEB MONITORING EDP</div>

        {{-- ERROR --}}
        @if(session('error'))
        <div class="error-alert">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="error-alert">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            {{-- NIK --}}
            <div class="form-group">
                <label class="form-label">NIK Karyawan</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    <input
                        type="text"
                        name="NIK"
                        id="nik-input"
                        class="form-input"
                        placeholder="Masukkan NIK Anda"
                        value="{{ old('NIK') }}"
                        autocomplete="off"
                        spellcheck="false"
                        autofocus
                    >
                </div>
                <div class="nik-display" id="nik-display"></div>
            </div>

            {{-- PASSWORD --}}
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        type="password"
                        name="Password"
                        id="pass-input"
                        class="form-input"
                        style="padding-right: 44px;"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                    <button type="button" class="eye-toggle" id="eye-toggle" tabindex="-1">
                        <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <div class="capslock-warn" id="capslock-warn">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#f6ad55" stroke-width="2" stroke-linecap="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                    CAPS LOCK aktif
                </div>
            </div>

            {{-- SUBMIT --}}
            <button type="submit" class="btn-login" id="login-btn">
                <div class="btn-content">
                    <div class="spinner"></div>
                    <span class="btn-text">L O G I N </span>
                    <svg width="15" height="15" class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
            </button>

            {{-- DIVIDER --}}
            <div class="divider-wrap">
                <span class="divider-line"></span>
                <span class="divider-text">atau</span>
                <span class="divider-line"></span>
            </div>

            {{-- REGISTER BUTTON --}}
            <a href="{{ route('register') }}" class="btn-register" id="register-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                Buat Akun Baru
            </a>
        </form>

        {{-- CARD FOOTER --}}
        <div class="card-footer">
            <span class="sys-info">SYS/{{ date('Y') }}/EDP</span>
            <span class="status-dot">ONLINE</span>
        </div>

    </div>
</div>

<script>
/* ── CANVAS PARTICLE NETWORK ── */
const canvas = document.getElementById('canvas-bg');
const ctx = canvas.getContext('2d');

function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
}
resize();
window.addEventListener('resize', resize);

const PARTICLE_COUNT = 55;
const MAX_DIST = 140;
const particles = [];

for (let i = 0; i < PARTICLE_COUNT; i++) {
    particles.push({
        x: Math.random() * window.innerWidth,
        y: Math.random() * window.innerHeight,
        vx: (Math.random() - 0.5) * 0.4,
        vy: (Math.random() - 0.5) * 0.4,
        r: Math.random() * 2 + 1,
        opacity: Math.random() * 0.5 + 0.1,
    });
}

let mouse = { x: -999, y: -999 };
window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

function drawParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < particles.length; i++) {
        const p = particles[i];
        p.x += p.vx; p.y += p.vy;
        if (p.x < 0 || p.x > canvas.width)  p.vx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.vy *= -1;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(99,179,237,${p.opacity})`;
        ctx.fill();

        for (let j = i + 1; j < particles.length; j++) {
            const q = particles[j];
            const dx = p.x - q.x, dy = p.y - q.y;
            const dist = Math.sqrt(dx*dx + dy*dy);
            if (dist < MAX_DIST) {
                const alpha = (1 - dist / MAX_DIST) * 0.18;
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                ctx.lineTo(q.x, q.y);
                ctx.strokeStyle = `rgba(99,179,237,${alpha})`;
                ctx.lineWidth = 0.5;
                ctx.stroke();
            }
        }

        const mdx = p.x - mouse.x, mdy = p.y - mouse.y;
        const mdist = Math.sqrt(mdx*mdx + mdy*mdy);
        if (mdist < 120) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(mouse.x, mouse.y);
            const ma = (1 - mdist / 120) * 0.35;
            ctx.strokeStyle = `rgba(99,179,237,${ma})`;
            ctx.lineWidth = 0.7;
            ctx.stroke();
        }
    }
    requestAnimationFrame(drawParticles);
}
drawParticles();

/* ── NIK DISPLAY ── */
const nikInput = document.getElementById('nik-input');
const nikDisplay = document.getElementById('nik-display');

nikInput.addEventListener('input', () => {
    const val = nikInput.value;
    if (val.length > 0) {
        nikDisplay.textContent = '> ' + val.split('').join(' ') + ' _';
    } else {
        nikDisplay.textContent = '';
    }
});

/* ── SHOW/HIDE PASSWORD ── */
const passInput = document.getElementById('pass-input');
const eyeToggle = document.getElementById('eye-toggle');
const eyeIcon = document.getElementById('eye-icon');

const eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
const eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

let passVisible = false;
eyeToggle.addEventListener('click', () => {
    passVisible = !passVisible;
    passInput.type = passVisible ? 'text' : 'password';
    eyeIcon.innerHTML = passVisible ? eyeClosed : eyeOpen;
});

/* ── CAPS LOCK DETECTION ── */
const capswarn = document.getElementById('capslock-warn');
passInput.addEventListener('keyup', e => {
    if (e.getModifierState) {
        capswarn.classList.toggle('show', e.getModifierState('CapsLock'));
    }
});

/* ── FORM SUBMIT WITH LOADING ── */
const form = document.getElementById('loginForm');
const btn = document.getElementById('login-btn');

form.addEventListener('submit', () => {
    if (nikInput.value.trim() && passInput.value.trim()) {
        btn.classList.add('loading');
        btn.disabled = true;
    }
});

/* ── RIPPLE EFFECT ── */
btn.addEventListener('click', function(e) {
    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    const size = Math.max(rect.width, rect.height);
    ripple.style.cssText = `
        width: ${size}px; height: ${size}px;
        left: ${e.clientX - rect.left - size/2}px;
        top: ${e.clientY - rect.top - size/2}px;
    `;
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
});

/* ── CARD MOUSE TILT ── */
const card = document.getElementById('login-card');
card.addEventListener('mousemove', e => {
    const rect = card.getBoundingClientRect();
    const cx = rect.left + rect.width / 2;
    const cy = rect.top + rect.height / 2;
    const dx = (e.clientX - cx) / (rect.width / 2);
    const dy = (e.clientY - cy) / (rect.height / 2);
    card.style.transform = `perspective(900px) rotateY(${dx * 3}deg) rotateX(${-dy * 3}deg)`;
});
card.addEventListener('mouseleave', () => {
    card.style.transform = 'perspective(900px) rotateY(0deg) rotateX(0deg)';
    card.style.transition = 'transform 0.6s cubic-bezier(0.16,1,0.3,1)';
    setTimeout(() => { card.style.transition = ''; }, 600);
});

/* ── REGISTER TRANSITION ANIMATION ── */
const registerBtn = document.getElementById('register-btn');
const tc = document.getElementById('tc');
const tl = document.getElementById('tl');
const regModal = document.getElementById('regPasswordModal');

registerBtn.addEventListener('click', function(e) {
    e.preventDefault();
    // Tampilkan modal
    regModal.style.display = 'flex';
    setTimeout(() => document.getElementById('regPassInput').focus(), 100);
});

function closeRegModal() {
    regModal.style.display = 'none';
    document.getElementById('regPassInput').value = '';
    document.getElementById('regPassError').style.display = 'none';
}

function confirmRegPass() {
    const input = document.getElementById('regPassInput').value;
    const err   = document.getElementById('regPassError');

    if (input !== '@nt@riks@') {
        err.style.display = 'block';
        document.getElementById('regPassInput').style.borderColor = 'rgba(252,129,129,0.5)';
        document.getElementById('regPassInput').style.boxShadow   = '0 0 0 3px rgba(252,129,129,0.08)';
        document.getElementById('regPassInput').value = '';
        document.getElementById('regPassInput').focus();
        return;
    }

    // Password benar — tutup modal, jalankan animasi transisi
    regModal.style.display = 'none';
    const dest = registerBtn.href;

    tc.style.transition = 'width 0.65s cubic-bezier(0.87,0,0.13,1), height 0.65s cubic-bezier(0.87,0,0.13,1)';
    tc.classList.add('expand');
    tl.classList.add('show');

    setTimeout(() => { window.location.href = dest; }, 750);
}

// Tutup modal kalau klik backdrop
regModal.addEventListener('click', function(e) {
    if (e.target === regModal) closeRegModal();
});
</script>

</body>
</html>