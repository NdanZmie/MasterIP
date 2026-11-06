@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Syne:wght@700;800&display=swap');

    :root {
        --primary: #06b6d4;
        --primary-hover: #0891b2;
        --primary-light: #ecfeff;
        --primary-glow: rgba(6,182,212,0.22);
        --blue: #2563eb;
        --blue-glow: rgba(37,99,235,0.20);
        --emerald: #10b981;
        --emerald-glow: rgba(16,185,129,0.20);
        --amber: #f59e0b;
        --amber-glow: rgba(245,158,11,0.20);
        --rose: #f43f5e;
        --purple: #8b5cf6;
        --purple-glow: rgba(139,92,246,0.20);
        --surface: rgba(255,255,255,0.85);
        --surface-card: rgba(255,255,255,0.92);
        --surface-hover: rgba(255,255,255,0.98);
        --border: rgba(6,182,212,0.15);
        --border-strong: rgba(6,182,212,0.30);
        --text-head: #0f172a;
        --text-body: #334155;
        --text-muted: #64748b;
        --radius: 18px;
        --radius-sm: 10px;
    }

    .tampung-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }
    .font-syne { font-family: 'Syne', sans-serif !important; }

    .tampung-wrap {
        min-height: 100vh;
        padding-top: 10px;
        padding-bottom: 70px;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0;
        padding-left: 14px;
        padding-right: 14px;
        box-sizing: border-box;
    }

    /* ── HEADER ── */
    .tp-header {
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

    .tp-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .title-left { display: flex; align-items: center; gap: 14px; }
    .page-icon {
        width: 52px; height: 52px; border-radius: 16px;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(6,182,212,0.35);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .page-icon svg { width: 28px; height: 28px; color: #fff; }

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
        margin-top: 4px;
    }

    .btn-upload-program {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #ffffff;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(6,182,212,0.38);
        transition: all 0.25s ease;
    }
    .btn-upload-program:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 26px rgba(6,182,212,0.50);
        color: #ffffff;
    }

    /* ── STATS ROW ── */
    .tp-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    @media (max-width: 992px) { .tp-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .tp-stats-grid { grid-template-columns: 1fr; } }

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
        box-shadow: 0 8px 25px rgba(6,182,212,0.12);
    }
    .stat-meta { display: flex; flex-direction: column; }
    .stat-label { font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); }
    .stat-val { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 800; color: var(--text-head); margin-top: 2px; }
    .stat-badge { font-size: 0.72rem; padding: 2px 8px; border-radius: 999px; font-weight: 600; margin-top: 4px; display: inline-block; width: fit-content; }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 22px; height: 22px; }

    /* ── TOOLBAR & FILTER ── */
    .tp-toolbar {
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

    .tp-categories-row {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        flex: 1;
    }
    .cat-btn {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        color: var(--text-muted);
        background: rgba(241, 245, 249, 0.8);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .cat-btn:hover {
        background: #ffffff;
        color: var(--primary-hover);
        border-color: var(--primary);
    }
    .cat-btn.active {
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 4px 14px rgba(6,182,212,0.30);
    }

    .tp-filter-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .search-box-wrap {
        position: relative;
        min-width: 240px;
    }
    .search-box-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px; height: 15px;
        color: var(--text-muted);
    }
    .search-input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border-radius: 10px;
        border: 1px solid rgba(203, 213, 225, 0.8);
        background: #ffffff;
        font-size: 0.84rem;
        color: var(--text-head);
        outline: none;
        transition: all 0.2s;
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .sort-select {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid rgba(203, 213, 225, 0.8);
        background: #ffffff;
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--text-body);
        outline: none;
        cursor: pointer;
    }

    .view-toggle-wrap {
        display: inline-flex;
        background: rgba(241, 245, 249, 0.9);
        border: 1px solid rgba(203, 213, 225, 0.7);
        border-radius: 10px;
        padding: 3px;
        gap: 2px;
    }
    .btn-toggle-view {
        padding: 5px 9px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-toggle-view.active {
        background: #ffffff;
        color: var(--primary);
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* ── CARDS GRID VIEW ── */
    .tp-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 16px;
    }

    .program-card {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        overflow: hidden;
    }
    .program-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(6,182,212,0.12);
        border-color: var(--border-strong);
    }
    .program-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #06b6d4, #2563eb);
        opacity: 0;
        transition: opacity 0.2s;
    }
    .program-card:hover::before {
        opacity: 1;
    }

    .card-top-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .program-icon-box {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 800;
        font-size: 0.72rem;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }

    /* Badges for extension */
    .badge-exe { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-zip { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-iso { background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .badge-script { background: #ecfeff; color: #0891b2; border: 1px solid #a5f3fc; }
    .badge-apk { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-doc { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-link { background: #fdf4ff; color: #c026d3; border: 1px solid #f0abfc; }
    .badge-default { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    .card-meta-tags {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .category-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        background: rgba(6,182,212,0.08);
        color: #0891b2;
        border: 1px solid rgba(6,182,212,0.20);
    }
    .version-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #334155;
    }

    .program-name {
        font-family: 'Syne', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-head);
        line-height: 1.3;
        margin-bottom: 6px;
        word-break: break-word;
    }
    .program-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 14px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.74rem;
        color: var(--text-muted);
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        padding-top: 10px;
        margin-bottom: 12px;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-action-bar {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download-main {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 14px;
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.82rem;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(6,182,212,0.25);
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-download-main:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(6,182,212,0.40);
        color: #ffffff;
    }

    .btn-card-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-card-icon:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .btn-card-del:hover {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border-color: #fecaca !important;
    }

    /* ── TABLE VIEW ── */
    .tp-table-card {
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        backdrop-filter: blur(12px);
    }
    table.tp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }
    table.tp-table thead th {
        background: rgba(248, 250, 252, 0.95);
        color: var(--text-muted);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 14px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        white-space: nowrap;
    }
    table.tp-table tbody tr {
        border-bottom: 1px solid rgba(241, 245, 249, 0.9);
        transition: background 0.15s;
    }
    table.tp-table tbody tr:hover {
        background: rgba(236, 254, 255, 0.4);
    }
    table.tp-table td {
        padding: 12px 14px;
        vertical-align: middle;
        color: var(--text-body);
    }

    /* ── MODALS ── */
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
        max-width: 640px;
        margin: auto;
        transform: scale(0.96);
        animation: modalPop 0.25s cubic-bezier(0.16,1,0.3,1) forwards;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.6);
    }
    @keyframes modalPop { to { transform: scale(1); } }

    .modal-header {
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }
    .modal-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-head);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-close-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: transparent; border: none; cursor: pointer;
        color: #64748b; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .modal-close-btn:hover { background: #e2e8f0; color: #0f172a; }

    .modal-body {
        padding: 22px;
        max-height: calc(85vh - 120px);
        overflow-y: auto;
    }
    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
    }

    /* Form inputs */
    .form-group { margin-bottom: 14px; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 5px; }
    .form-control {
        width: 100%;
        padding: 9px 13px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 0.86rem;
        color: #0f172a;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    /* Source type pills */
    .source-type-chooser {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        background: #f1f5f9;
        padding: 5px;
        border-radius: 12px;
        margin-bottom: 18px;
    }
    .source-type-card {
        padding: 10px 14px;
        border-radius: 9px;
        border: 2px solid transparent;
        background: transparent;
        cursor: pointer;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }
    .source-type-card.selected {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 3px 12px rgba(6,182,212,0.15);
    }
    .src-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
    }
    .src-title { font-weight: 700; font-size: 0.84rem; color: #0f172a; }
    .src-desc { font-size: 0.7rem; color: #64748b; }

    /* Drag & Drop Zone */
    .dropzone-box {
        border: 2px dashed #93c5fd;
        border-radius: 14px;
        background: #eff6ff;
        padding: 24px 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .dropzone-box:hover, .dropzone-box.dragover {
        border-color: #2563eb;
        background: #dbeafe;
    }
    .dropzone-icon {
        width: 48px; height: 48px; border-radius: 50%;
        background: #ffffff; color: #2563eb;
        margin: 0 auto 10px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(37,99,235,0.15);
    }
    .dropzone-text-main { font-weight: 700; font-size: 0.9rem; color: #1e3a8a; }
    .dropzone-text-sub { font-size: 0.74rem; color: #64748b; margin-top: 4px; }
    .file-chosen-preview {
        margin-top: 10px;
        padding: 8px 12px;
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #bfdbfe;
        display: none;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1e40af;
        text-align: left;
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

<div class="tampung-wrap">

    <!-- PAGE HEADER -->
    <div class="tp-header">
        <div class="tp-title-row">
            <div class="title-left">
                <div class="page-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">TAMPUNG / REPOSITORI PROGRAM</h1>
                    <p class="page-subtitle">Pusat penampungan & sharing installer, utilitas EDP, driver hardware, script otomatisasi, dan tools aplikasi</p>
                </div>
            </div>

            <button type="button" class="btn-upload-program" onclick="openUploadModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                + Tampung Program Baru
            </button>
        </div>
    </div>



    <!-- TOOLBAR & FILTERS -->
    <div class="tp-toolbar">
        <div class="tp-categories-row">
            <a href="{{ route('tampung.index', ['search' => $search, 'sort' => $sort]) }}"
               class="cat-btn {{ $kategori === 'ALL' || empty($kategori) ? 'active' : '' }}">
                Semua Program
            </a>
            @foreach($categoriesList as $cat)
                <a href="{{ route('tampung.index', ['kategori' => $cat, 'search' => $search, 'sort' => $sort]) }}"
                   class="cat-btn {{ $kategori === $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <div class="tp-filter-right">
            <!-- Search Form -->
            <form action="{{ route('tampung.index') }}" method="GET" class="search-box-wrap">
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" class="search-input" value="{{ $search }}" placeholder="Cari program / file...">
            </form>

            <!-- Sort Select -->
            <select class="sort-select" onchange="handleSortChange(this.value)">
                <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="populer" {{ $sort === 'populer' ? 'selected' : '' }}>Paling Banyak Diunduh</option>
                <option value="ukuran" {{ $sort === 'ukuran' ? 'selected' : '' }}>Ukuran Terbesar</option>
                <option value="nama" {{ $sort === 'nama' ? 'selected' : '' }}>Nama A-Z</option>
            </select>

            <!-- Grid vs Table View Switcher -->
            <div class="view-toggle-wrap">
                <button type="button" class="btn-toggle-view active" id="btnViewGrid" onclick="switchView('grid')" title="Tampilan Grid Kartu">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </button>
                <button type="button" class="btn-toggle-view" id="btnViewTable" onclick="switchView('table')" title="Tampilan Tabel Rinci">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════════
         VIEW 1: CARDS GRID (DEFAULT)
    ════════════════════════════════════════ ═-->
    <div class="tp-cards-grid" id="containerGridView">
        @forelse($programs as $prog)
            <div class="program-card">
                <div>
                    <div class="card-top-row">
                        <div class="program-icon-box {{ $prog->badge_color }}">
                            {{ $prog->ext_upper }}
                        </div>

                        <div class="card-meta-tags">
                            <span class="category-badge">{{ $prog->kategori }}</span>
                            @if(!empty($prog->versi))
                                <span class="version-badge">{{ $prog->versi }}</span>
                            @endif
                        </div>
                    </div>

                    <h3 class="program-name" title="{{ $prog->nama_program }}">
                        {{ $prog->nama_program }}
                    </h3>

                    <p class="program-desc">
                        {{ $prog->deskripsi ?: 'Tidak ada deskripsi khusus.' }}
                    </p>
                </div>

                <div>
                    <div class="card-footer-info">
                        <span class="info-item font-mono font-bold">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                            {{ $prog->formatted_size }}
                        </span>
                        <span class="info-item">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            {{ number_format($prog->download_count) }}x diunduh
                        </span>
                        <span class="info-item" title="Pengunggah: {{ $prog->uploader ?: 'EDP' }}">
                            👤 {{ Str::limit($prog->uploader ?: 'EDP', 10) }}
                        </span>
                    </div>

                    <div class="card-action-bar">
                        <!-- Main Download Button -->
                        <a href="{{ route('tampung.download', $prog->id) }}"
                           class="btn-download-main"
                           target="{{ $prog->tipe_sumber === 'link' ? '_blank' : '_self' }}"
                           title="Unduh {{ $prog->nama_program }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ $prog->tipe_sumber === 'link' ? 'Buka Tautan' : 'Unduh File' }}
                        </a>

                        <!-- Copy Link Button -->
                        <button type="button" class="btn-card-icon"
                                title="Salin Tautan Unduh"
                                onclick="copyDownloadUrl('{{ route('tampung.download', $prog->id) }}')">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <!-- Edit Button -->
                        <button type="button" class="btn-card-icon"
                                title="Edit Detail Program"
                                onclick="openEditModal({{ json_encode($prog) }})">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn-card-icon btn-card-del"
                                title="Hapus Program"
                                onclick="openDeleteModal({{ $prog->id }}, '{{ addslashes($prog->nama_program) }}')">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; background: var(--surface-card); border-radius: var(--radius); border: 1px dashed var(--border);">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: #ecfeff; color: #0891b2; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 style="font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--text-head); margin-bottom: 6px;">Belum Ada Program di Tampung</h3>
                <p style="font-size: 0.84rem; color: var(--text-muted); max-width: 420px; margin: 0 auto 16px;">
                    @if(!empty($search) || ($kategori !== 'ALL' && !empty($kategori)))
                        Tidak ada program yang sesuai dengan filter atau kata kunci pencarian.
                    @else
                        Halaman ini dapat menampung aplikasi, utilitas, installer, atau driver yang ingin dishare ke tim.
                    @endif
                </p>
                <button type="button" class="btn-upload-program" onclick="openUploadModal()">
                    + Unggah Program Pertama
                </button>
            </div>
        @endforelse
    </div>

    <!-- ════════════════════════════════════════
         VIEW 2: COMPACT TABLE (ALTERNATIVE)
    ════════════════════════════════════════ ═-->
    <div class="tp-table-card" id="containerTableView" style="display: none;">
        <div style="overflow-x: auto;">
            <table class="tp-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th>Program & Versi</th>
                        <th>Kategori</th>
                        <th>Tipe / Ekstensi</th>
                        <th>Ukuran</th>
                        <th>Diunduh</th>
                        <th>Pengunggah</th>
                        <th>Tgl Unggah</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $idx => $prog)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #94a3b8;" class="font-mono">
                                {{ $programs->firstItem() + $idx }}
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.88rem;">{{ $prog->nama_program }}</div>
                                @if(!empty($prog->deskripsi))
                                    <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">{{ Str::limit($prog->deskripsi, 50) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="category-badge">{{ $prog->kategori }}</span>
                            </td>
                            <td>
                                <span class="program-icon-box {{ $prog->badge_color }}" style="width: auto; height: auto; padding: 2px 7px; border-radius: 6px; display: inline-block;">
                                    {{ $prog->ext_upper }}
                                </span>
                            </td>
                            <td class="font-mono font-bold" style="font-size: 0.82rem;">
                                {{ $prog->formatted_size }}
                            </td>
                            <td class="font-mono" style="font-weight: 600;">
                                {{ number_format($prog->download_count) }}x
                            </td>
                            <td style="font-size: 0.8rem; font-weight: 600;">
                                {{ $prog->uploader ?: 'EDP' }}
                            </td>
                            <td style="font-size: 0.76rem; color: #64748b; white-space: nowrap;">
                                {{ $prog->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <a href="{{ route('tampung.download', $prog->id) }}"
                                       class="btn-card-icon"
                                       style="background: #ecfeff; color: #0891b2; border-color: #a5f3fc;"
                                       title="Unduh"
                                       target="{{ $prog->tipe_sumber === 'link' ? '_blank' : '_self' }}">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                    <button type="button" class="btn-card-icon"
                                            title="Salin Tautan"
                                            onclick="copyDownloadUrl('{{ route('tampung.download', $prog->id) }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                    </button>
                                    <button type="button" class="btn-card-icon"
                                            title="Edit"
                                            onclick="openEditModal({{ json_encode($prog) }})">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </button>
                                    <button type="button" class="btn-card-icon btn-card-del"
                                            title="Hapus"
                                            onclick="openDeleteModal({{ $prog->id }}, '{{ addslashes($prog->nama_program) }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px; color: #64748b;">
                                Belum ada program di Tampung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    @if($programs->hasPages())
        <div style="margin-top: 22px;">
            {{ $programs->links() }}
        </div>
    @endif

</div>

<!-- ═══════════════════════════════════════════
     MODAL 1: UNGGAH PROGRAM BARU
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalUploadProgram">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">
                <svg width="22" height="22" fill="none" stroke="#0891b2" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Tampung Program Baru
            </div>
            <button type="button" class="modal-close-btn" onclick="closeUploadModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form id="formUploadProgram" action="{{ route('tampung.store') }}" method="POST" enctype="multipart/form-data" onsubmit="handleUploadSubmit(event)">
            @csrf
            <div class="modal-body">

                <!-- Source Type Chooser -->
                <div class="source-type-chooser">
                    <div class="source-type-card selected" id="srcTypeUpload" onclick="setSourceType('upload')">
                        <div class="src-icon" style="background:#ecfeff; color:#0891b2;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        </div>
                        <div>
                            <div class="src-title">Upload File Langsung</div>
                            <div class="src-desc">EXE, ZIP, RAR, MSI, ISO, APK</div>
                        </div>
                    </div>

                    <div class="source-type-card" id="srcTypeLink" onclick="setSourceType('link')">
                        <div class="src-icon" style="background:#fdf4ff; color:#c026d3;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </div>
                        <div>
                            <div class="src-title">Tautan Link Eksternal</div>
                            <div class="src-desc">GDrive, NAS, Web / Server</div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="tipe_sumber" id="inputTipeSumber" value="upload">

                <!-- Upload Dropzone (Upload Mode) -->
                <div id="dropzoneContainer" class="form-group">
                    <label class="form-label">Pilih atau Tarik File Program ke Sini <span style="color:red">*</span></label>
                    <div class="dropzone-box" id="dropzoneBox" onclick="document.getElementById('fileInput').click()">
                        <div class="dropzone-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <div class="dropzone-text-main">Klik untuk memilih file atau Drag & Drop</div>
                        <div class="dropzone-text-sub">Mendukung installer .exe, .msi, arsip .zip, .rar, driver .iso, script .bat, dll (Maks. 500 MB)</div>

                        <div class="file-chosen-preview" id="fileChosenPreview">
                            <span id="chosenFileName">-</span>
                            <span id="chosenFileSize" style="margin-left: auto; font-family: monospace; font-size: 0.76rem; color: #64748b;">-</span>
                        </div>
                    </div>
                    <input type="file" name="file" id="fileInput" style="display: none;" onchange="handleFileChosen(this)">
                </div>

                <!-- External Link Input (Link Mode) -->
                <div id="linkContainer" class="form-group" style="display: none;">
                    <label class="form-label">URL / Tautan Download Eksternal <span style="color:red">*</span></label>
                    <input type="url" name="external_link" id="inputExternalLink" class="form-control" placeholder="https://drive.google.com/... atau http://192.168.75.../installer.exe">
                    <small style="font-size: 0.72rem; color: #64748b; margin-top: 4px; display: block;">Gunakan opsi ini jika file berukuran sangat besar atau sudah tersimpan di cloud / NAS kantor.</small>
                </div>

                <!-- Program Name & Version Grid -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Nama Program / Aplikasi <span style="color:red">*</span></label>
                        <input type="text" name="nama_program" id="inputNamaProgram" class="form-control" placeholder="e.g. AnyDesk Portable 7.1 / Driver Zebra ZD411" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Versi (Opsional)</label>
                        <input type="text" name="versi" id="inputVersi" class="form-control font-mono" placeholder="e.g. v7.1.4">
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label class="form-label">Kategori Program <span style="color:red">*</span></label>
                    <select name="kategori" id="inputKategori" class="form-control" required>
                        @foreach($categoriesList as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description / Usage notes -->
                <div class="form-group">
                    <label class="form-label">Deskripsi / Catatan Penggunaan (Opsional)</label>
                    <textarea name="deskripsi" id="inputDeskripsi" class="form-control" rows="2" placeholder="Jelaskan kegunaan program, cara install, atau catatan penting untuk user lain..."></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="cat-btn" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn-upload-program" id="btnSubmitUpload">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan & Tampung Program
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL 2: EDIT METADATA PROGRAM
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalEditProgram">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">
                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
                Edit Informasi Program
            </div>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form id="formEditProgram" onsubmit="handleEditSubmit(event)">
            @csrf
            <input type="hidden" id="editProgramId">
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Nama Program <span style="color:red">*</span></label>
                        <input type="text" id="editNamaProgram" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Versi</label>
                        <input type="text" id="editVersi" class="form-control font-mono">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select id="editKategori" class="form-control" required>
                        @foreach($categoriesList as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="editLinkGroup" style="display: none;">
                    <label class="form-label">Tautan Eksternal</label>
                    <input type="url" id="editExternalLink" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi / Catatan Penggunaan</label>
                    <textarea id="editDeskripsi" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="cat-btn" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-upload-program" id="btnSubmitEdit">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL 3: DELETE CONFIRMATION
═══════════════════════════════════════════ -->
<div class="modal-backdrop" id="modalDeleteProgram">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <div class="modal-title" style="color: #dc2626;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Konfirmasi Hapus
            </div>
            <button type="button" class="modal-close-btn" onclick="closeDeleteModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <p style="font-size: 0.95rem; color: #1e293b; margin-bottom: 8px;">Apakah Anda yakin ingin menghapus program ini dari Tampung?</p>
            <div id="deleteProgramName" style="font-weight: 700; color: #dc2626; font-size: 1rem; background: #fef2f2; padding: 8px 14px; border-radius: 8px; display: inline-block;">
                -
            </div>
            <p style="font-size: 0.78rem; color: #64748b; margin-top: 10px;">File fisik di server juga akan dihapus dan tidak bisa dipulihkan kembali.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="cat-btn" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn-upload-program" style="background: #dc2626; box-shadow: 0 4px 14px rgba(220,38,38,0.35);" id="btnConfirmDelete" onclick="executeDelete()">
                Ya, Hapus Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Toast Element -->
<div class="toast-popup" id="toastPopup">
    <svg width="18" height="18" fill="none" stroke="#06b6d4" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    <span id="toastMessage">Berhasil!</span>
</div>

<script>
    let deletingProgramId = null;

    document.addEventListener('DOMContentLoaded', () => {
        // Init view preference
        const savedView = localStorage.getItem('tampung_view') || 'grid';
        switchView(savedView);

        // Setup Drag & Drop listeners
        const dropBox = document.getElementById('dropzoneBox');
        if (dropBox) {
            ['dragenter', 'dragover'].forEach(name => {
                dropBox.addEventListener(name, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropBox.classList.add('dragover');
                }, false);
            });
            ['dragleave', 'drop'].forEach(name => {
                dropBox.addEventListener(name, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropBox.classList.remove('dragover');
                }, false);
            });
            dropBox.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    const fileInput = document.getElementById('fileInput');
                    fileInput.files = files;
                    handleFileChosen(fileInput);
                }
            }, false);
        }
    });

    // ── VIEW SWITCHER ──
    function switchView(type) {
        const gridEl = document.getElementById('containerGridView');
        const tableEl = document.getElementById('containerTableView');
        const btnGrid = document.getElementById('btnViewGrid');
        const btnTable = document.getElementById('btnViewTable');

        if (type === 'table') {
            gridEl.style.display = 'none';
            tableEl.style.display = 'block';
            btnTable.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('tampung_view', 'table');
        } else {
            gridEl.style.display = 'grid';
            tableEl.style.display = 'none';
            btnGrid.classList.add('active');
            btnTable.classList.remove('active');
            localStorage.setItem('tampung_view', 'grid');
        }
    }

    function handleSortChange(sortVal) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortVal);
        window.location.href = url.toString();
    }

    // ── UPLOAD MODAL ──
    function openUploadModal() {
        document.getElementById('modalUploadProgram').classList.add('show');
    }
    function closeUploadModal() {
        document.getElementById('modalUploadProgram').classList.remove('show');
    }

    function setSourceType(type) {
        document.getElementById('inputTipeSumber').value = type;
        const cardUpload = document.getElementById('srcTypeUpload');
        const cardLink = document.getElementById('srcTypeLink');
        const dropzone = document.getElementById('dropzoneContainer');
        const linkCont = document.getElementById('linkContainer');

        if (type === 'upload') {
            cardUpload.classList.add('selected');
            cardLink.classList.remove('selected');
            dropzone.style.display = 'block';
            linkCont.style.display = 'none';
        } else {
            cardLink.classList.add('selected');
            cardUpload.classList.remove('selected');
            dropzone.style.display = 'none';
            linkCont.style.display = 'block';
        }
    }

    function handleFileChosen(input) {
        if (!input.files || input.files.length === 0) return;
        const file = input.files[0];

        const preview = document.getElementById('fileChosenPreview');
        const nameEl = document.getElementById('chosenFileName');
        const sizeEl = document.getElementById('chosenFileSize');
        const nameInput = document.getElementById('inputNamaProgram');

        preview.style.display = 'flex';
        nameEl.textContent = file.name;
        sizeEl.textContent = formatBytesJs(file.size);

        // Autofill program name if empty
        if (!nameInput.value.trim()) {
            const raw = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
            nameInput.value = raw.replace(/[-_]/g, ' ');
        }
    }

    async function handleUploadSubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitUpload');
        const form = document.getElementById('formUploadProgram');
        const formData = new FormData(form);

        btn.disabled = true;
        btn.innerHTML = `Mengunggah & Menyimpan...`;

        try {
            const res = await fetch("{{ route('tampung.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const json = await res.json();
            if (json.success) {
                closeUploadModal();
                showToast(json.message || "Program berhasil ditampung!");
                setTimeout(() => window.location.reload(), 900);
            } else {
                alert("Gagal mengunggah: " + (json.message || 'Terjadi kesalahan sistem'));
            }
        } catch (err) {
            console.error(err);
            alert("Terjadi kesalahan koneksi saat mengunggah file.");
        } finally {
            btn.disabled = false;
            btn.innerHTML = `
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan & Tampung Program
            `;
        }
    }

    // ── EDIT MODAL ──
    function openEditModal(prog) {
        document.getElementById('editProgramId').value = prog.id;
        document.getElementById('editNamaProgram').value = prog.nama_program;
        document.getElementById('editVersi').value = prog.versi || '';
        document.getElementById('editKategori').value = prog.kategori;
        document.getElementById('editDeskripsi').value = prog.deskripsi || '';

        const linkGroup = document.getElementById('editLinkGroup');
        const linkInput = document.getElementById('editExternalLink');
        if (prog.tipe_sumber === 'link') {
            linkGroup.style.display = 'block';
            linkInput.value = prog.external_link || '';
        } else {
            linkGroup.style.display = 'none';
        }

        document.getElementById('modalEditProgram').classList.add('show');
    }

    function closeEditModal() {
        document.getElementById('modalEditProgram').classList.remove('show');
    }

    async function handleEditSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('editProgramId').value;
        const btn = document.getElementById('btnSubmitEdit');

        btn.disabled = true;
        btn.textContent = "Menyimpan...";

        const payload = {
            nama_program: document.getElementById('editNamaProgram').value,
            versi: document.getElementById('editVersi').value,
            kategori: document.getElementById('editKategori').value,
            deskripsi: document.getElementById('editDeskripsi').value,
            external_link: document.getElementById('editExternalLink')?.value || null,
        };

        try {
            const res = await fetch(`/tampung/update/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();
            if (json.success) {
                closeEditModal();
                showToast("Perubahan program berhasil disimpan!");
                setTimeout(() => window.location.reload(), 800);
            } else {
                alert("Gagal memperbarui: " + (json.message || 'Terjadi kesalahan'));
            }
        } catch (err) {
            console.error(err);
            alert("Terjadi kesalahan koneksi.");
        } finally {
            btn.disabled = false;
            btn.textContent = "Simpan Perubahan";
        }
    }

    // ── DELETE MODAL ──
    function openDeleteModal(id, name) {
        deletingProgramId = id;
        document.getElementById('deleteProgramName').textContent = name;
        document.getElementById('modalDeleteProgram').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('modalDeleteProgram').classList.remove('show');
        deletingProgramId = null;
    }

    async function executeDelete() {
        if (!deletingProgramId) return;
        const btn = document.getElementById('btnConfirmDelete');
        btn.disabled = true;
        btn.textContent = "Menghapus...";

        try {
            const res = await fetch(`/tampung/delete/${deletingProgramId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();
            if (json.success) {
                closeDeleteModal();
                showToast(json.message || "Program berhasil dihapus!");
                setTimeout(() => window.location.reload(), 700);
            } else {
                alert("Gagal menghapus: " + (json.message || 'Terjadi kesalahan'));
            }
        } catch (err) {
            console.error(err);
            alert("Terjadi kesalahan koneksi saat menghapus.");
        } finally {
            btn.disabled = false;
            btn.textContent = "Ya, Hapus Sekarang";
        }
    }

    // ── COPY URL HELPER ──
    function copyDownloadUrl(url) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                showToast("Tautan unduh program berhasil disalin ke clipboard! 📋");
            });
        } else {
            const temp = document.createElement('input');
            temp.value = url;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            showToast("Tautan unduh program berhasil disalin ke clipboard! 📋");
        }
    }

    function showToast(msg) {
        const toast = document.getElementById('toastPopup');
        const text = document.getElementById('toastMessage');
        text.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3500);
    }

    function formatBytesJs(bytes) {
        if (bytes <= 0) return '0 B';
        const k = 1024;
        const dm = 2;
        const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
</script>

@endsection
