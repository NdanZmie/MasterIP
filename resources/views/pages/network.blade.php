{{-- network.blade --}}
@extends('layouts.app')

@section('content')
<style>
/* ══════════════════════════════════════════════════
   NETWORK MONITOR  —  network.blade.php  v3
   Aesthetic: Clean light glass — crisp, airy, modern
   Fonts: Syne (display) + DM Sans (body) + JetBrains Mono (data)
══════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap');

:root {
    --bg:         #f0f4fb;
    --surface:    rgba(255,255,255,0.78);
    --surface-h:  rgba(255,255,255,0.96);
    --border:     rgba(148,163,184,0.18);
    --border-h:   rgba(59,130,246,0.28);
    --accent:     #2563eb;
    --accent2:    #06b6d4;
    --green:      #16a34a;
    --green-bg:   rgba(22,163,74,0.08);
    --green-br:   rgba(22,163,74,0.22);
    --red:        #dc2626;
    --red-bg:     rgba(220,38,38,0.07);
    --red-br:     rgba(220,38,38,0.2);
    --amber:      #d97706;
    --amber-bg:   rgba(217,119,6,0.08);
    --amber-br:   rgba(217,119,6,0.22);
    --text-1:     #0f172a;
    --text-2:     #334155;
    --text-3:     #64748b;
    --text-4:     #94a3b8;
    --mono:       'JetBrains Mono', monospace;
    --sans:       'DM Sans', sans-serif;
    --display:    'Syne', sans-serif;
    --shadow-sm:  0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
    --shadow-md:  0 4px 16px rgba(15,23,42,0.08), 0 1px 4px rgba(15,23,42,0.04);
    --shadow-lg:  0 12px 40px rgba(15,23,42,0.10), 0 4px 12px rgba(15,23,42,0.05);
}

.nm * { box-sizing: border-box; }
.nm {
    font-family: var(--sans);
    color: var(--text-1);
}

/* Subtle dot pattern bg */
.nm::before {
    content: '';
    position: fixed; inset: 0; z-index: -1;
    background-image: radial-gradient(circle, rgba(59,130,246,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* ── Hero ─────────────────────────────────────── */
.nm-hero {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 24px;
}
.nm-eyebrow {
    display: flex; align-items: center; gap: 8px;
    font-family: var(--mono);
    font-size: .62rem; font-weight: 700;
    letter-spacing: .16em; text-transform: uppercase;
    color: var(--accent2);
    margin-bottom: 6px;
}
.nm-eyebrow-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--accent2);
    box-shadow: 0 0 0 3px rgba(6,182,212,0.2);
    animation: livepulse 2s infinite;
}
@keyframes livepulse {
    0%,100% { box-shadow: 0 0 0 3px rgba(6,182,212,0.2); }
    50%     { box-shadow: 0 0 0 7px rgba(6,182,212,0.04); }
}

.nm-title {
    font-family: var(--display);
    font-size: 2.2rem; font-weight: 800;
    color: var(--text-1); line-height: 1;
    letter-spacing: -.04em;
}
.nm-title span {
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.nm-sub {
    font-family: var(--mono);
    font-size: .7rem; color: var(--text-4); margin-top: 5px;
}

/* ── Stat pills ───────────────────────────────── */
.nm-stats { display: flex; gap: 8px; flex-wrap: wrap; align-items: flex-start; padding-top: 4px; }
.stat-pill {
    display: flex; align-items: center; gap: 9px;
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 10px 18px;
    box-shadow: var(--shadow-sm);
    transition: box-shadow .2s, transform .2s, border-color .2s;
}
.stat-pill:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--border-h);
}
.sp-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.sp-dot.online  { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.15); animation: sdpulse 2s infinite; }
.sp-dot.offline { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.12); }
.sp-dot.pending { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); animation: sdpulse 1.5s infinite; }
.sp-dot.total   { background: #cbd5e1; }
@keyframes sdpulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.5);opacity:.5} }
.sp-label { font-family: var(--mono); font-size: .62rem; font-weight: 700; letter-spacing: .08em; color: var(--text-4); text-transform: uppercase; }
.sp-num {
    font-family: var(--display);
    font-size: .95rem; font-weight: 700;
    color: var(--text-1); min-width: 22px; text-align: center;
}

/* ── Toolbar ─────────────────────────────────── */
.nm-toolbar {
    display: flex; align-items: center; gap: 8px;
    flex-wrap: wrap; margin-bottom: 14px;
}
.nm-search-wrap { flex: 1; min-width: 220px; position: relative; }
.nm-search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px; height: 15px; stroke: var(--text-4); pointer-events: none;
}
.nm-search-wrap input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-family: var(--sans); font-size: .875rem; color: var(--text-1);
    outline: none;
    box-shadow: var(--shadow-sm);
    transition: border-color .2s, box-shadow .2s;
}
.nm-search-wrap input::placeholder { color: var(--text-4); }
.nm-search-wrap input:focus {
    border-color: rgba(37,99,235,.35);
    box-shadow: 0 0 0 3px rgba(37,99,235,.08), var(--shadow-sm);
}

.nm-filter {
    display: flex; align-items: center; gap: 6px;
    padding: 10px 16px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-family: var(--mono); font-size: .7rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--text-3); cursor: pointer;
    box-shadow: var(--shadow-sm);
    transition: all .2s; white-space: nowrap;
}
.nm-filter svg { width: 13px; height: 13px; }
.nm-filter:hover { border-color: var(--border-h); color: var(--accent); }
.nm-filter.active {
    background: rgba(37,99,235,.06);
    border-color: rgba(37,99,235,.3);
    color: var(--accent);
}

.nm-scan-btn {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
    border: none; border-radius: 10px;
    font-family: var(--mono); font-size: .72rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: #fff; cursor: pointer; white-space: nowrap;
    box-shadow: 0 4px 16px rgba(37,99,235,.28);
    transition: transform .2s, box-shadow .2s, opacity .2s;
}
.nm-scan-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(37,99,235,.38); }
.nm-scan-btn:active:not(:disabled){ transform: translateY(0); }
.nm-scan-btn:disabled { opacity: .55; cursor: not-allowed; }
.btn-spin {
    display: none; width: 13px; height: 13px;
    border: 2px solid rgba(255,255,255,.3); border-top-color: #fff;
    border-radius: 50%; animation: rot .7s linear infinite;
}
@keyframes rot { to { transform: rotate(360deg); } }
.nm-scan-btn.loading .btn-label { display: none; }
.nm-scan-btn.loading .btn-spin  { display: block; }

/* ── Progress ─────────────────────────────────── */
.nm-prog-wrap {
    height: 3px; background: rgba(37,99,235,.08);
    border-radius: 3px; margin-bottom: 16px; overflow: hidden; display: none;
}
.nm-prog-wrap.show { display: block; }
.nm-prog-bar {
    height: 100%;
    background: linear-gradient(90deg, #2563eb, #06b6d4);
    border-radius: 3px; width: 0%;
    transition: width .25s ease;
}

/* ══════════════════════════════════════════════
   TABLE
══════════════════════════════════════════════ */
.nm-table-wrap {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.nm-table { width: 100%; border-collapse: collapse; }

/* Head */
.nm-table thead tr {
    background: rgba(248,250,252,0.95);
    border-bottom: 1px solid rgba(226,232,240,0.8);
}
.nm-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-family: var(--mono);
    font-size: .6rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--text-4); white-space: nowrap; user-select: none;
}
.nm-table thead th:first-child { padding-left: 22px; }
.nm-table thead th:last-child  { padding-right: 22px; text-align: center; }

/* Dept separator */
.dept-sep td {
    padding: 10px 22px 5px;
    background: rgba(241,245,249,0.7);
    border-top: 1px solid rgba(226,232,240,0.6);
}
.dept-sep-inner {
    display: flex; align-items: center; gap: 8px;
    font-family: var(--mono); font-size: .58rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase; color: var(--text-4);
}
.dept-sep-inner::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, rgba(148,163,184,.25), transparent);
}
.dept-cnt-badge {
    background: rgba(37,99,235,.08);
    color: var(--accent);
    border: 1px solid rgba(37,99,235,.15);
    border-radius: 20px; padding: 1px 8px; font-size: .56rem; font-weight: 700;
}

/* Body rows */
.nm-table tbody tr.dev-row {
    border-bottom: 1px solid rgba(226,232,240,0.5);
    transition: background .15s;
}
.nm-table tbody tr.dev-row:hover { background: rgba(239,246,255,0.6); }
.nm-table tbody tr.dev-row:last-child { border-bottom: none; }

.nm-table tbody td { padding: 11px 16px; vertical-align: middle; }
.nm-table tbody td:first-child { padding-left: 22px; }
.nm-table tbody td:last-child  { padding-right: 22px; }

/* ── No ── */
.td-no { font-family: var(--mono); font-size: .65rem; color: var(--text-4); width: 40px; }

/* ── Status badge ── */
.st-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    white-space: nowrap; transition: all .35s;
}
.st-badge.pending { background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-br); }
.st-badge.online  { background: var(--green-bg);  color: var(--green);  border: 1px solid var(--green-br); }
.st-badge.offline { background: var(--red-bg);    color: var(--red);    border: 1px solid var(--red-br); }
.st-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.st-badge.pending .st-dot { background: var(--amber); animation: sdpulse 1.5s infinite; }
.st-badge.online  .st-dot { background: #22c55e;      animation: sdpulse 2s infinite; }
.st-badge.offline .st-dot { background: var(--red); }

/* ── IP ── */
.td-ip { font-family: var(--mono); font-size: .8rem; font-weight: 700; color: var(--text-1); }

/* ── Name ── */
.td-name { font-size: .85rem; font-weight: 600; color: var(--text-1); }

/* ── Meta ── */
.td-meta { font-family: var(--mono); font-size: .7rem; color: var(--text-3); }

/* ── Latency ── */
.lat-cell { min-width: 130px; }
.lat-wrap2 { display: flex; align-items: center; gap: 8px; }
.lat-track { flex: 1; height: 4px; background: rgba(148,163,184,.14); border-radius: 4px; overflow: hidden; }
.lat-fill { height: 100%; border-radius: 4px; width: 0%; transition: width .8s cubic-bezier(.34,1.56,.64,1); }
.lat-fill.good   { background: linear-gradient(90deg,#22c55e,#16a34a); }
.lat-fill.medium { background: linear-gradient(90deg,#f59e0b,#d97706); }
.lat-fill.slow   { background: linear-gradient(90deg,#ef4444,#dc2626); }
.lat-val { font-family: var(--mono); font-size: .68rem; font-weight: 700; color: var(--text-3); min-width: 40px; text-align: right; flex-shrink: 0; }

/* ── Actions ── */
.td-actions { white-space: nowrap; }
.action-group { display: flex; align-items: center; gap: 6px; justify-content: center; }

.act-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 5px;
    padding: 5px 12px; border-radius: 8px;
    font-family: var(--mono); font-size: .62rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
    border: 1px solid transparent; cursor: pointer;
    transition: all .2s; white-space: nowrap; background: white;
}
.act-btn svg { width: 11px; height: 11px; flex-shrink: 0; }

.act-ping {
    border-color: rgba(37,99,235,.22); color: var(--accent);
    box-shadow: 0 1px 4px rgba(37,99,235,.08);
}
.act-ping:hover {
    background: rgba(37,99,235,.06); border-color: rgba(37,99,235,.4);
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,.14);
}

.act-repng {
    border-color: rgba(148,163,184,.3); color: var(--text-3); padding: 5px 8px;
    box-shadow: 0 1px 3px rgba(15,23,42,.05);
}
.act-repng:hover {
    border-color: rgba(6,182,212,.35); color: var(--accent2);
    background: rgba(6,182,212,.05); transform: translateY(-1px);
}

/* ── Empty ── */
.nm-empty td { text-align: center; padding: 64px 20px; color: var(--text-4); font-size: .875rem; }

/* ── Footer ── */
.nm-footer-info {
    margin-top: 14px; text-align: right;
    font-family: var(--mono); font-size: .68rem; color: var(--text-4);
}
.nm-footer-info strong { color: var(--text-3); }

/* ══════════════════════════════════════════════
   PING MODAL
══════════════════════════════════════════════ */
.nm-modal-overlay {
    position: fixed; inset: 0; z-index: 9000;
    background: rgba(15,23,42,0.3);
    backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .25s;
}
.nm-modal-overlay.show { opacity: 1; pointer-events: all; }

.nm-modal {
    width: min(580px, 95vw);
    background: #fff;
    border: 1px solid rgba(148,163,184,.22);
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 24px 80px rgba(15,23,42,.18), 0 8px 24px rgba(15,23,42,.08);
    transform: translateY(16px) scale(.97);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.nm-modal-overlay.show .nm-modal { transform: translateY(0) scale(1); }

.modal-bar {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    background: #f8fafc;
    border-bottom: 1px solid rgba(226,232,240,0.8);
}
.modal-dots { display: flex; gap: 6px; }
.modal-dots span { width: 11px; height: 11px; border-radius: 50%; cursor: pointer; transition: opacity .2s; }
.modal-dots span:nth-child(1) { background: #ef4444; }
.modal-dots span:nth-child(2) { background: #f59e0b; }
.modal-dots span:nth-child(3) { background: #22c55e; }
.modal-dots span:hover { opacity: .7; }

.modal-title {
    flex: 1; text-align: center;
    font-family: var(--mono); font-size: .68rem; font-weight: 700;
    color: var(--text-3); letter-spacing: .08em;
}
.modal-close-x {
    background: none; border: none; cursor: pointer;
    color: var(--text-4); font-size: 1rem; line-height: 1;
    padding: 2px 6px; border-radius: 4px; transition: all .2s;
}
.modal-close-x:hover { color: var(--red); background: rgba(220,38,38,.06); }

/* Terminal output area */
.modal-body {
    padding: 16px 18px;
    height: 300px; overflow-y: auto;
    font-family: var(--mono); font-size: .76rem;
    line-height: 1.85; color: var(--text-1);
    background: #f8fafc;
    border-bottom: 1px solid rgba(226,232,240,0.7);
    scroll-behavior: smooth;
}
.modal-body::-webkit-scrollbar { width: 4px; }
.modal-body::-webkit-scrollbar-track { background: transparent; }
.modal-body::-webkit-scrollbar-thumb { background: rgba(148,163,184,.3); border-radius: 4px; }

.term-line    { display: block; animation: fadeIn .1s ease both; }
@keyframes fadeIn { from{opacity:0;transform:translateX(-3px)} to{opacity:1;transform:none} }
.term-prompt  { color: var(--accent); font-weight: 700; }
.term-success { color: var(--green); }
.term-error   { color: var(--red); }
.term-info    { color: var(--text-3); }
.term-time    { color: var(--amber); font-weight: 700; }

.modal-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 11px 18px; gap: 10px;
    background: #f8fafc;
}
.modal-status {
    font-family: var(--mono); font-size: .68rem; color: var(--text-3);
}
.modal-status strong { color: var(--text-1); }
.modal-actions { display: flex; gap: 7px; }
.modal-btn {
    padding: 6px 14px; border-radius: 8px;
    font-family: var(--mono); font-size: .67rem; font-weight: 700;
    letter-spacing: .04em; border: 1px solid rgba(148,163,184,.3);
    cursor: pointer; transition: all .2s; background: white; color: var(--text-2);
}
.modal-btn:hover { border-color: rgba(37,99,235,.3); color: var(--accent); }
.modal-btn.primary {
    background: rgba(37,99,235,.07); border-color: rgba(37,99,235,.25); color: var(--accent);
}
.modal-btn.primary:hover { background: rgba(37,99,235,.14); }
.modal-btn.danger { color: var(--red); border-color: rgba(220,38,38,.2); }
.modal-btn.danger:hover { background: rgba(220,38,38,.05); border-color: rgba(220,38,38,.35); }

/* Toast */
#nm-toast {
    position: fixed; bottom: 24px; right: 24px;
    z-index: 9999; display: flex; flex-direction: column; gap: 8px;
    pointer-events: none;
}
.toast {
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(16px);
    color: var(--text-1);
    padding: 10px 16px; border-radius: 10px;
    font-family: var(--mono); font-size: .72rem;
    box-shadow: 0 8px 32px rgba(15,23,42,.13), 0 2px 8px rgba(15,23,42,.06);
    border-left: 3px solid var(--accent);
    animation: toastIn .3s cubic-bezier(.34,1.56,.64,1) both;
    pointer-events: auto;
}
.toast.ok  { border-left-color: #22c55e; }
.toast.err { border-left-color: var(--red); }
@keyframes toastIn { from{opacity:0;transform:translateX(24px)}to{opacity:1;transform:none} }

/* Responsive */
@media (max-width: 768px) {
    .nm-title { font-size: 1.6rem; }
    .col-dept, .col-comp, .col-nik { display: none; }
}
@media (max-width: 500px) {
    .stat-pill { padding: 8px 12px; }
}
</style>

{{-- Toast --}}
<div id="nm-toast"></div>

{{-- ══════════════════════════════════════════════
     PING MODAL
══════════════════════════════════════════════ --}}
<div class="nm-modal-overlay" id="ping-modal">
    <div class="nm-modal">
        <div class="modal-bar">
            <div class="modal-dots">
                <span onclick="closeModal()"></span>
                <span></span><span></span>
            </div>
            <div class="modal-title" id="modal-title">PING — 0.0.0.0</div>
            <button class="modal-close-x" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body" id="modal-body">
            <span class="term-info term-line">// Terminal siap. Pilih IP untuk memulai ping.</span>
        </div>
        <div class="modal-footer">
            <div class="modal-status" id="modal-status"><strong>Ready</strong></div>
            <div class="modal-actions">
                <button class="modal-btn danger"  id="btn-stop-ping" onclick="stopPing()" style="display:none">■ Stop</button>
                <button class="modal-btn primary" id="btn-repng"     onclick="rePingModal()" style="display:none">↺ Ping Ulang</button>
                <button class="modal-btn"         onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="nm">

{{-- ── HERO ──────────────────────────────────── --}}
<div class="nm-hero">
    <div>
        {{-- <div class="nm-eyebrow">
            <span class="nm-eyebrow-dot"></span>
            Network Monitor · Live
        </div> --}}
        <h1 class="nm-title">IP <span>Monitor</span></h1>
        <p class="nm-sub">Monitoring Network · {{ now()->format('d M Y') }}</p>
    </div>

    <div class="nm-stats">
        <div class="stat-pill">
            <span class="sp-dot online"></span>
            <span class="sp-label">Online</span>
            <span class="sp-num" id="cnt-on">—</span>
        </div>
        <div class="stat-pill">
            <span class="sp-dot offline"></span>
            <span class="sp-label">Offline</span>
            <span class="sp-num" id="cnt-off">—</span>
        </div>
        <div class="stat-pill">
            <span class="sp-dot pending"></span>
            <span class="sp-label">Pending</span>
            <span class="sp-num" id="cnt-pend">{{ $devices->count() }}</span>
        </div>
        <div class="stat-pill">
            <span class="sp-dot total"></span>
            <span class="sp-label">Total</span>
            <span class="sp-num">{{ $devices->count() }}</span>
        </div>
    </div>
</div>

{{-- ── TOOLBAR ───────────────────────────────── --}}
<div class="nm-toolbar">
    <div class="nm-search-wrap">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="nm-q" placeholder="Cari IP, nama, departemen, komputer…">
    </div>

    <button class="nm-filter active" data-f="all">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M6 12h12M9 18h6"/></svg>
        Semua
    </button>
    <button class="nm-filter" data-f="online">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/></svg>
        Online
    </button>
    <button class="nm-filter" data-f="offline">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="1" y1="1" x2="23" y2="23"/><path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55M5 12.55a10.94 10.94 0 0 1 5.17-2.39"/></svg>
        Offline
    </button>

    <button class="nm-scan-btn" id="scan-btn">
        <div class="btn-spin"></div>
        <span class="btn-label" style="display:flex;align-items:center;gap:6px">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:13px;height:13px">
                <polyline points="23 4 23 10 17 10"/>
                <polyline points="1 20 1 14 7 14"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
            Scan Semua
        </span>
    </button>
</div>

{{-- Progress --}}
<div class="nm-prog-wrap" id="nm-prog-wrap">
    <div class="nm-prog-bar" id="nm-prog-bar"></div>
</div>

{{-- ── TABLE ─────────────────────────────────── --}}
<div class="nm-table-wrap">
<table class="nm-table">
    <thead>
        <tr>
            <th style="width:40px">#</th>
            <th>Status</th>
            <th>IP Address</th>
            <th>Nama</th>
            <th class="col-dept">Departemen</th>
            <th class="col-comp">Computer Name</th>
            <th class="col-nik">NIK</th>
            <th class="lat-cell">Latency (RTT)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="nm-tbody">
    @php $grouped = $devices->groupBy('dept'); $rowNum = 1; @endphp

    @forelse($grouped as $dept => $deptDevices)
        <tr class="dept-sep" data-dept-hdr="{{ strtolower($dept) }}">
            <td colspan="9">
                <div class="dept-sep-inner">
                    {{ $dept ?: 'Tanpa Departemen' }}
                    <span class="dept-cnt-badge">{{ $deptDevices->count() }}</span>
                </div>
            </td>
        </tr>

        @foreach($deptDevices as $dev)
        <tr class="dev-row"
            id="row-{{ $dev->id }}"
            data-id="{{ $dev->id }}"
            data-ip="{{ $dev->ip }}"
            data-nama="{{ strtolower($dev->nama ?? '') }}"
            data-dept="{{ strtolower($dev->dept ?? '') }}"
            data-comp="{{ strtolower($dev->compname ?? '') }}"
            data-status="pending">

            <td class="td-no">{{ $rowNum++ }}</td>

            <td>
                <span class="st-badge pending" id="badge-{{ $dev->id }}">
                    <span class="st-dot"></span>
                    <span id="btxt-{{ $dev->id }}">Pending</span>
                </span>
            </td>

            <td class="td-ip">{{ $dev->ip }}</td>

            <td>
                <div class="td-name">{{ $dev->nama ?: '—' }}</div>
            </td>

            <td class="col-dept">
                <div class="td-meta">{{ $dev->dept ?: '—' }}</div>
            </td>

            <td class="col-comp">
                <div class="td-meta">{{ $dev->compname ?: '—' }}</div>
            </td>

            <td class="col-nik">
                <div class="td-meta">{{ $dev->nik ?: '—' }}</div>
            </td>

            <td class="lat-cell">
                <div class="lat-wrap2">
                    <div class="lat-track">
                        <div class="lat-fill" id="lbar-{{ $dev->id }}"></div>
                    </div>
                    <span class="lat-val" id="lval-{{ $dev->id }}">—</span>
                </div>
            </td>

            <td class="td-actions">
                <div class="action-group">
                    <button class="act-btn act-ping"
                            title="Buka terminal ping"
                            onclick="openPingModal({{ $dev->id }}, '{{ $dev->ip }}', '{{ $dev->nama }}')">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                        Ping
                    </button>
                    <button class="act-btn act-repng"
                            title="Quick scan"
                            onclick="quickPing({{ $dev->id }}, '{{ $dev->ip }}')">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="23 4 23 10 17 10"/>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10"/>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach

    @empty
        <tr class="nm-empty"><td colspan="9">
            Tidak ada data IP. Tambahkan melalui halaman
            <a href="/spekpc" style="color:var(--accent)">Spek PC</a>.
        </td></tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="nm-footer-info" id="nm-footer-info"></div>
</div>{{-- .nm --}}

<script>
/* ══════════════════════════════════════════════
   NETWORK MONITOR v3 — JS
══════════════════════════════════════════════ */
const PING_URL    = '/network/ping';
const CSRF        = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const BATCH       = 5;
const PING_ROUNDS = 4;

const allRows = Array.from(document.querySelectorAll('.dev-row'));
let activeFilter = 'all';
let scanning     = false;
let counters     = { online: 0, offline: 0, pending: allRows.length };

/* ── Stats ──────────────────────────────────── */
function updateStats() {
    document.getElementById('cnt-on').textContent   = counters.online;
    document.getElementById('cnt-off').textContent  = counters.offline;
    document.getElementById('cnt-pend').textContent = counters.pending;
}

/* ── Set row status ─────────────────────────── */
function setStatus(id, status, latency) {
    const row   = document.getElementById(`row-${id}`);
    const badge = document.getElementById(`badge-${id}`);
    const btxt  = document.getElementById(`btxt-${id}`);
    const lbar  = document.getElementById(`lbar-${id}`);
    const lval  = document.getElementById(`lval-${id}`);
    if (!row) return;

    const prev = row.dataset.status;
    if (counters[prev] !== undefined) counters[prev] = Math.max(0, counters[prev] - 1);

    row.dataset.status = status;
    badge.className    = `st-badge ${status}`;
    btxt.textContent   = status === 'online' ? 'Online' : status === 'offline' ? 'Offline' : 'Pending';
    counters[status]   = (counters[status] ?? 0) + 1;

    if (latency !== null && latency !== undefined) {
        lval.textContent = latency + ' ms';
        const pct = Math.min(100, (latency / 150) * 100);
        lbar.style.width = pct + '%';
        lbar.className   = 'lat-fill ' + (latency < 15 ? 'good' : latency < 60 ? 'medium' : 'slow');
    } else {
        lval.textContent = status === 'offline' ? 'n/a' : '—';
        lbar.style.width = '0%';
        lbar.className   = 'lat-fill';
    }
    updateStats();
    applyFilter();
}

/* ── Quick ping ─────────────────────────────── */
async function quickPing(id, ip) {
    setStatus(id, 'pending', null);
    try {
        const r    = await fetch(PING_URL, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
            body: JSON.stringify({ ip }),
        });
        const data = await r.json();
        setStatus(id, data.online ? 'online' : 'offline', data.latency);
        showToast(
            `${ip} → ${data.online ? '✓ Online' : '✗ Offline'}${data.latency ? ' · ' + data.latency + ' ms' : ''}`,
            data.online ? 'ok' : 'err'
        );
    } catch {
        setStatus(id, 'offline', null);
    }
}

/* ── Scan All ───────────────────────────────── */
async function scanAll() {
    if (scanning) return;
    scanning = true;

    const btn  = document.getElementById('scan-btn');
    const prog = document.getElementById('nm-prog-wrap');
    const bar  = document.getElementById('nm-prog-bar');

    btn.classList.add('loading'); btn.disabled = true;
    prog.classList.add('show');

    allRows.forEach(r => setStatus(r.dataset.id, 'pending', null));
    counters = { online: 0, offline: 0, pending: allRows.length };
    updateStats();

    const total = allRows.length; let done = 0;

    for (let i = 0; i < allRows.length; i += BATCH) {
        const batch = allRows.slice(i, i + BATCH);
        await Promise.all(batch.map(async row => {
            try {
                const r = await fetch(PING_URL, {
                    method: 'POST',
                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
                    body: JSON.stringify({ ip: row.dataset.ip }),
                });
                const data = await r.json();
                setStatus(row.dataset.id, data.online ? 'online' : 'offline', data.latency);
            } catch {
                setStatus(row.dataset.id, 'offline', null);
            }
            done++;
            bar.style.width = Math.round((done / total) * 100) + '%';
        }));
    }

    btn.classList.remove('loading'); btn.disabled = false; scanning = false;

    const now = new Date().toLocaleTimeString('id-ID');
    document.getElementById('nm-footer-info').innerHTML =
        `Scan selesai &nbsp;·&nbsp; <strong>${now}</strong> &nbsp;·&nbsp; ` +
        `<strong style="color:#16a34a">${counters.online}</strong> online &nbsp;·&nbsp; ` +
        `<strong style="color:#dc2626">${counters.offline}</strong> offline`;

    setTimeout(() => { prog.classList.remove('show'); bar.style.width = '0%'; }, 2000);
}

/* ══════════════════════════════════════════════
   PING MODAL
══════════════════════════════════════════════ */
let currentPingId = null;
let currentPingIp = null;
let pingRunning   = false;
let pingCount     = 0;

function openPingModal(id, ip, nama) {
    currentPingId = id;
    currentPingIp = ip;
    document.getElementById('modal-title').textContent = `PING — ${ip}${nama ? '  ·  ' + nama : ''}`;
    document.getElementById('modal-body').innerHTML    = '';
    document.getElementById('modal-status').innerHTML  = '<strong>Menghubungkan…</strong>';
    document.getElementById('btn-stop-ping').style.display = 'none';
    document.getElementById('btn-repng').style.display     = 'none';
    document.getElementById('ping-modal').classList.add('show');
    runPingSequence(id, ip);
}

function closeModal() {
    pingRunning = false;
    document.getElementById('ping-modal').classList.remove('show');
}

function rePingModal() {
    if (currentPingId && currentPingIp) {
        document.getElementById('modal-body').innerHTML = '';
        document.getElementById('btn-repng').style.display = 'none';
        runPingSequence(currentPingId, currentPingIp);
    }
}

function stopPing() {
    pingRunning = false;
    addTermLine('// Ping dihentikan oleh user.', 'term-info');
    document.getElementById('btn-stop-ping').style.display = 'none';
    document.getElementById('btn-repng').style.display     = '';
    document.getElementById('modal-status').innerHTML = '<strong>Stopped</strong>';
}

async function runPingSequence(id, ip) {
    pingRunning = true;
    pingCount   = 0;
    let success = 0, fail = 0, totalMs = 0;

    document.getElementById('btn-stop-ping').style.display = '';
    document.getElementById('btn-repng').style.display     = 'none';

    addTermLine(`<span class="term-prompt">C:\\Users\\Admin&gt;</span> ping ${ip} -n ${PING_ROUNDS}`, 'term-line');
    addTermLine('', 'term-line');
    addTermLine(`Pinging ${ip} with 32 bytes of data:`, 'term-info');

    for (let i = 0; i < PING_ROUNDS; i++) {
        if (!pingRunning) break;
        pingCount = i + 1;
        document.getElementById('modal-status').innerHTML = `Pinging… <strong>${i + 1}/${PING_ROUNDS}</strong>`;

        try {
            const t0   = performance.now();
            const r    = await fetch(PING_URL, {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
                body: JSON.stringify({ ip }),
            });
            const data = await r.json();
            const wall = Math.round(performance.now() - t0);

            if (data.online) {
                const ms = data.latency ?? wall;
                success++; totalMs += ms;
                addTermLine(`Reply from ${ip}: bytes=32 <span class="term-time">time=${ms}ms</span> TTL=128`, 'term-success');
                setStatus(id, 'online', ms);
            } else {
                fail++;
                addTermLine(`Request timeout for icmp_seq ${i}`, 'term-error');
                setStatus(id, 'offline', null);
            }
        } catch {
            fail++;
            addTermLine(`General failure. (code=-1)`, 'term-error');
        }

        if (i < PING_ROUNDS - 1 && pingRunning) await sleep(900);
    }

    if (!pingRunning) return;
    pingRunning = false;

    document.getElementById('btn-stop-ping').style.display = 'none';
    document.getElementById('btn-repng').style.display     = '';

    const sent = pingCount;
    const pct  = Math.round((fail / sent) * 100);
    const avg  = success ? Math.round(totalMs / success) : null;

    addTermLine('', 'term-line');
    addTermLine(`Ping statistics for ${ip}:`, 'term-info');
    addTermLine(
        `    Packets: Sent = ${sent}, Received = ${success}, Lost = ${fail} (${pct}% loss)`,
        fail === 0 ? 'term-success' : fail === sent ? 'term-error' : 'term-time'
    );
    if (avg !== null) {
        addTermLine('Approximate round trip times in milli-seconds:', 'term-info');
        addTermLine(`    Average = <span class="term-time">${avg}ms</span>`, 'term-success');
    }

    const finalStatus = success > 0 ? 'online' : 'offline';
    document.getElementById('modal-status').innerHTML =
        `<strong style="color:${finalStatus === 'online' ? '#16a34a' : '#dc2626'}">` +
        `${finalStatus === 'online' ? '✓ Online' : '✗ Offline'}</strong>` +
        `${avg ? ' · ' + avg + 'ms avg' : ''}`;
}

function addTermLine(html, cls = 'term-line') {
    const el = document.createElement('span');
    el.className = cls;
    el.innerHTML = html + '\n';
    const body = document.getElementById('modal-body');
    body.appendChild(el);
    body.scrollTop = body.scrollHeight;
}

function sleep(ms) { return new Promise(r => setTimeout(r, ms)); }

/* ── Filter + Search ────────────────────────── */
function applyFilter() {
    const q = document.getElementById('nm-q').value.toLowerCase().trim();
    allRows.forEach(row => {
        const fOk = activeFilter === 'all' || row.dataset.status === activeFilter;
        const sOk = !q
            || row.dataset.ip.includes(q)
            || row.dataset.nama.includes(q)
            || row.dataset.dept.includes(q)
            || row.dataset.comp.includes(q);
        row.style.display = (fOk && sOk) ? '' : 'none';
    });
    document.querySelectorAll('[data-dept-hdr]').forEach(hdr => {
        const dept = hdr.dataset.deptHdr;
        const any  = allRows.filter(r => r.dataset.dept === dept).some(r => r.style.display !== 'none');
        hdr.style.display = any ? '' : 'none';
    });
}

document.querySelectorAll('[data-f]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('[data-f]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeFilter = btn.dataset.f;
        applyFilter();
    });
});
document.getElementById('nm-q').addEventListener('input', applyFilter);
document.getElementById('scan-btn').addEventListener('click', scanAll);
document.getElementById('ping-modal').addEventListener('click', e => {
    if (e.target === document.getElementById('ping-modal')) closeModal();
});

/* ── Toast ───────────────────────────────────── */
function showToast(msg, type = '') {
    const el = document.createElement('div');
    el.className = `toast ${type}`;
    el.textContent = msg;
    document.getElementById('nm-toast').appendChild(el);
    setTimeout(() => el.remove(), 4000);
}

/* ── Auto scan on load ───────────────────────── */
window.addEventListener('DOMContentLoaded', () => setTimeout(scanAll, 500));
</script>
@endsection