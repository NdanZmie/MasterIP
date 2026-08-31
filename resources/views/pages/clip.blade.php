@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Syne:wght@700;800&display=swap');

    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --primary-light: #eff6ff;
        --primary-glow: rgba(37,99,235,0.18);
        --cyan: #06b6d4;
        --cyan-glow: rgba(6,182,212,0.20);
        --emerald: #10b981;
        --emerald-glow: rgba(16,185,129,0.22);
        --amber: #f59e0b;
        --purple: #8b5cf6;
        --surface: rgba(255,255,255,0.85);
        --surface-card: rgba(255,255,255,0.92);
        --surface-hover: rgba(255,255,255,0.98);
        --border: rgba(37,99,235,0.12);
        --border-strong: rgba(37,99,235,0.24);
        --text-head: #0f172a;
        --text-body: #334155;
        --text-muted: #64748b;
        --radius: 16px;
        --radius-sm: 10px;
    }

    .clip-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }
    .font-syne { font-family: 'Syne', sans-serif !important; }

    .clip-wrap {
        min-height: 100vh;
        padding-top: 10px;
        padding-bottom: 60px;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0;
        padding-left: 12px;
        padding-right: 12px;
        box-sizing: border-box;
    }

    /* ── PAGE HEADER ── */
    .clip-header {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 22px;
        animation: slideDown 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .clip-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .title-left { display: flex; align-items: center; gap: 14px; }
    .page-icon {
        width: 48px; height: 48px; border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(37,99,235,0.35);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .page-icon::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent);
    }
    .page-icon svg { width: 24px; height: 24px; stroke: #fff; position: relative; z-index: 1; }
    .page-title { font-size: 1.55rem; font-weight: 800; color: var(--text-head); letter-spacing: -0.03em; }
    .page-subtitle { font-size: 0.82rem; color: var(--text-muted); font-weight: 500; margin-top: 1px; }

    /* Top Action Buttons */
    .top-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .btn-top {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.79rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
        white-space: nowrap;
    }
    .btn-copy-all {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(239,68,68,0.32);
    }
    .btn-copy-all:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 20px rgba(239,68,68,0.45);
    }
    .btn-download-script {
        background: rgba(37,99,235,0.08);
        color: #2563eb;
        border: 1px solid rgba(37,99,235,0.22);
    }
    .btn-download-script:hover {
        background: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(37,99,235,0.3);
    }
    .btn-add-custom {
        background: rgba(139,92,246,0.1);
        color: #7c3aed;
        border: 1px solid rgba(139,92,246,0.25);
    }
    .btn-add-custom:hover {
        background: #7c3aed;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(139,92,246,0.3);
    }

    /* ── STATS COUNTER BAR ── */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) { .stats-bar { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .stats-bar { grid-template-columns: 1fr; } }

    .stat-pill {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.02);
        transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
    }
    .stat-pill:hover {
        transform: translateY(-2px);
        border-color: var(--border-strong);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }
    .stat-pill-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-pill-icon.blue { background: rgba(37,99,235,0.12); color: #2563eb; }
    .stat-pill-icon.emerald { background: rgba(16,185,129,0.12); color: #059669; }
    .stat-pill-icon.cyan { background: rgba(6,182,212,0.12); color: #0891b2; }
    .stat-pill-icon.purple { background: rgba(139,92,246,0.12); color: #7c3aed; }
    .stat-pill-icon svg { width: 19px; height: 19px; }
    .stat-pill-val { font-size: 1.25rem; font-weight: 800; color: var(--text-head); line-height: 1.1; }
    .stat-pill-lbl { font-size: 0.68rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 1px; }

    /* ── TOOLBAR / SEARCH & CATEGORIES ── */
    .toolbar-box {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 12px 16px;
        margin-bottom: 20px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }
    .search-input-wrap {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.95);
        border: 1.5px solid var(--border-strong);
        border-radius: 50px;
        overflow: hidden;
        min-width: 280px;
        flex: 1;
        max-width: 460px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input-wrap:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }
    .search-input-wrap svg {
        margin-left: 14px;
        width: 16px; height: 16px; color: var(--text-muted); flex-shrink: 0;
    }
    .search-input-wrap input {
        border: none; outline: none; background: transparent;
        padding: 9px 12px; font-size: 0.82rem; color: var(--text-body);
        width: 100%;
    }
    .search-input-wrap .search-clear {
        background: none; border: none; padding: 0 12px;
        color: #94a3b8; cursor: pointer; display: none;
    }
    .search-input-wrap .search-clear.show { display: block; }
    .search-input-wrap .search-clear:hover { color: #0f172a; }

    /* Category Pill Tabs */
    .cat-tabs {
        display: flex;
        align-items: center;
        background: rgba(241,245,249,0.85);
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: 3px;
        gap: 3px;
        overflow-x: auto;
    }
    .cat-tab {
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 50px;
        color: var(--text-muted);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .cat-tab.active {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .cat-tab:hover:not(.active) {
        color: var(--text-head);
    }
    .cat-badge-count {
        font-size: 0.65rem;
        padding: 1px 6px;
        border-radius: 20px;
        background: rgba(148,163,184,0.2);
        color: #475569;
    }
    .cat-tab.active .cat-badge-count {
        background: rgba(37,99,235,0.12);
        color: #2563eb;
    }

    /* ── QUICK TIPS BANNER ── */
    .tips-banner {
        background: linear-gradient(135deg, rgba(37,99,235,0.06), rgba(6,182,212,0.06));
        border: 1px solid rgba(37,99,235,0.18);
        border-radius: 14px;
        padding: 12px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .tips-content {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.80rem;
        color: #1e293b;
    }
    .tips-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: #2563eb; color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .tips-icon svg { width: 16px; height: 16px; }
    .kbd-shortcut {
        display: inline-block;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        border-radius: 5px;
        padding: 1px 6px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.72rem;
        font-weight: 700;
        color: #334155;
        margin: 0 2px;
    }

    /* ── COMMAND GRID ── */
    .commands-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }
    @media (max-width: 992px) { .commands-grid { grid-template-columns: 1fr; } }

    .command-card {
        background: var(--surface-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 12px;
    }
    .command-card:hover {
        transform: translateY(-3px);
        border-color: rgba(37,99,235,0.35);
        box-shadow: 0 8px 28px rgba(37,99,235,0.12);
        background: var(--surface-hover);
    }
    .command-card.highlight {
        animation: pulseHighlight 1s ease-out;
    }
    @keyframes pulseHighlight {
        0% { box-shadow: 0 0 0 0 rgba(37,99,235,0.5); }
        70% { box-shadow: 0 0 0 10px rgba(37,99,235,0); }
        100% { box-shadow: 0 0 0 0 rgba(37,99,235,0); }
    }

    .cmd-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }
    .cmd-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .cmd-title {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cmd-desc {
        font-size: 0.76rem;
        color: #64748b;
        line-height: 1.4;
    }

    /* Badges */
    .badge-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    .badge-tag.ps {
        background: rgba(37,99,235,0.1);
        color: #1d4ed8;
        border: 1px solid rgba(37,99,235,0.25);
    }
    .badge-tag.cmd {
        background: rgba(15,23,42,0.08);
        color: #0f172a;
        border: 1px solid rgba(15,23,42,0.18);
    }
    .badge-tag.admin {
        background: rgba(239,68,68,0.1);
        color: #dc2626;
        border: 1px solid rgba(239,68,68,0.25);
    }
    .badge-tag.hardware {
        background: rgba(6,182,212,0.1);
        color: #0891b2;
        border: 1px solid rgba(6,182,212,0.25);
    }
    .badge-tag.os {
        background: rgba(139,92,246,0.1);
        color: #7c3aed;
        border: 1px solid rgba(139,92,246,0.25);
    }
    .badge-tag.network {
        background: rgba(16,185,129,0.1);
        color: #059669;
        border: 1px solid rgba(16,185,129,0.25);
    }

    /* Code Block inside Card */
    .cmd-code-wrap {
        background: #090f1d;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 10px 14px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: inset 0 2px 6px rgba(0,0,0,0.4);
    }
    .cmd-code {
        color: #38bdf8;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.79rem;
        font-weight: 500;
        white-space: pre-wrap;
        word-break: break-all;
        line-height: 1.45;
        flex: 1;
    }
    .cmd-code-wrap:hover .cmd-code {
        color: #7dd3fc;
    }

    /* Action Buttons in Card */
    .cmd-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 4px;
    }
    .cmd-footer-meta {
        font-size: 0.70rem;
        color: #94a3b8;
        font-family: 'JetBrains Mono', monospace;
    }

    .btn-copy {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
        box-shadow: 0 2px 8px rgba(37,99,235,0.25);
        flex-shrink: 0;
    }
    .btn-copy:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37,99,235,0.4);
    }
    .btn-copy.copied {
        background: #059669 !important;
        box-shadow: 0 2px 10px rgba(5,150,105,0.4) !important;
        transform: scale(0.97);
    }
    .btn-copy svg { width: 13px; height: 13px; flex-shrink: 0; }

    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 50px 20px;
        background: var(--surface);
        border: 1px dashed var(--border-strong);
        border-radius: 16px;
        color: var(--text-muted);
    }
    .empty-state svg {
        width: 44px; height: 44px; margin: 0 auto 12px; opacity: 0.4; display: block;
    }

    /* ── ALL-IN-ONE HERO SECTION ── */
    .hero-script-box {
        background: linear-gradient(135deg, #090f1d 0%, #0d1a35 100%);
        border: 1px solid rgba(59,130,246,0.3);
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 28px;
        box-shadow: 0 12px 36px rgba(6,13,31,0.25), inset 0 1px 0 rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
    }
    .hero-script-box::before {
        content: '';
        position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, transparent 60%);
        pointer-events: none;
    }
    .hero-script-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    .hero-script-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 800;
    }
    .hero-script-title span.badge-hero {
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: #fff;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.08em;
    }
    .hero-code-container {
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 14px 18px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.81rem;
        color: #67e8f9;
        line-height: 1.5;
        white-space: pre-wrap;
        word-break: break-all;
        position: relative;
        z-index: 1;
        margin-bottom: 14px;
        max-height: 160px;
        overflow-y: auto;
    }

    /* ── CUSTOM SNIPPET MODAL ── */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(6,13,31,0.75);
        backdrop-filter: blur(8px);
        display: none; align-items: center; justify-content: center;
        padding: 20px;
    }
    .modal-backdrop.show { display: flex !important; animation: fadeIn 0.2s ease-out; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    .modal-card {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.8);
        overflow: hidden;
        animation: scaleUp 0.25s cubic-bezier(0.16,1,0.3,1);
    }
    @keyframes scaleUp {
        from { transform: scale(0.94) translateY(10px); opacity:0; }
        to   { transform: scale(1) translateY(0); opacity:1; }
    }
    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
    }
    .modal-header h3 {
        font-size: 1.05rem; font-weight: 800; color: #0f172a;
        display: flex; align-items: center; gap: 8px;
    }
    .modal-close {
        background: transparent; border: none; cursor: pointer;
        color: #94a3b8; padding: 4px; border-radius: 6px;
        transition: color 0.2s, background 0.2s;
    }
    .modal-close:hover { color: #0f172a; background: #e2e8f0; }
    .modal-body { padding: 20px; max-height: 78vh; overflow-y: auto; }
    .modal-footer {
        padding: 14px 20px; border-top: 1px solid #e2e8f0;
        background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;
    }

    .form-group { margin-bottom: 14px; }
    .form-group label {
        display: block; font-size: 0.78rem; font-weight: 700; color: #334155; margin-bottom: 5px;
    }
    .form-control {
        width: 100%; padding: 8px 12px;
        border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 0.84rem; color: #0f172a; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .form-control:focus {
        border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }
    textarea.form-control { resize: vertical; min-height: 75px; }

    .btn-cancel {
        padding: 8px 16px; font-size: 0.80rem; font-weight: 600;
        color: #475569; background: #e2e8f0; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #cbd5e1; }
    .btn-submit-modal {
        padding: 8px 18px; font-size: 0.80rem; font-weight: 700;
        color: #fff; background: #2563eb; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-submit-modal:hover { background: #1d4ed8; box-shadow: 0 4px 14px rgba(37,99,235,0.3); }

    /* Custom item delete button */
    .btn-del-custom {
        background: none; border: none; color: #ef4444; cursor: pointer;
        padding: 3px 6px; border-radius: 4px; font-size: 0.72rem;
        transition: background 0.15s;
    }
    .btn-del-custom:hover { background: rgba(239,68,68,0.1); }
</style>

<div class="clip-wrap">

    {{-- ═══════════════════════════════════════════
       HEADER & ACTIONS
    ═══════════════════════════════════════════ --}}
    <div class="clip-header">
        <div class="clip-title-row">
            <div class="title-left">
                <div class="page-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">Command Clipboard & Toolset</h1>
                    <p class="page-subtitle">Kumpulan perintah audit hardware, lisensi Windows, network diagnosa, dan script otomatisasi EDP</p>
                </div>
            </div>

            <div class="top-actions">
                {{-- Copy All Visible --}}
                <button type="button" class="btn-top btn-copy-all" onclick="copyAllCurrent()">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                    </svg>
                    <span>Copy Semua Command</span>
                </button>

                {{-- Download Script (.bat) --}}
                <button type="button" class="btn-top btn-download-script" onclick="downloadBatchFile()">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Download Script (.bat)</span>
                </button>

                {{-- Tambah Snippet Custom --}}
                <button type="button" class="btn-top btn-add-custom" onclick="openModal('modalCustomSnippet')">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Custom Snippet</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
       STATISTICS COUNTER
    ═══════════════════════════════════════════ --}}
    <div class="stats-bar">
        <div class="stat-pill">
            <div class="stat-pill-icon blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <div>
                <div class="stat-pill-val" id="countTotal">0</div>
                <div class="stat-pill-lbl">Total Perintah</div>
            </div>
        </div>

        <div class="stat-pill">
            <div class="stat-pill-icon cyan">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
            </div>
            <div>
                <div class="stat-pill-val" id="countHardware">0</div>
                <div class="stat-pill-lbl">Hardware & Spek</div>
            </div>
        </div>

        <div class="stat-pill">
            <div class="stat-pill-icon emerald">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </div>
            <div>
                <div class="stat-pill-val" id="countNetwork">0</div>
                <div class="stat-pill-lbl">Network & IP</div>
            </div>
        </div>

        <div class="stat-pill">
            <div class="stat-pill-icon purple">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <div class="stat-pill-val" id="countCustom">0</div>
                <div class="stat-pill-lbl">Custom Snippets</div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
       HERO: ALL-IN-ONE SYSTEM EXTRACTOR SCRIPT
    ═══════════════════════════════════════════ --}}
    <div class="hero-script-box">
        <div class="hero-script-header">
            <div class="hero-script-title">
                <svg style="width:20px;height:20px;color:#38bdf8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Script All-in-One Spek PC (1-Baris PowerShell)</span>
                <span class="badge-hero">RECOMMENDED</span>
            </div>
            <button type="button" class="btn-copy" onclick="copyHeroScript(this)">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                <span>Copy 1-Liner Script</span>
            </button>
        </div>
        <p style="font-size:0.78rem; color:#94a3b8; margin-bottom:10px; position:relative; z-index:1;">
            Jalankan perintah ini di PowerShell pada PC target untuk langsung mengekstrak ComputerName, Serial Number BIOS, Processor, Total RAM (GB), Storage & Harddisk, serta Versi OS dalam satu tabel rapi.
        </p>
        <div class="hero-code-container" id="heroScriptCode">powershell -NoProfile -Command "Write-Host '=== INFORMASI SPESIFIKASI PC (MASTERIP) ===' -ForegroundColor Cyan; Get-CimInstance Win32_OperatingSystem | Select-Object @{N='ComputerName';E={$_.CSName}}, @{N='OS';E={$_.Caption}}, @{N='Arch';E={$_.OSArchitecture}}; Get-CimInstance Win32_Processor | Select-Object @{N='Processor';E={$_.Name}}; Get-CimInstance Win32_Bios | Select-Object @{N='SerialNumber';E={$_.SerialNumber}}; Get-CimInstance Win32_PhysicalMemory | Measure-Object -Property Capacity -Sum | Select-Object @{N='TotalRAM(GB)';E={[math]::Round($_.Sum/1GB)}}; Get-CimInstance Win32_DiskDrive | Select-Object Model, @{N='Size(GB)';E={[math]::Round($_.Size/1GB)}} | Format-List"</div>
    </div>

    {{-- ═══════════════════════════════════════════
       SEARCH & CATEGORY TOOLBAR
    ═══════════════════════════════════════════ --}}
    <div class="toolbar-box">
        <div class="search-input-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari nama perintah, deskripsi, atau kata kunci (contoh: ram, bios, ip)..." oninput="filterCommands()">
            <button type="button" class="search-clear" id="searchClear" onclick="clearSearch()">✕</button>
        </div>

        <div class="cat-tabs">
            <button type="button" class="cat-tab active" data-cat="all" onclick="selectCategory('all', this)">
                <span>Semua</span>
                <span class="cat-badge-count" id="badgeAll">0</span>
            </button>
            <button type="button" class="cat-tab" data-cat="hardware" onclick="selectCategory('hardware', this)">
                <span>🖥️ Hardware</span>
                <span class="cat-badge-count" id="badgeHw">0</span>
            </button>
            <button type="button" class="cat-tab" data-cat="os" onclick="selectCategory('os', this)">
                <span>🪟 OS & Lisensi</span>
                <span class="cat-badge-count" id="badgeOs">0</span>
            </button>
            <button type="button" class="cat-tab" data-cat="network" onclick="selectCategory('network', this)">
                <span>🌐 Network & IP</span>
                <span class="cat-badge-count" id="badgeNet">0</span>
            </button>
            <button type="button" class="cat-tab" data-cat="diagnostics" onclick="selectCategory('diagnostics', this)">
                <span>⚡ Diagnostik</span>
                <span class="cat-badge-count" id="badgeDiag">0</span>
            </button>
            <button type="button" class="cat-tab" data-cat="custom" onclick="selectCategory('custom', this)">
                <span>⭐ Custom</span>
                <span class="cat-badge-count" id="badgeCust">0</span>
            </button>
        </div>
    </div>

    {{-- Quick Tips Banner --}}
    <div class="tips-banner">
        <div class="tips-content">
            <div class="tips-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
            </div>
            <div>
                <strong>Tips Cepat EDP:</strong> Buka CMD / PowerShell di Windows dengan menekan <span class="kbd-shortcut">Win + R</span> &rarr; ketik <span class="kbd-shortcut">powershell</span> atau <span class="kbd-shortcut">cmd</span> &rarr; tekan <span class="kbd-shortcut">Enter</span>. Klik tombol <strong>Copy</strong> untuk menyalin dan tempel menggunakan <span class="kbd-shortcut">Ctrl + V</span> atau klik kanan.
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
       COMMAND CARDS GRID
    ═══════════════════════════════════════════ --}}
    <div class="commands-grid" id="commandsContainer">
        {{-- Diisi secara dinamis via JavaScript --}}
    </div>

</div>

{{-- ═══════════════════════════════════════════
   MODAL TAMBAH CUSTOM SNIPPET
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalCustomSnippet">
    <div class="modal-card">
        <form onsubmit="saveCustomSnippet(event)">
            <div class="modal-header">
                <h3>
                    <svg style="width:18px;height:18px;color:#7c3aed;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Snippet Command Baru
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalCustomSnippet')">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul / Nama Perintah <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="custTitle" class="form-control" placeholder="Contoh: Cek Versi Microsoft Office / IP Scanner" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat (Opsional)</label>
                    <input type="text" id="custDesc" class="form-control" placeholder="Contoh: Menampilkan status lisensi dan registrasi aplikasi">
                </div>

                <div class="form-group">
                    <label>Shell Environment & Kategori</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                        <select id="custShell" class="form-control">
                            <option value="CMD">CMD / Batch</option>
                            <option value="PowerShell">PowerShell</option>
                        </select>
                        <select id="custCategory" class="form-control">
                            <option value="custom">Custom Snippets</option>
                            <option value="hardware">Hardware</option>
                            <option value="os">OS & Lisensi</option>
                            <option value="network">Network & IP</option>
                            <option value="diagnostics">Diagnostik</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Perintah / Script Command <span style="color:#ef4444;">*</span></label>
                    <textarea id="custCode" class="form-control font-mono" placeholder="Masukkan baris perintah di sini..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalCustomSnippet')">Batal</button>
                <button type="submit" class="btn-submit-modal">Simpan Snippet</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   JAVASCRIPT CORE
═══════════════════════════════════════════ --}}
<script>
    // Master data command built-in
    const BUILTIN_COMMANDS = [
        // ── HARDWARE ──
        {
            id: 'hw-cpu',
            title: 'Model & Spesifikasi Processor (CPU)',
            desc: 'Menampilkan nama lengkap processor, arsitektur, dan clock speed',
            code: 'wmic cpu get name',
            shell: 'CMD / WMIC',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-bios-sn',
            title: 'Nomor Seri BIOS / Serial Number PC',
            desc: 'Mengambil Serial Number / Service Tag hardware untuk database SpekPC',
            code: 'wmic bios get serialnumber',
            shell: 'CMD / WMIC',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-motherboard',
            title: 'Informasi Motherboard / Baseboard',
            desc: 'Menampilkan merk manufaktur dan model motherboard PC / laptop',
            code: 'wmic baseboard get product,Manufacturer',
            shell: 'CMD / WMIC',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-ram-total',
            title: 'Kapasitas Total RAM (dalam GB Bulat)',
            desc: 'Menghitung total kapasitas memori RAM fisik yang terpasang dalam satuan GB',
            code: 'powershell "[math]::Round((Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory/1GB)"',
            shell: 'PowerShell',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-ram-slots',
            title: 'Rincian Slot & Kecepatan Tiap Keping RAM',
            desc: 'Melihat rincian slot RAM terpakai, kapasitas per slot, merk, dan speed (MHz)',
            code: 'wmic memorychip get capacity,speed,devicelocator,manufacturer',
            shell: 'CMD / WMIC',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-disk-summary',
            title: 'Model & Kapasitas Hard Disk / SSD (GB)',
            desc: 'Daftar semua drive penyimpanan fisik beserta ukurannya dalam GB',
            code: 'powershell "Get-CimInstance Win32_DiskDrive | Select Model,@{Name=\'Size(GB)\';Expression={[math]::Round($_.Size/1GB)}}"',
            shell: 'PowerShell',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-storage-type',
            title: 'Deteksi Tipe Drive (SSD vs HDD)',
            desc: 'Mendeteksi apakah media penyimpanan bertipe SSD, HDD, atau NVMe',
            code: 'powershell "Get-PhysicalDisk | Select FriendlyName,MediaType,BusType,Size"',
            shell: 'PowerShell',
            category: 'hardware',
            admin: false
        },
        {
            id: 'hw-gpu',
            title: 'Grafis / Kartu Display VGA',
            desc: 'Melihat nama kartu grafis GPU (Intel UHD, AMD Radeon, NVIDIA GeForce)',
            code: 'wmic path win32_VideoController get name,AdapterRAM',
            shell: 'CMD / WMIC',
            category: 'hardware',
            admin: false
        },

        // ── OS & LISENSI ──
        {
            id: 'os-arch',
            title: 'Arsitektur Sistem Operasi (32-bit / 64-bit)',
            desc: 'Mengecek tipe bit arsitektur Windows yang terinstal',
            code: 'wmic os get osarchitecture',
            shell: 'CMD / WMIC',
            category: 'os',
            admin: false
        },
        {
            id: 'os-edition-build',
            title: 'Edisi Lengkap Windows & Nomor Build',
            desc: 'Menampilkan nama edisi Windows (Home/Pro/Enterprise) dan nomor OS Build',
            code: 'powershell "(Get-CimInstance Win32_OperatingSystem).Caption + \' - Build \' + (Get-CimInstance Win32_OperatingSystem).BuildNumber"',
            shell: 'PowerShell',
            category: 'os',
            admin: false
        },
        {
            id: 'os-prod-key',
            title: 'Original OEM Product Key dari BIOS',
            desc: 'Mengambil lisensi Windows asli yang tertanam pada motherboard BIOS / UEFI',
            code: 'wmic path softwarelicensingservice get OA3xOriginalProductKey',
            shell: 'CMD / WMIC',
            category: 'os',
            admin: true
        },
        {
            id: 'os-act-status',
            title: 'Cek Status Masa Aktif Lisensi Windows',
            desc: 'Membuka popup status aktivasi permanen Windows (slmgr)',
            code: 'slmgr /xpr',
            shell: 'CMD',
            category: 'os',
            admin: false
        },
        {
            id: 'os-install-date',
            title: 'Tanggal & Waktu Instalasi Windows',
            desc: 'Mengecek kapan Windows pertama kali diinstal pada komputer ini',
            code: 'powershell "([WMI]\'\').ConvertToDateTime((Get-CimInstance Win32_OperatingSystem).InstallDate)"',
            shell: 'PowerShell',
            category: 'os',
            admin: false
        },

        // ── NETWORK & IP ──
        {
            id: 'net-ip-all',
            title: 'Konfigurasi Lengkap Network & IP (ipconfig)',
            desc: 'Melihat IPv4, Subnet, Default Gateway, DNS Server, dan DHCP IP',
            code: 'ipconfig /all',
            shell: 'CMD',
            category: 'network',
            admin: false
        },
        {
            id: 'net-ip-summary',
            title: 'Ringkasan IPv4 Adapter Aktif',
            desc: 'Daftar ringkas nama adapter LAN/Wi-Fi dan alamat IP yang terpasang',
            code: 'powershell "Get-NetIPAddress -AddressFamily IPv4 | Where-Object {$_.InterfaceAlias -notlike \'*Loopback*\'} | Select InterfaceAlias,IPAddress"',
            shell: 'PowerShell',
            category: 'network',
            admin: false
        },
        {
            id: 'net-mac-address',
            title: 'MAC Address (Physical Address) Network Card',
            desc: 'Melihat Physical Address (MAC) tiap interface jaringan untuk whitelist IP',
            code: 'getmac /v',
            shell: 'CMD',
            category: 'network',
            admin: false
        },
        {
            id: 'net-flush-dns',
            title: 'Flush DNS Cache',
            desc: 'Membersihkan cache DNS lokal saat terjadi masalah koneksi atau resolve domain',
            code: 'ipconfig /flushdns',
            shell: 'CMD',
            category: 'network',
            admin: true
        },
        {
            id: 'net-listening-ports',
            title: 'Cek Port Listening & Koneksi Aktif',
            desc: 'Menampilkan port TCP/UDP yang sedang aktif terbuka di komputer',
            code: 'netstat -ano | findstr LISTENING',
            shell: 'CMD',
            category: 'network',
            admin: false
        },
        {
            id: 'net-ping-loop',
            title: 'Continuous Ping Gateway / Toko',
            desc: 'Melakukan ping berkala tanpa batas untuk monitor kestabilan koneksi toko',
            code: 'ping 192.168.1.1 -t',
            shell: 'CMD',
            category: 'network',
            admin: false
        },

        // ── DIAGNOSTIK ──
        {
            id: 'diag-hostname',
            title: 'Nama Komputer (Computer Name / Hostname)',
            desc: 'Menampilkan nama komputer yang terdaftar di jaringan',
            code: 'hostname',
            shell: 'CMD',
            category: 'diagnostics',
            admin: false
        },
        {
            id: 'diag-whoami',
            title: 'User Login & Hak Akses (WhoAmI)',
            desc: 'Mengecek username yang sedang aktif di session Windows',
            code: 'whoami',
            shell: 'CMD',
            category: 'diagnostics',
            admin: false
        },
        {
            id: 'diag-uptime',
            title: 'System Uptime (Lama PC Hidup Tanpa Restart)',
            desc: 'Melihat durasi waktu komputer menyala sejak reboot terakhir',
            code: 'powershell "(Get-Date) - (Get-CimInstance Win32_OperatingSystem).LastBootUpTime"',
            shell: 'PowerShell',
            category: 'diagnostics',
            admin: false
        },
        {
            id: 'diag-disk-smart',
            title: 'Health & Status S.M.A.R.T Drive',
            desc: 'Pengecekan status kesehatan fisik drive (Status: OK)',
            code: 'wmic diskdrive get status,model',
            shell: 'CMD / WMIC',
            category: 'diagnostics',
            admin: false
        },
        {
            id: 'diag-battery-report',
            title: 'Generate Laporan Baterai Laptop (HTML Report)',
            desc: 'Membuat file laporan cycle count & kapasitas baterai di Desktop',
            code: 'powercfg /batteryreport /output "%USERPROFILE%\\Desktop\\battery_report.html"',
            shell: 'CMD',
            category: 'diagnostics',
            admin: true
        }
    ];

    let currentCategory = 'all';
    let searchQuery = '';

    // Load custom snippets from localStorage
    function getCustomSnippets() {
        try {
            const raw = localStorage.getItem('masterip_custom_snippets');
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCustomSnippetsArray(arr) {
        localStorage.setItem('masterip_custom_snippets', JSON.stringify(arr));
    }

    function getAllCommands() {
        return [...BUILTIN_COMMANDS, ...getCustomSnippets()];
    }

    // Render list
    function renderCommands() {
        const container = document.getElementById('commandsContainer');
        const all = getAllCommands();

        // Update counts
        document.getElementById('countTotal').innerText = all.length;
        document.getElementById('countHardware').innerText = all.filter(c => c.category === 'hardware').length;
        document.getElementById('countNetwork').innerText = all.filter(c => c.category === 'network').length;
        document.getElementById('countCustom').innerText = getCustomSnippets().length;

        document.getElementById('badgeAll').innerText = all.length;
        document.getElementById('badgeHw').innerText = all.filter(c => c.category === 'hardware').length;
        document.getElementById('badgeOs').innerText = all.filter(c => c.category === 'os').length;
        document.getElementById('badgeNet').innerText = all.filter(c => c.category === 'network').length;
        document.getElementById('badgeDiag').innerText = all.filter(c => c.category === 'diagnostics').length;
        document.getElementById('badgeCust').innerText = getCustomSnippets().length;

        // Filter
        const q = searchQuery.toLowerCase().trim();
        const filtered = all.filter(item => {
            const matchCat = (currentCategory === 'all') || (item.category === currentCategory);
            const matchSearch = !q ||
                item.title.toLowerCase().includes(q) ||
                item.desc.toLowerCase().includes(q) ||
                item.code.toLowerCase().includes(q) ||
                item.shell.toLowerCase().includes(q);
            return matchCat && matchSearch;
        });

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <p style="font-weight:700; font-size:0.95rem; color:#334155;">Tidak ada perintah yang cocok</p>
                    <p style="font-size:0.78rem; margin-top:3px;">Coba gunakan kata kunci pencarian lain atau pilih tab kategori berbeda.</p>
                </div>
            `;
            return;
        }

        let html = '';
        filtered.forEach((cmd, idx) => {
            const isCustom = cmd.id && cmd.id.startsWith('cust-');
            const shellBadgeClass = cmd.shell.toLowerCase().includes('powershell') ? 'ps' : 'cmd';
            const catBadgeClass = cmd.category || 'hardware';

            let catLabel = 'Hardware';
            if (cmd.category === 'os') catLabel = 'OS & Lisensi';
            else if (cmd.category === 'network') catLabel = 'Network';
            else if (cmd.category === 'diagnostics') catLabel = 'Diagnostik';
            else if (cmd.category === 'custom') catLabel = 'Custom';

            html += `
                <div class="command-card" id="card-${cmd.id || idx}">
                    <div>
                        <div class="cmd-card-top">
                            <div class="cmd-info">
                                <div class="cmd-title">
                                    <span>${escapeHtml(cmd.title)}</span>
                                </div>
                                <div class="cmd-desc">${escapeHtml(cmd.desc || '')}</div>
                            </div>
                            <div style="display:flex; align-items:center; gap:5px; flex-shrink:0;">
                                <span class="badge-tag ${shellBadgeClass}">${escapeHtml(cmd.shell)}</span>
                                <span class="badge-tag ${catBadgeClass}">${catLabel}</span>
                                ${cmd.admin ? '<span class="badge-tag admin" title="Memerlukan Run as Administrator">Admin</span>' : ''}
                                ${isCustom ? `<button class="btn-del-custom" onclick="deleteCustomSnippet('${cmd.id}')" title="Hapus snippet custom">🗑️</button>` : ''}
                            </div>
                        </div>

                        <div class="cmd-code-wrap" style="margin-top:12px;">
                            <code class="cmd-code" id="code-${cmd.id || idx}">${escapeHtml(cmd.code)}</code>
                        </div>
                    </div>

                    <div class="cmd-card-footer">
                        <span class="cmd-footer-meta">📋 Klik copy & tempel ke terminal</span>
                        <button type="button" class="btn-copy" onclick="copySingleCommand(this, '${cmd.id || idx}')">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            <span>Copy Command</span>
                        </button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

    // Copy Single Command
    function copySingleCommand(btn, id) {
        const codeEl = document.getElementById('code-' + id);
        if (!codeEl) return;
        const text = codeEl.innerText;

        copyToClipboard(text, () => {
            const originalHTML = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = `
                <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Tersalin!</span>
            `;
            setTimeout(() => {
                btn.classList.remove('copied');
                btn.innerHTML = originalHTML;
            }, 1800);
        });
    }

    // Copy Hero Script
    function copyHeroScript(btn) {
        const code = document.getElementById('heroScriptCode').innerText;
        copyToClipboard(code, () => {
            const originalHTML = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = `
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Script Tersalin!</span>
            `;
            setTimeout(() => {
                btn.classList.remove('copied');
                btn.innerHTML = originalHTML;
            }, 2000);
        });
    }

    // Copy All Current Filtered Commands
    function copyAllCurrent() {
        const all = getAllCommands();
        const q = searchQuery.toLowerCase().trim();
        const filtered = all.filter(item => {
            const matchCat = (currentCategory === 'all') || (item.category === currentCategory);
            const matchSearch = !q ||
                item.title.toLowerCase().includes(q) ||
                item.desc.toLowerCase().includes(q) ||
                item.code.toLowerCase().includes(q);
            return matchCat && matchSearch;
        });

        if (filtered.length === 0) return;

        let script = ":: ==================================================\n";
        script += ":: MASTERIP COMMAND TOOLSET & AUDIT PC\n";
        script += ":: Generated on: " + new Date().toLocaleString() + "\n";
        script += ":: ==================================================\n\n";

        filtered.forEach(cmd => {
            script += `:: [${cmd.title}]\n`;
            if (cmd.desc) script += `:: Ket: ${cmd.desc}\n`;
            script += `${cmd.code}\n\n`;
        });

        copyToClipboard(script, () => {
            if (window.showToast) {
                window.showToast("Berhasil menyalin seluruh command!", "ok");
            } else {
                alert(`Berhasil menyalin ${filtered.length} perintah ke clipboard!`);
            }
        });
    }

    // Download Batch File
    function downloadBatchFile() {
        const all = getAllCommands();
        let content = "@echo off\n";
        content += "title MasterIP PC Hardware & System Extractor\n";
        content += "color 0A\n";
        content += "echo ======================================================\n";
        content += "echo      MASTERIP - PC HARDWARE & NETWORK AUDIT SCRIPT    \n";
        content += "echo ======================================================\n";
        content += "echo.\n\n";

        all.forEach(cmd => {
            content += `echo --- [ ${cmd.title} ] ---\n`;
            content += `${cmd.code}\n`;
            content += "echo.\n";
        });

        content += "echo ======================================================\n";
        content += "echo Selesai mengekstrak informasi PC.\n";
        content += "echo ======================================================\n";
        content += "pause\n";

        const blob = new Blob([content], { type: 'text/plain;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `masterip_audit_tools_${new Date().toISOString().slice(0,10)}.bat`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    // Core Clipboard function
    function copyToClipboard(text, callback) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                if (callback) callback();
            }).catch(err => {
                fallbackCopy(text, callback);
            });
        } else {
            fallbackCopy(text, callback);
        }
    }

    function fallbackCopy(text, callback) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.left = '-999999px';
        textarea.style.top = '-999999px';
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        try {
            document.execCommand('copy');
            if (callback) callback();
        } catch (err) {
            console.error('Fallback copy failed', err);
        }
        document.body.removeChild(textarea);
    }

    // Filter & Category Handlers
    function selectCategory(cat, btn) {
        currentCategory = cat;
        document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
        if (btn) btn.classList.add('active');
        renderCommands();
    }

    function filterCommands() {
        const input = document.getElementById('searchInput');
        searchQuery = input.value;
        const clearBtn = document.getElementById('searchClear');
        if (searchQuery.length > 0) {
            clearBtn.classList.add('show');
        } else {
            clearBtn.classList.remove('show');
        }
        renderCommands();
    }

    function clearSearch() {
        const input = document.getElementById('searchInput');
        input.value = '';
        searchQuery = '';
        document.getElementById('searchClear').classList.remove('show');
        renderCommands();
    }

    // Custom Snippet Logic
    function saveCustomSnippet(e) {
        e.preventDefault();
        const title = document.getElementById('custTitle').value.trim();
        const desc = document.getElementById('custDesc').value.trim();
        const shell = document.getElementById('custShell').value;
        const category = document.getElementById('custCategory').value;
        const code = document.getElementById('custCode').value.trim();

        if (!title || !code) return;

        const snippets = getCustomSnippets();
        const newSnippet = {
            id: 'cust-' + Date.now(),
            title: title,
            desc: desc || 'Custom command snippet oleh teknisi',
            code: code,
            shell: shell,
            category: category,
            admin: false
        };

        snippets.unshift(newSnippet);
        saveCustomSnippetsArray(snippets);

        closeModal('modalCustomSnippet');
        e.target.reset();
        renderCommands();

        if (window.showToast) {
            window.showToast("Snippet custom berhasil disimpan!", "ok");
        }
    }

    function deleteCustomSnippet(id) {
        if (!confirm('Hapus snippet custom ini?')) return;
        let snippets = getCustomSnippets();
        snippets = snippets.filter(s => s.id !== id);
        saveCustomSnippetsArray(snippets);
        renderCommands();
    }

    // Modal helpers
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.add('show');
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.remove('show');
    }

    // Keyboard shortcut '/' to focus search
    document.addEventListener('keydown', function(e) {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const input = document.getElementById('searchInput');
            if (input) {
                input.focus();
                input.select();
            }
        }
    });

    // Close on backdrop click
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });

        // Initial Render
        renderCommands();
    });
</script>

@endsection