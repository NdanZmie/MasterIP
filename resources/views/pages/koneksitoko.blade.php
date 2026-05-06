{{-- views/pages/koneksitoko.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap');

:root {
    --bg:         #f0f4fb;
    --surface:    rgba(255,255,255,0.78);
    --surface-h:  rgba(255,255,255,0.96);
    --border:     rgba(148,163,184,0.18);
    --border-h:   rgba(37,99,235,0.28);
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

.kt * { box-sizing: border-box; }
.kt { font-family: var(--sans); color: var(--text-1); }

.kt::before {
    content: '';
    position: fixed; inset: 0; z-index: -1;
    background-image: radial-gradient(circle, rgba(59,130,246,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* ── Hero ─────────────────────────────────────── */
.kt-hero {
    display: flex; align-items: flex-start;
    justify-content: space-between; flex-wrap: wrap;
    gap: 20px; margin-bottom: 24px;
}
.kt-title {
    font-family: var(--display);
    font-size: 2.2rem; font-weight: 800;
    color: var(--text-1); line-height: 1; letter-spacing: -.04em;
}
.kt-title span {
    background: linear-gradient(135deg, #2563eb, #06b6d4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.kt-sub { font-family: var(--mono); font-size: .7rem; color: var(--text-4); margin-top: 5px; }

/* ── Stat pills ───────────────────────────────── */
.kt-stats { display: flex; gap: 8px; flex-wrap: wrap; align-items: flex-start; padding-top: 4px; }
.stat-pill {
    display: flex; align-items: center; gap: 9px;
    background: var(--surface); backdrop-filter: blur(20px);
    border: 1px solid var(--border); border-radius: 12px;
    padding: 10px 18px; box-shadow: var(--shadow-sm);
    transition: box-shadow .2s, transform .2s, border-color .2s;
}
.stat-pill:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); border-color: var(--border-h); }
.sp-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.sp-dot.online  { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.15); animation: sdpulse 2s infinite; }
.sp-dot.offline { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.12); }
.sp-dot.pending { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); animation: sdpulse 1.5s infinite; }
.sp-dot.total   { background: #cbd5e1; }
@keyframes sdpulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.5);opacity:.5} }
.sp-label { font-family: var(--mono); font-size: .62rem; font-weight: 700; letter-spacing: .08em; color: var(--text-4); text-transform: uppercase; }
.sp-num   { font-family: var(--display); font-size: .95rem; font-weight: 700; color: var(--text-1); min-width: 22px; text-align: center; }

/* ── Toolbar ─────────────────────────────────── */
.kt-toolbar { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
.kt-search-wrap { flex: 1; min-width: 220px; position: relative; }
.kt-search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; stroke: var(--text-4); pointer-events: none; }
.kt-search-wrap input {
    width: 100%; padding: 10px 14px 10px 38px;
    background: white; border: 1px solid var(--border); border-radius: 10px;
    font-family: var(--sans); font-size: .875rem; color: var(--text-1);
    outline: none; box-shadow: var(--shadow-sm); transition: border-color .2s, box-shadow .2s;
}
.kt-search-wrap input::placeholder { color: var(--text-4); }
.kt-search-wrap input:focus { border-color: rgba(37,99,235,.35); box-shadow: 0 0 0 3px rgba(37,99,235,.08), var(--shadow-sm); }

.kt-filter {
    display: flex; align-items: center; gap: 6px;
    padding: 10px 16px; background: white;
    border: 1px solid var(--border); border-radius: 10px;
    font-family: var(--mono); font-size: .7rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--text-3); cursor: pointer; box-shadow: var(--shadow-sm);
    transition: all .2s; white-space: nowrap;
}
.kt-filter svg { width: 13px; height: 13px; }
.kt-filter:hover { border-color: var(--border-h); color: var(--accent); }
.kt-filter.active { background: rgba(37,99,235,.06); border-color: rgba(37,99,235,.3); color: var(--accent); }

.kt-scan-btn {
    display: flex; align-items: center; gap: 7px; padding: 10px 22px;
    background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
    border: none; border-radius: 10px;
    font-family: var(--mono); font-size: .72rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: #fff; cursor: pointer; white-space: nowrap;
    box-shadow: 0 4px 16px rgba(37,99,235,.28);
    transition: transform .2s, box-shadow .2s, opacity .2s;
}
.kt-scan-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(37,99,235,.38); }
.kt-scan-btn:disabled { opacity: .55; cursor: not-allowed; }
.btn-spin { display: none; width: 13px; height: 13px; border: 2px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: rot .7s linear infinite; }
@keyframes rot { to { transform: rotate(360deg); } }
.kt-scan-btn.loading .btn-label { display: none; }
.kt-scan-btn.loading .btn-spin  { display: block; }

.kt-add-btn {
    display: flex; align-items: center; gap: 7px; padding: 10px 20px;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    border: none; border-radius: 10px;
    font-family: var(--mono); font-size: .72rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: #fff; cursor: pointer; white-space: nowrap;
    box-shadow: 0 4px 16px rgba(16,185,129,.28);
    transition: transform .2s, box-shadow .2s;
}
.kt-add-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(16,185,129,.38); }

/* ── Progress ─────────────────────────────────── */
.kt-prog-wrap { height: 3px; background: rgba(37,99,235,.08); border-radius: 3px; margin-bottom: 16px; overflow: hidden; display: none; }
.kt-prog-wrap.show { display: block; }
.kt-prog-bar { height: 100%; background: linear-gradient(90deg, #2563eb, #06b6d4); border-radius: 3px; width: 0%; transition: width .25s ease; }

/* ══════════════════════════════════════════════
   TABLE
══════════════════════════════════════════════ */
.kt-table-wrap {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid rgba(226,232,240,0.8);
    border-radius: 16px; overflow: hidden;
    box-shadow: var(--shadow-lg);
}
.kt-table { width: 100%; border-collapse: collapse; }

.kt-table thead tr { background: rgba(248,250,252,0.95); border-bottom: 1px solid rgba(226,232,240,0.8); }
.kt-table thead th {
    padding: 12px 16px; text-align: left;
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--text-4); white-space: nowrap; user-select: none;
}
.kt-table thead th:first-child { padding-left: 22px; }
.kt-table thead th:last-child  { padding-right: 22px; text-align: center; }

.kt-table tbody tr.dev-row { border-bottom: 1px solid rgba(226,232,240,0.5); transition: background .15s; }
.kt-table tbody tr.dev-row:hover { background: rgba(239,246,255,0.6); }
.kt-table tbody tr.dev-row:last-child { border-bottom: none; }
.kt-table tbody td { padding: 12px 16px; vertical-align: top; }
.kt-table tbody td:first-child { padding-left: 22px; }
.kt-table tbody td:last-child  { padding-right: 22px; }

.td-no { font-family: var(--mono); font-size: .65rem; color: var(--text-4); width: 40px; padding-top: 14px !important; }

/* Status badge (ping) */
.st-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    white-space: nowrap; transition: all .35s;
}
.st-badge.pending     { background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-br); }
.st-badge.online      { background: var(--green-bg);  color: var(--green);  border: 1px solid var(--green-br); }
.st-badge.offline     { background: var(--red-bg);    color: var(--red);    border: 1px solid var(--red-br); }
.st-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.st-badge.pending .st-dot { background: var(--amber); animation: sdpulse 1.5s infinite; }
.st-badge.online  .st-dot { background: #22c55e; animation: sdpulse 2s infinite; }
.st-badge.offline .st-dot { background: var(--red); }

.td-name { font-size: .875rem; font-weight: 600; color: var(--text-1); }
.td-sub  { font-size: .72rem; color: var(--text-3); margin-top: 3px; font-family: var(--mono); }

/* IP grid */
.ip-grid { display: flex; flex-direction: column; gap: 3px; }
.ip-row  { display: flex; align-items: center; gap: 8px; }
.ip-lbl  {
    font-family: var(--mono); font-size: .56rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--text-4); min-width: 60px; flex-shrink: 0;
}
.ip-val  { font-family: var(--mono); font-size: .76rem; font-weight: 700; color: var(--text-1); }
.ip-val.empty { color: var(--text-4); font-weight: 400; }

/* Ping per-device badges */
.ip-ping-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 7px; border-radius: 20px;
    font-family: var(--mono); font-size: .56rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
    white-space: nowrap; transition: all .35s;
    cursor: pointer; border: 1px solid transparent;
}
.ip-ping-badge.pending  { background: var(--amber-bg); color: var(--amber); border-color: var(--amber-br); }
.ip-ping-badge.online   { background: var(--green-bg); color: var(--green); border-color: var(--green-br); }
.ip-ping-badge.offline  { background: var(--red-bg);   color: var(--red);   border-color: var(--red-br); }
.ip-ping-dot { width: 4px; height: 4px; border-radius: 50%; flex-shrink: 0; }
.ip-ping-badge.pending .ip-ping-dot { background: var(--amber); animation: sdpulse 1.5s infinite; }
.ip-ping-badge.online  .ip-ping-dot { background: #22c55e; animation: sdpulse 2s infinite; }
.ip-ping-badge.offline .ip-ping-dot { background: var(--red); }

/* Latency */
.lat-wrap { display: flex; align-items: center; gap: 6px; min-width: 110px; }
.lat-track { flex: 1; height: 4px; background: rgba(148,163,184,.14); border-radius: 4px; overflow: hidden; }
.lat-fill  { height: 100%; border-radius: 4px; width: 0%; transition: width .8s cubic-bezier(.34,1.56,.64,1); }
.lat-fill.good   { background: linear-gradient(90deg,#22c55e,#16a34a); }
.lat-fill.medium { background: linear-gradient(90deg,#f59e0b,#d97706); }
.lat-fill.slow   { background: linear-gradient(90deg,#ef4444,#dc2626); }
.lat-val { font-family: var(--mono); font-size: .68rem; font-weight: 700; color: var(--text-3); min-width: 42px; text-align: right; flex-shrink: 0; }

/* Actions */
.action-group { display: flex; align-items: center; gap: 5px; justify-content: center; padding-top: 2px; }
.act-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 5px;
    padding: 5px 10px; border-radius: 8px;
    font-family: var(--mono); font-size: .62rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
    border: 1px solid transparent; cursor: pointer;
    transition: all .2s; white-space: nowrap; background: white;
}
.act-btn svg { width: 11px; height: 11px; flex-shrink: 0; }

.act-scan  { border-color: rgba(37,99,235,.22); color: var(--accent); box-shadow: 0 1px 4px rgba(37,99,235,.08); }
.act-scan:hover  { background: rgba(37,99,235,.06); border-color: rgba(37,99,235,.4); transform: translateY(-1px); }

.act-edit  { border-color: rgba(245,158,11,.25); color: var(--amber); padding: 5px 7px; }
.act-edit:hover  { border-color: rgba(245,158,11,.45); background: rgba(245,158,11,.06); transform: translateY(-1px); }

.act-del   { border-color: rgba(220,38,38,.2); color: var(--red); padding: 5px 7px; }
.act-del:hover   { border-color: rgba(220,38,38,.4); background: rgba(220,38,38,.05); transform: translateY(-1px); }

/* Empty */
.kt-empty td { text-align: center; padding: 64px 20px; color: var(--text-4); font-size: .875rem; }

/* Footer info */
.kt-footer-info { margin-top: 14px; text-align: right; font-family: var(--mono); font-size: .68rem; color: var(--text-4); }
.kt-footer-info strong { color: var(--text-3); }

/* ══════════════════════════════════════════════
   PING MODAL (terminal style)
══════════════════════════════════════════════ */
.kt-modal-overlay {
    position: fixed; inset: 0; z-index: 9000;
    background: rgba(15,23,42,0.3); backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .25s;
}
.kt-modal-overlay.show { opacity: 1; pointer-events: all; }
.kt-modal {
    width: min(600px, 95vw); background: #fff;
    border: 1px solid rgba(148,163,184,.22); border-radius: 16px; overflow: hidden;
    box-shadow: 0 24px 80px rgba(15,23,42,.18), 0 8px 24px rgba(15,23,42,.08);
    transform: translateY(16px) scale(.97);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.kt-modal-overlay.show .kt-modal { transform: translateY(0) scale(1); }

.modal-bar { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: #f8fafc; border-bottom: 1px solid rgba(226,232,240,0.8); }
.modal-dots { display: flex; gap: 6px; }
.modal-dots span { width: 11px; height: 11px; border-radius: 50%; cursor: pointer; }
.modal-dots span:nth-child(1) { background: #ef4444; }
.modal-dots span:nth-child(2) { background: #f59e0b; }
.modal-dots span:nth-child(3) { background: #22c55e; }
.modal-title { flex: 1; text-align: center; font-family: var(--mono); font-size: .68rem; font-weight: 700; color: var(--text-3); letter-spacing: .08em; }
.modal-close-x { background: none; border: none; cursor: pointer; color: var(--text-4); font-size: 1rem; line-height: 1; padding: 2px 6px; border-radius: 4px; transition: all .2s; }
.modal-close-x:hover { color: var(--red); background: rgba(220,38,38,.06); }

.modal-body {
    padding: 16px 18px; height: 300px; overflow-y: auto;
    font-family: var(--mono); font-size: .76rem; line-height: 1.85; color: var(--text-1);
    background: #f8fafc; border-bottom: 1px solid rgba(226,232,240,0.7); scroll-behavior: smooth;
}
.modal-body::-webkit-scrollbar { width: 4px; }
.modal-body::-webkit-scrollbar-thumb { background: rgba(148,163,184,.3); border-radius: 4px; }

.term-line    { display: block; animation: fadeIn .1s ease both; }
@keyframes fadeIn { from{opacity:0;transform:translateX(-3px)} to{opacity:1;transform:none} }
.term-prompt  { color: var(--accent); font-weight: 700; }
.term-success { color: var(--green); }
.term-error   { color: var(--red); }
.term-info    { color: var(--text-3); }
.term-time    { color: var(--amber); font-weight: 700; }

.modal-footer { display: flex; align-items: center; justify-content: space-between; padding: 11px 18px; gap: 10px; background: #f8fafc; }
.modal-status { font-family: var(--mono); font-size: .68rem; color: var(--text-3); }
.modal-status strong { color: var(--text-1); }
.modal-actions { display: flex; gap: 7px; }
.modal-btn {
    padding: 6px 14px; border-radius: 8px;
    font-family: var(--mono); font-size: .67rem; font-weight: 700;
    letter-spacing: .04em; border: 1px solid rgba(148,163,184,.3);
    cursor: pointer; transition: all .2s; background: white; color: var(--text-2);
}
.modal-btn:hover { border-color: rgba(37,99,235,.3); color: var(--accent); }
.modal-btn.primary { background: rgba(37,99,235,.07); border-color: rgba(37,99,235,.25); color: var(--accent); }
.modal-btn.danger  { color: var(--red); border-color: rgba(220,38,38,.2); }
.modal-btn.danger:hover { background: rgba(220,38,38,.05); border-color: rgba(220,38,38,.35); }

/* Toast */
#kt-toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; pointer-events: none; }
.toast { background: rgba(255,255,255,0.97); backdrop-filter: blur(16px); color: var(--text-1); padding: 10px 16px; border-radius: 10px; font-family: var(--mono); font-size: .72rem; box-shadow: 0 8px 32px rgba(15,23,42,.13), 0 2px 8px rgba(15,23,42,.06); border-left: 3px solid var(--accent); animation: toastIn .3s cubic-bezier(.34,1.56,.64,1) both; pointer-events: auto; }
.toast.ok  { border-left-color: #22c55e; }
.toast.err { border-left-color: var(--red); }
@keyframes toastIn { from{opacity:0;transform:translateX(24px)}to{opacity:1;transform:none} }

/* Alert session */
.kt-alert { display: flex; align-items: center; gap: 10px; padding: 11px 16px; border-radius: 10px; margin-bottom: 14px; font-family: var(--mono); font-size: .72rem; font-weight: 600; }
.kt-alert.success { background: var(--green-bg); border: 1px solid var(--green-br); color: var(--green); }
.kt-alert.error   { background: var(--red-bg);   border: 1px solid var(--red-br);   color: var(--red); }

/* Shared modal styles */
.toko-section-label { font-size: 0.65rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
.toko-section-line { height: 1px; flex: 1; }
.toko-label { display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #64748b; margin-bottom: 5px; }
.toko-input { width: 100%; padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: 0.84rem; color: #334155; transition: border-color 0.2s, box-shadow 0.2s; outline: none; background: #fff; box-sizing: border-box; }
.toko-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
.toko-btn-cancel { padding: 10px 22px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.83rem; font-weight: 600; color: #64748b; cursor: pointer; transition: all 0.2s; font-family: inherit; }
.toko-btn-cancel:hover { border-color: #cbd5e1; background: #f8fafc; }
.toko-btn-submit { padding: 10px 26px; border: none; border-radius: 12px; font-size: 0.83rem; font-weight: 700; color: #fff; cursor: pointer; font-family: inherit; transition: transform 0.15s, box-shadow 0.2s; display: flex; align-items: center; gap: 7px; }

@keyframes tokoModalIn {
    from { opacity: 0; transform: translateY(24px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

@media (max-width: 768px) {
    .kt-title { font-size: 1.6rem; }
    .col-hide { display: none; }
}
@media (max-width: 500px) {
    .stat-pill { padding: 8px 12px; }
}
</style>

{{-- Toast container --}}
<div id="kt-toast"></div>

{{-- ══════════════════════════════════════════════
     PING MODAL
══════════════════════════════════════════════ --}}
<div class="kt-modal-overlay" id="ping-modal">
    <div class="kt-modal">
        <div class="modal-bar">
            <div class="modal-dots">
                <span onclick="closeModal()"></span>
                <span></span><span></span>
            </div>
            <div class="modal-title" id="modal-title">PING — 0.0.0.0</div>
            <button class="modal-close-x" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body" id="modal-body">
            <span class="term-info term-line">// Terminal siap. Pilih IP perangkat untuk memulai ping.</span>
        </div>
        <div class="modal-footer">
            <div class="modal-status" id="modal-status"><strong>Ready</strong></div>
            <div class="modal-actions">
                <button class="modal-btn danger"  id="btn-stop-ping" onclick="stopPing()"    style="display:none">■ Stop</button>
                <button class="modal-btn primary" id="btn-repng"     onclick="rePingModal()" style="display:none">↺ Ping Ulang</button>
                <button class="modal-btn"         onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('aset.modal-tambah-toko')
@include('aset.modal-edit-toko')
@include('aset.modal-delete-toko')

<div class="kt">

{{-- Session alerts --}}
@if(session('success'))
<div class="kt-alert success">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="kt-alert error">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
@endif

{{-- ── HERO ──────────────────────────────────── --}}
<div class="kt-hero">
    <div>
        <h1 class="kt-title">Koneksi <span>Toko</span></h1>
        <p class="kt-sub">Network Monitor Toko · {{ now()->format('d M Y') }}</p>
    </div>

    <div class="kt-stats">
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
<div class="kt-toolbar">
    <div class="kt-search-wrap">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="kt-q" placeholder="Cari nama toko, kode, IP…">
    </div>

    <button class="kt-filter active" data-f="all">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M6 12h12M9 18h6"/></svg>
        Semua
    </button>
    <button class="kt-filter" data-f="online">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/></svg>
        Online
    </button>
    <button class="kt-filter" data-f="offline">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="1" y1="1" x2="23" y2="23"/><path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55M5 12.55a10.94 10.94 0 0 1 5.17-2.39"/></svg>
        Offline
    </button>

    <button class="kt-scan-btn" id="scan-btn">
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

    <button class="kt-add-btn" onclick="openModalTambahToko()">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:13px;height:13px">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Toko
    </button>
</div>

{{-- Progress bar --}}
<div class="kt-prog-wrap" id="kt-prog-wrap">
    <div class="kt-prog-bar" id="kt-prog-bar"></div>
</div>

{{-- ── TABLE ─────────────────────────────────── --}}
<div class="kt-table-wrap">
<table class="kt-table">
    <thead>
        <tr>
            <th style="width:40px">#</th>
            <th style="width:120px">Ping CCTV</th>
            <th>Nama Toko</th>
            <th>IP Perangkat</th>
            <th style="width:140px">Latency CCTV</th>
            <th style="width:120px">Aksi</th>
        </tr>
    </thead>
    <tbody id="kt-tbody">

    @php $rowNum = 1; @endphp

    @forelse($devices as $dev)
    <tr class="dev-row"
        id="row-{{ $dev->id_toko }}"
        data-id="{{ $dev->id_toko }}"
        data-ip="{{ $dev->ip_cctv }}"
        data-nama="{{ strtolower($dev->nama_toko ?? '') }}"
        data-kode="{{ strtolower($dev->kode_toko ?? '') }}"
        data-ping-status="pending"
        data-json="{{ json_encode([
            'id_toko'      => $dev->id_toko,
            'nama_toko'    => $dev->nama_toko,
            'kode_toko'    => $dev->kode_toko,
            'ip_cctv'      => $dev->ip_cctv,
            'ip_station_1' => $dev->ip_station_1,
            'ip_station_2' => $dev->ip_station_2,
            'ip_station_3' => $dev->ip_station_3,
            'ip_station_4' => $dev->ip_station_4,
            'ip_station_5' => $dev->ip_station_5,
            'ip_stb'       => $dev->ip_stb,
        ]) }}">

        {{-- No --}}
        <td class="td-no">{{ $rowNum++ }}</td>

        {{-- Ping status CCTV --}}
        <td style="vertical-align: middle; padding-top: 14px;">
            <span class="st-badge pending" id="badge-{{ $dev->id_toko }}">
                <span class="st-dot"></span>
                <span id="btxt-{{ $dev->id_toko }}">Pending</span>
            </span>
        </td>

        {{-- Nama & Kode --}}
        <td>
            <div class="td-name">{{ $dev->nama_toko ?: '—' }}</div>
            @if($dev->kode_toko)
                <div class="td-sub">{{ $dev->kode_toko }}</div>
            @endif
        </td>

        {{-- IP Grid --}}
        <td>
            <div class="ip-grid">
                {{-- CCTV --}}
                <div class="ip-row">
                    <span class="ip-lbl">CCTV</span>
                    @if($dev->ip_cctv)
                        <span class="ip-val">{{ $dev->ip_cctv }}</span>
                        <span class="ip-ping-badge pending"
                              id="ibadge-cctv-{{ $dev->id_toko }}"
                              onclick="openPingModal({{ $dev->id_toko }}, '{{ $dev->ip_cctv }}', 'CCTV · {{ $dev->nama_toko }}')">
                            <span class="ip-ping-dot"></span>
                            <span id="ibtxt-cctv-{{ $dev->id_toko }}">ping</span>
                        </span>
                    @else
                        <span class="ip-val empty">—</span>
                    @endif
                </div>

                {{-- STB --}}
                <div class="ip-row">
                    <span class="ip-lbl">STB</span>
                    @if($dev->ip_stb)
                        <span class="ip-val">{{ $dev->ip_stb }}</span>
                        <span class="ip-ping-badge pending"
                              id="ibadge-stb-{{ $dev->id_toko }}"
                              onclick="openPingModal({{ $dev->id_toko }}, '{{ $dev->ip_stb }}', 'STB · {{ $dev->nama_toko }}')">
                            <span class="ip-ping-dot"></span>
                            <span id="ibtxt-stb-{{ $dev->id_toko }}">ping</span>
                        </span>
                    @else
                        <span class="ip-val empty">—</span>
                    @endif
                </div>

                {{-- Station 1–5 --}}
                @foreach([1,2,3,4,5] as $s)
                @php $ipKey = 'ip_station_' . $s; @endphp
                <div class="ip-row">
                    <span class="ip-lbl">Station {{ $s }}</span>
                    @if($dev->$ipKey)
                        <span class="ip-val">{{ $dev->$ipKey }}</span>
                        <span class="ip-ping-badge pending"
                              id="ibadge-st{{ $s }}-{{ $dev->id_toko }}"
                              onclick="openPingModal({{ $dev->id_toko }}, '{{ $dev->$ipKey }}', 'Station {{ $s }} · {{ $dev->nama_toko }}')">
                            <span class="ip-ping-dot"></span>
                            <span id="ibtxt-st{{ $s }}-{{ $dev->id_toko }}">ping</span>
                        </span>
                    @else
                        <span class="ip-val empty">—</span>
                    @endif
                </div>
                @endforeach
            </div>
        </td>

        {{-- Latency CCTV --}}
        <td style="vertical-align: middle;">
            <div class="lat-wrap">
                <div class="lat-track">
                    <div class="lat-fill" id="lbar-{{ $dev->id_toko }}"></div>
                </div>
                <span class="lat-val" id="lval-{{ $dev->id_toko }}">—</span>
            </div>
        </td>

        {{-- Actions --}}
        <td>
            <div class="action-group">
                <button class="act-btn act-scan" title="Scan semua IP toko ini"
                        onclick="scanOneToko({{ $dev->id_toko }})">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10"/>
                    </svg>
                    Scan
                </button>
                <button class="act-btn act-edit" title="Edit data toko"
                        onclick="openModalEditToko(JSON.parse(this.closest('tr').dataset.json))">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
                <button class="act-btn act-del" title="Hapus data toko"
                        onclick="openModalDeleteToko({{ $dev->id_toko }}, '{{ addslashes($dev->nama_toko) }}')">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                    </svg>
                </button>
            </div>
        </td>
    </tr>

    @empty
    <tr class="kt-empty">
        <td colspan="6">
            Tidak ada data toko. Klik <strong>Tambah Toko</strong> untuk memulai.
        </td>
    </tr>
    @endforelse

    </tbody>
</table>
</div>

<div class="kt-footer-info" id="kt-footer-info"></div>
</div>{{-- .kt --}}

<script>
/* ══════════════════════════════════════════════
   KONEKSI TOKO MONITOR — JS
══════════════════════════════════════════════ */
const PING_URL    = '/koneksitoko/ping';
const CSRF        = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const BATCH       = 5;
const PING_ROUNDS = 4;

// Kumpulkan semua baris toko
const allRows = Array.from(document.querySelectorAll('.dev-row'));
let activeFilter = 'all';
let scanning     = false;
let counters     = { online: 0, offline: 0, pending: allRows.length };

/* ── Update stat pills ──────────────────────── */
function updateStats() {
    document.getElementById('cnt-on').textContent   = counters.online;
    document.getElementById('cnt-off').textContent  = counters.offline;
    document.getElementById('cnt-pend').textContent = counters.pending;
}

/* ── Set status baris (berdasarkan ping CCTV) ── */
function setRowStatus(id, status, latency) {
    const row   = document.getElementById(`row-${id}`);
    const badge = document.getElementById(`badge-${id}`);
    const btxt  = document.getElementById(`btxt-${id}`);
    const lbar  = document.getElementById(`lbar-${id}`);
    const lval  = document.getElementById(`lval-${id}`);
    if (!row) return;

    const prev = row.dataset.pingStatus;
    if (counters[prev] !== undefined) counters[prev] = Math.max(0, counters[prev] - 1);

    row.dataset.pingStatus = status;
    badge.className        = `st-badge ${status}`;
    btxt.textContent       = status === 'online' ? 'Online' : status === 'offline' ? 'Offline' : 'Pending';
    counters[status]       = (counters[status] ?? 0) + 1;

    if (latency !== null && latency !== undefined) {
        lval.textContent = latency + ' ms';
        const pct        = Math.min(100, (latency / 150) * 100);
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

/* ── Set status badge per-IP di dalam row ───── */
function setIpBadge(badgeId, txtId, status, latency) {
    const badge = document.getElementById(badgeId);
    const txt   = document.getElementById(txtId);
    if (!badge || !txt) return;

    badge.className = `ip-ping-badge ${status}`;
    if (status === 'online')  txt.textContent = latency ? latency + 'ms' : 'online';
    if (status === 'offline') txt.textContent = 'offline';
    if (status === 'pending') txt.textContent = 'ping';
}

/* ── Ping satu IP, update badge + row status ── */
async function doPingOne(ip) {
    const r    = await fetch(PING_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ ip }),
    });
    return await r.json();
}

/* ── Scan semua IP satu toko ────────────────── */
async function scanOneToko(id) {
    const row  = document.getElementById(`row-${id}`);
    if (!row) return;

    const data = JSON.parse(row.dataset.json);
    const ipMap = {
        cctv: data.ip_cctv,
        stb:  data.ip_stb,
        st1:  data.ip_station_1,
        st2:  data.ip_station_2,
        st3:  data.ip_station_3,
        st4:  data.ip_station_4,
        st5:  data.ip_station_5,
    };

    // Reset semua badge ke pending
    Object.keys(ipMap).forEach(key => {
        setIpBadge(`ibadge-${key}-${id}`, `ibtxt-${key}-${id}`, 'pending', null);
    });
    setRowStatus(id, 'pending', null);

    // Ping CCTV dulu (sebagai representasi row)
    if (ipMap.cctv) {
        try {
            const res = await doPingOne(ipMap.cctv);
            setRowStatus(id, res.online ? 'online' : 'offline', res.latency);
            setIpBadge(`ibadge-cctv-${id}`, `ibtxt-cctv-${id}`, res.online ? 'online' : 'offline', res.latency);
        } catch {
            setRowStatus(id, 'offline', null);
            setIpBadge(`ibadge-cctv-${id}`, `ibtxt-cctv-${id}`, 'offline', null);
        }
    }

    // Ping sisanya secara paralel
    const otherKeys = ['stb','st1','st2','st3','st4','st5'];
    await Promise.all(otherKeys.map(async key => {
        const ip = ipMap[key === 'stb' ? 'stb' : 'ip_station_' + key.replace('st','')];
        const realIp = key === 'stb' ? ipMap.stb : ipMap['st' + key.replace('st','')];
        if (!realIp) return;
        try {
            const res = await doPingOne(realIp);
            setIpBadge(`ibadge-${key}-${id}`, `ibtxt-${key}-${id}`, res.online ? 'online' : 'offline', res.latency);
        } catch {
            setIpBadge(`ibadge-${key}-${id}`, `ibtxt-${key}-${id}`, 'offline', null);
        }
    }));

    showToast(`Scan selesai: ${data.nama_toko}`, 'ok');
}

/* ── Scan Semua Toko ────────────────────────── */
async function scanAll() {
    if (scanning) return;
    scanning = true;

    const btn  = document.getElementById('scan-btn');
    const prog = document.getElementById('kt-prog-wrap');
    const bar  = document.getElementById('kt-prog-bar');

    btn.classList.add('loading'); btn.disabled = true;
    prog.classList.add('show');

    // Reset semua ke pending
    allRows.forEach(r => setRowStatus(r.dataset.id, 'pending', null));
    counters = { online: 0, offline: 0, pending: allRows.length };
    updateStats();

    const total = allRows.length; let done = 0;

    for (let i = 0; i < allRows.length; i += BATCH) {
        const batch = allRows.slice(i, i + BATCH);
        await Promise.all(batch.map(async row => {
            const id   = row.dataset.id;
            const data = JSON.parse(row.dataset.json);

            // ── Ping CCTV (penentu status baris & progress) ──
            if (data.ip_cctv) {
                try {
                    const res = await doPingOne(data.ip_cctv);
                    setRowStatus(id, res.online ? 'online' : 'offline', res.latency);
                    setIpBadge(`ibadge-cctv-${id}`, `ibtxt-cctv-${id}`,
                        res.online ? 'online' : 'offline', res.latency);
                } catch {
                    setRowStatus(id, 'offline', null);
                    setIpBadge(`ibadge-cctv-${id}`, `ibtxt-cctv-${id}`, 'offline', null);
                }
            } else {
                setRowStatus(id, 'offline', null);
            }

            // ── Ping STB & Station (fire-and-forget, tidak menahan progress) ──
            const others = {
                stb: data.ip_stb,
                st1: data.ip_station_1,
                st2: data.ip_station_2,
                st3: data.ip_station_3,
                st4: data.ip_station_4,
                st5: data.ip_station_5,
            };
            Object.entries(others).forEach(([key, ip]) => {
                if (!ip) return;
                doPingOne(ip)
                    .then(res => setIpBadge(
                        `ibadge-${key}-${id}`, `ibtxt-${key}-${id}`,
                        res.online ? 'online' : 'offline', res.latency))
                    .catch(() => setIpBadge(
                        `ibadge-${key}-${id}`, `ibtxt-${key}-${id}`, 'offline', null));
            });

            done++;
            bar.style.width = Math.round((done / total) * 100) + '%';
        }));
    }

    btn.classList.remove('loading'); btn.disabled = false; scanning = false;

    const now = new Date().toLocaleTimeString('id-ID');
    document.getElementById('kt-footer-info').innerHTML =
        `Scan selesai &nbsp;·&nbsp; <strong>${now}</strong> &nbsp;·&nbsp; ` +
        `<strong style="color:#16a34a">${counters.online}</strong> online &nbsp;·&nbsp; ` +
        `<strong style="color:#dc2626">${counters.offline}</strong> offline`;

    setTimeout(() => { prog.classList.remove('show'); bar.style.width = '0%'; }, 2000);
}

/* ══════════════════════════════════════════════
   PING MODAL (terminal style)
══════════════════════════════════════════════ */
let currentPingId = null;
let currentPingIp = null;
let pingRunning   = false;
let pingCount     = 0;

function openPingModal(id, ip, label) {
    currentPingId = id;
    currentPingIp = ip;
    document.getElementById('modal-title').textContent = `PING — ${ip}  ·  ${label}`;
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ ip }),
            });
            const data = await r.json();
            const wall = Math.round(performance.now() - t0);

            if (data.online) {
                const ms = data.latency ?? wall;
                success++; totalMs += ms;
                addTermLine(`Reply from ${ip}: bytes=32 <span class="term-time">time=${ms}ms</span> TTL=128`, 'term-success');
            } else {
                fail++;
                addTermLine(`Request timeout for icmp_seq ${i}`, 'term-error');
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
    const el    = document.createElement('span');
    el.className = cls;
    el.innerHTML = html + '\n';
    const body  = document.getElementById('modal-body');
    body.appendChild(el);
    body.scrollTop = body.scrollHeight;
}

function sleep(ms) { return new Promise(r => setTimeout(r, ms)); }

/* ── Filter + Search ────────────────────────── */
function applyFilter() {
    const q = document.getElementById('kt-q').value.toLowerCase().trim();
    allRows.forEach(row => {
        const fOk = activeFilter === 'all' || row.dataset.pingStatus === activeFilter;
        const sOk = !q
            || row.dataset.nama.includes(q)
            || row.dataset.kode.includes(q)
            || (row.dataset.ip && row.dataset.ip.includes(q));
        row.style.display = (fOk && sOk) ? '' : 'none';
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

document.getElementById('kt-q').addEventListener('input', applyFilter);
document.getElementById('scan-btn').addEventListener('click', scanAll);
document.getElementById('ping-modal').addEventListener('click', e => {
    if (e.target === document.getElementById('ping-modal')) closeModal();
});

/* ── Toast ───────────────────────────────────── */
function showToast(msg, type = '') {
    const el    = document.createElement('div');
    el.className = `toast ${type}`;
    el.textContent = msg;
    document.getElementById('kt-toast').appendChild(el);
    setTimeout(() => el.remove(), 4000);
}

/* ── Auto scan on load ───────────────────────── */
window.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('ping-modal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        requestAnimationFrame(() => {
            modal.style.opacity = '';
            modal.style.pointerEvents = '';
        });
    }
    setTimeout(scanAll, 900);
});
</script>
@endsection