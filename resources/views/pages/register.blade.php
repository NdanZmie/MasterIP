<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterIP — Registrasi</title>
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
            --text: #e8edf5;
            --text-muted: #8899aa;
            --danger: #fc8181;
            --danger-bg: rgba(252, 129, 129, 0.08);
            --success: #68d391;
            --success-bg: rgba(104, 211, 145, 0.08);
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

        #canvas-bg {
            position: fixed; inset: 0; z-index: 0; opacity: 0.6;
        }

        .grid-overlay {
            position: fixed; inset: 0; z-index: 1;
            background-image:
                linear-gradient(rgba(99,179,237,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,179,237,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(80px); pointer-events: none; z-index: 1;
        }
        .orb-1 { width: 500px; height: 500px; background: rgba(66,153,225,0.07); top: -100px; right: -150px; }
        .orb-2 { width: 350px; height: 350px; background: rgba(104,211,145,0.04); bottom: -80px; left: -80px; }

        /* ── TRANSITION IN (dari halaman login) ── */
        #page-in {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none;
        }
        .pi-circle {
            width: 200vmax; height: 200vmax;
            border-radius: 50%;
            background: radial-gradient(circle, #1a2a3a 0%, #080b10 100%);
            position: absolute;
            transition: width 0.7s cubic-bezier(0.16,1,0.3,1),
                        height 0.7s cubic-bezier(0.16,1,0.3,1);
        }
        .pi-circle.collapse {
            width: 0; height: 0;
        }

        /* ── WRAPPER ── */
        .register-wrapper {
            position: relative; z-index: 10;
            width: 100%; max-width: 460px; padding: 24px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s 0.3s, transform 0.5s 0.3s cubic-bezier(0.16,1,0.3,1);
        }
        .register-wrapper.visible {
            opacity: 1; transform: translateY(0);
        }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.4s, transform 0.1s;
            box-shadow:
                0 0 0 1px rgba(99,179,237,0.04),
                0 32px 64px rgba(0,0,0,0.5),
                0 0 100px rgba(99,179,237,0.03) inset;
        }
        .card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg,
                transparent 0%, rgba(99,179,237,0.4) 30%,
                rgba(99,179,237,0.6) 50%, rgba(99,179,237,0.4) 70%, transparent 100%);
        }
        .card:hover { border-color: var(--border-hover); }

        /* ── BRAND ── */
        .brand {
            display: flex; align-items: center; gap: 12px; margin-bottom: 30px;
        }
        .brand-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #2b6cb0, #63b3ed);
            display: flex; align-items: center; justify-content: center;
            position: relative; box-shadow: 0 0 20px rgba(99,179,237,0.3);
        }
        .brand-icon svg { width: 22px; height: 22px; stroke: white; }
        .brand-icon::after {
            content: ''; position: absolute; inset: -1px;
            border-radius: 11px; border: 1px solid rgba(255,255,255,0.2);
        }
        .brand-name { font-size: 20px; font-weight: 600; color: var(--text); letter-spacing: -0.3px; }
        .brand-badge {
            font-family: 'JetBrains Mono', monospace; font-size: 9px;
            color: var(--accent); background: rgba(99,179,237,0.1);
            border: 1px solid rgba(99,179,237,0.2); border-radius: 4px;
            padding: 2px 6px; letter-spacing: 0.5px;
        }

        /* ── STEP INDICATOR ── */
        .step-bar {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 28px;
        }
        .step {
            display: flex; align-items: center; gap: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px; letter-spacing: 0.5px;
        }
        .step-dot {
            width: 22px; height: 22px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 600;
            transition: all 0.3s;
        }
        .step-dot.active {
            background: linear-gradient(135deg, #2b6cb0, #63b3ed);
            color: white; box-shadow: 0 0 12px rgba(99,179,237,0.4);
        }
        .step-dot.done {
            background: rgba(104,211,145,0.2);
            color: var(--success);
            border: 1px solid rgba(104,211,145,0.3);
        }
        .step-dot.pending {
            background: var(--surface2);
            color: var(--text-muted);
            border: 1px solid rgba(99,179,237,0.1);
        }
        .step-label { color: var(--text-muted); font-size: 10px; }
        .step-label.active-label { color: var(--accent); }
        .step-connector {
            flex: 1; height: 1px;
            background: rgba(99,179,237,0.1);
            margin: 0 8px;
            position: relative; overflow: hidden;
        }
        .step-connector-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, #2b6cb0, #63b3ed);
            transition: width 0.5s cubic-bezier(0.16,1,0.3,1);
        }

        /* ── HEADING ── */
        .reg-title { font-size: 24px; font-weight: 700; color: var(--text); letter-spacing: -0.5px; margin-bottom: 4px; }
        .reg-sub { font-size: 13px; color: var(--text-muted); margin-bottom: 28px; line-height: 1.5; }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; position: relative; }
        .form-label {
            display: flex; align-items: center; justify-content: space-between;
            font-size: 11px; font-weight: 500; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 7px;
            font-family: 'JetBrains Mono', monospace; transition: color 0.2s;
        }
        .form-group:focus-within .form-label { color: var(--accent); }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; stroke: var(--text-muted);
            transition: stroke 0.2s; pointer-events: none;
        }
        .form-group:focus-within .input-icon { stroke: var(--accent); }

        .form-input {
            width: 100%;
            background: var(--surface2);
            border: 1px solid rgba(99,179,237,0.1);
            border-radius: 10px;
            padding: 13px 14px 13px 42px;
            font-size: 14px;
            font-family: 'Space Grotesk', sans-serif;
            color: var(--text); outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            caret-color: var(--accent);
        }
        .form-input::placeholder { color: rgba(136,153,170,0.4); }
        .form-input:focus {
            border-color: rgba(99,179,237,0.5);
            box-shadow: 0 0 0 3px rgba(99,179,237,0.08);
            background: var(--bg);
        }
        .form-input.valid {
            border-color: rgba(104,211,145,0.4);
            box-shadow: 0 0 0 3px rgba(104,211,145,0.06);
        }
        .form-input.invalid {
            border-color: rgba(252,129,129,0.4);
            box-shadow: 0 0 0 3px rgba(252,129,129,0.06);
        }

        /* VALID / INVALID INDICATOR */
        .field-status {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s;
        }
        .field-status.show { opacity: 1; }

        /* PASSWORD STRENGTH */
        .strength-bar-wrap {
            margin-top: 8px; display: flex; gap: 4px;
        }
        .strength-seg {
            flex: 1; height: 3px; border-radius: 99px;
            background: rgba(99,179,237,0.1);
            transition: background 0.3s;
        }
        .strength-label {
            font-size: 10px; font-family: 'JetBrains Mono', monospace;
            margin-top: 5px; letter-spacing: 0.5px;
            transition: color 0.3s;
            color: var(--text-muted);
        }

        /* EYE TOGGLE */
        .eye-toggle {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: 4px;
            color: var(--text-muted); transition: color 0.2s;
            display: flex; align-items: center;
        }
        .eye-toggle:hover { color: var(--accent); }
        .eye-toggle svg { width: 16px; height: 16px; stroke: currentColor; }

        /* CAPS LOCK */
        .capslock-warn {
            font-size: 11px; color: #f6ad55; margin-top: 5px;
            display: none; align-items: center; gap: 4px;
            font-family: 'JetBrains Mono', monospace;
        }
        .capslock-warn.show { display: flex; }

        /* ── HINT TEXT ── */
        .field-hint {
            font-size: 10.5px; color: var(--text-muted);
            margin-top: 5px; font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.3px;
        }

        /* ── ALERTS ── */
        .error-alert {
            background: var(--danger-bg); border: 1px solid rgba(252,129,129,0.2);
            border-radius: 10px; padding: 12px 16px; margin-bottom: 18px;
            display: flex; align-items: flex-start; gap: 10px;
            animation: shake 0.4s cubic-bezier(0.36,0.07,0.19,0.97);
        }
        .error-alert svg { width: 15px; height: 15px; stroke: var(--danger); flex-shrink: 0; margin-top: 1px; }
        .error-alert span { font-size: 13px; color: var(--danger); line-height: 1.4; }

        @keyframes shake {
            0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)}
            40%{transform:translateX(6px)} 60%{transform:translateX(-4px)}
            80%{transform:translateX(4px)}
        }

        /* ── SUBMIT ── */
        .btn-register-submit {
            width: 100%; padding: 14px; margin-top: 8px;
            background: linear-gradient(135deg, #276749 0%, #38a169 100%);
            border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
            color: white; cursor: pointer; position: relative;
            overflow: hidden;
            transition: transform 0.15s, box-shadow 0.3s, opacity 0.2s;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 24px rgba(56,161,105,0.25);
        }
        .btn-register-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
            pointer-events: none;
        }
        .btn-register-submit:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(56,161,105,0.35);
        }
        .btn-register-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-register-submit:disabled { opacity: 0.7; cursor: not-allowed; }
        .btn-content { display: flex; align-items: center; justify-content: center; gap: 8px; }
        .spinner {
            display: none; width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        .btn-register-submit.loading .btn-text { display: none; }
        .btn-register-submit.loading .spinner { display: block; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── RIPPLE ── */
        .ripple {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: scale(0);
            animation: ripple 0.5s linear;
            pointer-events: none;
        }
        @keyframes ripple { to { transform: scale(4); opacity: 0; } }

        /* ── DIVIDER ── */
        .divider-wrap { display: flex; align-items: center; gap: 12px; margin: 18px 0 14px; }
        .divider-line { flex: 1; height: 1px; background: rgba(99,179,237,0.1); }
        .divider-text { font-size: 11px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; letter-spacing: 1px; }

        /* ── BACK TO LOGIN ── */
        .btn-back {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 13px;
            background: transparent;
            border: 1px solid rgba(99,179,237,0.15);
            border-radius: 10px; font-size: 14px; font-weight: 500;
            font-family: 'Space Grotesk', sans-serif;
            color: var(--text-muted); text-decoration: none;
            transition: border-color 0.25s, color 0.25s, transform 0.15s;
        }
        .btn-back:hover { border-color: rgba(99,179,237,0.35); color: var(--accent); transform: translateY(-1px); }

        /* ── FOOTER ── */
        .card-footer {
            margin-top: 22px; padding-top: 18px;
            border-top: 1px solid rgba(99,179,237,0.07);
            display: flex; align-items: center; justify-content: space-between;
        }
        .sys-info { font-family: 'JetBrains Mono', monospace; font-size: 10px; color: rgba(136,153,170,0.5); }
        .status-dot {
            display: flex; align-items: center; gap: 5px;
            font-family: 'JetBrains Mono', monospace; font-size: 10px; color: var(--success);
        }
        .status-dot::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--success); box-shadow: 0 0 6px var(--success);
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

        /* ── PAGE-OUT TRANSITION ── */
        #page-out {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none;
        }
        .po-circle {
            width: 0; height: 0; border-radius: 50%;
            background: radial-gradient(circle, #1a2a3a 0%, #080b10 100%);
            position: absolute;
            transition: width 0.65s cubic-bezier(0.87,0,0.13,1),
                        height 0.65s cubic-bezier(0.87,0,0.13,1);
        }
        .po-circle.expand { width: 200vmax; height: 200vmax; }
        .po-label {
            font-family: 'JetBrains Mono', monospace; font-size: 12px;
            color: rgba(99,179,237,0.8); letter-spacing: 3px; z-index: 1;
            opacity: 0; transition: opacity 0.3s 0.25s; text-transform: uppercase;
        }
        .po-label.show { opacity: 1; }
    </style>
</head>
<body>

<canvas id="canvas-bg"></canvas>
<div class="grid-overlay"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

{{-- TRANSITION IN --}}
<div id="page-in">
    <div class="pi-circle" id="pic"></div>
</div>

{{-- TRANSITION OUT --}}
<div id="page-out">
    <div class="po-circle" id="poc"></div>
    <span class="po-label" id="pol">KEMBALI KE LOGIN...</span>
</div>

<div class="register-wrapper" id="register-wrapper">
    <div class="card" id="reg-card">

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
                <div class="brand-badge">REGISTRASI</div>
            </div>
        </div>

        {{-- STEP INDICATOR --}}
        <div class="step-bar">
            <div class="step">
                <div class="step-dot active" id="step1-dot">1</div>
                <span class="step-label active-label" id="step1-label">Identitas</span>
            </div>
            <div class="step-connector">
                <div class="step-connector-fill" id="conn1"></div>
            </div>
            <div class="step">
                <div class="step-dot pending" id="step2-dot">2</div>
                <span class="step-label" id="step2-label">Keamanan</span>
            </div>
            <div class="step-connector">
                <div class="step-connector-fill" id="conn2"></div>
            </div>
            <div class="step">
                <div class="step-dot pending" id="step3-dot">3</div>
                <span class="step-label" id="step3-label">Konfirmasi</span>
            </div>
        </div>

        {{-- HEADING --}}
        <div class="reg-title" id="step-title">Informasi Identitas</div>
        <div class="reg-sub" id="step-sub">Masukkan NIK dan nama lengkap Anda</div>

        {{-- ERROR --}}
        @if(session('error'))
        <div class="error-alert">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="error-alert">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('register.post') }}" id="regForm">
            @csrf

            {{-- STEP 1: NIK + NAMA --}}
            <div id="step-1">
                {{-- NIK --}}
                <div class="form-group">
                    <label class="form-label">
                        NIK Karyawan
                        <span style="color:rgba(252,129,129,0.6);font-size:9px">* Wajib</span>
                    </label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                        </svg>
                        <input type="text" name="NIK" id="nik-input" class="form-input"
                            placeholder="Masukkan NIK Anda"
                            value="{{ old('NIK') }}"
                            autocomplete="off" spellcheck="false" autofocus>
                        <svg class="field-status" id="nik-ok" viewBox="0 0 24 24" fill="none" stroke="#68d391" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div class="field-hint">Gunakan NIK sesuai data karyawan</div>
                </div>

                {{-- NAMA --}}
                <div class="form-group">
                    <label class="form-label">
                        Nama Lengkap
                        <span style="color:rgba(252,129,129,0.6);font-size:9px">* Wajib</span>
                    </label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input type="text" name="Nama" id="nama-input" class="form-input"
                            placeholder="Nama"
                            value="{{ old('Nama') }}"
                            autocomplete="off">
                        <svg class="field-status" id="nama-ok" viewBox="0 0 24 24" fill="none" stroke="#68d391" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                </div>

                <button type="button" class="btn-register-submit" id="next-btn" onclick="goStep2()">
                    <div class="btn-content">
                        <span class="btn-text">Lanjutkan</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>
            </div>

            {{-- STEP 2: PASSWORD --}}
            <div id="step-2" style="display:none">
                <div class="form-group">
                    <label class="form-label">
                        Password
                        <span style="color:rgba(252,129,129,0.6);font-size:9px">* Wajib</span>
                    </label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" name="Password" id="pass-input" class="form-input"
                            style="padding-right: 44px;"
                            placeholder="Buat password">
                        <button type="button" class="eye-toggle" id="eye1" tabindex="-1">
                            <svg id="eye1-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="strength-bar-wrap">
                        <div class="strength-seg" id="seg1"></div>
                        <div class="strength-seg" id="seg2"></div>
                        <div class="strength-seg" id="seg3"></div>
                        <div class="strength-seg" id="seg4"></div>
                    </div>
                    <div class="strength-label" id="strength-label">Masukkan password</div>
                    <div class="capslock-warn" id="capslock-warn">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#f6ad55" stroke-width="2" stroke-linecap="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                        </svg>
                        CAPS LOCK aktif
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <input type="password" id="pass-confirm" class="form-input"
                            style="padding-right: 44px;"
                            placeholder="Ulangi password">
                        <button type="button" class="eye-toggle" id="eye2" tabindex="-1">
                            <svg id="eye2-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="field-hint" id="match-hint" style="color:var(--text-muted)">Ketik ulang password di atas</div>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px">
                    <button type="button" class="btn-back" style="flex:0 0 auto;width:auto;padding:13px 18px;" onclick="goStep1()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" class="btn-register-submit" style="flex:1" onclick="goStep3()">
                        <div class="btn-content">
                            <span class="btn-text">Lanjutkan</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>

            {{-- STEP 3: KONFIRMASI --}}
            <div id="step-3" style="display:none">
                <div style="background:var(--surface2);border:1px solid rgba(99,179,237,0.1);border-radius:12px;padding:20px;margin-bottom:18px">
                    <div style="font-size:11px;font-family:'JetBrains Mono',monospace;color:var(--text-muted);letter-spacing:1px;margin-bottom:14px;text-transform:uppercase">
                        Ringkasan Data
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <div style="display:flex;align-items:center;gap:12px">
                            <span style="font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;min-width:50px">NIK</span>
                            <span style="font-size:14px;color:var(--text);font-weight:500" id="confirm-nik">—</span>
                        </div>
                        <div style="height:1px;background:rgba(99,179,237,0.07)"></div>
                        <div style="display:flex;align-items:center;gap:12px">
                            <span style="font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;min-width:50px">Nama</span>
                            <span style="font-size:14px;color:var(--text);font-weight:500" id="confirm-nama">—</span>
                        </div>
                        <div style="height:1px;background:rgba(99,179,237,0.07)"></div>
                        <div style="display:flex;align-items:center;gap:12px">
                            <span style="font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;min-width:50px">Password</span>
                            <span style="font-size:14px;color:var(--text)">••••••••</span>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px">
                    <button type="button" class="btn-back" style="flex:0 0 auto;width:auto;padding:13px 18px;" onclick="goStep2()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="submit" class="btn-register-submit" style="flex:1" id="submit-btn">
                        <div class="btn-content">
                            <div class="spinner"></div>
                            <span class="btn-text">Daftarkan Akun</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <line x1="19" y1="8" x2="19" y2="14"/>
                                <line x1="22" y1="11" x2="16" y2="11"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>

        </form>

        {{-- DIVIDER --}}
        <div class="divider-wrap">
            <span class="divider-line"></span>
            <span class="divider-text">sudah punya akun?</span>
            <span class="divider-line"></span>
        </div>

        {{-- BACK TO LOGIN --}}
        <a href="{{ route('login') }}" class="btn-back" id="back-login-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke Login
        </a>

        {{-- FOOTER --}}
        <div class="card-footer">
            <span class="sys-info">SYS/{{ date('Y') }}/EDP</span>
            <span class="status-dot">ONLINE</span>
        </div>

    </div>
</div>

<script>
/* ── CANVAS PARTICLES ── */
const canvas = document.getElementById('canvas-bg');
const ctx = canvas.getContext('2d');
function resize(){ canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
resize(); window.addEventListener('resize', resize);
const particles = [];
for(let i=0;i<55;i++) particles.push({
    x:Math.random()*window.innerWidth, y:Math.random()*window.innerHeight,
    vx:(Math.random()-.5)*.4, vy:(Math.random()-.5)*.4,
    r:Math.random()*2+1, opacity:Math.random()*.5+.1
});
let mouse={x:-999,y:-999};
window.addEventListener('mousemove',e=>{mouse.x=e.clientX;mouse.y=e.clientY;});
function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    for(let i=0;i<particles.length;i++){
        const p=particles[i];
        p.x+=p.vx; p.y+=p.vy;
        if(p.x<0||p.x>canvas.width) p.vx*=-1;
        if(p.y<0||p.y>canvas.height) p.vy*=-1;
        ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle=`rgba(99,179,237,${p.opacity})`; ctx.fill();
        for(let j=i+1;j<particles.length;j++){
            const q=particles[j];
            const d=Math.sqrt((p.x-q.x)**2+(p.y-q.y)**2);
            if(d<140){ ctx.beginPath(); ctx.moveTo(p.x,p.y); ctx.lineTo(q.x,q.y);
                ctx.strokeStyle=`rgba(99,179,237,${(1-d/140)*.18})`; ctx.lineWidth=.5; ctx.stroke(); }
        }
        const md=Math.sqrt((p.x-mouse.x)**2+(p.y-mouse.y)**2);
        if(md<120){ ctx.beginPath(); ctx.moveTo(p.x,p.y); ctx.lineTo(mouse.x,mouse.y);
            ctx.strokeStyle=`rgba(99,179,237,${(1-md/120)*.35})`; ctx.lineWidth=.7; ctx.stroke(); }
    }
    requestAnimationFrame(draw);
}
draw();

/* ── PAGE TRANSITION IN (collapse circle) ── */
window.addEventListener('DOMContentLoaded', () => {
    const pic = document.getElementById('pic');
    const wrapper = document.getElementById('register-wrapper');
    setTimeout(() => {
        pic.classList.add('collapse');
        setTimeout(() => {
            wrapper.classList.add('visible');
            document.getElementById('page-in').style.pointerEvents = 'none';
        }, 400);
    }, 50);
});

/* ── CARD TILT ── */
const card = document.getElementById('reg-card');
card.addEventListener('mousemove', e => {
    const r = card.getBoundingClientRect();
    const dx = (e.clientX - r.left - r.width/2) / (r.width/2);
    const dy = (e.clientY - r.top - r.height/2) / (r.height/2);
    card.style.transform = `perspective(900px) rotateY(${dx*2.5}deg) rotateX(${-dy*2.5}deg)`;
});
card.addEventListener('mouseleave', () => {
    card.style.transform = 'perspective(900px) rotateY(0deg) rotateX(0deg)';
    card.style.transition = 'transform 0.6s cubic-bezier(0.16,1,0.3,1)';
    setTimeout(() => { card.style.transition = ''; }, 600);
});

/* ── STEP MANAGEMENT ── */
const titles = ['Informasi Identitas','Buat Password','Konfirmasi Data'];
const subs = ['Masukkan NIK dan nama lengkap Anda','Buat password yang kuat untuk akun Anda','Periksa data sebelum mendaftar'];

function setStep(n) {
    [1,2,3].forEach(i => {
        document.getElementById(`step-${i}`).style.display = i === n ? 'block' : 'none';
    });
    document.getElementById('step-title').textContent = titles[n-1];
    document.getElementById('step-sub').textContent = subs[n-1];

    // update step dots
    [1,2,3].forEach(i => {
        const dot = document.getElementById(`step${i}-dot`);
        const lbl = document.getElementById(`step${i}-label`);
        if(i < n) { dot.className = 'step-dot done'; dot.innerHTML = '✓'; }
        else if(i === n) { dot.className = 'step-dot active'; dot.textContent = i; }
        else { dot.className = 'step-dot pending'; dot.textContent = i; }
        lbl.className = 'step-label' + (i === n ? ' active-label' : '');
    });

    // connectors
    document.getElementById('conn1').style.width = n >= 2 ? '100%' : '0%';
    document.getElementById('conn2').style.width = n >= 3 ? '100%' : '0%';
}

function goStep2() {
    const nik = document.getElementById('nik-input').value.trim();
    const nama = document.getElementById('nama-input').value.trim();
    if (!nik || !nama) {
        const inputs = [nik ? null : 'nik-input', nama ? null : 'nama-input'].filter(Boolean);
        inputs.forEach(id => {
            const el = document.getElementById(id);
            el.classList.add('invalid');
            el.addEventListener('input', () => el.classList.remove('invalid'), {once:true});
        });
        return;
    }
    setStep(2);
    setTimeout(() => document.getElementById('pass-input').focus(), 100);
}

function goStep1() { setStep(1); }

function goStep3() {
    const pass = document.getElementById('pass-input').value;
    const conf = document.getElementById('pass-confirm').value;
    if (!pass || pass.length < 4) {
        document.getElementById('strength-label').style.color = 'var(--danger)';
        document.getElementById('strength-label').textContent = 'Password terlalu pendek';
        return;
    }
    if (pass !== conf) {
        document.getElementById('match-hint').style.color = 'var(--danger)';
        document.getElementById('match-hint').textContent = 'Password tidak cocok';
        document.getElementById('pass-confirm').classList.add('invalid');
        return;
    }
    // populate confirm step
    document.getElementById('confirm-nik').textContent  = document.getElementById('nik-input').value;
    document.getElementById('confirm-nama').textContent = document.getElementById('nama-input').value;
    setStep(3);
}

function goStep2fromStep3() { setStep(2); }

/* ── NIK VALIDATION INDICATOR ── */
document.getElementById('nik-input').addEventListener('input', function() {
    const ok = document.getElementById('nik-ok');
    if (this.value.trim().length >= 3) {
        this.classList.add('valid'); this.classList.remove('invalid');
        ok.classList.add('show');
    } else {
        this.classList.remove('valid'); ok.classList.remove('show');
    }
});
document.getElementById('nama-input').addEventListener('input', function() {
    const ok = document.getElementById('nama-ok');
    if (this.value.trim().length >= 2) {
        this.classList.add('valid'); this.classList.remove('invalid');
        ok.classList.add('show');
    } else {
        this.classList.remove('valid'); ok.classList.remove('show');
    }
});

/* ── PASSWORD STRENGTH ── */
document.getElementById('pass-input').addEventListener('input', function() {
    const v = this.value;
    let score = 0;
    if (v.length >= 6) score++;
    if (v.length >= 10) score++;
    if (/[A-Z]/.test(v) && /[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;

    const colors = ['','#fc8181','#f6ad55','#63b3ed','#68d391'];
    const labels = ['','Lemah','Cukup','Kuat','Sangat kuat'];
    const lbl = document.getElementById('strength-label');
    lbl.textContent = v.length > 0 ? labels[score] : 'Masukkan password';
    lbl.style.color = v.length > 0 ? colors[score] : 'var(--text-muted)';

    [1,2,3,4].forEach(i => {
        document.getElementById(`seg${i}`).style.background =
            i <= score ? colors[score] : 'rgba(99,179,237,0.1)';
    });
});

/* ── PASSWORD MATCH ── */
document.getElementById('pass-confirm').addEventListener('input', function() {
    const pass = document.getElementById('pass-input').value;
    const hint = document.getElementById('match-hint');
    if (this.value.length === 0) {
        hint.textContent = 'Ketik ulang password di atas';
        hint.style.color = 'var(--text-muted)';
        this.classList.remove('valid','invalid');
    } else if (this.value === pass) {
        hint.textContent = '✓ Password cocok';
        hint.style.color = 'var(--success)';
        this.classList.add('valid'); this.classList.remove('invalid');
    } else {
        hint.textContent = 'Password belum cocok';
        hint.style.color = 'var(--danger)';
        this.classList.add('invalid'); this.classList.remove('valid');
    }
});

/* ── CAPS LOCK ── */
document.getElementById('pass-input').addEventListener('keyup', e => {
    if (e.getModifierState)
        document.getElementById('capslock-warn').classList.toggle('show', e.getModifierState('CapsLock'));
});

/* ── EYE TOGGLES ── */
function makeEyeToggle(btnId, inputId, iconId) {
    let vis = false;
    const eyeOpen  = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    const eyeClose = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    document.getElementById(btnId).addEventListener('click', () => {
        vis = !vis;
        document.getElementById(inputId).type = vis ? 'text' : 'password';
        document.getElementById(iconId).innerHTML = vis ? eyeClose : eyeOpen;
    });
}
makeEyeToggle('eye1','pass-input','eye1-icon');
makeEyeToggle('eye2','pass-confirm','eye2-icon');

/* ── SUBMIT LOADING ── */
document.getElementById('regForm').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    btn.classList.add('loading'); btn.disabled = true;
});

/* ── RIPPLE ON SUBMIT BTN ── */
document.getElementById('submit-btn').addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const rip = document.createElement('span');
    rip.className = 'ripple';
    const size = Math.max(rect.width, rect.height);
    rip.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
    this.appendChild(rip);
    setTimeout(() => rip.remove(), 600);
});

/* ── BACK TO LOGIN TRANSITION ── */
document.getElementById('back-login-btn').addEventListener('click', function(e) {
    e.preventDefault();
    const dest = this.href;
    const poc = document.getElementById('poc');
    const pol = document.getElementById('pol');
    setTimeout(() => { poc.classList.add('expand'); pol.classList.add('show'); }, 50);
    setTimeout(() => { window.location.href = dest; }, 720);
});
</script>

</body>
</html>