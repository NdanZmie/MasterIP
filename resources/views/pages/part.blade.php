@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-glow: rgba(37,99,235,0.14);
        --surface: rgba(255,255,255,0.85);
        --surface-hover: rgba(255,255,255,0.98);
        --border: rgba(37,99,235,0.12);
        --border-strong: rgba(37,99,235,0.22);
        --text-head: #0f172a;
        --text-body: #334155;
        --text-muted: #64748b;
        --radius: 16px;
    }

    .part-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }

    .part-wrap {
        min-height: 100vh;
        padding-top: 10px;
        padding-bottom: 50px;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0;
        padding-left: 16px;
        padding-right: 16px;
        box-sizing: border-box;
    }

    /* ── HEADER ── */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 18px;
        animation: slideDown 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-14px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .page-title-block { display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
    .title-left { display:flex; align-items:center; gap:14px; }
    .page-icon {
        width:46px; height:46px; border-radius:14px;
        background: linear-gradient(135deg, #059669, #10b981);
        display:flex; align-items:center; justify-content:center;
        box-shadow: 0 6px 20px rgba(16,185,129,0.3);
        flex-shrink:0;
    }
    .page-icon svg { width:22px; height:22px; stroke:#fff; }
    .page-title { font-size:1.45rem; font-weight:800; color:var(--text-head); letter-spacing:-0.03em; }
    .page-subtitle { font-size:0.80rem; color:var(--text-muted); font-weight:500; margin-top:1px; }

    /* Top Nav Switcher */
    .nav-switcher {
        display: inline-flex;
        background: rgba(241,245,249,0.9);
        padding: 4px;
        border-radius: 50px;
        border: 1px solid var(--border);
        gap: 4px;
    }
    .nav-switch-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 16px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        color: var(--text-muted);
        transition: all 0.2s;
    }
    .nav-switch-btn.active {
        background: #ffffff;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .nav-switch-btn:hover:not(.active) {
        color: var(--text-head);
    }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }
    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.03);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(0,0,0,0.07);
        border-color: var(--border-strong);
    }
    .stat-icon {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 19px; height: 19px; }
    .stat-icon.slate { background: rgba(100,116,139,0.12); color: #475569; }
    .stat-icon.green { background: rgba(16,185,129,0.12); color: #059669; }
    .stat-icon.amber { background: rgba(245,158,11,0.12); color: #d97706; }
    .stat-icon.red { background: rgba(239,68,68,0.12); color: #dc2626; }

    .stat-info { display: flex; flex-direction: column; }
    .stat-val { font-size: 1.28rem; font-weight: 800; color: var(--text-head); line-height: 1.1; }
    .stat-lbl { font-size: 0.68rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }

    /* ── TOOLBAR ── */
    .toolbar-wrap {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 12px 16px;
        margin-bottom: 16px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }
    .search-box {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.95);
        border: 1px solid var(--border-strong);
        border-radius: 50px;
        overflow: hidden;
        min-width: 240px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-box:focus-within {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
    }
    .search-box svg {
        margin-left: 12px;
        width: 15px; height: 15px; color: var(--text-muted); flex-shrink: 0;
    }
    .search-box input {
        border: none; outline: none; background: transparent;
        padding: 7px 10px; font-size: 0.80rem; color: var(--text-body);
        width: 100%;
    }
    .search-box button {
        background: #059669; color: #fff; border: none;
        padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: background 0.2s;
    }
    .search-box button:hover { background: #047857; }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        align-items: center;
        background: rgba(241,245,249,0.75);
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: 2px;
        gap: 2px;
        overflow-x: auto;
    }
    .filter-tab {
        padding: 5px 10px;
        font-size: 0.73rem;
        font-weight: 600;
        border-radius: 50px;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .filter-tab.active {
        background: #fff;
        color: #059669;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .toolbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-manual-out {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        border: none;
        padding: 7px 15px;
        font-size: 0.80rem;
        font-weight: 700;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 3px 12px rgba(245,158,11,0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-manual-out:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(245,158,11,0.42);
    }
    .btn-manual-out svg { width: 15px; height: 15px; }

    .btn-add {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        border: none;
        padding: 7px 16px;
        font-size: 0.80rem;
        font-weight: 700;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 3px 12px rgba(16,185,129,0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(16,185,129,0.42);
    }
    .btn-add svg { width: 15px; height: 15px; }

    /* ── TABLE CONTAINER ── */
    .table-container {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        width: 100%;
        box-sizing: border-box;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        table-layout: auto;
    }
    .modern-table th {
        background: rgba(248,250,252,0.92);
        padding: 10px 12px;
        font-size: 0.71rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .modern-table td {
        padding: 10px 12px;
        font-size: 0.80rem;
        color: var(--text-body);
        border-bottom: 1px solid rgba(226,232,240,0.6);
        vertical-align: middle;
    }
    .modern-table tbody tr {
        transition: background 0.12s;
    }
    .modern-table tbody tr:hover {
        background: rgba(241,245,249,0.7);
    }

    /* Badges */
    .badge-plu {
        background: rgba(15,23,42,0.06);
        color: #0f172a;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid rgba(15,23,42,0.12);
        display: inline-block;
    }
    .badge-divisi {
        background: rgba(99,102,241,0.08);
        color: #4f46e5;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid rgba(99,102,241,0.2);
        display: inline-block;
    }
    .badge-stock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 50px;
        font-size: 0.74rem;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .badge-stock.success {
        background: rgba(16,185,129,0.12);
        color: #059669;
        border-color: rgba(16,185,129,0.25);
    }
    .badge-stock.warning {
        background: rgba(245,158,11,0.12);
        color: #d97706;
        border-color: rgba(245,158,11,0.25);
    }
    .badge-stock.danger {
        background: rgba(239,68,68,0.12);
        color: #dc2626;
        border-color: rgba(239,68,68,0.25);
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-stock.success .badge-dot { background: #10b981; }
    .badge-stock.warning .badge-dot { background: #f59e0b; }
    .badge-stock.danger .badge-dot { background: #ef4444; }

    /* Action Buttons */
    .btn-action-group {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 9px;
        font-size: 0.73rem;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-restock {
        background: rgba(16,185,129,0.12);
        color: #059669;
        border: 1px solid rgba(16,185,129,0.24);
    }
    .btn-restock:hover {
        background: #10b981;
        color: #fff;
        box-shadow: 0 3px 10px rgba(16,185,129,0.3);
    }
    .btn-edit {
        background: rgba(37,99,235,0.1);
        color: #2563eb;
        border: 1px solid rgba(37,99,235,0.2);
        padding: 5px 8px;
    }
    .btn-edit:hover { background: #2563eb; color: #fff; }

    /* ── MODALS ── */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(6,13,31,0.7);
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
        max-width: 540px;
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

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (max-width: 480px) { .form-grid-2 { grid-template-columns: 1fr; } }

    .form-group { margin-bottom: 14px; }
    .form-group label {
        display: block; font-size: 0.78rem; font-weight: 700; color: #334155; margin-bottom: 5px;
    }
    .form-group label span.req { color: #ef4444; }
    .form-control {
        width: 100%; padding: 8px 12px;
        border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 0.84rem; color: #0f172a; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .form-control:focus {
        border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
    }
    textarea.form-control { resize: vertical; min-height: 65px; }

    .btn-cancel {
        padding: 8px 16px; font-size: 0.80rem; font-weight: 600;
        color: #475569; background: #e2e8f0; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #cbd5e1; }
    .btn-submit {
        padding: 8px 18px; font-size: 0.80rem; font-weight: 700;
        color: #fff; background: #059669; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover { background: #047857; box-shadow: 0 4px 14px rgba(16,185,129,0.3); }

    /* Flash Alerts */
    .alert-banner {
        padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px; font-size: 0.84rem; font-weight: 600;
        animation: slideDown 0.3s ease-out;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
</style>

<div class="part-wrap">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert-banner alert-success">
            <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error') || (isset($errors) && $errors->any()))
        <div class="alert-banner alert-error">
            <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') ?: ($errors->first() ?? '') }}</span>
        </div>
    @endif

    {{-- Header with Nav Switcher --}}
    <div class="page-header">
        <div class="page-title-block">
            <div class="title-left">
                <div class="page-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">Monitoring & Manajemen Stok Part</h1>
                    <p class="page-subtitle">Kontrol kuantitas inventori sparepart, restock stok, dan pengeluaran part</p>
                </div>
            </div>

            {{-- Tab Switcher --}}
            <div class="nav-switcher">
                <a href="{{ route('part.index') }}" class="nav-switch-btn active">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Stok Part Aktif</span>
                </a>
                <a href="{{ route('part.log') }}" class="nav-switch-btn">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Log Transit (Keluar / Masuk)</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Counter --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon slate">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($totalSku) }}</span>
                <span class="stat-lbl">Total Jenis Part (SKU)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($amanCount) }}</span>
                <span class="stat-lbl">Stok Aman (> 5)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($menipisCount) }}</span>
                <span class="stat-lbl">Stok Menipis (1 - 5)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($habisCount) }}</span>
                <span class="stat-lbl">Stok Habis (0)</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar-wrap">
        <div class="toolbar-left">
            {{-- Search Box --}}
            <form action="{{ route('part.index') }}" method="GET" class="search-box">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="divisi" value="{{ $divisi }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari PLU, Nama Part, Divisi...">
                <button type="submit">Cari</button>
            </form>

            {{-- Filter Tabs --}}
            <div class="filter-tabs">
                <a href="{{ route('part.index', ['status' => 'all', 'search' => $search, 'divisi' => $divisi]) }}" class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
                    Semua ({{ $totalSku }})
                </a>
                <a href="{{ route('part.index', ['status' => 'aman', 'search' => $search, 'divisi' => $divisi]) }}" class="filter-tab {{ $status === 'aman' ? 'active' : '' }}">
                    Aman ({{ $amanCount }})
                </a>
                <a href="{{ route('part.index', ['status' => 'menipis', 'search' => $search, 'divisi' => $divisi]) }}" class="filter-tab {{ $status === 'menipis' ? 'active' : '' }}">
                    Menipis ({{ $menipisCount }})
                </a>
                <a href="{{ route('part.index', ['status' => 'habis', 'search' => $search, 'divisi' => $divisi]) }}" class="filter-tab {{ $status === 'habis' ? 'active' : '' }}">
                    Habis ({{ $habisCount }})
                </a>
            </div>
        </div>

        <div class="toolbar-actions">
            {{-- Out Barang Manual --}}
            <button type="button" class="btn-manual-out" onclick="openModal('modalOutManual')">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Out Part Manual</span>
            </button>

            {{-- Tambah Part Baru --}}
            <button type="button" class="btn-add" onclick="openModal('modalTambahPart')">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Part Baru</span>
            </button>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 32px; text-align: center;">No</th>
                    <th style="width: 100px;">Kode PLU</th>
                    <th>Nama Barang / Part</th>
                    <th style="width: 130px;">Divisi Item</th>
                    <th style="width: 80px; text-align: center;">Satuan</th>
                    <th style="width: 120px; text-align: right; padding-right: 24px;">Kuantitas Stok</th>
                    <th>Keterangan</th>
                    <th style="width: 120px;">Terakhir Update</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    <tr>
                        <td style="color: var(--text-muted); font-weight: 600; text-align: center; font-size: 0.76rem;">
                            {{ $items->firstItem() + $index }}
                        </td>
                        <td>
                            <span class="badge-plu">{{ $item->kode_plu }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.84rem;">{{ $item->nama_barang }}</div>
                        </td>
                        <td>
                            <span class="badge-divisi">{{ $item->divisi ?: 'Umum' }}</span>
                        </td>
                        <td style="text-align: center; font-weight: 700; font-size: 0.78rem; color: #475569;">
                            {{ $item->satuan ?: 'PCS' }}
                        </td>
                        <td style="text-align: right; padding-right: 24px;">
                            <span class="font-mono" style="font-weight: 800; font-size: 0.88rem; color: {{ $item->qty_stock <= 0 ? '#dc2626' : ($item->qty_stock <= 5 ? '#d97706' : '#047857') }};">
                                {{ number_format($item->qty_stock) }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.76rem;">
                            {{ $item->keterangan ?: '-' }}
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.74rem;">
                            {{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td style="text-align: center;">
                            <div class="btn-action-group" style="justify-content: center;">
                                {{-- Quick Restock --}}
                                <button type="button" class="btn-action btn-restock"
                                    title="Tambah / Restock Stok Part"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ htmlspecialchars($item->nama_barang, ENT_QUOTES, 'UTF-8') }}"
                                    data-plu="{{ $item->kode_plu }}"
                                    data-stock="{{ $item->qty_stock }}"
                                    data-satuan="{{ $item->satuan ?: 'PCS' }}"
                                    onclick="triggerRestockModal(this)">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span>+ Restock</span>
                                </button>

                                {{-- Edit --}}
                                <button type="button" class="btn-action btn-edit"
                                    title="Edit Informasi Part"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ htmlspecialchars($item->nama_barang, ENT_QUOTES, 'UTF-8') }}"
                                    data-plu="{{ $item->kode_plu }}"
                                    data-divisi="{{ htmlspecialchars($item->divisi ?? '', ENT_QUOTES, 'UTF-8') }}"
                                    data-satuan="{{ $item->satuan ?: 'PCS' }}"
                                    data-stock="{{ $item->qty_stock }}"
                                    data-keterangan="{{ htmlspecialchars($item->keterangan ?? '', ENT_QUOTES, 'UTF-8') }}"
                                    onclick="triggerEditModal(this)">
                                    <svg style="width:12.5px;height:12.5px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <svg style="width:40px;height:40px;margin:0 auto 10px;opacity:0.4;display:block;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p style="font-weight: 600;">Tidak ada data part yang ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($items->hasPages())
            <div style="padding: 14px 18px; border-top: 1px solid var(--border);">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL TAMBAH PART BARU
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalTambahPart">
    <div class="modal-card">
        <form action="{{ route('part.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h3>
                    <svg style="width:18px;height:18px;color:#059669;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Part / Barang Baru
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalTambahPart')">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Kode PLU <span class="req">*</span></label>
                        <input type="text" name="kode_plu" class="form-control font-mono" placeholder="Contoh: 01010101" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang / Part <span class="req">*</span></label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Head Printer TM-T82" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Divisi Item</label>
                        <input type="text" name="divisi" list="listDivisiTambah" class="form-control" placeholder="Pilih / ketik divisi (misal: Printer LX310)">
                        <datalist id="listDivisiTambah">
                            <option value="Printer Inkjet"></option>
                            <option value="Printer DotMatrix / LX310"></option>
                            <option value="PC & Server"></option>
                            <option value="CCTV & Security"></option>
                            <option value="Network & Router"></option>
                            <option value="Barcode Scanner"></option>
                            <option value="POS Station"></option>
                            <option value="Kabel & Adaptor"></option>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Satuan <span class="req">*</span></label>
                        <input type="text" name="satuan" list="listSatuanTambah" class="form-control" value="PCS" placeholder="PCS / Unit / Meter" required>
                        <datalist id="listSatuanTambah">
                            <option value="PCS"></option>
                            <option value="Unit"></option>
                            <option value="Roll"></option>
                            <option value="Meter"></option>
                            <option value="Set"></option>
                            <option value="Box"></option>
                            <option value="Pack"></option>
                        </datalist>
                    </div>
                </div>

                <div class="form-group">
                    <label>Stok Awal <span class="req">*</span></label>
                    <input type="number" name="qty_stock" class="form-control font-mono" value="0" min="0" required>
                </div>

                <div class="form-group">
                    <label>Keterangan / Lokasi Rak (Opsional)</label>
                    <textarea name="keterangan" class="form-control" placeholder="Catatan part, rak penyimpanan, atau spesifikasi..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalTambahPart')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Part</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL OUT BARANG MANUAL
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalOutManual">
    <div class="modal-card">
        <form action="{{ route('part.manualOut') }}" method="POST">
            @csrf
            <div class="modal-header" style="background:#fffbeb;">
                <h3 style="color:#b45309;">
                    <svg style="width:18px;height:18px;color:#d97706;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Out Barang Manual (Keluar ke Toko / Divisi)
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalOutManual')">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="background:#fef3c7; border:1px solid #fde68a; border-radius:10px; padding:10px 12px; margin-bottom:14px; font-size:0.78rem; color:#92400e; display:flex; align-items:center; gap:8px;">
                    <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Form ini digunakan untuk pengeluaran part ke Toko KDTK atau Divisi lain secara manual di luar service rutin. Stok part akan dipotong dan dicatat ke <strong>Log Transit</strong>.</span>
                </div>

                <div class="form-group">
                    <label>Pilih Barang / Part <span class="req">*</span></label>
                    <select name="barang_id" id="manualOutBarangId" class="form-control" required onchange="updateMaxQtyOut(this)">
                        <option value="">-- Pilih Barang / Sparepart --</option>
                        @foreach($allParts as $p)
                            <option value="{{ $p->id }}" data-stok="{{ $p->qty_stock }}" data-satuan="{{ $p->satuan ?: 'PCS' }}">
                                [PLU: {{ $p->kode_plu }}] {{ $p->nama_barang }} (Sisa Stok: {{ $p->qty_stock }} {{ $p->satuan ?: 'PCS' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Jumlah Keluar (Qty) <span class="req">*</span></label>
                        <input type="number" name="qty_out" id="manualOutQty" class="form-control font-mono" value="1" min="1" required>
                        <small id="manualOutInfoStok" style="font-size:0.72rem; color:#059669; margin-top:3px; display:block;"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pengeluaran <span class="req">*</span></label>
                        <input type="date" name="tanggal_keluar" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Out Ke / Tujuan Pengeluaran <span class="req">*</span></label>
                    <input type="text" name="tujuan_out" list="listTokoManualOut" class="form-control" placeholder="Pilih Kode Toko atau ketik divisi tujuan (misal: T9D4 - GRIYA PIAYU / Divisi EDP)" required>
                    <datalist id="listTokoManualOut">
                        @foreach($tokoList as $toko)
                            <option value="KDTK: {{ $toko->kode_toko }} ({{ $toko->nama_toko }})"></option>
                        @endforeach
                        <option value="Keperluan Divisi EDP"></option>
                        <option value="Project Server"></option>
                        <option value="Penggantian Sparepart Internal"></option>
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Keterangan / Alasan Pengeluaran</label>
                    <textarea name="keterangan" class="form-control" placeholder="Catatan pengiriman, no surat jalan, atau keperluan khusus..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalOutManual')">Batal</button>
                <button type="submit" class="btn-submit" style="background:#d97706;">Keluarkan Part</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL + RESTOCK JUMLAH STOK
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalRestock">
    <div class="modal-card" style="max-width: 460px;">
        <form id="formRestock" method="POST">
            @csrf
            <div class="modal-header" style="background:#f0fdf4;">
                <h3 style="color:#166534;">
                    <svg style="width:18px;height:18px;color:#16a34a;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Restock / Tambah Stok Part
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalRestock')">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px; margin-bottom:14px;">
                    <div style="font-size:0.72rem; color:#64748b; font-weight:700; text-transform:uppercase;">Barang yang Di-restock:</div>
                    <div id="restockNamaBarang" style="font-size:0.95rem; font-weight:800; color:#0f172a; margin-top:2px;">-</div>
                    <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">
                        PLU: <strong id="restockPlu" class="font-mono">-</strong> | Sisa Stok Saat Ini: <strong id="restockCurrentStock" class="font-mono text-emerald-600">0</strong> <span id="restockSatuan">PCS</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jumlah Penambahan Stok <span class="req">*</span></label>
                    <input type="number" name="qty_add" class="form-control font-mono" placeholder="Masukkan jumlah unit masuk" min="1" required>
                </div>

                <div class="form-group">
                    <label>Sumber Restock</label>
                    <input type="text" name="sumber" list="listSumberRestock" class="form-control" placeholder="Contoh: Supplier Epson / Gudang Pusat Batam">
                    <datalist id="listSumberRestock">
                        <option value="Gudang Supplier"></option>
                        <option value="Gudang Pusat"></option>
                        <option value="Pengadaan Baru"></option>
                        <option value="Retur Toko"></option>
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Catatan Restock (Opsional)</label>
                    <input type="text" name="catatan" class="form-control" placeholder="No PO, nota, atau alasan penambahan stok...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalRestock')">Batal</button>
                <button type="submit" class="btn-submit">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL EDIT PART
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalEditPart">
    <div class="modal-card">
        <form id="formEditPart" method="POST">
            @csrf
            <div class="modal-header">
                <h3>
                    <svg style="width:18px;height:18px;color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Data Part
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalEditPart')">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Kode PLU <span class="req">*</span></label>
                        <input type="text" name="kode_plu" id="editKodePlu" class="form-control font-mono" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang / Part <span class="req">*</span></label>
                        <input type="text" name="nama_barang" id="editNamaBarang" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Divisi Item</label>
                        <input type="text" name="divisi" id="editDivisi" list="listDivisiTambah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Satuan <span class="req">*</span></label>
                        <input type="text" name="satuan" id="editSatuan" list="listSatuanTambah" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kuantitas Stok <span class="req">*</span></label>
                    <input type="number" name="qty_stock" id="editQtyStock" class="form-control font-mono" min="0" required>
                </div>

                <div class="form-group">
                    <label>Keterangan / Lokasi Rak</label>
                    <textarea name="keterangan" id="editKeterangan" class="form-control" placeholder="Catatan part, rak penyimpanan, atau spesifikasi..."></textarea>
                </div>

                <div class="form-group">
                    <label>Alasan Perubahan / Catatan Edit <span style="font-size:0.72rem; color:#64748b; font-weight:500;">(Opsional - dicatat ke Log Transit)</span></label>
                    <input type="text" name="alasan_edit" id="editAlasanEdit" class="form-control" placeholder="Contoh: Koreksi stok opname / perbaikan divisi / update nama">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalEditPart')">Batal</button>
                <button type="submit" class="btn-submit" style="background:#2563eb;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.add('show');
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.remove('show');
    }

    function triggerRestockModal(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const plu = btn.getAttribute('data-plu');
        const currentStock = btn.getAttribute('data-stock');
        const satuan = btn.getAttribute('data-satuan') || 'PCS';
        openRestockModal(id, nama, plu, currentStock, satuan);
    }

    function triggerEditModal(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const plu = btn.getAttribute('data-plu');
        const divisi = btn.getAttribute('data-divisi') || '';
        const satuan = btn.getAttribute('data-satuan') || 'PCS';
        const qty = btn.getAttribute('data-stock');
        const ket = btn.getAttribute('data-keterangan') || '';
        openEditModal(id, nama, plu, divisi, satuan, qty, ket);
    }

    function openRestockModal(id, nama, plu, currentStock, satuan) {
        document.getElementById('restockNamaBarang').innerText = nama;
        document.getElementById('restockPlu').innerText = plu;
        document.getElementById('restockCurrentStock').innerText = currentStock;
        document.getElementById('restockSatuan').innerText = satuan;
        document.getElementById('formRestock').action = '/part/add-stock/' + id;
        openModal('modalRestock');
    }

    function openEditModal(id, nama, plu, divisi, satuan, qty, ket) {
        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editKodePlu').value = plu;
        document.getElementById('editDivisi').value = divisi;
        document.getElementById('editSatuan').value = satuan;
        document.getElementById('editQtyStock').value = qty;
        document.getElementById('editKeterangan').value = ket;
        const alasanInput = document.getElementById('editAlasanEdit');
        if (alasanInput) alasanInput.value = '';
        document.getElementById('formEditPart').action = '/part/update/' + id;
        openModal('modalEditPart');
    }

    function updateMaxQtyOut(select) {
        const opt = select.options[select.selectedIndex];
        const stok = opt ? opt.getAttribute('data-stok') : 0;
        const satuan = opt ? opt.getAttribute('data-satuan') : 'PCS';
        const info = document.getElementById('manualOutInfoStok');
        const qtyInput = document.getElementById('manualOutQty');

        if (stok) {
            info.innerText = `* Maksimal pengeluaran: ${stok} ${satuan}`;
            qtyInput.max = stok;
        } else {
            info.innerText = '';
            qtyInput.removeAttribute('max');
        }
    }

    // Close on backdrop click
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });
    });
</script>

@endsection
