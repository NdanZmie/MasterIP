{{-- Login.blade --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MasterIP — Login Portal EDP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
{{-- Three.js for 3D Cyber Graphics --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
/* ═══════════════════════════════════════════════
   RESET & SYSTEM VARIABLES
═══════════════════════════════════════════════ */
*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  /* Dark Cyber Theme (Default) */
  --bg: #030712;
  --bg-gradient: radial-gradient(circle at 50% 50%, #0c1228 0%, #030712 100%);
  --card-bg: rgba(10, 16, 35, 0.72);
  --card-border: rgba(99, 102, 241, 0.22);
  --card-border-glow: rgba(99, 102, 241, 0.5);
  --card-shadow: 0 30px 90px rgba(0, 0, 0, 0.8), 0 0 50px rgba(99, 102, 241, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.08);
  
  --accent: #6366f1;
  --accent-light: #818cf8;
  --accent-glow: rgba(99, 102, 241, 0.4);
  --cyan: #06b6d4;
  --cyan-glow: rgba(6, 182, 212, 0.4);
  --purple: #a855f7;
  --green: #10b981;
  --red: #f43f5e;
  
  --text: #f8fafc;
  --text-muted: #94a3b8;
  --text-dim: #64748b;
  
  --input-bg: rgba(15, 23, 42, 0.75);
  --input-border: rgba(99, 102, 241, 0.2);
  --input-border-focus: #06b6d4;
  --input-shadow-focus: 0 0 0 3px rgba(6, 182, 212, 0.2), 0 0 20px rgba(6, 182, 212, 0.15);
  
  --btn-grad: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #06b6d4 100%);
  --btn-shadow: 0 10px 30px rgba(79, 70, 229, 0.4), 0 0 20px rgba(6, 182, 212, 0.25);
  --btn-shadow-hover: 0 15px 45px rgba(79, 70, 229, 0.6), 0 0 30px rgba(6, 182, 212, 0.45);
  

  --modal-bg: #090e1f;
  --modal-border: rgba(99, 102, 241, 0.3);
  --modal-overlay: rgba(3, 7, 18, 0.85);
  
  --transition: 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}

body.theme-light {
  /* Light Cyber-Holo Theme */
  --bg: #edf2f9;
  --bg-gradient: radial-gradient(circle at 50% 50%, #e0e7ff 0%, #edf2f9 100%);
  --card-bg: rgba(255, 255, 255, 0.75);
  --card-border: rgba(99, 102, 241, 0.18);
  --card-border-glow: rgba(99, 102, 241, 0.45);
  --card-shadow: 0 25px 70px rgba(79, 70, 229, 0.12), 0 5px 20px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.9);
  
  --accent: #4f46e5;
  --accent-light: #6366f1;
  --accent-glow: rgba(79, 70, 229, 0.25);
  --cyan: #0284c7;
  --cyan-glow: rgba(2, 132, 199, 0.25);
  --purple: #9333ea;
  --green: #059669;
  --red: #e11d48;
  
  --text: #0f172a;
  --text-muted: #475569;
  --text-dim: #94a3b8;
  
  --input-bg: rgba(248, 250, 252, 0.9);
  --input-border: rgba(203, 213, 225, 0.9);
  --input-border-focus: #4f46e5;
  --input-shadow-focus: 0 0 0 3px rgba(79, 70, 229, 0.15), 0 0 20px rgba(79, 70, 229, 0.1);
  
  --btn-grad: linear-gradient(135deg, #4338ca 0%, #4f46e5 50%, #0284c7 100%);
  --btn-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
  --btn-shadow-hover: 0 15px 40px rgba(79, 70, 229, 0.45);
  

  --modal-bg: #ffffff;
  --modal-border: rgba(99, 102, 241, 0.2);
  --modal-overlay: rgba(15, 23, 42, 0.45);
}

body {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  background: var(--bg);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
  color: var(--text);
  transition: background var(--transition), color var(--transition);
}

/* ═══════════════════════════════════════════════
   3D WEBGL FULLSCREEN CANVAS
═══════════════════════════════════════════════ */
#threejsCanvas {
  position: fixed;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;
}

/* ═══════════════════════════════════════════════
   CINEMATIC VIDEO-STYLE OVERLAYS
═══════════════════════════════════════════════ */
/* Anamorphic Flare & Ambient Aura */
.cinematic-glow {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background: radial-gradient(circle at 50% 35%, rgba(99, 102, 241, 0.12) 0%, transparent 65%),
              radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.08) 0%, transparent 50%),
              radial-gradient(circle at 20% 70%, rgba(168, 85, 247, 0.08) 0%, transparent 50%);
  animation: glowBreathe 10s ease-in-out infinite alternate;
}
@keyframes glowBreathe {
  0% { opacity: 0.7; transform: scale(1); }
  100% { opacity: 1; transform: scale(1.05); }
}

/* Cyber Vignette & Scanlines */
.cinematic-vignette {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  box-shadow: inset 0 0 160px rgba(0, 0, 0, 0.85);
}
body.theme-light .cinematic-vignette {
  box-shadow: inset 0 0 160px rgba(15, 23, 42, 0.15);
}

.scanline {
  position: fixed;
  left: 0;
  right: 0;
  height: 2px;
  z-index: 2;
  pointer-events: none;
  background: linear-gradient(90deg, transparent, rgba(6, 182, 212, 0.5), rgba(99, 102, 241, 0.6), transparent);
  animation: scanRun 7s linear infinite;
}
@keyframes scanRun {
  0% { top: -5%; opacity: 0; }
  10% { opacity: 0.8; }
  90% { opacity: 0.6; }
  100% { top: 105%; opacity: 0; }
}



/* ═══════════════════════════════════════════════
   MAIN 3D CARD WRAPPER
═══════════════════════════════════════════════ */
.wrapper {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 440px;
  padding: 20px;
  perspective: 1200px;
}

.card-3d-wrap {
  width: 100%;
  transform-style: preserve-3d;
  transition: transform 0.15s ease-out;
}

.login-card {
  position: relative;
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border-radius: 26px;
  padding: 38px 34px 30px;
  box-shadow: var(--card-shadow);
  transition: border-color var(--transition), box-shadow var(--transition);
  overflow: hidden;
}

.login-card:hover {
  border-color: var(--card-border-glow);
}

/* Holographic Rotating Border Beam */
.card-holo-glow {
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: conic-gradient(from 0deg, transparent 0deg, rgba(6, 182, 212, 0.2) 60deg, transparent 120deg, rgba(99, 102, 241, 0.25) 240deg, transparent 360deg);
  animation: holoRotate 12s linear infinite;
  pointer-events: none;
  opacity: 0.7;
}
@keyframes holoRotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Inner Cyber Corner Brackets */
.corner {
  position: absolute;
  width: 12px;
  height: 12px;
  pointer-events: none;
  border-color: var(--cyan);
  opacity: 0.6;
}
.corner-tl { top: 12px; left: 12px; border-top: 2px solid; border-left: 2px solid; }
.corner-tr { top: 12px; right: 12px; border-top: 2px solid; border-right: 2px solid; }
.corner-bl { bottom: 12px; left: 12px; border-bottom: 2px solid; border-left: 2px solid; }
.corner-br { bottom: 12px; right: 12px; border-bottom: 2px solid; border-right: 2px solid; }

/* ═══════════════════════════════════════════════
   HEADER & BRANDING
═══════════════════════════════════════════════ */
.brand-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}

.brand-left {
  display: flex;
  align-items: center;
  gap: 14px;
}

.brand-icon-box {
  position: relative;
  width: 48px;
  height: 48px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(79, 70, 229, 0.8), rgba(6, 182, 212, 0.8));
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
  overflow: hidden;
}

.brand-icon-box svg {
  width: 24px;
  height: 24px;
  stroke: #ffffff;
  z-index: 2;
}

.brand-icon-ring {
  position: absolute;
  inset: -2px;
  border-radius: 16px;
  border: 1.5px solid rgba(255, 255, 255, 0.4);
  animation: pulseRing 3s ease-out infinite;
}
@keyframes pulseRing {
  0% { transform: scale(0.9); opacity: 1; }
  100% { transform: scale(1.4); opacity: 0; }
}

.brand-title-wrap {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-size: 22px;
  font-weight: 900;
  letter-spacing: -0.5px;
  background: linear-gradient(135deg, #ffffff 30%, var(--cyan) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1.15;
}
body.theme-light .brand-name {
  background: linear-gradient(135deg, #0f172a 30%, #4f46e5 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.brand-sub {
  font-family: 'JetBrains Mono', monospace;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 1.2px;
  color: var(--text-dim);
}

/* Theme Switcher Button */
.theme-toggle-btn {
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid var(--card-border);
  border-radius: 12px;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--text-muted);
  transition: all 0.25s ease;
}
body.theme-light .theme-toggle-btn {
  background: rgba(255, 255, 255, 0.85);
}
.theme-toggle-btn:hover {
  color: var(--cyan);
  border-color: var(--cyan);
  transform: scale(1.08);
}
.theme-toggle-btn svg {
  width: 18px;
  height: 18px;
}
.icon-sun { display: none; }
.icon-moon { display: block; }
body.theme-light .icon-sun { display: block; }
body.theme-light .icon-moon { display: none; }



/* ═══════════════════════════════════════════════
   ALERTS
═══════════════════════════════════════════════ */
.alert-box {
  background: rgba(244, 63, 94, 0.1);
  border: 1px solid rgba(244, 63, 94, 0.3);
  color: #fda4af;
  border-radius: 12px;
  padding: 11px 14px;
  font-size: 12.5px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 18px;
  animation: alertIn 0.3s ease-out;
}
body.theme-light .alert-box {
  background: rgba(225, 29, 72, 0.08);
  border-color: rgba(225, 29, 72, 0.25);
  color: #be123c;
}
.alert-box svg {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
}
@keyframes alertIn {
  from { opacity: 0; transform: translateY(-8px); }
  to { opacity: 1; transform: translateY(0); }
}

.alert-success {
  background: rgba(16, 185, 129, 0.1);
  border-color: rgba(16, 185, 129, 0.3);
  color: #6ee7b7;
}
body.theme-light .alert-success {
  background: rgba(5, 150, 105, 0.08);
  border-color: rgba(5, 150, 105, 0.25);
  color: #047857;
}

/* ═══════════════════════════════════════════════
   FORM ELEMENTS
═══════════════════════════════════════════════ */
.form-group {
  margin-bottom: 18px;
  position: relative;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  color: var(--text-muted);
  margin-bottom: 7px;
  letter-spacing: 0.3px;
}
.form-label svg {
  width: 14px;
  height: 14px;
  stroke: var(--cyan);
}

.input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-left {
  position: absolute;
  left: 14px;
  width: 16px;
  height: 16px;
  stroke: var(--text-dim);
  pointer-events: none;
  transition: stroke 0.2s;
}

.form-input {
  width: 100%;
  background: var(--input-bg);
  border: 1.5px solid var(--input-border);
  border-radius: 14px;
  padding: 13px 14px 13px 42px;
  font-size: 13.5px;
  font-family: 'Inter', sans-serif;
  color: var(--text);
  outline: none;
  transition: all 0.25s ease;
}

.form-input:focus {
  border-color: var(--input-border-focus);
  box-shadow: var(--input-shadow-focus);
  background: rgba(15, 23, 42, 0.95);
}
body.theme-light .form-input:focus {
  background: #ffffff;
}

.form-input:focus ~ .input-icon-left {
  stroke: var(--cyan);
}

.form-input::placeholder {
  color: rgba(148, 163, 184, 0.45);
}

/* Password Eye Toggle */
.eye-btn {
  position: absolute;
  right: 12px;
  background: transparent;
  border: none;
  padding: 6px;
  color: var(--text-dim);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  transition: color 0.2s, background 0.2s;
}
.eye-btn:hover {
  color: var(--cyan);
  background: rgba(6, 182, 212, 0.1);
}
.eye-btn svg {
  width: 17px;
  height: 17px;
}

/* Real-Time NIK Terminal Display Preview */
.nik-preview {
  font-family: 'JetBrains Mono', monospace;
  font-size: 11px;
  color: var(--cyan);
  margin-top: 5px;
  min-height: 16px;
  letter-spacing: 1px;
  opacity: 0.9;
}

/* CapsLock Warning */
.capslock-box {
  display: none;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-family: 'JetBrains Mono', monospace;
  color: #fbbf24;
  margin-top: 5px;
}
.capslock-box.show {
  display: flex;
}

/* ═══════════════════════════════════════════════
   BUTTONS & ACTIONS
═══════════════════════════════════════════════ */
.btn-submit-login {
  position: relative;
  width: 100%;
  padding: 14px;
  background: var(--btn-grad);
  border: none;
  border-radius: 14px;
  font-size: 14px;
  font-weight: 800;
  letter-spacing: 1px;
  color: #ffffff;
  cursor: pointer;
  box-shadow: var(--btn-shadow);
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  transition: transform 0.2s, box-shadow 0.2s;
  margin-top: 8px;
}

.btn-submit-login:hover {
  transform: translateY(-2px);
  box-shadow: var(--btn-shadow-hover);
}

.btn-submit-login:active {
  transform: translateY(0);
}

.btn-submit-login:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-ripple {
  position: absolute;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.35);
  transform: scale(0);
  animation: rippleFx 0.6s linear;
  pointer-events: none;
}
@keyframes rippleFx {
  to { transform: scale(4); opacity: 0; }
}

/* Loading Spinner */
.login-spinner {
  display: none;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
.btn-submit-login.loading .login-spinner {
  display: inline-block;
}
.btn-submit-login.loading .btn-text-content {
  display: none;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Divider */
.divider {
  display: flex;
  align-items: center;
  margin: 20px 0;
  gap: 12px;
}
.divider-line {
  flex: 1;
  height: 1px;
  background: rgba(99, 102, 241, 0.15);
}
.divider-text {
  font-size: 11px;
  font-family: 'JetBrains Mono', monospace;
  color: var(--text-dim);
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Register Button */
.btn-to-register {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 12px;
  background: rgba(99, 102, 241, 0.08);
  border: 1.5px solid rgba(99, 102, 241, 0.25);
  border-radius: 14px;
  font-size: 13px;
  font-weight: 700;
  color: var(--accent-light);
  text-decoration: none;
  cursor: pointer;
  transition: all 0.2s ease;
}
body.theme-light .btn-to-register {
  background: rgba(79, 70, 229, 0.06);
  color: #4f46e5;
}
.btn-to-register:hover {
  background: rgba(99, 102, 241, 0.16);
  border-color: var(--accent);
  transform: translateY(-1.5px);
}



/* ═══════════════════════════════════════════════
   REGISTER CONFIRMATION MODAL (@nt@riks@)
═══════════════════════════════════════════════ */
#regPasswordModal {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 99999;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  background: var(--modal-overlay);
  padding: 20px;
}
#regPasswordModal.open {
  display: flex;
}

.modal-content-box {
  background: var(--modal-bg);
  border: 1px solid var(--modal-border);
  border-radius: 24px;
  padding: 34px 30px;
  width: 100%;
  max-width: 400px;
  position: relative;
  box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8), 0 0 50px rgba(99, 102, 241, 0.2);
  animation: modalScaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
}
@keyframes modalScaleIn {
  from { opacity: 0; transform: perspective(800px) rotateX(15deg) scale(0.9) translateY(20px); }
  to { opacity: 1; transform: none; }
}

.modal-top-beam {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--cyan), var(--accent), var(--purple));
  border-radius: 24px 24px 0 0;
}

.modal-tag {
  font-family: 'JetBrains Mono', monospace;
  font-size: 9px;
  letter-spacing: 2px;
  color: #f59e0b;
  margin-bottom: 6px;
  font-weight: 700;
}

.modal-title {
  font-size: 19px;
  font-weight: 800;
  color: var(--text);
  margin-bottom: 6px;
}

.modal-desc {
  font-size: 12.5px;
  color: var(--text-muted);
  line-height: 1.6;
  margin-bottom: 20px;
}

.modal-input-field {
  width: 100%;
  background: var(--input-bg);
  border: 1.5px solid var(--input-border);
  border-radius: 12px;
  padding: 12px 14px 12px 40px;
  font-size: 14px;
  color: var(--text);
  outline: none;
  font-family: 'Inter', sans-serif;
  margin-bottom: 8px;
  transition: all 0.25s;
}
.modal-input-field:focus {
  border-color: var(--cyan);
  box-shadow: var(--input-shadow-focus);
}

.modal-error-msg {
  font-family: 'JetBrains Mono', monospace;
  font-size: 11px;
  color: var(--red);
  display: none;
  margin-bottom: 14px;
}
.modal-error-msg.show {
  display: block;
}

.modal-btn-row {
  display: flex;
  gap: 10px;
  margin-top: 8px;
}

.btn-modal-cancel {
  flex: 1;
  padding: 12px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 600;
  background: transparent;
  border: 1.5px solid var(--input-border);
  color: var(--text-muted);
  cursor: pointer;
  transition: all 0.2s;
}
.btn-modal-cancel:hover {
  background: rgba(99, 102, 241, 0.1);
  color: var(--text);
}

.btn-modal-confirm {
  flex: 2;
  padding: 12px;
  background: var(--btn-grad);
  border: none;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 700;
  color: #ffffff;
  cursor: pointer;
  box-shadow: var(--btn-shadow);
  transition: all 0.2s;
}
.btn-modal-confirm:hover {
  transform: translateY(-1.5px);
  box-shadow: var(--btn-shadow-hover);
}

/* Page Transition Veil */
#pageTransitionVeil {
  position: fixed;
  inset: 0;
  background: #030712;
  z-index: 100000;
  pointer-events: none;
  opacity: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 12px;
  transition: opacity 0.4s ease;
}
#pageTransitionVeil.active {
  opacity: 1;
  pointer-events: auto;
}
.veil-text {
  font-family: 'JetBrains Mono', monospace;
  font-size: 12px;
  letter-spacing: 3px;
  color: var(--cyan);
  font-weight: 700;
}
</style>
</head>

<body>

{{-- 3D WebGL Canvas Engine (Three.js with Fallback) --}}
<canvas id="threejsCanvas"></canvas>

{{-- Cinematic Video-Style Overlays --}}
<div class="cinematic-glow"></div>
<div class="cinematic-vignette"></div>
<div class="scanline"></div>



{{-- ══ REGISTER SECURITY PASSWORD MODAL ══ --}}
<div id="regPasswordModal">
  <div class="modal-content-box">
    <div class="modal-top-beam"></div>
    <div class="modal-tag">OTORISASI AKSES TERBATAS</div>
    <div class="modal-title">Password Verifikasi EDP</div>
    <div class="modal-desc">Halaman pendaftaran pengguna baru dilindungi. Masukkan password security internal EDP untuk melanjutkan.</div>
    
    <div style="position:relative;">
      <svg style="position:absolute; left:13px; top:13px; width:16px; height:16px; stroke:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
      <input type="password" id="regPassInput" class="modal-input-field" placeholder="••••••••" onkeydown="if(event.key==='Enter')confirmRegPass()">
    </div>
    
    <div class="modal-error-msg" id="regPassError">✕ Password verifikasi salah. Silakan coba kembali.</div>
    
    <div class="modal-btn-row">
      <button type="button" class="btn-modal-cancel" onclick="closeRegModal()">Batal</button>
      <button type="button" class="btn-modal-confirm" onclick="confirmRegPass()">Konfirmasi →</button>
    </div>
  </div>
</div>

{{-- Page Transition Screen --}}
<div id="pageTransitionVeil">
  <div style="width:36px; height:36px; border:3px solid rgba(6,182,212,0.2); border-top-color:var(--cyan); border-radius:50%; animation:spin 0.7s linear infinite;"></div>
  <div class="veil-text">MENGHUBUNGKAN KE REGISTRASI...</div>
</div>

{{-- ══ MAIN INTERACTIVE 3D LOGIN CONTAINER ══ --}}
<div class="wrapper">
  <div class="card-3d-wrap" id="card3dWrap">
    <div class="login-card" id="loginCard">
      <div class="card-holo-glow"></div>
      
      {{-- Corner Cyberspace Accents --}}
      <div class="corner corner-tl"></div>
      <div class="corner corner-tr"></div>
      <div class="corner corner-bl"></div>
      <div class="corner corner-br"></div>

      {{-- Brand Header & Theme Toggle --}}
      <div class="brand-header">
        <div class="brand-left">
          <div class="brand-icon-box">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="3" width="20" height="14" rx="2"/>
              <path d="M8 21h8M12 17v4"/>
              <path d="M6 8h.01M6 11h.01"/>
              <rect x="10" y="7" width="8" height="6" rx="1"/>
            </svg>
            <div class="brand-icon-ring"></div>
          </div>
          <div class="brand-title-wrap">
            <div class="brand-name">MasterIP</div>
            <div class="brand-sub">BY ZMIE_V1.0 BETA</div>
          </div>
        </div>

        <button type="button" class="theme-toggle-btn" id="themeBtn" onclick="toggleTheme()" aria-label="Ganti Tema">
          <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
          <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
        </button>
      </div>



      {{-- Flash Message & Errors --}}
      @if(session('error'))
      <div class="alert-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ session('error') }}</span>
      </div>
      @endif

      @if(session('success'))
      <div class="alert-box alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span>{{ session('success') }}</span>
      </div>
      @endif

      @if($errors->any())
      <div class="alert-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      {{-- Login Form --}}
      <form method="POST" action="{{ route('login.post') }}" id="loginForm">
        @csrf

        {{-- NIK Input --}}
        <div class="form-group">
          <label class="form-label" for="nik-input">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            NIK Karyawan
          </label>
          <div class="input-container">
            <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <input type="text" name="NIK" id="nik-input" class="form-input" placeholder="Masukkan NIK Anda" value="{{ old('NIK') }}" autocomplete="off" spellcheck="false" autofocus required>
          </div>
          <div class="nik-preview" id="nikPreview"></div>
        </div>

        {{-- Password Input --}}
        <div class="form-group">
          <label class="form-label" for="pass-input">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Password
          </label>
          <div class="input-container">
            <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input type="password" name="Password" id="pass-input" class="form-input" style="padding-right:44px;" placeholder="••••••••" autocomplete="current-password" required>
            <button type="button" class="eye-btn" id="eyeToggle" tabindex="-1" title="Lihat Password">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <div class="capslock-box" id="capslockBox">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
            </svg>
            <span>CAPS LOCK AKTIF</span>
          </div>
        </div>

        {{-- Submit Login Button --}}
        <button type="submit" class="btn-submit-login" id="loginBtn">
          <div class="login-spinner"></div>
          <span class="btn-text-content" style="display:flex; align-items:center; gap:8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            <span>M A S U K</span>
          </span>
        </button>

        {{-- Divider --}}
        <div class="divider">
          <span class="divider-line"></span>
          <span class="divider-text">atau</span>
          <span class="divider-line"></span>
        </div>

        {{-- Register Link Button (Protected by password modal) --}}
        <a href="{{ route('register') }}" class="btn-to-register" id="btnRegisterTrigger">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
          <span>Buat Akun Baru</span>
        </a>
      </form>


    </div>
  </div>
</div>

<script>
/* ════════════════════════════════════════════════
   THEME MANAGER
════════════════════════════════════════════════ */
const body = document.body;
let currentTheme = localStorage.getItem('masterip-theme') || 'dark';

function applyTheme(t) {
  currentTheme = t;
  if (t === 'light') {
    body.classList.add('theme-light');
  } else {
    body.classList.remove('theme-light');
  }
  localStorage.setItem('masterip-theme', t);
  if (window.update3DTheme) {
    window.update3DTheme(t);
  }
}
function toggleTheme() {
  applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
}
applyTheme(currentTheme);

/* ════════════════════════════════════════════════
   INTERACTIVE 3D THREE.JS SCENE (With Fallback)
   - 3D Holographic Rotating Cyber Core
   - Undulating 3D Cyberspace Terrain Highway (Continuous Video-like Flight)
   - Dynamic Floating Starfield & Deep Data Particles
   - Interactive Mouse Parallax & Dynamic Light Tracking
════════════════════════════════════════════════ */
(function init3DScene() {
  const canvas = document.getElementById('threejsCanvas');
  if (!canvas) return;

  // Check Three.js availability
  if (typeof THREE === 'undefined') {
    init2DFallback(canvas);
    return;
  }

  try {
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(currentTheme === 'light' ? 0xedf2f9 : 0x030712, 0.028);

    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 4, 18);

    const renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance'
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // Dynamic Lights
    const ambientLight = new THREE.AmbientLight(currentTheme === 'light' ? 0x7788aa : 0x1e293b, 1.2);
    scene.add(ambientLight);

    const mouseLight = new THREE.PointLight(0x06b6d4, 2.5, 50);
    mouseLight.position.set(0, 5, 10);
    scene.add(mouseLight);

    const coreLight = new THREE.PointLight(0x6366f1, 3.0, 40);
    coreLight.position.set(0, 0, 0);
    scene.add(coreLight);

    // ── 1. 3D CYBER CORE (HOLOGRAPHIC GEODESIC SPHERE + ORBIT RINGS) ──
    const coreGroup = new THREE.Group();
    coreGroup.position.set(0, 0.5, 0);
    scene.add(coreGroup);

    // Geodesic Wireframe Sphere
    const sphereGeo = new THREE.IcosahedronGeometry(4.2, 2);
    const sphereMat = new THREE.MeshBasicMaterial({
      color: 0x6366f1,
      wireframe: true,
      transparent: true,
      opacity: 0.35
    });
    const sphereMesh = new THREE.Mesh(sphereGeo, sphereMat);
    coreGroup.add(sphereMesh);

    // Inner Glowing Core
    const innerGeo = new THREE.OctahedronGeometry(2.0, 1);
    const innerMat = new THREE.MeshBasicMaterial({
      color: 0x06b6d4,
      wireframe: true,
      transparent: true,
      opacity: 0.7
    });
    const innerMesh = new THREE.Mesh(innerGeo, innerMat);
    coreGroup.add(innerMesh);

    // Rotating Holographic Rings
    const ring1Geo = new THREE.TorusGeometry(5.2, 0.04, 16, 100);
    const ring1Mat = new THREE.MeshBasicMaterial({ color: 0x06b6d4, transparent: true, opacity: 0.6 });
    const ring1 = new THREE.Mesh(ring1Geo, ring1Mat);
    ring1.rotation.x = Math.PI / 3;
    coreGroup.add(ring1);

    const ring2Geo = new THREE.TorusGeometry(6.0, 0.03, 16, 100);
    const ring2Mat = new THREE.MeshBasicMaterial({ color: 0xa855f7, transparent: true, opacity: 0.45 });
    const ring2 = new THREE.Mesh(ring2Geo, ring2Mat);
    ring2.rotation.y = Math.PI / 4;
    ring2.rotation.x = -Math.PI / 5;
    coreGroup.add(ring2);

    // ── 2. UNDULATING 3D CYBER HIGHWAY (MOVING TERRAIN GRID LIKE VIDEO) ──
    const gridCols = 45;
    const gridRows = 45;
    const planeGeo = new THREE.PlaneGeometry(90, 90, gridCols, gridRows);
    planeGeo.rotateX(-Math.PI / 2);
    planeGeo.translate(0, -6.5, 0);

    const planeMat = new THREE.MeshBasicMaterial({
      color: currentTheme === 'light' ? 0x6366f1 : 0x06b6d4,
      wireframe: true,
      transparent: true,
      opacity: currentTheme === 'light' ? 0.22 : 0.35
    });
    const terrainMesh = new THREE.Mesh(planeGeo, planeMat);
    scene.add(terrainMesh);

    const posAttr = planeGeo.attributes.position;
    const initialY = new Float32Array(posAttr.count);
    for (let i = 0; i < posAttr.count; i++) {
      initialY[i] = posAttr.getY(i);
    }

    // ── 3. 3D DEEP PARTICLE FIELD (1,200+ STARS & PACKETS) ──
    const particleCount = 1200;
    const particleGeo = new THREE.BufferGeometry();
    const particlePos = new Float32Array(particleCount * 3);
    const particleSpeeds = new Float32Array(particleCount);

    for (let i = 0; i < particleCount; i++) {
      particlePos[i * 3]     = (Math.random() - 0.5) * 80;
      particlePos[i * 3 + 1] = (Math.random() - 0.5) * 60;
      particlePos[i * 3 + 2] = (Math.random() - 0.5) * 70;
      particleSpeeds[i]      = 0.05 + Math.random() * 0.12;
    }
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePos, 3));

    const particleMat = new THREE.PointsMaterial({
      size: 0.35,
      color: currentTheme === 'light' ? 0x4f46e5 : 0x38bdf8,
      transparent: true,
      opacity: 0.7,
      blending: THREE.AdditiveBlending
    });
    const particleSystem = new THREE.Points(particleGeo, particleMat);
    scene.add(particleSystem);

    // Mouse Tracking
    let targetMouseX = 0, targetMouseY = 0;
    let curMouseX = 0, curMouseY = 0;
    let typingPulseEnergy = 0;

    window.addEventListener('mousemove', (e) => {
      targetMouseX = (e.clientX / window.innerWidth) * 2 - 1;
      targetMouseY = -(e.clientY / window.innerHeight) * 2 + 1;
    });

    window.triggerTypingPulse = function() {
      typingPulseEnergy = 1.0;
    };

    window.update3DTheme = function(t) {
      const isLight = (t === 'light');
      scene.fog.color.setHex(isLight ? 0xedf2f9 : 0x030712);
      ambientLight.color.setHex(isLight ? 0x7788aa : 0x1e293b);
      planeMat.color.setHex(isLight ? 0x6366f1 : 0x06b6d4);
      planeMat.opacity = isLight ? 0.22 : 0.35;
      particleMat.color.setHex(isLight ? 0x4f46e5 : 0x38bdf8);
      sphereMat.color.setHex(isLight ? 0x4f46e5 : 0x6366f1);
    };

    // Resize handler
    window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Animation Loop
    let clock = new THREE.Clock();
    let terrainOffset = 0;

    function animate() {
      requestAnimationFrame(animate);
      const delta = clock.getDelta();
      const time  = clock.getElapsedTime();

      // Smooth Mouse Lerp
      curMouseX += (targetMouseX - curMouseX) * 0.04;
      curMouseY += (targetMouseY - curMouseY) * 0.04;

      // Camera Parallax
      camera.position.x = curMouseX * 3.5;
      camera.position.y = 4 + curMouseY * 2.0;
      camera.lookAt(0, 0, 0);

      // Mouse Dynamic Light
      mouseLight.position.x = curMouseX * 12;
      mouseLight.position.y = curMouseY * 8 + 3;

      // 3D Core Rotation
      const spinMult = 1.0 + typingPulseEnergy * 3.5;
      coreGroup.rotation.y += 0.006 * spinMult;
      coreGroup.rotation.x += 0.003 * spinMult;
      ring1.rotation.z += 0.012 * spinMult;
      ring2.rotation.z -= 0.015 * spinMult;
      innerMesh.rotation.y -= 0.02 * spinMult;

      // Typing Pulse Decay
      if (typingPulseEnergy > 0) {
        typingPulseEnergy *= 0.94;
        sphereMesh.scale.setScalar(1 + typingPulseEnergy * 0.15);
      }

      // Continuous Cyber Highway Wave (Flight forward like video)
      terrainOffset += delta * 1.5;
      const positions = planeGeo.attributes.position;
      for (let i = 0; i < positions.count; i++) {
        const x = positions.getX(i);
        const z = positions.getZ(i);
        const wave = Math.sin(x * 0.25 + time * 2.0) * Math.cos(z * 0.25 + terrainOffset) * 1.6;
        positions.setY(i, initialY[i] + wave);
      }
      positions.needsUpdate = true;

      // Particle Streaming
      const pArr = particleGeo.attributes.position.array;
      for (let i = 0; i < particleCount; i++) {
        pArr[i * 3 + 2] += particleSpeeds[i] * (1.0 + typingPulseEnergy * 2);
        if (pArr[i * 3 + 2] > 35) {
          pArr[i * 3 + 2] = -35;
        }
      }
      particleGeo.attributes.position.needsUpdate = true;

      renderer.render(scene, camera);
    }
    animate();

  } catch(err) {
    console.warn('Three.js initialization error, falling back to 2D engine:', err);
    init2DFallback(canvas);
  }

  // 2D Canvas Fallback
  function init2DFallback(cvs) {
    const ctx = cvs.getContext('2d');
    function resize() {
      cvs.width = window.innerWidth;
      cvs.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    let offset = 0;
    function draw() {
      offset += 1.2;
      ctx.clearRect(0, 0, cvs.width, cvs.height);
      ctx.strokeStyle = currentTheme === 'light' ? 'rgba(99,102,241,0.18)' : 'rgba(6,182,212,0.22)';
      ctx.lineWidth = 1;

      // Perspective Grid
      const cx = cvs.width / 2;
      const cy = cvs.height * 0.65;
      for (let x = -cvs.width; x <= cvs.width * 2; x += 60) {
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(x, cvs.height);
        ctx.stroke();
      }
      for (let y = cy; y < cvs.height; y += 15 + (y - cy) * 0.2) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(cvs.width, y);
        ctx.stroke();
      }
      requestAnimationFrame(draw);
    }
    draw();
  }
})();

/* ════════════════════════════════════════════════
   INTERACTIVE 3D CARD PARALLAX TILT
════════════════════════════════════════════════ */
(function initCardTilt() {
  const card = document.getElementById('loginCard');
  const wrap = document.getElementById('card3dWrap');
  if (!card || !wrap) return;

  let rx = 0, ry = 0;
  let targetRx = 0, targetRy = 0;

  window.addEventListener('mousemove', (e) => {
    const rect = card.getBoundingClientRect();
    const cardCenterX = rect.left + rect.width / 2;
    const cardCenterY = rect.top + rect.height / 2;

    const dx = (e.clientX - cardCenterX) / (window.innerWidth / 2);
    const dy = (e.clientY - cardCenterY) / (window.innerHeight / 2);

    targetRy = dx * 10; // Yaw
    targetRx = -dy * 10; // Pitch
  });

  window.addEventListener('mouseleave', () => {
    targetRx = 0;
    targetRy = 0;
  });

  function updateTilt() {
    rx += (targetRx - rx) * 0.08;
    ry += (targetRy - ry) * 0.08;
    wrap.style.transform = `rotateX(${rx.toFixed(2)}deg) rotateY(${ry.toFixed(2)}deg)`;
    requestAnimationFrame(updateTilt);
  }
  updateTilt();
})();

/* ════════════════════════════════════════════════
   FORM LOGIC & INTERACTION TRIGGERS
════════════════════════════════════════════════ */
// NIK Terminal Preview & 3D Typing Energy Trigger
const nikInput = document.getElementById('nik-input');
const nikPreview = document.getElementById('nikPreview');
if (nikInput) {
  nikInput.addEventListener('input', () => {
    const v = nikInput.value.trim();
    if (nikPreview) {
      nikPreview.textContent = v.length ? '> NIK::' + v.split('').join(' ') + ' _' : '';
    }
    if (window.triggerTypingPulse) window.triggerTypingPulse();
  });
}

// Password Eye Toggle
const passInput = document.getElementById('pass-input');
const eyeToggle = document.getElementById('eyeToggle');
const eyeIcon   = document.getElementById('eyeIcon');
let passVisible = false;

const EYE_OPEN = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
const EYE_CLOSED = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

if (eyeToggle && passInput) {
  eyeToggle.addEventListener('click', () => {
    passVisible = !passVisible;
    passInput.type = passVisible ? 'text' : 'password';
    eyeIcon.innerHTML = passVisible ? EYE_CLOSED : EYE_OPEN;
  });

  passInput.addEventListener('input', () => {
    if (window.triggerTypingPulse) window.triggerTypingPulse();
  });
}

// CapsLock Detector
const capslockBox = document.getElementById('capslockBox');
if (passInput && capslockBox) {
  passInput.addEventListener('keyup', (e) => {
    if (e.getModifierState) {
      capslockBox.classList.toggle('show', e.getModifierState('CapsLock'));
    }
  });
}

// Login Submit Loading Spinner & Ripple
const loginForm = document.getElementById('loginForm');
const loginBtn  = document.getElementById('loginBtn');

if (loginForm && loginBtn) {
  loginForm.addEventListener('submit', () => {
    if (nikInput.value.trim() && passInput.value.trim()) {
      loginBtn.classList.add('loading');
      loginBtn.disabled = true;
    }
  });

  loginBtn.addEventListener('click', function(e) {
    const rect = loginBtn.getBoundingClientRect();
    const ripple = document.createElement('span');
    ripple.className = 'btn-ripple';
    const size = Math.max(rect.width, rect.height);
    ripple.style.width  = size + 'px';
    ripple.style.height = size + 'px';
    ripple.style.left   = (e.clientX - rect.left - size / 2) + 'px';
    ripple.style.top    = (e.clientY - rect.top - size / 2) + 'px';
    loginBtn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 650);
  });
}

/* ════════════════════════════════════════════════
   REGISTER MODAL VERIFICATION (@nt@riks@)
════════════════════════════════════════════════ */
const btnRegisterTrigger = document.getElementById('btnRegisterTrigger');
const regPasswordModal   = document.getElementById('regPasswordModal');
const regPassInput       = document.getElementById('regPassInput');
const regPassError       = document.getElementById('regPassError');
const veil               = document.getElementById('pageTransitionVeil');

if (btnRegisterTrigger && regPasswordModal) {
  btnRegisterTrigger.addEventListener('click', (e) => {
    e.preventDefault();
    regPasswordModal.classList.add('open');
    setTimeout(() => {
      if (regPassInput) regPassInput.focus();
    }, 120);
  });
}

function closeRegModal() {
  if (regPasswordModal) regPasswordModal.classList.remove('open');
  if (regPassInput) {
    regPassInput.value = '';
    regPassInput.style.borderColor = '';
  }
  if (regPassError) regPassError.classList.remove('show');
}

function confirmRegPass() {
  if (!regPassInput) return;
  const val = regPassInput.value;

  // Secret password verification for EDP registration
  if (val !== '@nt@riks@') {
    if (regPassError) regPassError.classList.add('show');
    regPassInput.style.borderColor = 'var(--red)';
    regPassInput.value = '';
    regPassInput.focus();
    return;
  }

  // Success
  closeRegModal();
  if (veil) veil.classList.add('active');
  setTimeout(() => {
    window.location.href = btnRegisterTrigger.href;
  }, 650);
}

if (regPasswordModal) {
  regPasswordModal.addEventListener('click', (e) => {
    if (e.target === regPasswordModal) closeRegModal();
  });
}

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && regPasswordModal && regPasswordModal.classList.contains('open')) {
    closeRegModal();
  }
});
</script>
</body>
</html>