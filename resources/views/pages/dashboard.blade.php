{{-- dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap');

:root {
    --surface:   rgba(255,255,255,0.82);
    --border:    rgba(148,163,184,0.18);
    --border-h:  rgba(59,130,246,0.30);
    --accent:    #2563eb;
    --accent2:   #06b6d4;
    --green:     #16a34a;
    --red:       #dc2626;
    --amber:     #d97706;
    --text-1:    #0f172a;
    --text-2:    #334155;
    --text-3:    #64748b;
    --text-4:    #94a3b8;
    --mono:      'JetBrains Mono', monospace;
    --sans:      'DM Sans', sans-serif;
    --display:   'Syne', sans-serif;
    --shadow-sm: 0 1px 4px rgba(15,23,42,0.07), 0 1px 2px rgba(15,23,42,0.04);
    --shadow-md: 0 4px 20px rgba(15,23,42,0.09), 0 1px 4px rgba(15,23,42,0.05);
    --shadow-lg: 0 12px 48px rgba(15,23,42,0.11), 0 4px 12px rgba(15,23,42,0.06);
    --shadow-xl: 0 24px 64px rgba(15,23,42,0.13), 0 8px 20px rgba(15,23,42,0.07);
}

.db * { box-sizing: border-box; }
.db { font-family: var(--sans); color: var(--text-1); }

/* ══ HERO ══════════════════════════════════════ */
.db-hero {
    display: flex; align-items: flex-end; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 32px;
    animation: dbSlide 0.55s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes dbSlide { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:none} }

.db-eyebrow {
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    letter-spacing: .16em; text-transform: uppercase;
    color: var(--accent2); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
}
.db-eyebrow-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--accent2);
    box-shadow: 0 0 0 3px rgba(6,182,212,0.22);
    animation: epulse 2.5s infinite;
}
@keyframes epulse {
    0%,100%{box-shadow:0 0 0 3px rgba(6,182,212,0.22)}
    50%{box-shadow:0 0 0 8px rgba(6,182,212,0.06)}
}
.db-title {
    font-family: var(--display); font-size: 2.2rem; font-weight: 800;
    color: var(--text-1); letter-spacing: -.045em; line-height: 1.05;
}
.db-title span {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.db-sub { font-family: var(--mono); font-size: .67rem; color: var(--text-4); margin-top: 6px; letter-spacing: .04em; }

.db-clock-widget {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(226,232,240,0.9);
    border-radius: 16px; padding: 14px 20px;
    box-shadow: var(--shadow-md);
    text-align: right; min-width: 160px;
}
.db-clock-label { font-family: var(--mono); font-size: .56rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--text-4); margin-bottom: 4px; }
.db-clock-time  { font-family: var(--display); font-size: 1.6rem; font-weight: 800; color: var(--text-1); line-height: 1; }
.db-clock-date  { font-family: var(--mono); font-size: .62rem; color: var(--text-3); margin-top: 3px; }

/* ══ ALERT ═══════════════════════════════════ */
.under-alert {
    background: linear-gradient(135deg, rgba(220,38,38,0.07), rgba(220,38,38,0.04));
    border: 1px solid rgba(220,38,38,0.2);
    border-radius: 14px; padding: 14px 18px;
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 24px;
    animation: dbSlide 0.4s cubic-bezier(0.16,1,0.3,1) both;
    box-shadow: 0 2px 12px rgba(220,38,38,0.08);
}
.under-alert-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(220,38,38,0.1);
    display: flex; align-items: center; justify-content: center;
}
.under-alert-icon svg { width: 18px; height: 18px; stroke: #dc2626; }
.under-alert-text { font-size: .8rem; font-weight: 600; color: #991b1b; line-height: 1.5; flex: 1; }
.under-alert-text strong { font-weight: 800; color: #dc2626; }
.under-alert-link {
    flex-shrink: 0;
    font-family: var(--mono); font-size: .62rem; font-weight: 700;
    color: #dc2626; text-decoration: none;
    background: rgba(220,38,38,0.08); border: 1px solid rgba(220,38,38,0.2);
    border-radius: 8px; padding: 6px 12px;
    transition: all .2s;
}
.under-alert-link:hover { background: rgba(220,38,38,0.15); }

/* ══ SECTION HEADER ══════════════════════════ */
.section-hdr {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px; flex-wrap: wrap; gap: 8px;
}
.section-title-wrap { display: flex; align-items: center; gap: 10px; }
.section-icon {
    width: 34px; height: 34px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.icon-blue { background: linear-gradient(135deg,#2563eb,#60a5fa); box-shadow: 0 4px 14px rgba(37,99,235,0.30); }
.icon-cyan { background: linear-gradient(135deg,#0891b2,#06b6d4); box-shadow: 0 4px 14px rgba(6,182,212,0.30); }
.section-icon svg { width: 16px; height: 16px; stroke: #fff; }
.section-label { font-family: var(--display); font-size: 1rem; font-weight: 700; color: var(--text-1); }
.section-count {
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    background: rgba(37,99,235,0.08); color: var(--accent);
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: 20px; padding: 2px 9px;
}
.section-link {
    font-family: var(--mono); font-size: .63rem; font-weight: 700;
    text-decoration: none; letter-spacing: .04em;
    border-radius: 8px; padding: 5px 12px;
    border: 1px solid; transition: all .2s;
}
.section-link-blue { color: var(--accent); border-color: rgba(37,99,235,0.2); background: rgba(37,99,235,0.05); }
.section-link-blue:hover { background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.35); }
.section-link-cyan { color: #0891b2; border-color: rgba(6,182,212,0.2); background: rgba(6,182,212,0.05); }
.section-link-cyan:hover { background: rgba(6,182,212,0.1); border-color: rgba(6,182,212,0.35); }

/* ══ STAT CARDS ══════════════════════════════ */
.stat-grid { display: grid; gap: 14px; }
.stat-grid-5 { grid-template-columns: repeat(5,1fr); }
.stat-grid-4 { grid-template-columns: repeat(4,1fr); }
.stat-grid.anim { animation: dbFade 0.5s 0.1s cubic-bezier(0.16,1,0.3,1) both; }
@keyframes dbFade { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }

.stat-card {
    background: rgba(255,255,255,0.90);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid rgba(226,232,240,0.85);
    border-radius: 16px; padding: 18px 20px 16px;
    box-shadow: var(--shadow-md);
    transition: transform .22s, box-shadow .22s, border-color .22s;
    position: relative; overflow: hidden; cursor: default;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-xl); border-color: var(--border-h); }
.stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 16px 16px 0 0;
}
.sc-blue::before  { background: linear-gradient(90deg,#1d4ed8,#60a5fa); }
.sc-green::before { background: linear-gradient(90deg,#15803d,#22c55e); }
.sc-amber::before { background: linear-gradient(90deg,#b45309,#f59e0b); }
.sc-red::before   { background: linear-gradient(90deg,#b91c1c,#f87171); }
.sc-cyan::before  { background: linear-gradient(90deg,#0e7490,#22d3ee); }
.stat-card::after {
    content:''; position:absolute; bottom:-20px; right:-20px;
    width:90px; height:90px; border-radius:50%; pointer-events:none;
}
.sc-blue::after  { background:rgba(37,99,235,0.05); }
.sc-green::after { background:rgba(22,163,74,0.05); }
.sc-amber::after { background:rgba(217,119,6,0.05); }
.sc-red::after   { background:rgba(220,38,38,0.05); }
.sc-cyan::after  { background:rgba(6,182,212,0.05); }

.sc-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
.sc-icon { width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.sc-icon svg { width: 18px; height: 18px; }
.sc-icon-blue  { background: rgba(37,99,235,0.10);  color: #2563eb; }
.sc-icon-green { background: rgba(22,163,74,0.10);  color: #15803d; }
.sc-icon-amber { background: rgba(217,119,6,0.10);  color: #b45309; }
.sc-icon-red   { background: rgba(220,38,38,0.10);  color: #b91c1c; }
.sc-icon-cyan  { background: rgba(6,182,212,0.10);  color: #0e7490; }

.sc-badge {
    font-family: var(--mono); font-size: .58rem; font-weight: 700;
    padding: 3px 8px; border-radius: 20px; letter-spacing: .04em;
}
.sc-badge-up   { background: rgba(22,163,74,0.1);    color: #15803d; border: 1px solid rgba(22,163,74,0.2); }
.sc-badge-down { background: rgba(220,38,38,0.1);    color: #b91c1c; border: 1px solid rgba(220,38,38,0.2); }
.sc-badge-neu  { background: rgba(100,116,139,0.08); color: #475569; border: 1px solid rgba(100,116,139,0.15); }
.sc-badge-warn { background: rgba(217,119,6,0.1);    color: #b45309; border: 1px solid rgba(217,119,6,0.2); }
.sc-badge-cyan { background: rgba(6,182,212,0.1);    color: #0e7490; border: 1px solid rgba(6,182,212,0.2); }

.sc-val   { font-family: var(--display); font-size: 2rem; font-weight: 800; color: var(--text-1); line-height: 1; margin-bottom: 4px; }
.sc-label { font-size: .78rem; font-weight: 600; color: var(--text-2); }
.sc-sub   { font-family: var(--mono); font-size: .6rem; color: var(--text-4); margin-top: 3px; }

.sc-bar-wrap  { margin-top: 10px; }
.sc-bar-track { height: 6px; border-radius: 6px; background: rgba(226,232,240,0.8); overflow: hidden; }
.sc-bar-fill  { height: 100%; border-radius: 6px; transition: width 1.2s cubic-bezier(0.34,1.56,0.64,1); }
.fill-green { background: linear-gradient(90deg,#22c55e,#15803d); }
.fill-red   { background: linear-gradient(90deg,#f87171,#b91c1c); }
.sc-bar-meta { display: flex; justify-content: flex-end; margin-top: 4px; font-family: var(--mono); font-size: .58rem; color: var(--text-4); }

/* ══ DIVIDER ══════════════════════════════════ */
.db-divider { height: 1px; background: linear-gradient(90deg,transparent,rgba(148,163,184,0.25),transparent); margin: 28px 0; }

/* ══ MAIN GRID ════════════════════════════════ */
.db-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 18px; margin-top: 24px;
    animation: dbFade 0.5s 0.15s cubic-bezier(0.16,1,0.3,1) both;
}

/* ══ CARD ═════════════════════════════════════ */
.db-card {
    background: rgba(255,255,255,0.90);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid rgba(226,232,240,0.85);
    border-radius: 18px; overflow: hidden;
    box-shadow: var(--shadow-lg);
}
.db-card-hdr {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(226,232,240,0.7);
    background: linear-gradient(135deg,rgba(248,250,252,0.9),rgba(255,255,255,0.7));
    flex-wrap: wrap; gap: 8px;
}
.db-card-title {
    display: flex; align-items: center; gap: 8px;
    font-size: .88rem; font-weight: 700; color: var(--text-1);
    font-family: var(--display);
}

/* ══ TABLE ════════════════════════════════════ */
.db-table { width: 100%; border-collapse: collapse; font-size: .81rem; }
.db-table thead tr { background: rgba(248,250,252,0.7); border-bottom: 1px solid rgba(226,232,240,0.8); }
.db-table thead th {
    padding: 11px 16px;
    font-family: var(--mono); font-size: .58rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase; color: var(--text-4);
    text-align: left; white-space: nowrap;
}
.db-table tbody tr { border-bottom: 1px solid rgba(226,232,240,0.45); transition: background .15s; }
.db-table tbody tr:last-child { border-bottom: none; }
.db-table tbody tr:hover { background: rgba(239,246,255,0.6); }
.db-table tbody td { padding: 11px 16px; vertical-align: middle; }

.td-num  { font-family: var(--mono); font-size: .65rem; color: var(--text-4); width: 36px; }
.td-ip   { font-family: var(--mono); font-size: .74rem; font-weight: 700; color: #1d4ed8; }
.td-name { font-size: .82rem; font-weight: 600; color: var(--text-1); }
.td-dept {
    font-family: var(--mono); font-size: .62rem; font-weight: 700;
    background: rgba(99,102,241,0.08); color: #4f46e5;
    border: 1px solid rgba(99,102,241,0.14);
    border-radius: 6px; padding: 2px 8px; white-space: nowrap; display: inline-block;
}
.st-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-family: var(--mono); font-size: .6rem; font-weight: 700;
    text-transform: uppercase; white-space: nowrap;
}
.st-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.st-bagus { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.st-bagus .st-dot { background: #16a34a; }
.st-aman  { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
.st-aman  .st-dot { background: #d97706; }
.st-under { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.st-under .st-dot { background: #ef4444; animation: blink 1.2s infinite; }
@keyframes blink { 0%,100%{opacity:1}50%{opacity:0.25} }

/* ══ SIDE PANEL ═══════════════════════════════ */
.side-panel { display: flex; flex-direction: column; gap: 18px; }

.action-list { display: flex; flex-direction: column; gap: 6px; padding: 14px; }
.action-item {
    display: flex; align-items: center; gap: 13px;
    padding: 12px 14px; border-radius: 12px;
    text-decoration: none; cursor: pointer; background: none;
    border: 1px solid transparent; width: 100%; text-align: left;
    transition: transform .18s, background .18s, border-color .18s, box-shadow .18s;
    font-family: var(--sans);
}
.action-item:hover { transform: translateX(4px); box-shadow: 0 3px 12px rgba(0,0,0,0.07); }
.ai-icon {
    width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: transform .18s;
}
.action-item:hover .ai-icon { transform: scale(1.08); }
.ai-icon svg { width: 17px; height: 17px; }
.ai-label { font-size: .83rem; font-weight: 700; color: var(--text-1); line-height: 1.2; }
.ai-sub   { font-size: .68rem; color: var(--text-4); margin-top: 2px; }
.ai-arrow { margin-left: auto; font-size: .8rem; color: var(--text-4); opacity: 0; transition: opacity .18s, transform .18s; }
.action-item:hover .ai-arrow { opacity: 1; transform: translateX(3px); }

.ai-green { background:rgba(5,150,105,0.06); border-color:rgba(5,150,105,0.15); }
.ai-green:hover { background:rgba(5,150,105,0.11); border-color:rgba(5,150,105,0.28); }
.ai-green .ai-icon { background:linear-gradient(135deg,#059669,#10b981); color:#fff; box-shadow:0 4px 12px rgba(5,150,105,0.32); }

.ai-blue { background:rgba(37,99,235,0.05); border-color:rgba(37,99,235,0.14); }
.ai-blue:hover { background:rgba(37,99,235,0.10); border-color:rgba(37,99,235,0.28); }
.ai-blue .ai-icon { background:linear-gradient(135deg,#1d4ed8,#60a5fa); color:#fff; box-shadow:0 4px 12px rgba(37,99,235,0.30); }

.ai-slate { background:rgba(71,85,105,0.05); border-color:rgba(71,85,105,0.13); }
.ai-slate:hover { background:rgba(71,85,105,0.09); border-color:rgba(71,85,105,0.22); }
.ai-slate .ai-icon { background:linear-gradient(135deg,#334155,#64748b); color:#fff; box-shadow:0 4px 12px rgba(71,85,105,0.22); }

.ai-cyan { background:rgba(6,182,212,0.05); border-color:rgba(6,182,212,0.14); }
.ai-cyan:hover { background:rgba(6,182,212,0.10); border-color:rgba(6,182,212,0.28); }
.ai-cyan .ai-icon { background:linear-gradient(135deg,#0891b2,#06b6d4); color:#fff; box-shadow:0 4px 12px rgba(6,182,212,0.28); }

/* ══ NETWORK LIST ══════════════════════════════ */
.net-list { max-height: 268px; overflow-y: auto; }
.net-list::-webkit-scrollbar { width: 3px; }
.net-list::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.25); border-radius: 3px; }

.net-row {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 18px; border-bottom: 1px solid rgba(226,232,240,0.4);
    transition: background .13s;
}
.net-row:last-child { border-bottom: none; }
.net-row:hover { background: rgba(239,246,255,0.6); }
.net-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; background: #cbd5e1;
}
.net-dot.online  { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.16); animation: ndp 2s infinite; }
.net-dot.offline { background: #f87171; }
.net-dot.pending { background: #fbbf24; animation: ndp 1.4s infinite; }
@keyframes ndp { 0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.6);opacity:.45} }

.net-ip   { font-family: var(--mono); font-size: .72rem; font-weight: 700; color: var(--text-2); flex: 1; }
.net-name { font-size: .7rem; color: var(--text-3); max-width: 96px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.net-lat  { font-family: var(--mono); font-size: .62rem; color: var(--text-4); min-width: 44px; text-align: right; }

.rescan-btn {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px;
    background: linear-gradient(135deg,#1d4ed8,#0891b2);
    border: none; border-radius: 0 0 18px 18px;
    font-family: var(--mono); font-size: .67rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #fff; cursor: pointer;
    transition: opacity .2s, filter .2s;
}
.rescan-btn:hover:not(:disabled) { filter: brightness(1.08); }
.rescan-btn:disabled { opacity: .5; cursor: not-allowed; }
.rescan-spin { display: none; width: 12px; height: 12px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: rot .7s linear infinite; }
@keyframes rot { to{transform:rotate(360deg)} }
.rescan-btn.loading .rescan-label { display: none; }
.rescan-btn.loading .rescan-spin  { display: block; }

.db-prog-wrap { height: 3px; background: rgba(37,99,235,.07); overflow: hidden; display: none; }
.db-prog-wrap.show { display: block; }
.db-prog-bar { height: 100%; background: linear-gradient(90deg,#2563eb,#06b6d4); width: 0%; transition: width .25s ease; }

.scan-badge {
    font-family: var(--mono); font-size: .58rem; font-weight: 700;
    border-radius: 20px; padding: 3px 9px;
    background: rgba(148,163,184,.1); color: var(--text-4);
    border: 1px solid rgba(148,163,184,.18);
    transition: all .3s;
}

.db-empty { text-align: center; padding: 48px 20px; color: var(--text-4); font-size: .8rem; }

@media (max-width: 1100px) {
    .stat-grid-5 { grid-template-columns: repeat(3,1fr); }
    .stat-grid-4 { grid-template-columns: repeat(2,1fr); }
    .db-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .stat-grid-5, .stat-grid-4 { grid-template-columns: repeat(2,1fr); }
    .db-title { font-size: 1.75rem; }
    .db-clock-widget { display: none; }
}
</style>

<div class="db">

{{-- ══ HERO ═══════════════════════════════════ --}}
<div class="db-hero">
    <div>
        <div class="db-eyebrow">
            <span class="db-eyebrow-dot"></span>
            MasterIP · Dashboard
        </div>
        <h1 class="db-title">Selamat Datang,<br><span>{{ session('user_nama', 'User') }}</span></h1>
        <p class="db-sub">{{ now()->isoFormat('dddd, D MMMM YYYY') }} &nbsp;·&nbsp; Ringkasan sistem & jaringan</p>
    </div>
    <div class="db-clock-widget">
        <div class="db-clock-label">Waktu Saat Ini</div>
        <div class="db-clock-time" id="db-clock">--:--:--</div>
        <div class="db-clock-date">{{ now()->format('d / m / Y') }}</div>
    </div>
</div>

{{-- ══ ALERT UNDER ═════════════════════════════ --}}
@if($underCount > 0)
<div class="under-alert">
    <div class="under-alert-icon">
        <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
    </div>
    <div class="under-alert-text">
        Terdapat <strong>{{ $underCount }} komputer</strong> berstatus <strong>UNDER</strong> yang memerlukan penanganan segera.
    </div>
    <a href="/spekpc?sort=status&direction=asc" class="under-alert-link">Lihat →</a>
</div>
@endif

{{-- ══ SECTION: SPEK PC ════════════════════════ --}}
<div class="section-hdr">
    <div class="section-title-wrap">
        <div class="section-icon icon-blue">
            <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
            </svg>
        </div>
        <span class="section-label">Spesifikasi PC</span>
        <span class="section-count">{{ $totalPc }} unit</span>
    </div>
    <a href="/spekpc" class="section-link section-link-blue">Lihat Semua →</a>
</div>

<div class="stat-grid stat-grid-5 anim">

    <div class="stat-card sc-blue">
        <div class="sc-header">
            <div class="sc-icon sc-icon-blue">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-neu">Total</span>
        </div>
        <div class="sc-val">{{ $totalPc }}</div>
        <div class="sc-label">Jumlah PC</div>
        <div class="sc-sub">Semua unit terdaftar</div>
    </div>

    <div class="stat-card sc-green">
        <div class="sc-header">
            <div class="sc-icon sc-icon-green">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-up">✓ OK</span>
        </div>
        <div class="sc-val" style="color:#15803d">{{ $bagusCount }}</div>
        <div class="sc-label">Status BAGUS</div>
        <div class="sc-sub">Kondisi prima</div>
    </div>

    <div class="stat-card sc-amber">
        <div class="sc-header">
            <div class="sc-icon sc-icon-amber">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-warn">⚠ Pantau</span>
        </div>
        <div class="sc-val" style="color:#b45309">{{ $amanCount }}</div>
        <div class="sc-label">Status AMAN</div>
        <div class="sc-sub">Perlu dipantau</div>
    </div>

    <div class="stat-card sc-red">
        <div class="sc-header">
            <div class="sc-icon sc-icon-red">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-down">! Kritis</span>
        </div>
        <div class="sc-val" style="color:#b91c1c">{{ $underCount }}</div>
        <div class="sc-label">Status UNDER</div>
        <div class="sc-sub">Butuh penanganan</div>
    </div>

    <div class="stat-card sc-cyan">
        <div class="sc-header">
            <div class="sc-icon sc-icon-cyan">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-cyan">Dept</span>
        </div>
        <div class="sc-val" style="color:#0e7490">{{ $deptCount }}</div>
        <div class="sc-label">Departemen</div>
        <div class="sc-sub">Departemen aktif</div>
    </div>

</div>

<div class="db-divider"></div>

{{-- ══ SECTION: NETWORK ════════════════════════ --}}
<div class="section-hdr">
    <div class="section-title-wrap">
        <div class="section-icon icon-cyan">
            <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
        </div>
        <span class="section-label">Network Monitor</span>
        <span class="section-count" style="color:#0891b2;background:rgba(6,182,212,0.08);border-color:rgba(6,182,212,0.18);">{{ $totalIp }} IP</span>
    </div>
    <a href="/network" class="section-link section-link-cyan">Lihat Semua →</a>
</div>

<div class="stat-grid stat-grid-4 anim">

    <div class="stat-card sc-cyan">
        <div class="sc-header">
            <div class="sc-icon sc-icon-cyan">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-neu">Total</span>
        </div>
        <div class="sc-val" style="color:#0e7490">{{ $totalIp }}</div>
        <div class="sc-label">Total IP</div>
        <div class="sc-sub">Terdaftar di sistem</div>
    </div>

    <div class="stat-card sc-green">
        <div class="sc-header">
            <div class="sc-icon sc-icon-green">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-up" id="db-cnt-on">—</span>
        </div>
        <div class="sc-val" id="db-val-on" style="color:#15803d">—</div>
        <div class="sc-label">IP Online</div>
        <div class="sc-sub">Merespons ping</div>
        <div class="sc-bar-wrap">
            <div class="sc-bar-track"><div class="sc-bar-fill fill-green" id="db-bar-on" style="width:0%"></div></div>
            <div class="sc-bar-meta"><span id="db-pct-on">0%</span></div>
        </div>
    </div>

    <div class="stat-card sc-red">
        <div class="sc-header">
            <div class="sc-icon sc-icon-red">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="1" y1="1" x2="23" y2="23"/>
                    <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55M5 12.55a10.94 10.94 0 0 1 5.17-2.39"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-down" id="db-cnt-off">—</span>
        </div>
        <div class="sc-val" id="db-val-off" style="color:#b91c1c">—</div>
        <div class="sc-label">IP Offline</div>
        <div class="sc-sub">Tidak merespons</div>
        <div class="sc-bar-wrap">
            <div class="sc-bar-track"><div class="sc-bar-fill fill-red" id="db-bar-off" style="width:0%"></div></div>
            <div class="sc-bar-meta"><span id="db-pct-off">0%</span></div>
        </div>
    </div>

    <div class="stat-card sc-amber">
        <div class="sc-header">
            <div class="sc-icon sc-icon-amber">
                <svg fill="none" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <span class="sc-badge sc-badge-warn" id="db-cnt-pend">{{ $totalIp }}</span>
        </div>
        <div class="sc-val" id="db-val-pend" style="color:#b45309">{{ $totalIp }}</div>
        <div class="sc-label">Menunggu Scan</div>
        <div class="sc-sub">Belum di-ping</div>
    </div>

</div>

{{-- ══ MAIN GRID ════════════════════════════════ --}}
<div class="db-grid">

    {{-- TABLE --}}
    <div class="db-card">
        <div class="db-card-hdr">
            <div class="db-card-title">
                <svg width="16" height="16" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
                Data PC Terbaru
            </div>
            <a href="/spekpc" class="section-link section-link-blue" style="font-size:.6rem;">Lihat Semua</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>#</th><th>IP Address</th><th>Nama</th><th>Dept</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPc as $i => $item)
                    <tr>
                        <td class="td-num">{{ $i+1 }}</td>
                        <td><span class="td-ip">{{ $item->ip }}</span></td>
                        <td><span class="td-name">{{ $item->nama ?: '—' }}</span></td>
                        <td><span class="td-dept">{{ $item->dept ?: '—' }}</span></td>
                        <td>
                            @php
                                $st  = strtolower($item->status);
                                $cls = $st === 'bagus' ? 'st-bagus' : ($st === 'aman' ? 'st-aman' : 'st-under');
                            @endphp
                            <span class="st-pill {{ $cls }}">
                                <span class="st-dot"></span>{{ strtoupper($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="db-empty">Belum ada data PC</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SIDE PANEL --}}
    <div class="side-panel">

        {{-- QUICK ACTIONS --}}
        <div class="db-card">
            <div class="db-card-hdr">
                <div class="db-card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                    Aksi Cepat
                </div>
            </div>
            <div class="action-list">

                <button type="button" onclick="dbOpenTambah()" class="action-item ai-green">
                    <div class="ai-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div><div class="ai-label">Tambah PC Baru</div><div class="ai-sub">Input spesifikasi komputer</div></div>
                    <span class="ai-arrow">→</span>
                </button>

                <a href="/spekpc/export/excel" class="action-item ai-blue">
                    <div class="ai-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <div><div class="ai-label">Export Excel</div><div class="ai-sub">Download data .xlsx</div></div>
                    <span class="ai-arrow">↓</span>
                </a>

                <a href="/spekpc/export/csv" class="action-item ai-slate">
                    <div class="ai-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div><div class="ai-label">Export CSV</div><div class="ai-sub">Download data .csv</div></div>
                    <span class="ai-arrow">↓</span>
                </a>

                <a href="/network" class="action-item ai-cyan">
                    <div class="ai-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <div><div class="ai-label">Network Monitor</div><div class="ai-sub">Halaman monitoring jaringan</div></div>
                    <span class="ai-arrow">→</span>
                </a>
            </div>
        </div>

        {{-- NETWORK STATUS MINI --}}
        <div class="db-card" style="overflow:hidden;">
            <div class="db-card-hdr">
                <div class="db-card-title">
                    <svg width="14" height="14" fill="none" stroke="var(--accent2)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Status Jaringan
                </div>
                <span class="scan-badge" id="db-scan-badge">Pending</span>
            </div>
            <div class="db-prog-wrap" id="db-prog"><div class="db-prog-bar" id="db-prog-bar"></div></div>
            <div class="net-list" id="db-net-list">
                @forelse($networkDevices as $dev)
                <div class="net-row" id="db-netrow-{{ $dev->id }}" data-id="{{ $dev->id }}" data-ip="{{ $dev->ip }}">
                    <span class="net-dot pending" id="db-ndot-{{ $dev->id }}"></span>
                    <span class="net-ip">{{ $dev->ip }}</span>
                    <span class="net-name">{{ Str::limit($dev->nama, 14) ?: '—' }}</span>
                    <span class="net-lat" id="db-nlat-{{ $dev->id }}">—</span>
                </div>
                @empty
                <div style="padding:24px;text-align:center;font-size:.75rem;color:var(--text-4);">Tidak ada IP terdaftar</div>
                @endforelse
            </div>
            <button class="rescan-btn" id="db-rescan-btn">
                <div class="rescan-spin"></div>
                <span class="rescan-label" style="display:flex;align-items:center;gap:6px;">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:12px;height:12px;">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                    </svg>
                    Scan Ulang
                </span>
            </button>
        </div>

    </div>
</div>

</div>{{-- /.db --}}

{{-- ══ MODAL TAMBAH (include dari aset) ════════ --}}
@include('aset.modal_tambah_spekpc')

<script>
/* ── CLOCK ───────────────────────────────────── */
(function() {
    const el = document.getElementById('db-clock');
    function tick() { if (el) el.textContent = new Date().toLocaleTimeString('id-ID'); }
    tick(); setInterval(tick, 1000);
})();

/* ── MODAL TAMBAH — close/cancel fix ─────────── */
/* Definisikan closeModal di scope global agar tombol Batal & ✕ di dalam modal bisa berfungsi */
window.closeModal = function() {
    const m = document.getElementById('modal');
    if (!m) return;
    m.classList.add('hidden');
    m.classList.remove('flex');
};

function dbOpenTambah() {
    const m = document.getElementById('modal');
    if (!m) return;
    m.classList.remove('hidden');
    m.classList.add('flex');
}

/* Klik backdrop → tutup modal */
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modal');
    if (!modal || modal.classList.contains('hidden')) return;
    /* Backdrop adalah div absolute pertama di dalam modal */
    if (e.target && e.target.getAttribute('onclick') === 'closeModal()') {
        closeModal();
    }
});

/* ESC → tutup modal */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

/* ── NETWORK SCAN ─────────────────────────────── */
const PING_URL = '/network/ping';
const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const BATCH    = 6;
const netRows  = Array.from(document.querySelectorAll('[data-id][data-ip]'));
const TOTAL    = {{ $totalIp }};
let scanning   = false;
let cntOn = 0, cntOff = 0, cntPend = TOTAL;

function setEl(id, val) { const e = document.getElementById(id); if (e) e.textContent = val; }

function updateNetStats() {
    setEl('db-val-on',   cntOn);
    setEl('db-val-off',  cntOff);
    setEl('db-val-pend', cntPend);
    setEl('db-cnt-on',   cntOn);
    setEl('db-cnt-off',  cntOff);
    setEl('db-cnt-pend', cntPend);
    if (TOTAL > 0) {
        const pOn  = Math.round((cntOn  / TOTAL) * 100);
        const pOff = Math.round((cntOff / TOTAL) * 100);
        const bOn  = document.getElementById('db-bar-on');
        const bOff = document.getElementById('db-bar-off');
        if (bOn)  bOn.style.width  = pOn  + '%';
        if (bOff) bOff.style.width = pOff + '%';
        setEl('db-pct-on',  pOn  + '%');
        setEl('db-pct-off', pOff + '%');
    }
}

function setNetRow(id, status, latency) {
    const dot = document.getElementById(`db-ndot-${id}`);
    const lat = document.getElementById(`db-nlat-${id}`);
    if (dot) dot.className = `net-dot ${status}`;
    if (lat) lat.textContent = latency ? latency + 'ms' : (status === 'offline' ? 'n/a' : '—');
}

async function runScan() {
    if (scanning || netRows.length === 0) return;
    scanning = true;
    cntOn = 0; cntOff = 0; cntPend = TOTAL;

    const btn   = document.getElementById('db-rescan-btn');
    const prog  = document.getElementById('db-prog');
    const bar   = document.getElementById('db-prog-bar');
    const badge = document.getElementById('db-scan-badge');

    if (btn)   { btn.classList.add('loading'); btn.disabled = true; }
    if (prog)  prog.classList.add('show');
    if (badge) { badge.textContent = 'Scanning…'; badge.style.color = 'var(--amber)'; badge.style.background = 'rgba(217,119,6,0.08)'; badge.style.borderColor = 'rgba(217,119,6,0.2)'; }

    netRows.forEach(r => setNetRow(r.dataset.id, 'pending', null));
    updateNetStats();

    let done = 0;
    for (let i = 0; i < netRows.length; i += BATCH) {
        const batch = netRows.slice(i, i + BATCH);
        await Promise.all(batch.map(async row => {
            try {
                const res  = await fetch(PING_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: JSON.stringify({ ip: row.dataset.ip }),
                });
                const data = await res.json();
                const st   = data.online ? 'online' : 'offline';
                setNetRow(row.dataset.id, st, data.latency);
                data.online ? (cntOn++, cntPend--) : (cntOff++, cntPend--);
            } catch {
                setNetRow(row.dataset.id, 'offline', null);
                cntOff++; cntPend--;
            }
            done++;
            if (bar) bar.style.width = Math.round((done / netRows.length) * 100) + '%';
            updateNetStats();
        }));
    }

    scanning = false;
    if (btn)   { btn.classList.remove('loading'); btn.disabled = false; }
    if (badge) {
        badge.textContent = '✓ Selesai';
        badge.style.color = 'var(--green)';
        badge.style.background = 'rgba(22,163,74,0.08)';
        badge.style.borderColor = 'rgba(22,163,74,0.2)';
    }
    setTimeout(() => {
        if (prog) prog.classList.remove('show');
        if (bar)  bar.style.width = '0%';
    }, 2000);
}

document.getElementById('db-rescan-btn')?.addEventListener('click', runScan);
window.addEventListener('DOMContentLoaded', () => setTimeout(runScan, 700));
</script>
@endsection