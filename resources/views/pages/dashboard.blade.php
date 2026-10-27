@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap');

:root {
    --db-font: 'Plus Jakarta Sans', sans-serif;
    --db-display: 'Syne', sans-serif;
    --db-mono: 'JetBrains Mono', monospace;

    --c-surface: rgba(255, 255, 255, 0.88);
    --c-surface-hover: rgba(255, 255, 255, 0.98);
    --c-card-bg: rgba(255, 255, 255, 0.82);
    --c-border: rgba(226, 232, 240, 0.85);
    --c-border-hover: rgba(59, 130, 246, 0.40);
    
    --c-blue: #2563eb;
    --c-blue-light: #eff6ff;
    --c-cyan: #0891b2;
    --c-cyan-light: #ecfeff;
    --c-emerald: #059669;
    --c-emerald-light: #ecfdf5;
    --c-amber: #d97706;
    --c-amber-light: #fffbeb;
    --c-rose: #e11d48;
    --c-rose-light: #fff1f2;
    --c-purple: #7c3aed;
    --c-purple-light: #f5f3ff;
    
    --c-text-main: #0f172a;
    --c-text-sub: #334155;
    --c-text-muted: #64748b;
    --c-text-light: #94a3b8;

    --sh-card: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    --sh-hover: 0 16px 36px -6px rgba(15, 23, 42, 0.12), 0 6px 14px -3px rgba(15, 23, 42, 0.06);
    --radius-lg: 20px;
    --radius-md: 14px;
    --radius-sm: 10px;
}

.db-container * {
    box-sizing: border-box;
}

.db-container {
    font-family: var(--db-font);
    color: var(--c-text-main);
    width: 100%;
    margin: 0 auto;
    padding-bottom: 30px;
}

/* ══════════════ 1. LIVE INDICATOR & CLOCK PILL ══════════════ */
.db-dot-live {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
    animation: livePulse 2s infinite ease-in-out;
}

@keyframes livePulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25); }
    50% { transform: scale(1.15); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.12); }
}

.db-clock-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: var(--radius-sm);
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    font-family: var(--db-mono);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--c-text-sub);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

/* ══════════════ 2. INTERACTIVE MODULE NAV TABS ══════════════ */
.db-nav-control-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 22px;
}

.db-tab-switcher {
    display: inline-flex;
    background: rgba(241, 245, 249, 0.85);
    backdrop-filter: blur(16px);
    padding: 5px;
    border-radius: 9999px;
    border: 1px solid var(--c-border);
    gap: 4px;
}

.db-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 9999px;
    border: none;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--c-text-muted);
    background: transparent;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.db-tab-btn:hover {
    color: var(--c-text-main);
}

.db-tab-btn.active {
    background: #ffffff;
    color: var(--c-blue);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.db-tab-btn .badge-pill {
    font-family: var(--db-mono);
    font-size: 0.65rem;
    padding: 2px 7px;
    border-radius: 9999px;
    background: rgba(37, 99, 235, 0.08);
    color: var(--c-blue);
}

.db-quick-actions-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action-db {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: var(--radius-sm);
    font-size: 0.78rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-primary-db {
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
    color: #fff;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
}
.btn-primary-db:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

.btn-emerald-db {
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
}
.btn-emerald-db:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

.btn-outline-db {
    background: var(--c-surface);
    color: var(--c-text-sub);
    border-color: var(--c-border);
}
.btn-outline-db:hover {
    background: #fff;
    border-color: var(--c-blue);
    color: var(--c-blue);
    transform: translateY(-1px);
}

/* ══════════════ 4. KPI METRICS CARDS (Bento Grid) ══════════════ */
.db-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 1200px) {
    .db-kpi-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .db-kpi-grid { grid-template-columns: 1fr; }
}

.db-kpi-card {
    background: var(--c-card-bg);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    padding: 20px 22px;
    box-shadow: var(--sh-card);
    position: relative;
    overflow: hidden;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.db-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--sh-hover);
    border-color: var(--c-border-hover);
}

.db-kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
}

.kpi-blue::before    { background: linear-gradient(90deg, #2563eb, #60a5fa); }
.kpi-emerald::before { background: linear-gradient(90deg, #059669, #34d399); }
.kpi-amber::before   { background: linear-gradient(90deg, #d97706, #fbbf24); }
.kpi-purple::before  { background: linear-gradient(90deg, #7c3aed, #a78bfa); }

.db-kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.db-kpi-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.kpi-blue .db-kpi-icon    { background: rgba(37, 99, 235, 0.10); color: #2563eb; }
.kpi-emerald .db-kpi-icon { background: rgba(5, 150, 105, 0.10); color: #059669; }
.kpi-amber .db-kpi-icon   { background: rgba(217, 119, 6, 0.10); color: #d97706; }
.kpi-purple .db-kpi-icon  { background: rgba(124, 58, 237, 0.10); color: #7c3aed; }

.db-kpi-tag {
    font-family: var(--db-mono);
    font-size: 0.65rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 9999px;
    letter-spacing: 0.02em;
}

.tag-blue    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.tag-emerald { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
.tag-amber   { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.tag-purple  { background: #f5f3ff; color: #5b21b6; border: 1px solid #ddd6fe; }

.db-kpi-value {
    font-family: var(--db-display);
    font-size: 2.20rem;
    font-weight: 800;
    line-height: 1;
    color: var(--c-text-main);
    margin-bottom: 4px;
}

.db-kpi-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--c-text-sub);
}

.db-kpi-desc {
    font-size: 0.72rem;
    color: var(--c-text-muted);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.db-kpi-progress {
    margin-top: 14px;
    height: 6px;
    border-radius: 9999px;
    background: #e2e8f0;
    overflow: hidden;
}

.db-kpi-bar {
    height: 100%;
    border-radius: 9999px;
    transition: width 1s ease-in-out;
}

.bar-blue    { background: linear-gradient(90deg, #2563eb, #38bdf8); }
.bar-emerald { background: linear-gradient(90deg, #059669, #34d399); }
.bar-amber   { background: linear-gradient(90deg, #d97706, #fbbf24); }
.bar-purple  { background: linear-gradient(90deg, #7c3aed, #a78bfa); }

/* ══════════════ 5. VISUAL ANALYTICS & CHARTS GRID ══════════════ */
.db-charts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 24px;
}

@media (max-width: 1100px) {
    .db-charts-grid { grid-template-columns: 1fr; }
}

.db-card-panel {
    background: var(--c-card-bg);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--sh-card);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}

.db-card-panel:hover {
    box-shadow: var(--sh-hover);
}

.db-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7);
    background: linear-gradient(135deg, rgba(248,250,252,0.8), rgba(255,255,255,0.6));
}

.db-panel-title {
    display: flex;
    align-items: center;
    gap: 9px;
    font-family: var(--db-display);
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--c-text-main);
}

.db-panel-badge {
    font-family: var(--db-mono);
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 9999px;
    background: #f1f5f9;
    color: var(--c-text-muted);
}

.db-panel-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.chart-wrapper {
    position: relative;
    width: 100%;
    min-height: 220px;
    max-height: 230px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-center-info {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    pointer-events: none;
}

.chart-center-val {
    font-family: var(--db-display);
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--c-text-main);
    line-height: 1;
}

.chart-center-lbl {
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--c-text-muted);
    text-transform: uppercase;
}

.chart-legend-custom {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-top: 14px;
    flex-wrap: wrap;
}

.chart-legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.72rem;
    color: var(--c-text-sub);
    font-weight: 600;
    cursor: pointer;
    padding: 3px 8px;
    border-radius: 6px;
    transition: all 0.15s ease;
}

.chart-legend-item:hover {
    background: rgba(241, 245, 249, 0.9);
    transform: translateY(-1px);
}

.chart-legend-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
}

/* Secondary 2-column chart row */
.db-sub-charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 24px;
}

@media (max-width: 900px) {
    .db-sub-charts-grid { grid-template-columns: 1fr; }
}

/* ══════════════ 6. DATA EXPLORER & INTERACTIVE TABLE ══════════════ */
.db-explorer-card {
    background: var(--c-card-bg);
    backdrop-filter: blur(24px) saturate(160%);
    border: 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--sh-card);
    overflow: hidden;
    margin-bottom: 24px;
}

.db-explorer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 22px;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7);
    background: linear-gradient(135deg, rgba(248,250,252,0.8), rgba(255,255,255,0.7));
    flex-wrap: wrap;
    gap: 14px;
}

.db-explorer-nav {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.exp-nav-btn {
    padding: 7px 14px;
    border-radius: var(--radius-sm);
    border: 1px solid transparent;
    background: transparent;
    font-size: 0.76rem;
    font-weight: 700;
    color: var(--c-text-muted);
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.exp-nav-btn:hover {
    color: var(--c-text-main);
    background: rgba(241, 245, 249, 0.8);
}

.exp-nav-btn.active {
    background: #ffffff;
    color: var(--c-blue);
    border-color: var(--c-border);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.db-search-box {
    position: relative;
    width: 260px;
}

.db-search-input {
    width: 100%;
    padding: 8px 14px 8px 34px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--c-border);
    background: rgba(255, 255, 255, 0.95);
    font-size: 0.78rem;
    color: var(--c-text-main);
    outline: none;
    transition: all 0.2s;
}

.db-search-input:focus {
    border-color: var(--c-blue);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.db-search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--c-text-light);
    pointer-events: none;
}

/* Standard Table Styling */
.db-table-responsive {
    overflow-x: auto;
    width: 100%;
}

.db-table-custom {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.80rem;
    text-align: left;
}

.db-table-custom thead th {
    padding: 12px 18px;
    background: rgba(248, 250, 252, 0.75);
    font-family: var(--db-mono);
    font-size: 0.64rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--c-text-muted);
    border-bottom: 1px solid rgba(226, 232, 240, 0.85);
    white-space: nowrap;
}

.db-table-custom tbody tr {
    border-bottom: 1px solid rgba(226, 232, 240, 0.45);
    transition: background 0.15s ease;
}

.db-table-custom tbody tr:hover {
    background: rgba(239, 246, 255, 0.55);
}

.db-table-custom tbody td {
    padding: 12px 18px;
    vertical-align: middle;
}

/* Table Pill Status */
.badge-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 9999px;
    font-family: var(--db-mono);
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    white-space: nowrap;
}

.pill-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.pill-bagus { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.pill-bagus .pill-dot { background: #16a34a; }

.pill-aman { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
.pill-aman .pill-dot { background: #d97706; }

.pill-under { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.pill-under .pill-dot { background: #ef4444; animation: blink 1.2s infinite; }

.pill-selesai { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.pill-selesai .pill-dot { background: #16a34a; }

.pill-suplier { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
.pill-suplier .pill-dot { background: #9333ea; }

.pill-belum { background: #fff7ed; color: #9a3412; border: 1px solid #ffedd5; }
.pill-belum .pill-dot { background: #ea580c; }

.pill-in { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
.pill-out { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }

.empty-row-msg {
    text-align: center;
    padding: 36px 20px;
    color: var(--c-text-muted);
    font-size: 0.82rem;
}

/* Quick Spec Modal */
.spec-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.spec-modal-backdrop.active {
    display: flex;
}

.spec-modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 600px;
    border-radius: var(--radius-lg);
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalPop {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes dbFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes dbSlideDown {
    from { opacity: 0; transform: translateY(-12px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* Sync Animation */
.spin-sync {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<div class="db-container">

    {{-- ══════════════ 1. INTERACTIVE MODULE NAV & QUICK ACTIONS ══════════════ --}}
    <div class="db-nav-control-bar">
        <div class="db-tab-switcher">
            <button type="button" class="db-tab-btn active" onclick="switchDbView('all', this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Ringkasan Semua
            </button>
            <button type="button" class="db-tab-btn" onclick="switchDbView('pc', this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
                Armada PC
                <span class="badge-pill">{{ $totalPc }}</span>
            </button>
            <button type="button" class="db-tab-btn" onclick="switchDbView('service', this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
                Monitoring Servis
                <span class="badge-pill">{{ $totalService }}</span>
            </button>
            <button type="button" class="db-tab-btn" onclick="switchDbView('part', this)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
                Stok Sparepart
                <span class="badge-pill">{{ $totalParts }}</span>
            </button>
        </div>

        <div class="db-quick-actions-bar">
            {{-- Compact Live Clock Pill --}}
            <div class="db-clock-pill">
                <span class="db-dot-live"></span>
                <span id="liveClock">--:--:--</span>
            </div>
            {{-- Tambah PC --}}
            <button type="button" onclick="dbOpenTambah()" class="btn-action-db btn-primary-db">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah PC
            </button>

            {{-- Input Service --}}
            <a href="/service" class="btn-action-db btn-emerald-db">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Input Servis
            </a>

            {{-- Export Spek PC --}}
            <a href="/spekpc/export/excel" class="btn-action-db btn-outline-db" title="Download rekap spesifikasi PC (.xlsx)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Excel
            </a>
        </div>
    </div>

    {{-- ══════════════ 4. KPI METRICS CARDS (Bento Grid) ══════════════ --}}
    <div class="db-kpi-grid">
        {{-- Card 1: Armada PC --}}
        <div class="db-kpi-card kpi-blue view-sec-all view-sec-pc">
            <div class="db-kpi-header">
                <div class="db-kpi-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                    </svg>
                </div>
                <span class="db-kpi-tag tag-blue">{{ $deptCount }} Departemen</span>
            </div>
            <div class="db-kpi-value">{{ $totalPc }}</div>
            <div class="db-kpi-title">Total Unit PC Terdata</div>
            <div class="db-kpi-desc">
                <span style="color:#16a34a; font-weight:700;">{{ $bagusCount }} Bagus</span> &bull;
                <span style="color:#d97706; font-weight:700;">{{ $amanCount }} Aman</span> &bull;
                <span style="color:#dc2626; font-weight:700;">{{ $underCount }} Under</span>
            </div>
            <div class="db-kpi-progress">
                <div class="db-kpi-bar bar-blue" style="width: {{ $totalPc > 0 ? round(($bagusCount / $totalPc) * 100) : 0 }}%;"></div>
            </div>
        </div>

        {{-- Card 2: Monitoring Servis --}}
        <div class="db-kpi-card kpi-emerald view-sec-all view-sec-service">
            <div class="db-kpi-header">
                <div class="db-kpi-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                </div>
                <span class="db-kpi-tag tag-emerald">{{ $serviceResolutionRate }}% Selesai</span>
            </div>
            <div class="db-kpi-value">{{ $totalService }}</div>
            <div class="db-kpi-title">Tiket Servis Barang</div>
            <div class="db-kpi-desc">
                <span style="color:#059669; font-weight:700;">{{ $selesaiCount }} Selesai</span> &bull;
                <span style="color:#7c3aed; font-weight:700;">{{ $suplierCount }} Suplier</span> &bull;
                <span style="color:#ea580c; font-weight:700;">{{ $belumCekCount }} Menunggu</span>
            </div>
            <div class="db-kpi-progress">
                <div class="db-kpi-bar bar-emerald" style="width: {{ $serviceResolutionRate }}%;"></div>
            </div>
        </div>

        {{-- Card 3: Sparepart Stok --}}
        <div class="db-kpi-card kpi-amber view-sec-all view-sec-part">
            <div class="db-kpi-header">
                <div class="db-kpi-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    </svg>
                </div>
                <span class="db-kpi-tag tag-amber">{{ number_format($totalStockQty) }} Total Qty</span>
            </div>
            <div class="db-kpi-value">{{ $totalParts }}</div>
            <div class="db-kpi-title">Katalog Sparepart</div>
            <div class="db-kpi-desc">
                <span style="color:#059669; font-weight:700;">{{ $partAmanCount }} Aman</span> &bull;
                <span style="color:#d97706; font-weight:700;">{{ $partMenipisCount }} Menipis</span> &bull;
                <span style="color:#dc2626; font-weight:700;">{{ $partHabisCount }} Kosong</span>
            </div>
            <div class="db-kpi-progress">
                <div class="db-kpi-bar bar-amber" style="width: {{ $totalParts > 0 ? round(($partAmanCount / $totalParts) * 100) : 0 }}%;"></div>
            </div>
        </div>

        {{-- Card 4: Log Transit & Toko --}}
        <div class="db-kpi-card kpi-purple view-sec-all view-sec-part">
            <div class="db-kpi-header">
                <div class="db-kpi-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <span class="db-kpi-tag tag-purple">{{ $totalToko }} Jaringan Toko</span>
            </div>
            <div class="db-kpi-value">{{ number_format($totalLogs) }}</div>
            <div class="db-kpi-title">Riwayat Mutasi Log Transit</div>
            <div class="db-kpi-desc">
                <span style="color:#059669; font-weight:700;">{{ number_format($logInCount) }} Part Masuk</span> &bull;
                <span style="color:#dc2626; font-weight:700;">{{ number_format($logOutCount) }} Part Keluar</span>
            </div>
            <div class="db-kpi-progress">
                <div class="db-kpi-bar bar-purple" style="width: {{ $totalLogs > 0 ? round(($logOutCount / $totalLogs) * 100) : 50 }}%;"></div>
            </div>
        </div>
    </div>

    {{-- ══════════════ 5. VISUAL ANALYTICS & CHARTS GRID ══════════════ --}}
    <div class="db-charts-grid">
        {{-- Chart 1: Kondisi Kesehatan PC --}}
        <div class="db-card-panel view-sec-all view-sec-pc">
            <div class="db-panel-header">
                <div class="db-panel-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-blue)" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    Kesehatan Armada PC
                </div>
                <span class="db-panel-badge">{{ $totalPc }} Unit</span>
            </div>
            <div class="db-panel-body">
                <div class="chart-wrapper" style="cursor: pointer;" onclick="openPcStatusModal('ALL')" title="Klik diagram untuk melihat seluruh daftar armada PC">
                    <canvas id="chartPcHealth" style="cursor: pointer;"></canvas>
                    <div class="chart-center-info">
                        <div class="chart-center-val">{{ $totalPc > 0 ? round(($bagusCount / $totalPc) * 100) : 0 }}%</div>
                        <div class="chart-center-lbl">Kondisi Prima</div>
                    </div>
                </div>
                <div class="chart-legend-custom">
                    <div class="chart-legend-item" onclick="openPcStatusModal('BAGUS')" title="Klik untuk lihat daftar PC Bagus ({{ $bagusCount }})">
                        <span class="chart-legend-dot" style="background:#10b981;"></span>
                        Bagus ({{ $bagusCount }})
                    </div>
                    <div class="chart-legend-item" onclick="openPcStatusModal('AMAN')" title="Klik untuk lihat daftar PC Aman ({{ $amanCount }})">
                        <span class="chart-legend-dot" style="background:#f59e0b;"></span>
                        Aman ({{ $amanCount }})
                    </div>
                    <div class="chart-legend-item" onclick="openPcStatusModal('UNDER')" title="Klik untuk lihat daftar PC Under ({{ $underCount }})">
                        <span class="chart-legend-dot" style="background:#ef4444;"></span>
                        Under ({{ $underCount }})
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart 2: Ketersediaan Stok Sparepart --}}
        <div class="db-card-panel view-sec-all view-sec-part">
            <div class="db-panel-header">
                <div class="db-panel-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-amber)" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                    Ketersediaan Stok Part
                </div>
                <span class="db-panel-badge">{{ $totalParts }} Katalog</span>
            </div>
            <div class="db-panel-body">
                <div class="chart-wrapper">
                    <canvas id="chartStockHealth"></canvas>
                    <div class="chart-center-info">
                        <div class="chart-center-val">{{ $partHabisCount }}</div>
                        <div class="chart-center-lbl" style="color:#ef4444;">Stok Habis</div>
                    </div>
                </div>
                <div class="chart-legend-custom">
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#059669;"></span>
                        Aman >5 ({{ $partAmanCount }})
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#d97706;"></span>
                        Menipis &le;5 ({{ $partMenipisCount }})
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#dc2626;"></span>
                        Habis 0 ({{ $partHabisCount }})
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart 3: Status Penanganan Servis --}}
        <div class="db-card-panel view-sec-all view-sec-service">
            <div class="db-panel-header">
                <div class="db-panel-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-emerald)" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Penyelesaian Servis
                </div>
                <span class="db-panel-badge">{{ $totalService }} Tiket</span>
            </div>
            <div class="db-panel-body">
                <div class="chart-wrapper">
                    <canvas id="chartServiceStatus"></canvas>
                    <div class="chart-center-info">
                        <div class="chart-center-val">{{ $serviceResolutionRate }}%</div>
                        <div class="chart-center-lbl">Terselesaikan</div>
                    </div>
                </div>
                <div class="chart-legend-custom">
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#10b981;"></span>
                        Selesai ({{ $selesaiCount }})
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#8b5cf6;"></span>
                        Suplier ({{ $suplierCount }})
                    </div>
                    <div class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#f97316;"></span>
                        Pending ({{ $belumCekCount + $sudahCekCount }})
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Secondary Charts Row: Dept Distribution & Part Moving Categories --}}
    <div class="db-sub-charts-grid">
        {{-- Top Departemen PC --}}
        <div class="db-card-panel view-sec-all view-sec-pc">
            <div class="db-panel-header">
                <div class="db-panel-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-blue)" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                    </svg>
                    Distribusi PC per Departemen
                </div>
                <a href="/spekpc" style="font-size:0.70rem; color:var(--c-blue); text-decoration:none; font-weight:700;">Lihat Detail &rarr;</a>
            </div>
            <div class="db-panel-body">
                <div style="height: 200px;">
                    <canvas id="chartDeptDist"></canvas>
                </div>
            </div>
        </div>

        {{-- Kategori Perputaran Sparepart (Moving) --}}
        <div class="db-card-panel view-sec-all view-sec-part">
            <div class="db-panel-header">
                <div class="db-panel-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-purple)" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Kategori Perputaran Sparepart (Moving)
                </div>
                <a href="/part" style="font-size:0.70rem; color:var(--c-purple); text-decoration:none; font-weight:700;">Kelola Part &rarr;</a>
            </div>
            <div class="db-panel-body">
                <div style="height: 200px;">
                    <canvas id="chartMovingDist"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════ 6. DATA EXPLORER & INTERACTIVE TABLES ══════════════ --}}
    <div class="db-explorer-card">
        <div class="db-explorer-header">
            <div class="db-explorer-nav">
                <button type="button" class="exp-nav-btn active" onclick="switchTableTab('pc', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                    </svg>
                    Armada PC Terbaru ({{ count($recentPc) }})
                </button>
                <button type="button" class="exp-nav-btn" onclick="switchTableTab('service', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                    Tiket Servis Berjalan ({{ count($recentServices) }})
                </button>
                <button type="button" class="exp-nav-btn" onclick="switchTableTab('critical-part', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    </svg>
                    Stok Menipis & Kosong ({{ count($criticalParts) }})
                </button>
                <button type="button" class="exp-nav-btn" onclick="switchTableTab('log', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/>
                    </svg>
                    Mutasi Log Transit ({{ count($recentLogs) }})
                </button>
            </div>

            <div class="db-search-box">
                <svg class="db-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="dbTableSearch" class="db-search-input" placeholder="Cari dalam tabel..." onkeyup="filterActiveTable()">
            </div>
        </div>

        {{-- TAB 1: ARMADA PC TERBARU --}}
        <div id="tableTab-pc" class="table-tab-pane">
            <div class="db-table-responsive">
                <table class="db-table-custom" id="tableDataPc">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>User / Nama PC</th>
                            <th>Departemen</th>
                            <th>Sistem Operasi</th>
                            <th>RAM / Storage</th>
                            <th>Status Unit</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPc as $idx => $pc)
                        <tr class="searchable-row" data-search="{{ strtolower($pc->ip . ' ' . $pc->nama . ' ' . $pc->compname . ' ' . $pc->dept . ' ' . $pc->windows . ' ' . $pc->status) }}">
                            <td style="font-family:var(--db-mono); color:var(--c-text-muted); font-size:0.70rem;">{{ $idx + 1 }}</td>
                            <td>
                                <span style="font-family:var(--db-mono); font-weight:700; color:var(--c-blue); background:rgba(37,99,235,0.06); padding:2px 6px; border-radius:6px;">
                                    {{ $pc->ip }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:700; color:var(--c-text-main);">{{ $pc->nama ?: 'Tanpa Nama' }}</div>
                                @if($pc->compname)
                                <div style="font-size:0.68rem; color:var(--c-text-muted); font-family:var(--db-mono);">{{ $pc->compname }}</div>
                                @endif
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-size:0.68rem; font-weight:700; background:#f1f5f9; padding:2px 8px; border-radius:6px; color:var(--c-text-sub);">
                                    {{ $pc->dept ?: '—' }}
                                </span>
                            </td>
                            <td style="font-size:0.75rem; color:var(--c-text-sub);">
                                {{ $pc->windows ?: '—' }}
                            </td>
                            <td style="font-family:var(--db-mono); font-size:0.72rem; color:var(--c-text-muted);">
                                {{ $pc->ram ?: '—' }} / {{ $pc->storage ?: '—' }}
                            </td>
                            <td>
                                @php
                                    $st = strtoupper(trim((string)$pc->status));
                                    $pillCls = $st === 'BAGUS' ? 'pill-bagus' : ($st === 'AMAN' ? 'pill-aman' : 'pill-under');
                                @endphp
                                <span class="badge-status-pill {{ $pillCls }}">
                                    <span class="pill-dot"></span>
                                    {{ $st ?: 'UNKNOWN' }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <button type="button" onclick="showPcDetail({{ json_encode($pc) }})" class="btn-action-db btn-outline-db" style="padding:4px 10px; font-size:0.68rem;">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-row-msg">Belum ada data PC yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 2: TIKET SERVIS BERJALAN --}}
        <div id="tableTab-service" class="table-tab-pane" style="display:none;">
            <div class="db-table-responsive">
                <table class="db-table-custom" id="tableDataService">
                    <thead>
                        <tr>
                            <th>No DAT</th>
                            <th>Nama Unit Barang</th>
                            <th>No Serial (SN)</th>
                            <th>Toko Asal</th>
                            <th>Tgl Masuk</th>
                            <th>Durasi Pengerjaan</th>
                            <th>Status Tiket</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentServices as $srv)
                        <tr class="searchable-row" data-search="{{ strtolower($srv->no_dat . ' ' . $srv->nama_barang . ' ' . $srv->sn . ' ' . $srv->kode_toko . ' ' . $srv->status) }}">
                            <td style="font-family:var(--db-mono); font-weight:700; color:var(--c-emerald);">
                                {{ $srv->no_dat }}
                            </td>
                            <td style="font-weight:700; color:var(--c-text-main);">
                                {{ $srv->nama_barang }}
                            </td>
                            <td style="font-family:var(--db-mono); font-size:0.72rem; color:var(--c-text-muted);">
                                {{ $srv->sn ?: '—' }}
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-size:0.70rem; font-weight:700; background:#f1f5f9; padding:2px 8px; border-radius:6px;">
                                    {{ $srv->kode_toko }} {{ $srv->toko ? '· ' . $srv->toko->nama_toko : '' }}
                                </span>
                            </td>
                            <td style="font-family:var(--db-mono); font-size:0.72rem; color:var(--c-text-muted);">
                                {{ $srv->tanggal_masuk ? $srv->tanggal_masuk->format('d/m/Y') : '—' }}
                            </td>
                            <td style="font-size:0.75rem; color:var(--c-text-sub);">
                                {{ $srv->durasi_text }}
                            </td>
                            <td>
                                @php
                                    $sSt = $srv->status;
                                    $sCls = $sSt === 'Selesai Service' ? 'pill-selesai' : ($sSt === 'Service Suplier' ? 'pill-suplier' : 'pill-belum');
                                @endphp
                                <span class="badge-status-pill {{ $sCls }}">
                                    <span class="pill-dot"></span>
                                    {{ $sSt }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="/service" class="btn-action-db btn-outline-db" style="padding:4px 10px; font-size:0.68rem;">
                                    Kelola &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-row-msg">Belum ada data servis barang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 3: STOK MENIPIS & KOSONG --}}
        <div id="tableTab-critical-part" class="table-tab-pane" style="display:none;">
            <div class="db-table-responsive">
                <table class="db-table-custom" id="tableDataCriticalPart">
                    <thead>
                        <tr>
                            <th>Kode PLU</th>
                            <th>Nama Sparepart</th>
                            <th>Kategori Moving</th>
                            <th>Sisa Stok</th>
                            <th>Satuan</th>
                            <th>Status Peringatan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criticalParts as $part)
                        <tr class="searchable-row" data-search="{{ strtolower($part->kode_plu . ' ' . $part->nama_barang . ' ' . $part->moving) }}">
                            <td style="font-family:var(--db-mono); font-weight:700; color:var(--c-blue);">
                                {{ $part->kode_plu }}
                            </td>
                            <td style="font-weight:700; color:var(--c-text-main);">
                                {{ $part->nama_barang }}
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-size:0.66rem; font-weight:700; padding:2px 8px; border-radius:6px; background:#f1f5f9; color:var(--c-text-sub);">
                                    {{ $part->moving ?: 'STANDARD' }}
                                </span>
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-size:0.90rem; font-weight:800; color: {{ $part->qty_stock <= 0 ? '#ef4444' : '#d97706' }};">
                                    {{ $part->qty_stock }}
                                </span>
                            </td>
                            <td style="font-size:0.72rem; color:var(--c-text-muted);">
                                {{ $part->satuan ?: 'PCS' }}
                            </td>
                            <td>
                                @if($part->qty_stock <= 0)
                                <span class="badge-status-pill pill-under">
                                    <span class="pill-dot"></span>
                                    HABIS (0)
                                </span>
                                @else
                                <span class="badge-status-pill pill-aman">
                                    <span class="pill-dot"></span>
                                    MENIPIS (&le;5)
                                </span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="/part" class="btn-action-db btn-outline-db" style="padding:4px 10px; font-size:0.68rem;">
                                    Tambah Stok &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-row-msg">Semua stok sparepart berada dalam kondisi aman!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 4: MUTASI LOG TRANSIT --}}
        <div id="tableTab-log" class="table-tab-pane" style="display:none;">
            <div class="db-table-responsive">
                <table class="db-table-custom" id="tableDataLog">
                    <thead>
                        <tr>
                            <th>Waktu & Tanggal</th>
                            <th>Tipe Mutasi</th>
                            <th>Nama Sparepart</th>
                            <th>Qty</th>
                            <th>Toko / Tujuan</th>
                            <th>Keterangan Transaksi</th>
                            <th style="text-align: right;">Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr class="searchable-row" data-search="{{ strtolower($log->nama_barang . ' ' . $log->tipe . ' ' . $log->kdtk . ' ' . $log->nama_toko . ' ' . $log->keterangan) }}">
                            <td style="font-family:var(--db-mono); font-size:0.70rem; color:var(--c-text-muted);">
                                {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : ($log->tanggal_transaksi ? $log->tanggal_transaksi->format('d/m/Y') : '—') }}
                            </td>
                            <td>
                                <span class="badge-status-pill {{ $log->tipe === 'IN' ? 'pill-in' : 'pill-out' }}">
                                    <span class="pill-dot"></span>
                                    {{ $log->tipe === 'IN' ? '+ MASUK' : '- KELUAR' }}
                                </span>
                            </td>
                            <td style="font-weight:700; color:var(--c-text-main);">
                                {{ $log->nama_barang }}
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-weight:800; font-size:0.85rem; color: {{ $log->tipe === 'IN' ? '#059669' : '#dc2626' }};">
                                    {{ $log->tipe === 'IN' ? '+' : '-' }}{{ $log->qty }}
                                </span>
                            </td>
                            <td>
                                <span style="font-family:var(--db-mono); font-size:0.68rem; font-weight:700; background:#f1f5f9; padding:2px 8px; border-radius:6px;">
                                    {{ $log->kdtk ?: '—' }} {{ $log->nama_toko ? '· ' . $log->nama_toko : '' }}
                                </span>
                            </td>
                            <td style="font-size:0.72rem; color:var(--c-text-muted); max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                {{ $log->keterangan ?: '—' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="/part/log" class="btn-action-db btn-outline-db" style="padding:4px 10px; font-size:0.68rem;">
                                    Log &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-row-msg">Belum ada riwayat mutasi log transit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>{{-- /.db-container --}}

{{-- ══════════════ MODAL DETAIL SPESIFIKASI PC ══════════════ --}}
<div id="modalPcDetail" class="spec-modal-backdrop" onclick="closePcDetailBackdrop(event)">
    <div class="spec-modal-card">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #eff6ff, #fff);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                    </svg>
                </div>
                <div>
                    <h3 id="mdlPcTitle" style="font-family: var(--db-display); font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Spesifikasi Komputer</h3>
                    <p id="mdlPcSubtitle" style="font-family: var(--db-mono); font-size: 0.72rem; color: #64748b; margin: 2px 0 0;">IP: -</p>
                </div>
            </div>
            <button type="button" onclick="closePcDetail()" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 8px; font-size: 1rem; color: #64748b; cursor: pointer;">✕</button>
        </div>

        <div style="padding: 24px; max-height: 70vh; overflow-y: auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.80rem;">
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Pengguna & Dept</div>
                    <div id="mdlPcUser" style="font-weight:700; color:#0f172a; margin-top:3px;">-</div>
                </div>
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Status Kesehatan</div>
                    <div id="mdlPcStatus" style="font-weight:700; margin-top:3px;">-</div>
                </div>
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Processor & Merk</div>
                    <div id="mdlPcProcessor" style="font-weight:700; color:#0f172a; margin-top:3px;">-</div>
                </div>
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">RAM & Kapasitas Storage</div>
                    <div id="mdlPcRamStorage" style="font-weight:700; color:#0f172a; margin-top:3px;">-</div>
                </div>
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Sistem Operasi (OS)</div>
                    <div id="mdlPcWindows" style="font-weight:700; color:#0f172a; margin-top:3px;">-</div>
                </div>
                <div style="background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Lisensi Windows & Office</div>
                    <div id="mdlPcLicense" style="font-weight:700; color:#0f172a; margin-top:3px;">-</div>
                </div>
                <div style="grid-column: 1 / -1; background:#f8fafc; padding:12px; border-radius:10px;">
                    <div style="font-size:0.65rem; color:#94a3b8; font-weight:700; text-transform:uppercase;">Catatan / Keterangan</div>
                    <div id="mdlPcNotes" style="font-weight:500; color:#475569; margin-top:3px;">-</div>
                </div>
            </div>
        </div>

        <div style="padding: 14px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px;">
            <a id="mdlPcEditLink" href="/spekpc" class="btn-action-db btn-primary-db" style="padding: 6px 16px;">
                Buka di Spek PC &rarr;
            </a>
            <button type="button" onclick="closePcDetail()" class="btn-action-db btn-outline-db" style="padding: 6px 16px;">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- ══════════════ MODAL DAFTAR PC BY STATUS ══════════════ --}}
<div id="modalPcStatusList" class="spec-modal-backdrop" onclick="closePcStatusBackdrop(event)" style="z-index: 9990;">
    <div class="spec-modal-card" style="max-width: 940px; width: 95%; max-height: 90vh; display: flex; flex-direction: column;">
        {{-- Header --}}
        <div style="padding: 16px 22px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #eff6ff, #fff); flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="mdlStatusIconBox" style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #ef4444, #f87171); display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 12px rgba(239,68,68,0.25);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h3 id="mdlStatusTitle" style="font-family: var(--db-display); font-size: 1.08rem; font-weight: 800; color: #0f172a; margin: 0;">Daftar Armada PC</h3>
                        <span id="mdlStatusHeaderBadge" class="tbl-pill pill-under" style="font-size: 0.68rem; padding: 2px 8px;">UNDER</span>
                    </div>
                    <p id="mdlStatusSubtitle" style="font-size: 0.72rem; color: #64748b; margin: 2px 0 0;">Menampilkan data armada PC berdasarkan status kesehatan terpilih.</p>
                </div>
            </div>
            <button type="button" onclick="closePcStatusModal()" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 8px; font-size: 1rem; color: #64748b; cursor: pointer; transition: all 0.15s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">✕</button>
        </div>

        {{-- Filter Tabs & Search Bar --}}
        <div style="padding: 12px 22px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; flex-shrink: 0;">
            <div style="display: flex; gap: 6px; flex-wrap: wrap;" id="mdlStatusFilterTabs">
                <button type="button" onclick="filterMdlStatusTab('ALL')" id="tabBtnALL" class="exp-nav-btn">Semua ({{ $totalPc }})</button>
                <button type="button" onclick="filterMdlStatusTab('UNDER')" id="tabBtnUNDER" class="exp-nav-btn" style="color: #ef4444;"><span style="width:8px;height:8px;border-radius:50%;background:#ef4444;display:inline-block;"></span> Under ({{ $underCount }})</button>
                <button type="button" onclick="filterMdlStatusTab('AMAN')" id="tabBtnAMAN" class="exp-nav-btn" style="color: #f59e0b;"><span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;display:inline-block;"></span> Aman ({{ $amanCount }})</button>
                <button type="button" onclick="filterMdlStatusTab('BAGUS')" id="tabBtnBAGUS" class="exp-nav-btn" style="color: #10b981;"><span style="width:8px;height:8px;border-radius:50%;background:#10b981;display:inline-block;"></span> Bagus ({{ $bagusCount }})</button>
            </div>
            <div style="position: relative; width: 250px; min-width: 180px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" id="mdlPcSearchInput" oninput="searchMdlPcList()" placeholder="Cari IP, nama, dept, spek..." style="width: 100%; padding: 6px 12px 6px 30px; font-size: 0.74rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: #fff; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'" />
            </div>
        </div>

        {{-- Table Container --}}
        <div style="flex: 1; overflow-y: auto; overflow-x: auto; min-height: 200px; max-height: 55vh; padding: 0;">
            <table class="db-table" style="width: 100%; border-collapse: collapse;">
                <thead style="position: sticky; top: 0; background: #f8fafc; z-index: 10; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <tr>
                        <th style="width: 45px; text-align: center;">No</th>
                        <th>IP Address</th>
                        <th>Pengguna / Host</th>
                        <th>Dept</th>
                        <th>Spesifikasi (CPU & RAM)</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th style="text-align: center; width: 85px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="mdlPcTableBody">
                    {{-- Dynamically rendered via JS --}}
                </tbody>
            </table>
            <div id="mdlPcEmptyState" style="display: none; text-align: center; padding: 48px 20px; color: #94a3b8;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin: 0 auto 10px;">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
                <p style="font-size: 0.85rem; font-weight: 700; color: #64748b; margin: 0;">Tidak ada armada PC yang cocok</p>
                <p style="font-size: 0.74rem; color: #94a3b8; margin: 4px 0 0;">Coba ganti filter status atau ubah kata kunci pencarian.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding: 12px 22px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <span id="mdlPcFooterCount" style="font-size: 0.72rem; font-weight: 600; color: #64748b;">Menampilkan 0 unit</span>
            <div style="display: flex; gap: 8px;">
                <a href="/spekpc" class="btn-action-db btn-primary-db" style="padding: 6px 14px; font-size: 0.72rem; text-decoration: none;">
                    Buka Halaman Spek PC &rarr;
                </a>
                <button type="button" onclick="closePcStatusModal()" class="btn-action-db btn-outline-db" style="padding: 6px 14px; font-size: 0.72rem;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH DARI ASET --}}
@include('aset.modal_tambah_spekpc')

{{-- Chart.js CDN (Lightweight, Interactive & Responsive) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
/* ── 1. DIGITAL CLOCK ───────────────────────────────────────── */
(function() {
    const clockEl = document.getElementById('liveClock');
    function updateClock() {
        if (!clockEl) return;
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        clockEl.textContent = `${h}:${m}:${s}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
})();

/* ── 2. MODAL TAMBAH PC HELPER ─────────────────────────────── */
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

/* ── 3. MODAL DETAIL QUICK-VIEW ────────────────────────────── */
function showPcDetail(pc) {
    if (!pc) return;
    document.getElementById('mdlPcTitle').textContent = pc.nama || pc.compname || 'Komputer Unit';
    document.getElementById('mdlPcSubtitle').textContent = `IP: ${pc.ip || '-'} · NIK: ${pc.nik || '-'} · DAT: ${pc.dat || '-'}`;
    document.getElementById('mdlPcUser').textContent = `${pc.nama || '-'} (${pc.dept || 'Umum'})`;
    
    const stEl = document.getElementById('mdlPcStatus');
    const st = (pc.status || '').toUpperCase();
    stEl.textContent = st || 'UNKNOWN';
    stEl.style.color = st === 'BAGUS' ? '#16a34a' : (st === 'AMAN' ? '#d97706' : '#dc2626');

    document.getElementById('mdlPcProcessor').textContent = `${pc.processor || '-'} (${pc.merk || 'Merk Tidak Tercatat'})`;
    document.getElementById('mdlPcRamStorage').textContent = `RAM: ${pc.ram || '-'} · Storage: ${pc.storage || '-'}`;
    document.getElementById('mdlPcWindows').textContent = pc.windows || '-';
    document.getElementById('mdlPcLicense').textContent = `Win: ${pc.lisensi_windows || '-'} · Office: ${pc.lisensi_office || '-'}`;
    document.getElementById('mdlPcNotes').textContent = pc.keterangan || 'Tidak ada catatan khusus.';
    document.getElementById('mdlPcEditLink').href = `/spekpc?search=${encodeURIComponent(pc.ip || '')}`;

    document.getElementById('modalPcDetail').classList.add('active');
}

function closePcDetail() {
    document.getElementById('modalPcDetail').classList.remove('active');
}

function closePcDetailBackdrop(e) {
    if (e.target.id === 'modalPcDetail') {
        closePcDetail();
    }
}

/* ── 3B. MODAL DAFTAR PC BY STATUS (DONUT & LEGEND CLICK) ──── */
const DB_ALL_PCS = @json($allPcList ?? []);
let currentMdlStatusFilter = 'ALL';
let currentMdlSearch = '';

function openPcStatusModal(status = 'ALL') {
    currentMdlStatusFilter = (status || 'ALL').toUpperCase();
    currentMdlSearch = '';
    const searchInput = document.getElementById('mdlPcSearchInput');
    if (searchInput) searchInput.value = '';

    updateMdlHeaderStyle(currentMdlStatusFilter);
    updateMdlTabButtons(currentMdlStatusFilter);
    renderPcStatusModal();

    const m = document.getElementById('modalPcStatusList');
    if (m) m.classList.add('active');
}

function closePcStatusModal() {
    const m = document.getElementById('modalPcStatusList');
    if (m) m.classList.remove('active');
}

function closePcStatusBackdrop(e) {
    if (e.target.id === 'modalPcStatusList') {
        closePcStatusModal();
    }
}

function filterMdlStatusTab(status) {
    currentMdlStatusFilter = (status || 'ALL').toUpperCase();
    updateMdlHeaderStyle(currentMdlStatusFilter);
    updateMdlTabButtons(currentMdlStatusFilter);
    renderPcStatusModal();
}

function searchMdlPcList() {
    currentMdlSearch = (document.getElementById('mdlPcSearchInput')?.value || '').toLowerCase().trim();
    renderPcStatusModal();
}

function updateMdlTabButtons(status) {
    ['ALL', 'UNDER', 'AMAN', 'BAGUS'].forEach(st => {
        const btn = document.getElementById(`tabBtn${st}`);
        if (!btn) return;
        if (st === status) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

function updateMdlHeaderStyle(status) {
    const iconBox = document.getElementById('mdlStatusIconBox');
    const badge = document.getElementById('mdlStatusHeaderBadge');
    const title = document.getElementById('mdlStatusTitle');
    const subtitle = document.getElementById('mdlStatusSubtitle');

    if (!iconBox || !badge || !title) return;

    if (status === 'UNDER') {
        iconBox.style.background = 'linear-gradient(135deg, #ef4444, #f87171)';
        iconBox.style.boxShadow = '0 4px 12px rgba(239,68,68,0.25)';
        badge.className = 'tbl-pill pill-under';
        badge.style.background = '';
        badge.style.color = '';
        badge.textContent = 'STATUS: UNDER';
        title.textContent = 'Daftar Armada PC Status UNDER';
        subtitle.textContent = 'Unit PC yang membutuhkan perbaikan, upgrade spek, atau perhatian mendesak.';
    } else if (status === 'AMAN') {
        iconBox.style.background = 'linear-gradient(135deg, #f59e0b, #fbbf24)';
        iconBox.style.boxShadow = '0 4px 12px rgba(245,158,11,0.25)';
        badge.className = 'tbl-pill pill-aman';
        badge.style.background = '';
        badge.style.color = '';
        badge.textContent = 'STATUS: AMAN';
        title.textContent = 'Daftar Armada PC Status AMAN';
        subtitle.textContent = 'Unit PC yang beroperasi normal dengan spesifikasi mencukupi.';
    } else if (status === 'BAGUS') {
        iconBox.style.background = 'linear-gradient(135deg, #10b981, #34d399)';
        iconBox.style.boxShadow = '0 4px 12px rgba(16,185,129,0.25)';
        badge.className = 'tbl-pill pill-bagus';
        badge.style.background = '';
        badge.style.color = '';
        badge.textContent = 'STATUS: BAGUS';
        title.textContent = 'Daftar Armada PC Kondisi BAGUS (Prima)';
        subtitle.textContent = 'Unit PC dengan performa prima, spesifikasi tinggi dan terawat dengan baik.';
    } else {
        iconBox.style.background = 'linear-gradient(135deg, #2563eb, #38bdf8)';
        iconBox.style.boxShadow = '0 4px 12px rgba(37,99,235,0.25)';
        badge.className = 'tbl-pill';
        badge.style.background = '#e0f2fe';
        badge.style.color = '#0369a1';
        badge.textContent = 'SEMUA STATUS';
        title.textContent = 'Semua Armada PC Terdata';
        subtitle.textContent = 'Daftar lengkap seluruh komputer armada yang tercatat di sistem.';
    }
}

function renderPcStatusModal() {
    const tbody = document.getElementById('mdlPcTableBody');
    const emptyState = document.getElementById('mdlPcEmptyState');
    const countEl = document.getElementById('mdlPcFooterCount');
    if (!tbody) return;

    // Filter by status
    let filtered = DB_ALL_PCS.filter(pc => {
        if (currentMdlStatusFilter === 'ALL') return true;
        return (pc.status || '').toUpperCase() === currentMdlStatusFilter;
    });

    // Filter by search
    if (currentMdlSearch) {
        filtered = filtered.filter(pc => {
            const ip = (pc.ip || '').toLowerCase();
            const nama = (pc.nama || '').toLowerCase();
            const compname = (pc.compname || '').toLowerCase();
            const dept = (pc.dept || '').toLowerCase();
            const processor = (pc.processor || '').toLowerCase();
            const ram = (pc.ram || '').toLowerCase();
            const merk = (pc.merk || '').toLowerCase();
            const ket = (pc.keterangan || '').toLowerCase();
            return ip.includes(currentMdlSearch) ||
                   nama.includes(currentMdlSearch) ||
                   compname.includes(currentMdlSearch) ||
                   dept.includes(currentMdlSearch) ||
                   processor.includes(currentMdlSearch) ||
                   ram.includes(currentMdlSearch) ||
                   merk.includes(currentMdlSearch) ||
                   ket.includes(currentMdlSearch);
        });
    }

    if (countEl) {
        countEl.textContent = `Menampilkan ${filtered.length} dari ${DB_ALL_PCS.length} total armada unit`;
    }

    if (filtered.length === 0) {
        tbody.innerHTML = '';
        if (emptyState) emptyState.style.display = 'block';
        return;
    }

    if (emptyState) emptyState.style.display = 'none';

    tbody.innerHTML = filtered.map((pc, idx) => {
        const st = (pc.status || '').toUpperCase();
        let pillClass = 'pill-under';
        if (st === 'BAGUS') pillClass = 'pill-bagus';
        else if (st === 'AMAN') pillClass = 'pill-aman';

        const rawJson = JSON.stringify(pc).replace(/"/g, '&quot;');

        return `
            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <td style="text-align: center; font-size: 0.72rem; color: #94a3b8; font-weight: 600; padding: 10px 8px;">${idx + 1}</td>
                <td style="padding: 10px 12px;">
                    <span class="tbl-code-badge">${pc.ip || '-'}</span>
                </td>
                <td style="padding: 10px 12px;">
                    <div style="font-weight: 700; color: #0f172a; font-size: 0.78rem;">${pc.nama || pc.compname || '-'}</div>
                    ${pc.compname ? `<div style="font-size: 0.68rem; color: #94a3b8; font-family: var(--db-mono);">${pc.compname}</div>` : ''}
                </td>
                <td style="padding: 10px 12px;">
                    <span style="font-size: 0.74rem; font-weight: 600; color: #475569;">${pc.dept || 'Umum'}</span>
                </td>
                <td style="padding: 10px 12px;">
                    <div style="font-size: 0.74rem; font-weight: 600; color: #1e293b;">${pc.processor || '-'}</div>
                    <div style="font-size: 0.68rem; color: #64748b;">RAM: ${pc.ram || '-'} · ${pc.storage || '-'}</div>
                </td>
                <td style="padding: 10px 12px;">
                    <span class="tbl-pill ${pillClass}">
                        <span class="pill-dot"></span>
                        ${st || 'UNKNOWN'}
                    </span>
                </td>
                <td style="max-width: 180px; font-size: 0.72rem; color: #64748b; padding: 10px 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${pc.keterangan || '-'}">
                    ${pc.keterangan || '<span style="color:#cbd5e1;">-</span>'}
                </td>
                <td style="text-align: center; padding: 10px 8px;">
                    <button type="button" onclick='showPcDetail(${rawJson})' class="btn-action-db btn-outline-db" style="padding: 4px 10px; font-size: 0.70rem;" title="Lihat detail lengkap spesifikasi unit">
                        Detail
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

/* ── 4. VIEW / TAB FILTER (All / PC / Service / Part) ───────── */
function switchDbView(mode, btn) {
    document.querySelectorAll('.db-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const kpiCards = document.querySelectorAll('.db-kpi-card');
    const chartPanels = document.querySelectorAll('.db-card-panel');

    if (mode === 'all') {
        kpiCards.forEach(c => c.style.display = 'block');
        chartPanels.forEach(c => c.style.display = 'flex');
    } else {
        kpiCards.forEach(c => {
            c.style.display = c.classList.contains(`view-sec-${mode}`) ? 'block' : 'none';
        });
        chartPanels.forEach(c => {
            c.style.display = c.classList.contains(`view-sec-${mode}`) ? 'flex' : 'none';
        });
    }
}

/* ── 5. TABLE TAB SWITCHER & LIVE CLIENT-SIDE SEARCH ────────── */
function switchTableTab(tabName, btn) {
    document.querySelectorAll('.exp-nav-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.table-tab-pane').forEach(p => p.style.display = 'none');
    const activePane = document.getElementById(`tableTab-${tabName}`);
    if (activePane) activePane.style.display = 'block';

    // Clear and re-apply search if exists
    filterActiveTable();
}

function filterActiveTable() {
    const query = document.getElementById('dbTableSearch').value.toLowerCase().trim();
    const activePane = document.querySelector('.table-tab-pane:not([style*="display: none"])');
    if (!activePane) return;

    const rows = activePane.querySelectorAll('.searchable-row');
    rows.forEach(row => {
        const text = row.getAttribute('data-search') || '';
        if (text.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


/* ── 7. CHART.JS VISUALISASI DATA ───────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    // Chart 1: PC Fleet Health
    const ctxPc = document.getElementById('chartPcHealth')?.getContext('2d');
    if (ctxPc) {
        new Chart(ctxPc, {
            type: 'doughnut',
            data: {
                labels: ['Bagus', 'Aman', 'Under'],
                datasets: [{
                    data: [{{ $bagusCount }}, {{ $amanCount }}, {{ $underCount }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    hoverBackgroundColor: ['#059669', '#d97706', '#dc2626'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: (evt, elements) => {
                    if (elements && elements.length > 0) {
                        const idx = elements[0].index;
                        const statuses = ['BAGUS', 'AMAN', 'UNDER'];
                        const selectedStatus = statuses[idx] || 'ALL';
                        openPcStatusModal(selectedStatus);
                    } else {
                        openPcStatusModal('ALL');
                    }
                },
                onHover: (evt, elements) => {
                    if (evt && evt.native && evt.native.target) {
                        evt.native.target.style.cursor = (elements && elements.length > 0) ? 'pointer' : 'default';
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = {{ $totalPc }} || 1;
                                const val = ctx.raw || 0;
                                const pct = Math.round((val / total) * 100);
                                return ` ${ctx.label}: ${val} Unit (${pct}%) — Klik untuk lihat daftar`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Chart 2: Ketersediaan Stok Sparepart
    const ctxStock = document.getElementById('chartStockHealth')?.getContext('2d');
    if (ctxStock) {
        new Chart(ctxStock, {
            type: 'doughnut',
            data: {
                labels: ['Aman (>5)', 'Menipis (≤5)', 'Habis (0)'],
                datasets: [{
                    data: [{{ $partAmanCount }}, {{ $partMenipisCount }}, {{ $partHabisCount }}],
                    backgroundColor: ['#059669', '#d97706', '#dc2626'],
                    hoverBackgroundColor: ['#047857', '#b45309', '#b91c1c'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = {{ $totalParts }} || 1;
                                const val = ctx.raw || 0;
                                const pct = Math.round((val / total) * 100);
                                return ` ${ctx.label}: ${val} Part (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Chart 3: Penyelesaian Servis
    const ctxService = document.getElementById('chartServiceStatus')?.getContext('2d');
    if (ctxService) {
        new Chart(ctxService, {
            type: 'doughnut',
            data: {
                labels: ['Selesai Service', 'Service Suplier', 'Belum / Sudah Cek'],
                datasets: [{
                    data: [{{ $selesaiCount }}, {{ $suplierCount }}, {{ $belumCekCount + $sudahCekCount }}],
                    backgroundColor: ['#10b981', '#8b5cf6', '#f97316'],
                    hoverBackgroundColor: ['#059669', '#7c3aed', '#ea580c'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ` ${ctx.label}: ${ctx.raw} Tiket`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Chart 4: Top Departemen PC (Horizontal Bar)
    const ctxDept = document.getElementById('chartDeptDist')?.getContext('2d');
    if (ctxDept) {
        const deptLabels = {!! json_encode($topDepts->pluck('dept')) !!};
        const deptTotals = {!! json_encode($topDepts->pluck('total')) !!};
        new Chart(ctxDept, {
            type: 'bar',
            data: {
                labels: deptLabels,
                datasets: [{
                    label: 'Jumlah PC',
                    data: deptTotals,
                    backgroundColor: 'rgba(37, 99, 235, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { family: "'JetBrains Mono', monospace", size: 10 } },
                        grid: { color: 'rgba(226, 232, 240, 0.6)' }
                    },
                    y: {
                        ticks: { font: { weight: 600, size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Chart 5: Kategori Perputaran Part (Moving Categories)
    const ctxMoving = document.getElementById('chartMovingDist')?.getContext('2d');
    if (ctxMoving) {
        const movingLabels = {!! json_encode($partMovingStats->pluck('moving')) !!};
        const movingTotals = {!! json_encode($partMovingStats->pluck('total')) !!};
        new Chart(ctxMoving, {
            type: 'bar',
            data: {
                labels: movingLabels,
                datasets: [{
                    label: 'Jumlah Part',
                    data: movingTotals,
                    backgroundColor: [
                        'rgba(6, 182, 212, 0.85)',
                        'rgba(244, 63, 94, 0.85)',
                        'rgba(139, 92, 246, 0.85)',
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(16, 185, 129, 0.85)'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { family: "'JetBrains Mono', monospace", size: 10 } },
                        grid: { color: 'rgba(226, 232, 240, 0.6)' }
                    },
                    x: {
                        ticks: { font: { weight: 600, size: 10 } },
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endsection