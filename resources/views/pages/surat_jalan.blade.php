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

    .sj-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }
    .font-syne { font-family: 'Syne', sans-serif !important; }

    .sj-wrap {
        min-height: 100vh;
        padding-top: 10px;
        padding-bottom: 60px;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0;
        padding-left: 14px;
        padding-right: 14px;
        box-sizing: border-box;
    }

    /* ── PAGE HEADER ── */
    .sj-header {
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

    .sj-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .title-left { display: flex; align-items: center; gap: 14px; }
    .page-icon {
        width: 50px; height: 50px; border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(37,99,235,0.35);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .page-icon svg { width: 26px; height: 26px; color: #fff; }

    .page-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-head);
        letter-spacing: -0.02em;
        line-height: 1.1;
    }
    .page-subtitle {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .title-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .btn-create-sj {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        color: #ffffff;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(37,99,235,0.35);
        transition: all 0.25s ease;
    }
    .btn-create-sj:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,99,235,0.45);
        color: #fff;
    }

    /* ── STATS ROW ── */
    .sj-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    @media (max-width: 992px) { .sj-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .sj-stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        backdrop-filter: blur(12px);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37,99,235,0.08);
    }
    .stat-meta { display: flex; flex-direction: column; }
    .stat-label { font-size: 0.76rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); }
    .stat-val { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 800; color: var(--text-head); margin-top: 2px; }
    .stat-badge { font-size: 0.72rem; padding: 2px 8px; border-radius: 999px; font-weight: 600; margin-top: 4px; display: inline-block; width: fit-content; }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 22px; height: 22px; }

    /* ── FILTER & TOOLBAR ── */
    .tracking-toolbar {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }

    .type-switcher {
        display: inline-flex;
        background: rgba(241, 245, 249, 0.9);
        border: 1px solid rgba(203, 213, 225, 0.6);
        border-radius: 10px;
        padding: 3px;
        gap: 2px;
    }
    .type-btn {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        color: var(--text-muted);
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        cursor: pointer;
    }
    .type-btn.active {
        background: #ffffff;
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .search-box-wrap {
        position: relative;
        min-width: 260px;
        flex: 1;
        max-width: 420px;
    }
    .search-box-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--text-muted);
    }
    .search-input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border-radius: 10px;
        border: 1px solid rgba(203, 213, 225, 0.8);
        background: #ffffff;
        font-size: 0.85rem;
        color: var(--text-head);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    /* ── TRACKING TABLE CARD ── */
    .tracking-card {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.03);
        backdrop-filter: blur(12px);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    table.tracking-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
    }
    table.tracking-table thead th {
        background: rgba(248, 250, 252, 0.95);
        color: var(--text-muted);
        font-size: 0.74rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 14px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        white-space: nowrap;
    }
    table.tracking-table tbody tr {
        border-bottom: 1px solid rgba(241, 245, 249, 0.9);
        transition: background 0.15s ease;
    }
    table.tracking-table tbody tr:hover {
        background: rgba(239, 246, 255, 0.5);
    }
    table.tracking-table td {
        padding: 13px 14px;
        vertical-align: middle;
        color: var(--text-body);
    }

    /* Badges */
    .badge-tipe {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.03em;
    }
    .badge-tipe-go {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .badge-tipe-normal {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .no-sj-badge {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 600;
        font-size: 0.82rem;
        color: #1e293b;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-action-preview {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .btn-action-preview:hover {
        background: #2563eb;
        color: #ffffff;
    }
    .btn-action-print {
        background: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .btn-action-print:hover {
        background: #059669;
        color: #ffffff;
    }
    .btn-action-delete {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* ── MODALS (General) ── */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.72);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 10000;
        display: none;
        padding: 24px 16px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .modal-backdrop.show {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        animation: fadeIn 0.2s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 60px -15px rgba(0,0,0,0.35);
        width: 100%;
        max-width: 880px;
        max-height: calc(100vh - 48px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        margin: auto;
        transform: scale(0.96);
        animation: modalPop 0.25s cubic-bezier(0.16,1,0.3,1) forwards;
        border: 1px solid rgba(255,255,255,0.6);
        position: relative;
    }
    @keyframes modalPop {
        to { transform: scale(1); }
    }

    #formCreateSj {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        height: 100%;
        overflow: hidden;
    }

    .modal-header {
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        flex-shrink: 0;
        z-index: 10;
    }
    .modal-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-head);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-close-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .modal-close-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .modal-body {
        padding: 22px;
        overflow-y: auto;
        overflow-x: hidden;
        flex: 1;
        min-height: 0;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Sleek scrollbar for modal body */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 8px;
    }
    .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
    }
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        flex-shrink: 0;
        z-index: 10;
        box-shadow: 0 -4px 14px rgba(0,0,0,0.03);
    }

    /* Form UI elements */
    .form-group {
        margin-bottom: 14px;
    }
    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.86rem;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    /* Modal Form Type Segmented Pills */
    .modal-type-chooser {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 14px;
        margin-bottom: 18px;
    }
    .type-choice-card {
        padding: 12px 14px;
        border-radius: 10px;
        border: 2px solid transparent;
        background: transparent;
        cursor: pointer;
        text-align: left;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .type-choice-card.selected {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 4px 14px rgba(37,99,235,0.15);
    }
    .choice-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .choice-title { font-weight: 700; font-size: 0.9rem; color: #0f172a; }
    .choice-desc { font-size: 0.72rem; color: #64748b; margin-top: 1px; }

    /* Items table editor */
    .items-editor-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        padding: 12px;
        margin-top: 14px;
    }
    .items-editor-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .table-editor {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }
    .table-editor th {
        text-align: left;
        padding: 6px 8px;
        font-weight: 600;
        color: #475569;
        font-size: 0.75rem;
    }
    .table-editor td {
        padding: 4px 6px;
        vertical-align: top;
    }
    .table-editor .form-control {
        padding: 6px 8px;
        font-size: 0.8rem;
    }
    .btn-row-del {
        background: transparent;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: background 0.15s;
    }
    .btn-row-del:hover { background: #fee2e2; }

    /* ── PREVIEW MODAL ── */
    #modalPreviewSj .modal-box {
        max-width: 920px;
    }
    .preview-paper {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 24px;
        border-radius: 6px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        font-family: Arial, sans-serif;
        color: #000;
    }

    /* TOAST */
    .toast-popup {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        background: #0f172a;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        pointer-events: none;
    }
    .toast-popup.show {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }
</style>

<div class="sj-wrap">

    <!-- PAGE HEADER -->
    <div class="sj-header">
        <div class="sj-title-row">
            <div class="title-left">
                <div class="page-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">SJ / SURAT JALAN</h1>
                    <p class="page-subtitle">Buat Surat Jalan secara otomatis, tracking pengiriman barang, dan cetak langsung (Format Resmi Indomaret)</p>
                </div>
            </div>

            <div class="title-actions">
                <button type="button" class="btn-create-sj" id="btnOpenCreateModal">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    + Buat Surat Jalan Baru
                </button>
            </div>
        </div>
    </div>

    <!-- STATS OVERVIEW CARDS -->
    <div class="sj-stats-grid">
        <div class="stat-card">
            <div class="stat-meta">
                <span class="stat-label">Total Surat Jalan</span>
                <span class="stat-val font-syne">{{ number_format($totalSj) }}</span>
                <span class="stat-badge" style="background: #eff6ff; color: #2563eb;">Semua Arsip SJ</span>
            </div>
            <div class="stat-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-meta">
                <span class="stat-label">SJ GO Toko</span>
                <span class="stat-val font-syne">{{ number_format($totalGo) }}</span>
                <span class="stat-badge" style="background: #fef3c7; color: #b45309;">Serah Terima GO</span>
            </div>
            <div class="stat-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="1" y="3" width="15" height="13"/>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-meta">
                <span class="stat-label">SJ Normal / Rutin</span>
                <span class="stat-val font-syne">{{ number_format($totalNormal) }}</span>
                <span class="stat-badge" style="background: #e0f2fe; color: #0369a1;">Pengiriman Rutin</span>
            </div>
            <div class="stat-icon" style="background: rgba(6,182,212,0.1); color: #06b6d4;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-meta">
                <span class="stat-label">Dibuat Hari Ini</span>
                <span class="stat-val font-syne">{{ number_format($todaySj) }}</span>
                <span class="stat-badge" style="background: #ecfdf5; color: #059669;">{{ date('d M Y') }}</span>
            </div>
            <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- TRACKING TOOLBAR & FILTERS -->
    <div class="tracking-toolbar">
        <div class="toolbar-left">
            <!-- Tipe switcher -->
            <div class="type-switcher">
                <a href="{{ route('surat_jalan.index', array_merge(request()->query(), ['tipe' => 'ALL'])) }}"
                   class="type-btn {{ $tipe === 'ALL' ? 'active' : '' }}">
                    Semua ({{ $totalSj }})
                </a>
                <a href="{{ route('surat_jalan.index', array_merge(request()->query(), ['tipe' => 'GO'])) }}"
                   class="type-btn {{ $tipe === 'GO' ? 'active' : '' }}">
                    🚚 SJ GO ({{ $totalGo }})
                </a>
                <a href="{{ route('surat_jalan.index', array_merge(request()->query(), ['tipe' => 'NORMAL'])) }}"
                   class="type-btn {{ $tipe === 'NORMAL' ? 'active' : '' }}">
                    📄 Normal ({{ $totalNormal }})
                </a>
            </div>

            <!-- Search input form -->
            <form action="{{ route('surat_jalan.index') }}" method="GET" class="search-box-wrap">
                @if($tipe !== 'ALL')
                    <input type="hidden" name="tipe" value="{{ $tipe }}">
                @endif
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" class="search-input"
                       placeholder="Cari No SJ, Toko, Kepada, Perihal..."
                       value="{{ $search }}">
            </form>
        </div>

        @if(!empty($search) || $tipe !== 'ALL')
            <a href="{{ route('surat_jalan.index') }}" style="font-size: 0.8rem; color: #ef4444; text-decoration: none; font-weight: 600;">
                &times; Reset Filter
            </a>
        @endif
    </div>

    <!-- TRACKING LIST TABLE -->
    <div class="tracking-card">
        <div class="table-responsive">
            <table class="tracking-table">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>No. Surat Jalan</th>
                        <th>Tipe</th>
                        <th>Tanggal</th>
                        <th>Kepada / Yth</th>
                        <th>Perihal / Tujuan</th>
                        <th class="text-center">Item</th>
                        <th>Dibuat Oleh</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratJalanList as $idx => $row)
                        <tr>
                            <td class="text-center font-bold font-mono" style="color: var(--text-muted);">
                                {{ $suratJalanList->firstItem() + $idx }}
                            </td>
                            <td>
                                <div class="no-sj-badge">
                                    <span>{{ $row->no_sj }}</span>
                                </div>
                            </td>
                            <td>
                                @if($row->tipe_sj === 'GO')
                                    <span class="badge-tipe badge-tipe-go">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                                        SJ GO
                                    </span>
                                @else
                                    <span class="badge-tipe badge-tipe-normal">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        NORMAL
                                    </span>
                                @endif
                            </td>
                            <td style="white-space: nowrap;">
                                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                            </td>
                            <td style="font-weight: 600;">
                                {{ $row->kepada ?: '-' }}
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;">
                                    @if($row->tipe_sj === 'GO')
                                        <span style="color: #2563eb; font-weight: 700;">{{ $row->perihal ?: ('SERAH TERIMA BARANG EDP UNTUK TOKO BARU ' . ($row->kode_toko ? "{$row->kode_toko} - {$row->nama_toko}" : '')) }}</span>
                                    @else
                                        {{ $row->perihal ?: '-' }}
                                    @endif
                                </div>
                                @if(!empty($row->catatan))
                                    <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                                        <em>Note: {{ Str::limit($row->catatan, 40) }}</em>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center font-bold font-mono">
                                <span style="background: rgba(37,99,235,0.08); color: #2563eb; padding: 2px 7px; border-radius: 6px;">
                                    {{ count($row->items ?: []) }}
                                </span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $row->created_by ?: 'EDP' }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <!-- Preview Button -->
                                    <button type="button" class="btn-action-icon btn-action-preview"
                                            title="Preview Surat Jalan"
                                            onclick="openPreviewModal({{ $row->id }})">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>

                                    <!-- Direct Print Button -->
                                    <a href="{{ route('surat_jalan.print', $row->id) }}?autoprint=1"
                                       target="_blank"
                                       class="btn-action-icon btn-action-print"
                                       title="Cetak Langsung">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="6 9 6 2 18 2 18 9"/>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                            <rect x="6" y="14" width="12" height="8"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn-action-icon btn-action-delete"
                                            title="Hapus Surat Jalan"
                                            onclick="confirmDeleteSj({{ $row->id }}, '{{ $row->no_sj }}')">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px 20px;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;">
                                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 1.05rem;">Belum ada Surat Jalan tersimpan</div>
                                    <p style="font-size: 0.82rem; color: #64748b; max-width: 380px;">Klik tombol "+ Buat Surat Jalan Baru" untuk membuat dan mencetak SJ GO Toko atau SJ Normal.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratJalanList->hasPages())
            <div style="padding: 14px 18px; border-top: 1px solid #e2e8f0;">
                {{ $suratJalanList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ═══════════════════════════════════════════
     MODAL 1: CREATE SURAT JALAN
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalCreateSj">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="color: #2563eb;">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Buat Surat Jalan Baru
            </div>
            <button type="button" class="modal-close-btn" onclick="closeCreateModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formCreateSj" onsubmit="handleFormSubmit(event)">
            @csrf
            <div class="modal-body">

                <!-- Type Chooser Segmented Pills -->
                <div class="modal-type-chooser">
                    <div class="type-choice-card selected" id="choiceGo" onclick="setSjType('GO')">
                        <div class="choice-icon" style="background: #fef3c7; color: #b45309;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="1" y="3" width="15" height="13"/>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="choice-title">SJ GO TOKO</div>
                            <div class="choice-desc">Serah terima peralatan toko baru / GO</div>
                        </div>
                    </div>

                    <div class="type-choice-card" id="choiceNormal" onclick="setSjType('NORMAL')">
                        <div class="choice-icon" style="background: #e0f2fe; color: #0369a1;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div>
                            <div class="choice-title">SJ NORMAL</div>
                            <div class="choice-desc">Surat jalan operasional / pengiriman umum</div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="tipe_sj" id="inputTipeSj" value="GO">

                <!-- Header Information Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">Tanggal Surat <span style="color:red">*</span></label>
                        <input type="date" name="tanggal" id="inputTanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Surat Jalan (Auto / Custom)</label>
                        <input type="text" name="no_sj" id="inputNoSj" class="form-control font-mono" placeholder="Otomatis dibuat sistem (e.g. SJ-GO-20261102-001)">
                    </div>
                </div>

                <!-- DYNAMIC FIELDS: SJ GO SPECIFIC -->
                <div id="sectionSjGoFields">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Pilih Toko GO (Autocomplete)</label>
                            <input type="text" list="tokoDataList" id="selectTokoQuick" class="form-control"
                                   placeholder="Ketik Kode atau Nama Toko..."
                                   oninput="handleTokoSelected(this.value)">
                            <datalist id="tokoDataList">
                                @foreach($tokoList as $tk)
                                    <option value="{{ $tk->kode_toko }} - {{ $tk->nama_toko }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kepada Yth</label>
                            <input type="text" name="kepada" id="inputKepadaGo" class="form-control" value="GA DEPT">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 140px 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Kode Toko</label>
                            <input type="text" name="kode_toko" id="inputKodeToko" class="form-control font-mono" placeholder="e.g. G219" oninput="syncGoPerihal()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" id="inputNamaToko" class="form-control" placeholder="e.g. TANJUNG PINANG" oninput="syncGoPerihal()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Judul Surat Jalan GO (Otomatis / Bisa Diketik Manual)</label>
                        <input type="text" name="perihal" id="inputPerihalGo" class="form-control font-bold" value="SERAH TERIMA BARANG EDP UNTUK TOKO BARU " placeholder="SERAH TERIMA BARANG EDP UNTUK TOKO BARU (KODE TOKO - NAMA TOKO)">
                        <small style="color: #64748b; font-size: 0.73rem;">Format otomatis: <strong>SERAH TERIMA BARANG EDP UNTUK TOKO BARU [KODE TOKO - NAMA TOKO]</strong>. Anda tetap bisa mengedit judul ini secara bebas.</small>
                    </div>

                    <!-- Signatures for GO: AWS (GAM), MJA (EDPM), SETIAWAN (EDPS), BOBBY (GAS), GA, NANDA (EDPADM) -->
                    <div style="margin-top: 10px; padding: 14px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #1e293b; text-transform: uppercase;">Penandatangan SJ GO (Default & Bisa Diedit):</span>
                            <span style="font-size: 0.72rem; color: #64748b;">Jabatan tetap & nama penanda tangan default terisi otomatis</span>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            <!-- DISETUJUI -->
                            <div style="background: #ffffff; padding: 8px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-weight: 700; font-size: 0.75rem; color: #2563eb; margin-bottom: 6px; text-transform: uppercase;">DISETUJUI</div>
                                <div style="margin-bottom: 6px;">
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">GAM</label>
                                    <input type="text" name="signatures[gam]" class="form-control" value="AWS" placeholder="Nama GAM">
                                </div>
                                <div>
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">EDPM</label>
                                    <input type="text" name="signatures[edpm]" class="form-control" value="MJA" placeholder="Nama EDPM">
                                </div>
                            </div>

                            <!-- DIKETAHUI -->
                            <div style="background: #ffffff; padding: 8px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-weight: 700; font-size: 0.75rem; color: #2563eb; margin-bottom: 6px; text-transform: uppercase;">DIKETAHUI</div>
                                <div style="margin-bottom: 6px;">
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">EDPS</label>
                                    <input type="text" name="signatures[edps]" class="form-control" value="SETIAWAN" placeholder="Nama EDPS">
                                </div>
                                <div>
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">GAS</label>
                                    <input type="text" name="signatures[gas]" class="form-control" value="BOBBY" placeholder="Nama GAS">
                                </div>
                            </div>

                            <!-- DITERIMA -->
                            <div style="background: #ffffff; padding: 8px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-weight: 700; font-size: 0.75rem; color: #2563eb; margin-bottom: 6px; text-transform: uppercase;">DITERIMA</div>
                                <div>
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">GA</label>
                                    <input type="text" name="signatures[ga]" class="form-control" placeholder="(Kosong jika manual)">
                                </div>
                            </div>

                            <!-- DIBUAT -->
                            <div style="background: #ffffff; padding: 8px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="font-weight: 700; font-size: 0.75rem; color: #2563eb; margin-bottom: 6px; text-transform: uppercase;">DIBUAT</div>
                                <div>
                                    <label class="form-label" style="font-size: 0.7rem; margin-bottom: 2px;">EDPADM</label>
                                    <input type="text" name="signatures[edpadm]" class="form-control" value="NANDA" placeholder="Nama EDPADM">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DYNAMIC FIELDS: SJ NORMAL SPECIFIC -->
                <div id="sectionSjNormalFields" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Kepada (Penerima) <span style="color:red">*</span></label>
                            <input type="text" list="penerimaDataList" name="kepada_normal" id="inputKepadaNormal" class="form-control" placeholder="Pilih atau ketik Toko / Dept / Penerima...">
                            <datalist id="penerimaDataList">
                                @foreach($tokoList as $tk)
                                    <option value="{{ $tk->kode_toko }} - {{ $tk->nama_toko }}"></option>
                                    <option value="{{ $tk->kode_toko }}"></option>
                                @endforeach
                                <option value="GA DEPT"></option>
                                <option value="EDP"></option>
                                <option value="FINANCE"></option>
                                <option value="HRD"></option>
                                <option value="LOGISTIK"></option>
                                <option value="DISTRIBUTION CENTER (DC)"></option>
                                <option value="OPERASIONAL"></option>
                                <option value="MARKETING"></option>
                                <option value="MAINTENANCE"></option>
                                @if(isset($kepadaHistory) && count($kepadaHistory) > 0)
                                    @foreach($kepadaHistory as $kpd)
                                        <option value="{{ $kpd }}"></option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Perihal</label>
                            <input type="text" name="perihal_normal" id="inputPerihalNormal" class="form-control" placeholder="e.g. Pengiriman Sparepart / Barang Servis">
                        </div>
                    </div>

                    <!-- Signatures for Normal -->
                    <div style="margin-top: 10px; padding: 12px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px;">
                        <span style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase;">Penandatangan (4 Kolom):</span>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 8px;">
                            <div>
                                <label class="form-label" style="font-size: 0.72rem;">EDPM (Disetujui)</label>
                                <input type="text" name="signatures[edpm]" class="form-control" placeholder="Nama EDPM">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 0.72rem;">EDPS (Diketahui)</label>
                                <input type="text" name="signatures[edps]" class="form-control" placeholder="Nama EDPS">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 0.72rem;">EDP (Diserahkan)</label>
                                <input type="text" name="signatures[edp_normal]" class="form-control" value="{{ session('user_nama', 'EDP') }}">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 0.72rem;">Penerima & NIK</label>
                                <input type="text" name="signatures[penerima_nama]" class="form-control" placeholder="Nama Penerima" style="margin-bottom: 4px;">
                                <input type="text" name="signatures[penerima_nik]" class="form-control" placeholder="NIK Penerima">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEMS TABLE BUILDER -->
                <div class="items-editor-card">
                    <div class="items-editor-header">
                        <div>
                            <span style="font-weight: 700; font-size: 0.88rem; color: #0f172a;">Rincian Barang / Peralatan</span>
                            <span style="font-size: 0.74rem; color: #64748b; margin-left: 6px;" id="itemCountLabel">(0 item)</span>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <!-- One-click Preset Button for SJ GO -->
                            <button type="button" class="btn-create-sj" id="btnLoadGoPreset"
                                    style="padding: 6px 12px; font-size: 0.76rem; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; box-shadow: none;"
                                    onclick="loadStandardGoPreset()">
                                ⚡ Isi Preset Standar GO Toko (21 Item)
                            </button>

                            <button type="button" class="btn-create-sj"
                                    style="padding: 6px 12px; font-size: 0.76rem; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; box-shadow: none;"
                                    onclick="addNewItemRow()">
                                + Tambah Baris
                            </button>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table-editor" id="tableItemsEditor">
                            <thead id="tableEditorThead">
                                <!-- Dynamic Thead via JS -->
                            </thead>
                            <tbody id="tableEditorTbody">
                                <!-- Dynamic Rows via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- General Notes -->
                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <input type="text" name="catatan" class="form-control" placeholder="Catatan internal atau keterangan khusus...">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="type-btn" style="background:#e2e8f0; color:#475569;" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-create-sj" id="btnSubmitSj">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan & Tampilkan Preview
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL 2: POP-UP PREVIEW & PRINT SJ
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalPreviewSj">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="color: #059669;">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Preview Surat Jalan & Print
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <button type="button" class="btn-create-sj" id="btnPrintFromModal" style="padding: 7px 14px; font-size: 0.82rem; background: linear-gradient(135deg, #059669, #10b981);" onclick="printModalDocument()">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Cetak / Print
                </button>
                <a href="#" target="_blank" id="btnOpenFullPrintTab" class="btn-create-sj" style="padding: 7px 14px; font-size: 0.82rem; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; box-shadow:none;">
                    Buka Tab Baru
                </a>
                <button type="button" class="modal-close-btn" onclick="closePreviewModal()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="modal-body" style="background: #f1f5f9; padding: 20px;">
            <div id="previewPaperContainer" class="preview-paper">
                <!-- Loaded via AJAX from server -->
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    Memuat dokumen surat jalan...
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <span style="font-size: 0.8rem; color: #64748b; margin-right: auto;" id="previewMetaFooter">No. SJ: -</span>
            <button type="button" class="type-btn" style="background:#e2e8f0; color:#475569;" onclick="closePreviewModal()">Tutup</button>
            <button type="button" class="btn-create-sj" style="background: linear-gradient(135deg, #059669, #10b981);" onclick="printModalDocument()">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Print Sekarang
            </button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL 3: DELETE CONFIRMATION
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalDeleteSj">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <div class="modal-title" style="color: #dc2626;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Konfirmasi Hapus
            </div>
            <button type="button" class="modal-close-btn" onclick="closeDeleteModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <p style="font-size: 0.95rem; color: #1e293b; margin-bottom: 6px;">Apakah Anda yakin ingin menghapus Surat Jalan ini?</p>
            <div id="deleteSjTargetName" style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #dc2626; font-size: 1.1rem; background: #fef2f2; padding: 6px 12px; border-radius: 8px; display: inline-block;">
                -
            </div>
            <p style="font-size: 0.78rem; color: #64748b; margin-top: 10px;">Data yang dihapus tidak dapat dipulihkan kembali.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="type-btn" style="background:#e2e8f0; color:#475569;" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn-create-sj" style="background: #dc2626; box-shadow: 0 4px 14px rgba(220,38,38,0.35);" id="btnConfirmDelete">
                Ya, Hapus Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Hidden Iframe for Direct Printing -->
<iframe id="printIframe" style="display: none; width: 0; height: 0; border: none;"></iframe>

<!-- Toast Notification Element -->
<div class="toast-popup" id="toastPopup">
    <svg width="18" height="18" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    <span id="toastMessage">Berhasil!</span>
</div>

<script>
    // State management
    let currentSjType = 'GO';
    let currentActiveSjId = null;
    let deletingSjId = null;

    // Preloaded standard GO equipment draft from sj.xlsx (21 standard items)
    const STANDARD_GO_ITEMS = [
        {
            nama_barang: "CPU BASIC ZYREX CORE I3 GEN 12 (ST01)\nCPU BASIC GEAR GOLD G7400 (ST02, ST04)",
            jml: "3",
            ket: "1. TAC02Z0212\n2. IMV262926070045029\n3. IMV262526060044041\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "DUAL TOUCHSCREEN MONITOR ZYREX (ST01, ST02, ST04)",
            jml: "3",
            ket: "1. GX20260116010263A, GX20260116010263B\n2. GX20260409010151A, GX20260409010151B\n3. GX20260116010818A, GX20260116010818B\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "GUN SCANNER DATALOGIC (ST01, ST02, ST04)",
            jml: "3",
            ket: "1. G25FD0189\n2. G25G87535\n3. G25H37903\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "PRINTER THERMAL ZYREX ZP-L3305 XH (ST01, ST02)\nPRINTER THERMAL CITIZEN CT-D150 (ST04)",
            jml: "3",
            ket: "1. L3305XH26320540\n2. L3305XH26320926\n3. TF3025Y0844\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "UPS ICA (ST01, ST02, ST04)",
            jml: "3",
            ket: "1. 1C1|G2501211\n2. 1C1|G2502674\n3. 1C1|G2600730\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "FINGER SCANNER HID DIGITAL PERSONA (ST01, ST02, ST04)",
            jml: "3",
            ket: "1. VD20E16512\n2. VD20E16550\n3. VD20E16239\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "MOUSE & KEYBOARD USB ZYREX & GEAR",
            jml: "3",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "STOP KONTAK 6 LUBANG 150 CM",
            jml: "3",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "PRINTER INKJET BROTHER DCP-T420W",
            jml: "1",
            ket: "1. E80718H3H203762\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "PRINTER LABEL ZEBRA ZD411",
            jml: "1",
            ket: "1. DFJ254900565\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "PDA (PERSONAL DIGITAL ASSISTANT) + BATERAI + KABEL CHARGER TYPE C + ADAPTOR 10 W",
            jml: "1",
            ket: "MT93LHQGSLIDGC00263 - 864700070107685 - C26.013743\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "KABEL BELDEN CAT 5E (MERK BELDEN)",
            jml: "15 M",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "CONNECTOR RJ45 BIASA",
            jml: "10",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "SWITCH HUB 16 PORT 1GB",
            jml: "1",
            ket: "22611XK001876\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "RB 750 R2",
            jml: "1",
            ket: "D1530E8D3D44/117/r3\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "WIRELESS ROUTER RB951UI - 2HND -",
            jml: "1",
            ket: "HG509MZETK1/r3\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "MODEM ORBIT",
            jml: "1",
            ket: "MOC-44 | 081170003049 | 323744257973\nSUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "FLASHDISK ITV 64 GB",
            jml: "1",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "VGA CARD",
            jml: "1",
            ket: "SUDAH CEK BY EDP, STATUS OK"
        },
        {
            nama_barang: "EDC BCA (ST01, ST04)",
            jml: "2",
            ket: "SUDAH CEK BY VIRTUAL, STATUS OK"
        },
        {
            nama_barang: "EDC WIRECARD (ST01, ST04)",
            jml: "2",
            ket: "SUDAH CEK BY VIRTUAL, STATUS OK"
        }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Setup initial table headers
        renderTableHeaders();
        // Add 1 default row
        addNewItemRow();

        // Check if session contains preview_sj_id
        @if(session('preview_sj_id'))
            openPreviewModal({{ session('preview_sj_id') }});
        @endif

        // Button listener for opening create modal
        document.getElementById('btnOpenCreateModal').addEventListener('click', () => {
            openCreateModal();
        });
    });

    // ── CREATE MODAL TOGGLE & TYPE HANDLING ──
    function openCreateModal() {
        document.getElementById('modalCreateSj').classList.add('show');
    }

    function closeCreateModal() {
        document.getElementById('modalCreateSj').classList.remove('show');
    }

    function setSjType(type) {
        currentSjType = type;
        document.getElementById('inputTipeSj').value = type;

        const choiceGo = document.getElementById('choiceGo');
        const choiceNormal = document.getElementById('choiceNormal');
        const sectionGo = document.getElementById('sectionSjGoFields');
        const sectionNormal = document.getElementById('sectionSjNormalFields');
        const btnPreset = document.getElementById('btnLoadGoPreset');

        if (type === 'GO') {
            choiceGo.classList.add('selected');
            choiceNormal.classList.remove('selected');
            sectionGo.style.display = 'block';
            sectionNormal.style.display = 'none';
            btnPreset.style.display = 'inline-flex';
        } else {
            choiceNormal.classList.add('selected');
            choiceGo.classList.remove('selected');
            sectionGo.style.display = 'none';
            sectionNormal.style.display = 'block';
            btnPreset.style.display = 'none';
        }

        renderTableHeaders();
        // Clear items and insert 1 clean row
        document.getElementById('tableEditorTbody').innerHTML = '';
        addNewItemRow();
    }

    function syncGoPerihal() {
        const kdtk = document.getElementById('inputKodeToko').value.trim();
        const nama = document.getElementById('inputNamaToko').value.trim();
        let prihal = "SERAH TERIMA BARANG EDP UNTUK TOKO BARU";
        if (kdtk || nama) {
            prihal += " " + (kdtk ? kdtk : "") + (kdtk && nama ? " - " : "") + (nama ? nama : "");
        }
        document.getElementById('inputPerihalGo').value = prihal;
    }

    function handleTokoSelected(val) {
        if (!val) return;
        const parts = val.split(' - ');
        if (parts.length >= 2) {
            document.getElementById('inputKodeToko').value = parts[0].trim();
            document.getElementById('inputNamaToko').value = parts.slice(1).join(' - ').trim();
            syncGoPerihal();
        }
    }

    // ── ITEMS TABLE BUILDER ──
    function renderTableHeaders() {
        const thead = document.getElementById('tableEditorThead');
        if (currentSjType === 'GO') {
            thead.innerHTML = `
                <tr>
                    <th style="width: 36px; text-align: center;">NO</th>
                    <th style="width: 300px;">NAMA BARANG</th>
                    <th style="width: 65px; text-align: center;">JML</th>
                    <th>KET (SN / STATUS CEK)</th>
                    <th style="width: 36px;"></th>
                </tr>
            `;
        } else {
            thead.innerHTML = `
                <tr>
                    <th style="width: 36px; text-align: center;">No</th>
                    <th style="width: 230px;">Nama Barang</th>
                    <th style="width: 75px;">Jlh</th>
                    <th style="width: 160px;">SN - MAC</th>
                    <th>Keterangan</th>
                    <th style="width: 36px;"></th>
                </tr>
            `;
        }
    }

    function addNewItemRow(data = {}) {
        const tbody = document.getElementById('tableEditorTbody');
        const rowCount = tbody.querySelectorAll('tr').length + 1;
        const tr = document.createElement('tr');

        if (currentSjType === 'GO') {
            tr.innerHTML = `
                <td style="text-align: center; font-weight: 700; color: #64748b; padding-top: 10px;" class="row-number font-mono">${rowCount}</td>
                <td>
                    <textarea class="form-control item-nama-barang font-bold" rows="2" placeholder="Nama barang & tipe (bisa multiline)...">${data.nama_barang || data.deskripsi || ''}</textarea>
                </td>
                <td>
                    <input type="text" class="form-control item-jml text-center font-mono font-bold" value="${data.jml || data.qty || '1'}" placeholder="Jml">
                </td>
                <td>
                    <textarea class="form-control item-ket" rows="2" placeholder="Nomor Seri / MAC / Keterangan Cek...">${data.ket || data.keterangan || ''}</textarea>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <button type="button" class="btn-row-del" onclick="deleteItemRow(this)" title="Hapus baris">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </td>
            `;
        } else {
            tr.innerHTML = `
                <td style="text-align: center; font-weight: 700; color: #64748b; padding-top: 10px;" class="row-number font-mono">${rowCount}</td>
                <td>
                    <input type="text" class="form-control item-nama font-bold" value="${data.nama_barang || ''}" placeholder="Nama barang...">
                </td>
                <td>
                    <input type="text" class="form-control item-jlh text-center font-mono" value="${data.jlh || '1'}" placeholder="Jlh">
                </td>
                <td>
                    <input type="text" class="form-control item-sn-mac font-mono" value="${data.sn_mac || ''}" placeholder="SN / MAC Address">
                </td>
                <td>
                    <textarea class="form-control item-keterangan" rows="1" placeholder="Keterangan tambahan...">${data.keterangan || ''}</textarea>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <button type="button" class="btn-row-del" onclick="deleteItemRow(this)" title="Hapus baris">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </td>
            `;
        }

        tbody.appendChild(tr);
        updateItemCount();
    }

    function deleteItemRow(btn) {
        const tr = btn.closest('tr');
        tr.remove();
        reindexRows();
        updateItemCount();
    }

    function reindexRows() {
        const rows = document.querySelectorAll('#tableEditorTbody tr');
        rows.forEach((row, i) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) numCell.textContent = i + 1;
        });
    }

    function updateItemCount() {
        const count = document.querySelectorAll('#tableEditorTbody tr').length;
        document.getElementById('itemCountLabel').textContent = `(${count} item)`;
    }

    function loadStandardGoPreset() {
        const tbody = document.getElementById('tableEditorTbody');
        tbody.innerHTML = '';
        STANDARD_GO_ITEMS.forEach(it => {
            addNewItemRow(it);
        });
        showToast("Preset 21 Item Standar GO Toko berhasil dimuat!");
    }

    // ── FORM SUBMISSION VIA AJAX ──
    async function handleFormSubmit(e) {
        e.preventDefault();
        const btnSubmit = document.getElementById('btnSubmitSj');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `Menyimpan...`;

        try {
            // Collect Items
            const items = [];
            const rows = document.querySelectorAll('#tableEditorTbody tr');
            rows.forEach((row, idx) => {
                if (currentSjType === 'GO') {
                    const nama_barang = row.querySelector('.item-nama-barang')?.value || row.querySelector('.item-deskripsi')?.value || '';
                    const jml = row.querySelector('.item-jml')?.value || row.querySelector('.item-qty')?.value || '';
                    const ket = row.querySelector('.item-ket')?.value || row.querySelector('.item-keterangan')?.value || '';
                    if (nama_barang.trim() !== '' || ket.trim() !== '') {
                        items.push({ no: idx + 1, nama_barang, jml, ket, deskripsi: nama_barang, qty: jml, keterangan: ket });
                    }
                } else {
                    const nama_barang = row.querySelector('.item-nama')?.value || '';
                    const jlh = row.querySelector('.item-jlh')?.value || '';
                    const sn_mac = row.querySelector('.item-sn-mac')?.value || '';
                    const keterangan = row.querySelector('.item-keterangan')?.value || '';
                    if (nama_barang.trim() !== '' || sn_mac.trim() !== '') {
                        items.push({ no: idx + 1, nama_barang, jlh, sn_mac, keterangan });
                    }
                }
            });

            // Build payload
            const formData = new FormData(document.getElementById('formCreateSj'));
            formData.append('items', JSON.stringify(items));

            // Sync Kepada & Perihal based on type
            if (currentSjType === 'NORMAL') {
                formData.set('kepada', document.getElementById('inputKepadaNormal').value);
                formData.set('perihal', document.getElementById('inputPerihalNormal').value);
            }

            const response = await fetch("{{ route('surat_jalan.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (result.success && result.data) {
                closeCreateModal();
                showToast(result.message || "Surat Jalan berhasil dibuat!");

                // Instantly open the Preview Pop-up
                openPreviewModal(result.data.id);

                // Reload background list smoothly after a slight delay
                setTimeout(() => {
                    // Update current list or reload
                }, 1200);
            } else {
                alert("Gagal menyimpan Surat Jalan: " + (result.message || 'Terjadi kesalahan sistem'));
            }

        } catch (err) {
            console.error(err);
            alert("Terjadi kesalahan saat memproses data.");
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = `
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Simpan & Tampilkan Preview
            `;
        }
    }

    // ── PREVIEW MODAL ──
    async function openPreviewModal(id) {
        currentActiveSjId = id;
        const modal = document.getElementById('modalPreviewSj');
        const container = document.getElementById('previewPaperContainer');
        const printBtnFull = document.getElementById('btnOpenFullPrintTab');
        const footerMeta = document.getElementById('previewMetaFooter');

        modal.classList.add('show');
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <div style="display: inline-block; width: 24px; height: 24px; border: 3px solid #cbd5e1; border-top-color: #2563eb; border-radius: 50%; animation: spin 0.8s linear infinite;"></div>
                <div style="margin-top: 10px; font-weight: 600;">Memuat Surat Jalan...</div>
            </div>
            <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
        `;

        const printUrl = `/surat-jalan/print/${id}`;
        printBtnFull.href = printUrl;

        try {
            const res = await fetch(`/surat-jalan/show/${id}`);
            const json = await res.json();

            if (json.success && json.data) {
                const sj = json.data;
                footerMeta.textContent = `No. Reg: ${sj.no_sj} • Tipe: ${sj.tipe_sj === 'GO' ? 'SJ GO TOKO' : 'SJ NORMAL'}`;
                renderPreviewHtml(sj);
            } else {
                container.innerHTML = `<div style="color:red; text-align:center; padding: 30px;">Gagal memuat detail Surat Jalan.</div>`;
            }
        } catch (e) {
            console.error(e);
            container.innerHTML = `<div style="color:red; text-align:center; padding: 30px;">Terjadi kesalahan saat mengambil data preview.</div>`;
        }
    }

    function closePreviewModal() {
        document.getElementById('modalPreviewSj').classList.remove('show');
    }

    function renderPreviewHtml(sj) {
        const container = document.getElementById('previewPaperContainer');
        const isGo = sj.tipe_sj === 'GO';

        // Date formatting
        const d = new Date(sj.tanggal);
        const monthsIndo = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
        const dayStr = String(d.getDate()).padStart(2, '0');
        const monthStr = monthsIndo[d.getMonth()] || '';
        const yearStr = d.getFullYear();
        const dateStrGo = `BATAM, ${dayStr} ${monthStr} ${yearStr}`;
        const dateStrNormal = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: '2-digit' });

        const items = sj.items || [];
        let itemsRows = '';

        items.forEach((it, idx) => {
            if (isGo) {
                const desc = it.nama_barang || it.deskripsi || '';
                const qty = it.jml || it.qty || '';
                const ket = it.keterangan || it.ket || '';
                itemsRows += `
                    <tr>
                        <td style="text-align: center; font-weight: bold; border: 1px solid #000; padding: 4px 6px;">${it.no || idx+1}</td>
                        <td style="border: 1px solid #000; padding: 4px 6px; font-weight: 700; white-space: pre-line; line-height: 1.3;">${escapeHtml(desc)}</td>
                        <td style="text-align: center; font-weight: bold; border: 1px solid #000; padding: 4px 6px;">${escapeHtml(String(qty))}</td>
                        <td style="border: 1px solid #000; padding: 4px 6px; white-space: pre-line; line-height: 1.3;">${escapeHtml(ket)}</td>
                    </tr>
                `;
            } else {
                itemsRows += `
                    <tr>
                        <td style="text-align: center; font-weight: bold; border: 1.2px solid #000; padding: 5px;">${it.no || idx+1}</td>
                        <td style="border: 1.2px solid #000; padding: 5px; font-weight: bold;">${escapeHtml(it.nama_barang || '')}</td>
                        <td style="text-align: center; border: 1.2px solid #000; padding: 5px;">${escapeHtml(String(it.jlh || ''))}</td>
                        <td style="border: 1.2px solid #000; padding: 5px; font-family: monospace; font-size: 9pt;">${escapeHtml(it.sn_mac || '')}</td>
                        <td style="border: 1.2px solid #000; padding: 5px; white-space: pre-line;">${escapeHtml(it.keterangan || '')}</td>
                    </tr>
                `;
            }
        });

        if (items.length === 0) {
            const colspan = isGo ? 4 : 5;
            itemsRows = `<tr><td colspan="${colspan}" style="text-align:center; padding: 15px; border: 1px solid #000; color:#64748b;">(Belum ada rincian item)</td></tr>`;
        }

        const sig = sj.signatures || {};

        if (isGo) {
            const gamName = (sig.gam || 'AWS').trim();
            const edpmName = (sig.edpm || 'MJA').trim();
            const edpsName = (sig.edps || 'SETIAWAN').trim();
            const gasName = (sig.gas || 'BOBBY').trim();
            const gaName = (sig.ga || '').trim();
            const edpadmName = (sig.edpadm || 'NANDA').trim();

            const goTitle = escapeHtml(sj.perihal || ('SERAH TERIMA BARANG EDP UNTUK TOKO BARU ' + (sj.kode_toko ? sj.kode_toko + ' - ' + (sj.nama_toko || '') : '')));

            container.innerHTML = `
                <div style="width: 100%; font-family: Arial, sans-serif; color: #000; font-size: 9pt;">
                    <!-- HEADER KHUSUS SJ GO -->
                    <div style="text-align: center; margin-bottom: 14px;">
                        <div style="font-size: 12.5pt; font-weight: 800; letter-spacing: 0.03em; text-transform: uppercase; line-height: 1.35; white-space: pre-line; color: #000;">
                            ${goTitle}
                        </div>
                    </div>

                    <!-- MAIN TABLE SJ GO -->
                    <div style="margin-top: 8px;">
                        <table style="width: 100%; border-collapse: collapse; border: 1.5px solid #000; font-size: 8.5pt;">
                            <thead>
                                <tr>
                                    <th style="width: 38px; border: 1px solid #000; padding: 5px 4px; text-align: center; background: #d9e1f2; font-weight: 800;">NO</th>
                                    <th style="width: 330px; border: 1px solid #000; padding: 5px 6px; text-align: center; background: #d9e1f2; font-weight: 800;">NAMA BARANG</th>
                                    <th style="width: 55px; border: 1px solid #000; padding: 5px 4px; text-align: center; background: #d9e1f2; font-weight: 800;">JML</th>
                                    <th style="border: 1px solid #000; padding: 5px 6px; text-align: center; background: #d9e1f2; font-weight: 800;">KET</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsRows}
                            </tbody>
                        </table>
                    </div>

                    <!-- SIGNATURES SJ GO -->
                    <div style="margin-top: 16px;">
                        <div style="text-align: right; font-weight: 700; font-size: 9pt; text-transform: uppercase; margin-bottom: 8px; padding-right: 15px;">
                            ${dateStrGo}
                        </div>
                        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 9pt; border: none;">
                            <thead>
                                <tr>
                                    <th colspan="2" style="width: 32%; font-weight: 800; font-size: 9pt; padding-bottom: 6px; border: none;">DISETUJUI</th>
                                    <th colspan="2" style="width: 32%; font-weight: 800; font-size: 9pt; padding-bottom: 6px; border: none;">DIKETAHUI</th>
                                    <th style="width: 18%; font-weight: 800; font-size: 9pt; padding-bottom: 6px; border: none;">DITERIMA</th>
                                    <th style="width: 18%; font-weight: 800; font-size: 9pt; padding-bottom: 6px; border: none;">DIBUAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- DISETUJUI: GAM & EDPM -->
                                    <td style="width: 16%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt; text-transform: uppercase;">${escapeHtml(gamName)}</div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">GAM</div>
                                    </td>
                                    <td style="width: 16%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt; text-transform: uppercase;">${escapeHtml(edpmName)}</div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">EDPM</div>
                                    </td>

                                    <!-- DIKETAHUI: EDPS & GAS -->
                                    <td style="width: 16%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt; text-transform: uppercase;">${escapeHtml(edpsName)}</div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">EDPS</div>
                                    </td>
                                    <td style="width: 16%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt; text-transform: uppercase;">${escapeHtml(gasName)}</div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">GAS</div>
                                    </td>

                                    <!-- DITERIMA: GA -->
                                    <td style="width: 18%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt;">
                                            ${gaName ? `( ${escapeHtml(gaName)} )` : '( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )'}
                                        </div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">GA</div>
                                    </td>

                                    <!-- DIBUAT: EDPADM -->
                                    <td style="width: 18%; vertical-align: top; padding: 0 4px; border: none;">
                                        <div style="height: 48px;"></div>
                                        <div style="font-weight: 700; font-size: 9pt; text-transform: uppercase;">${escapeHtml(edpadmName)}</div>
                                        <div style="font-weight: 700; font-size: 8.5pt; color: #000;">EDPADM</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        } else {
            // SJ NORMAL
            const edpmName = (sig.edpm || '').trim();
            const edpsName = (sig.edps || '').trim();
            const edpName = (sig.edp || '').trim();
            const penerimaName = (sig.penerima_nama || '').trim();

            const sigHtml = `
                <table style="width: 100%; border-collapse: collapse; text-align: center; margin-top: 25px; font-size: 9.5pt;">
                    <tr>
                        <td style="width: 25%;">
                            <div style="font-weight: bold; margin-bottom: 50px;">Disetujui</div>
                            <div style="min-height: 18px; font-weight: 600;">${edpmName ? `( ${escapeHtml(edpmName)} )` : '&nbsp;'}</div>
                            <div style="font-weight: bold; font-size: 8.5pt;">EDPM</div>
                        </td>
                        <td style="width: 25%;">
                            <div style="font-weight: bold; margin-bottom: 50px;">Diketahui</div>
                            <div style="min-height: 18px; font-weight: 600;">${edpsName ? `( ${escapeHtml(edpsName)} )` : '&nbsp;'}</div>
                            <div style="font-weight: bold; font-size: 8.5pt;">EDPS</div>
                        </td>
                        <td style="width: 25%;">
                            <div style="font-weight: bold; margin-bottom: 50px;">Diserahkan</div>
                            <div style="min-height: 18px; font-weight: 600;">${edpName ? `( ${escapeHtml(edpName)} )` : '&nbsp;'}</div>
                            <div style="font-weight: bold; font-size: 8.5pt;">EDP</div>
                        </td>
                        <td style="width: 25%;">
                            <div style="font-weight: bold; margin-bottom: 50px;">Diterima</div>
                            <div style="min-height: 18px; font-weight: 600;">${penerimaName ? `( ${escapeHtml(penerimaName)} )` : '&nbsp;'}</div>
                            <div style="font-size: 8.5pt; font-style: italic;">${sig.penerima_nik ? 'NIK: ' + escapeHtml(sig.penerima_nik) : '*sertakan NIK'}</div>
                        </td>
                    </tr>
                </table>
            `;

            const addressHtml = `Plaza Batamindo - Jl. Rasamala-Batamindo Industrial Park<br>Kel Muka Kuning, Kec Sei Beduk Kota Batam, Kepulauan Riau - 29433`;

            container.innerHTML = `
                <div style="width: 100%; font-family: Arial, sans-serif; color: #000; font-size: 9.5pt;">

                    <!-- Header Top -->
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <div style="width: 200px;">
                            <img src="{{ asset('SJ/indomaret.png') }}" alt="Indomaret" style="width: 180px; height: auto;" onerror="this.src='{{ asset('aset/indomaret.png') }}'">
                        </div>
                        <div style="flex: 1; text-align: center; padding-right: 50px;">
                            <div style="font-size: 15pt; font-weight: 800; letter-spacing: 0.05em; line-height: 1.2;">
                                SURAT JALAN
                            </div>
                            <div style="font-size: 8.5pt; font-weight: 400; margin-top: 2px; color: #1e293b; letter-spacing: 0.02em;">No : ${escapeHtml(sj.no_sj)}</div>
                        </div>
                    </div>

                    <!-- Header Meta Grid -->
                    <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 16px; margin-top: 6px;">
                        <div>
                            <div style="font-weight: bold; font-size: 10pt;">PT. INDOMARCO PRISMATAMA</div>
                            <div style="font-weight: 600;">EDP - Departement</div>
                            <div style="font-size: 9pt; line-height: 1.3;">${addressHtml}</div>
                        </div>
                        <div>
                            <table style="width: 100%; font-size: 9.5pt; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 70px; font-weight: bold;">TGL</td>
                                    <td style="width: 10px; font-weight: bold;">:</td>
                                    <td style="font-weight: bold; text-transform: uppercase;">${dateStrNormal}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Kpd</td>
                                    <td style="font-weight: bold;">:</td>
                                    <td style="font-weight: bold; text-transform: uppercase;">${escapeHtml(sj.kepada || '-')}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Perihal</td>
                                    <td style="font-weight: bold;">:</td>
                                    <td style="font-weight: bold; text-transform: uppercase;">${escapeHtml(sj.perihal || '-')}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Table -->
                    <div style="margin-top: 14px;">
                        <table style="width: 100%; border-collapse: collapse; border: 2px solid #000; font-size: 9pt;">
                            <thead>
                                <tr style="background: #ffffff;">
                                    <th style="width: 42px; border: 1.2px solid #000; padding: 6px; text-align: center;">No</th>
                                    <th style="width: 260px; border: 1.2px solid #000; padding: 6px;">NAMA BARANG</th>
                                    <th style="width: 60px; border: 1.2px solid #000; padding: 6px; text-align: center;">JLH</th>
                                    <th style="width: 170px; border: 1.2px solid #000; padding: 6px;">SN - MAC</th>
                                    <th style="border: 1.2px solid #000; padding: 6px;">KETERANGAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsRows}
                            </tbody>
                        </table>
                    </div>

                    <!-- Signatures -->
                    ${sigHtml}

                </div>
            `;
        }
    }

    function printModalDocument() {
        if (!currentActiveSjId) return;
        const iframe = document.getElementById('printIframe');
        iframe.src = `/surat-jalan/print/${currentActiveSjId}?autoprint=1`;
    }

    // ── DELETE MODAL ──
    function confirmDeleteSj(id, noSj) {
        deletingSjId = id;
        document.getElementById('deleteSjTargetName').textContent = noSj;
        document.getElementById('modalDeleteSj').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('modalDeleteSj').classList.remove('show');
        deletingSjId = null;
    }

    document.getElementById('btnConfirmDelete').addEventListener('click', async () => {
        if (!deletingSjId) return;
        const btn = document.getElementById('btnConfirmDelete');
        btn.disabled = true;
        btn.textContent = "Menghapus...";

        try {
            const res = await fetch(`/surat-jalan/delete/${deletingSjId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (data.success) {
                closeDeleteModal();
                showToast(data.message || "Surat Jalan berhasil dihapus!");
                setTimeout(() => {
                    window.location.reload();
                }, 700);
            } else {
                alert("Gagal menghapus: " + (data.message || 'Terjadi kesalahan'));
            }
        } catch (e) {
            console.error(e);
            alert("Terjadi kesalahan koneksi saat menghapus.");
        } finally {
            btn.disabled = false;
            btn.textContent = "Ya, Hapus Sekarang";
        }
    });

    // ── TOAST HELPER ──
    function showToast(msg) {
        const toast = document.getElementById('toastPopup');
        const text = document.getElementById('toastMessage');
        text.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }

    function escapeHtml(string) {
        const entityMap = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        };
        return String(string).replace(/[&<>"']/g, s => entityMap[s]);
    }
</script>

@endsection
