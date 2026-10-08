@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap');

    :root {
        --primary: #059669;
        --primary-light: #ecfdf5;
        --primary-glow: rgba(5, 150, 105, 0.15);
        --surface: rgba(255, 255, 255, 0.92);
        --surface-hover: rgba(255, 255, 255, 0.98);
        --border: rgba(226, 232, 240, 0.9);
        --border-strong: rgba(203, 213, 225, 0.95);
        --text-head: #0f172a;
        --text-body: #334155;
        --text-muted: #64748b;
        --radius: 16px;
    }

    .part-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }

    .part-wrap {
        min-height: 100vh;
        padding: 8px 16px 40px;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box;
    }

    /* ── HEADER ── */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 16px;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .page-title-block { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; }
    .title-left { display: flex; align-items: center; gap: 14px; }
    .page-icon {
        width: 46px; height: 46px; border-radius: 14px;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.28);
        flex-shrink: 0;
    }
    .page-icon svg { width: 23px; height: 23px; stroke: #fff; }
    .page-title { font-size: 1.40rem; font-weight: 800; color: var(--text-head); letter-spacing: -0.03em; margin: 0; }
    .page-subtitle { font-size: 0.78rem; color: var(--text-muted); font-weight: 500; margin: 2px 0 0 0; }

    /* Top Nav Switcher */
    .nav-switcher {
        display: inline-flex;
        background: rgba(241, 245, 249, 0.95);
        padding: 4px;
        border-radius: 50px;
        border: 1px solid var(--border);
        gap: 4px;
    }
    .nav-switch-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.76rem;
        font-weight: 700;
        text-decoration: none;
        color: var(--text-muted);
        transition: all 0.2s;
    }
    .nav-switch-btn.active {
        background: #ffffff;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .nav-switch-btn:hover:not(.active) {
        color: var(--text-head);
    }

    /* ── STAT CARDS GRID (6 Cards) ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }
    @media (max-width: 1350px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        border-color: var(--border-strong);
    }
    .stat-icon {
        width: 38px; height: 38px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 19px; height: 19px; }
    .stat-icon.slate { background: rgba(100, 116, 139, 0.12); color: #475569; }
    .stat-icon.green { background: rgba(16, 185, 129, 0.12); color: #059669; }
    .stat-icon.amber { background: rgba(245, 158, 11, 0.12); color: #d97706; }
    .stat-icon.red   { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
    .stat-icon.purple{ background: rgba(168, 85, 247, 0.12); color: #9333ea; }
    .stat-icon.indigo{ background: rgba(99, 102, 241, 0.12); color: #4f46e5; }

    .stat-info { display: flex; flex-direction: column; overflow: hidden; }
    .stat-val { font-size: 1.15rem; font-weight: 800; color: var(--text-head); line-height: 1.1; }
    .stat-lbl { font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 3px; }

    /* ── TOOLBAR ── */
    .toolbar-container {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 16px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .toolbar-row-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .toolbar-filters-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }

    /* Search Box */
    .search-box {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid var(--border-strong);
        border-radius: 50px;
        overflow: hidden;
        min-width: 240px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-box:focus-within {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
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
        padding: 7px 14px; font-size: 0.76rem; font-weight: 700;
        cursor: pointer; transition: background 0.2s;
    }
    .search-box button:hover { background: #047857; }

    /* Dropdown Selects */
    .custom-select {
        background: #ffffff;
        border: 1px solid var(--border-strong);
        border-radius: 50px;
        padding: 7px 14px;
        font-size: 0.77rem;
        font-weight: 600;
        color: var(--text-body);
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .custom-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
    }

    /* Actions Buttons */
    .toolbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 15px;
        font-size: 0.77rem;
        font-weight: 700;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        white-space: nowrap;
    }
    .btn-action-primary:hover {
        transform: translateY(-1px);
    }

    .btn-sync {
        background: linear-gradient(135deg, #0284c7, #0ea5e9);
        color: #fff;
        box-shadow: 0 3px 10px rgba(14, 165, 233, 0.28);
    }
    .btn-sync:hover {
        box-shadow: 0 5px 14px rgba(14, 165, 233, 0.42);
    }

    .btn-manual-out {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        box-shadow: 0 3px 10px rgba(245, 158, 11, 0.28);
    }
    .btn-manual-out:hover {
        box-shadow: 0 5px 14px rgba(245, 158, 11, 0.42);
    }

    .btn-add {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        box-shadow: 0 3px 10px rgba(16, 185, 129, 0.28);
    }
    .btn-add:hover {
        box-shadow: 0 5px 14px rgba(16, 185, 129, 0.42);
    }

    /* Segmented Filter Tabs */
    .filter-tabs {
        display: flex;
        align-items: center;
        background: rgba(241, 245, 249, 0.9);
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: 3px;
        gap: 3px;
        overflow-x: auto;
        width: fit-content;
    }
    .filter-tab {
        padding: 5px 12px;
        font-size: 0.74rem;
        font-weight: 600;
        border-radius: 50px;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .filter-tab.active {
        background: #ffffff;
        color: #059669;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    .filter-tab:hover:not(.active) {
        color: var(--text-head);
    }

    /* ── TABLE CONTAINER ── */
    .table-container {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
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
        background: rgba(248, 250, 252, 0.96);
        padding: 11px 12px;
        font-size: 0.70rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .modern-table td {
        padding: 10px 12px;
        font-size: 0.80rem;
        color: var(--text-body);
        border-bottom: 1px solid rgba(226, 232, 240, 0.65);
        vertical-align: middle;
    }
    .modern-table tbody tr {
        transition: background 0.12s ease;
    }
    .modern-table tbody tr:hover {
        background: rgba(241, 245, 249, 0.65);
    }

    /* Column Specific Badges & Formatting */
    .badge-plu {
        background: rgba(15, 23, 42, 0.06);
        color: #0f172a;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.73rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        border: 1px solid rgba(15, 23, 42, 0.12);
        display: inline-block;
    }
    .badge-divisi {
        background: rgba(99, 102, 241, 0.08);
        color: #4f46e5;
        font-size: 0.70rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid rgba(99, 102, 241, 0.2);
        display: inline-block;
        white-space: nowrap;
    }
    .badge-moving {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .badge-moving.fast { background: rgba(16, 185, 129, 0.10); color: #047857; border-color: rgba(16, 185, 129, 0.25); }
    .badge-moving.slow { background: rgba(245, 158, 11, 0.10); color: #b45309; border-color: rgba(245, 158, 11, 0.25); }
    .badge-moving.not  { background: rgba(239, 68, 68, 0.10); color: #b91c1c; border-color: rgba(239, 68, 68, 0.25); }
    .badge-moving.spec { background: rgba(6, 182, 212, 0.10); color: #0e7490; border-color: rgba(6, 182, 212, 0.25); }
    .badge-moving.ho   { background: rgba(168, 85, 247, 0.10); color: #7e22ce; border-color: rgba(168, 85, 247, 0.25); }

    /* Stock Pill */
    .stock-chip {
        display: inline-flex;
        align-items: baseline;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.85rem;
    }
    .stock-chip.aman {
        background: rgba(16, 185, 129, 0.08);
        color: #047857;
    }
    .stock-chip.menipis {
        background: rgba(245, 158, 11, 0.10);
        color: #b45309;
    }
    .stock-chip.habis {
        background: rgba(239, 68, 68, 0.10);
        color: #dc2626;
    }

    /* Usulan PP Card */
    .pp-box {
        display: inline-flex;
        flex-direction: column;
        gap: 2px;
    }
    .badge-pp-qty {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(239, 68, 68, 0.08);
        color: #b91c1c;
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 2px 7px;
        border-radius: 5px;
        font-weight: 700;
        font-size: 0.71rem;
        width: fit-content;
    }
    .pp-nominal {
        font-size: 0.69rem;
        font-weight: 700;
        color: #059669;
    }
    .pp-pending-chip {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 0.67rem;
        color: #ea580c;
        font-weight: 700;
    }

    /* Action Buttons in Table */
    .btn-action-group {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .btn-tbl-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px; height: 28px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-tbl-restock {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }
    .btn-tbl-restock:hover {
        background: #10b981;
        color: #fff;
        box-shadow: 0 3px 8px rgba(16, 185, 129, 0.3);
    }
    .btn-tbl-edit {
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        border: 1px solid rgba(37, 99, 235, 0.22);
    }
    .btn-tbl-edit:hover {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.3);
    }

    /* ── MODALS ── */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(6px);
        display: none; align-items: center; justify-content: center;
        padding: 20px;
    }
    .modal-backdrop.show { display: flex !important; animation: fadeIn 0.2s ease-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .modal-card {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.8);
        overflow: hidden;
        animation: scaleUp 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes scaleUp {
        from { transform: scale(0.95) translateY(8px); opacity: 0; }
        to   { transform: scale(1) translateY(0); opacity: 1; }
    }
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
    }
    .modal-header h3 {
        font-size: 1.0rem; font-weight: 800; color: #0f172a; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .modal-close {
        background: transparent; border: none; cursor: pointer;
        color: #94a3b8; padding: 4px; border-radius: 6px;
        transition: color 0.2s, background 0.2s;
    }
    .modal-close:hover { color: #0f172a; background: #e2e8f0; }
    .modal-body { padding: 20px; max-height: 75vh; overflow-y: auto; }
    .modal-footer {
        padding: 12px 20px; border-top: 1px solid #e2e8f0;
        background: #f8fafc; display: flex; justify-content: flex-end; gap: 8px;
    }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
    @media (max-width: 520px) { .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; } }

    .form-group { margin-bottom: 13px; }
    .form-group label {
        display: block; font-size: 0.75rem; font-weight: 700; color: #334155; margin-bottom: 4px;
    }
    .form-group label span.req { color: #ef4444; }
    .form-control {
        width: 100%; padding: 7px 11px;
        border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 0.81rem; color: #0f172a; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .form-control:focus {
        border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
    }
    textarea.form-control { resize: vertical; min-height: 55px; }

    .btn-cancel {
        padding: 7px 15px; font-size: 0.78rem; font-weight: 600;
        color: #475569; background: #e2e8f0; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #cbd5e1; }
    .btn-submit {
        padding: 7px 16px; font-size: 0.78rem; font-weight: 700;
        color: #fff; background: #059669; border: none; border-radius: 8px;
        cursor: pointer; transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover { background: #047857; box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3); }

    /* Flash Alerts */
    .alert-banner {
        padding: 11px 15px; border-radius: 10px; margin-bottom: 14px;
        display: flex; align-items: center; gap: 10px; font-size: 0.82rem; font-weight: 600;
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
                    <h1 class="page-title">Monitoring LPP Stock (Sparepart EDP)</h1>
                    <p class="page-subtitle">
                        Sinkronisasi master data Google Sheets, kontrol buffer, analisis mutasi, dan perencanaan pengadaan (PP)
                    </p>
                </div>
            </div>

            {{-- Tab Switcher --}}
            <div class="nav-switcher">
                <a href="{{ route('part.index') }}" class="nav-switch-btn active">
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>LPP Stock EDP</span>
                </a>
                <a href="{{ route('part.log') }}" class="nav-switch-btn">
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Log Transit (Keluar/Masuk)</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Counter (6 Cards) --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon slate">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($totalSku) }}</span>
                <span class="stat-lbl">Total Item Part (SKU)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($totalStock) }}</span>
                <span class="stat-lbl">Total Fisik Stok</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($menipisCount) }} / {{ number_format($habisCount) }}</span>
                <span class="stat-lbl">Menipis / Habis</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($totalPpQty) }} <small style="font-size:0.75rem;font-weight:600;">unit</small></span>
                <span class="stat-lbl">Usulan PP Pengadaan</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val" style="font-size:1.0rem;">Rp {{ number_format($totalPpNominal / 1000000, 1, ',', '.') }} Jt</span>
                <span class="stat-lbl">Nilai Usulan PP</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon indigo">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($ppPendingCount) }} <small style="font-size:0.75rem;font-weight:600;">item</small></span>
                <span class="stat-lbl">PP Belum Realisasi</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar-container">
        {{-- Row 1: Search, Dropdowns, and Action Buttons --}}
        <div class="toolbar-row-top">
                {{-- Search Box with Instant Real-Time Live Search (No submit needed) --}}
                <div class="search-box" id="searchBoxPartWrap">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" id="liveSearchInputPart" name="search" value="{{ $search }}" placeholder="Ketik langsung untuk mencari part (mis: adaptor, ram, fan, kabel)..." autocomplete="off">
                    <span id="searchResultCountPart" style="display:none; font-size:0.68rem; font-weight:700; color:#0284c7; background:#e0f2fe; padding:2px 7px; border-radius:12px; margin-right:4px; white-space:nowrap;"></span>
                    <button type="button" id="btnClearSearchPart" style="display:none; background:transparent; border:none; cursor:pointer; color:#94a3b8; font-size:13px; font-weight:bold; padding:0 8px;" title="Hapus pencarian">✕</button>
                    <div style="background:#f1f5f9; color:#059669; font-size:0.68rem; font-weight:700; padding:7px 11px; border-left:1px solid #e2e8f0; display:flex; align-items:center; gap:5px;" title="Pencarian otomatis saat mengetik (tanpa perlu klik tombol)">
                        <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#10b981;"></span>
                        <span>Live</span>
                    </div>
                </div>

                {{-- Filter Divisi --}}
                <select class="custom-select" onchange="location = this.value;">
                    <option value="{{ route('part.index', ['divisi' => 'all', 'status' => $status, 'moving' => $moving, 'search' => $search]) }}">
                        Divisi: Semua ({{ $totalSku }})
                    </option>
                    @foreach($divisiList as $div)
                        <option value="{{ route('part.index', ['divisi' => $div, 'status' => $status, 'moving' => $moving, 'search' => $search]) }}" {{ $divisi === $div ? 'selected' : '' }}>
                            {{ $div }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Moving Status --}}
                <select class="custom-select" onchange="location = this.value;">
                    <option value="{{ route('part.index', ['moving' => 'all', 'divisi' => $divisi, 'status' => $status, 'search' => $search]) }}">
                        Moving: Semua
                    </option>
                    @foreach($movingList as $mov)
                        <option value="{{ route('part.index', ['moving' => $mov, 'divisi' => $divisi, 'status' => $status, 'search' => $search]) }}" {{ $moving === $mov ? 'selected' : '' }}>
                            {{ $mov }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="toolbar-actions">
                {{-- Sync Status / Connection Badge --}}
                @if($isGoogleConfigured)
                    <span title="Google Service Account terhubung. Auto write-back ke Google Sheets aktif." style="display:inline-flex; align-items:center; gap:5px; font-size:0.71rem; font-weight:700; color:#047857; background:#ecfdf5; padding:5px 12px; border-radius:50px; border:1px solid #a7f3d0;">
                        <span style="width:7px; height:7px; border-radius:50%; background:#10b981; animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></span>
                        <span>Auto Write-Back Aktif</span>
                    </span>
                @else
                    <button type="button" onclick="openModal('modalGoogleGuide')" title="Klik untuk melihat panduan menghubungkan Google Sheets API" style="display:inline-flex; align-items:center; gap:5px; font-size:0.71rem; font-weight:700; color:#475569; background:#f1f5f9; padding:5px 12px; border-radius:50px; border:1px solid #cbd5e1; cursor:pointer;">
                        <svg style="width:12px;height:12px;color:#0284c7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <span>Setup Auto Write-Back</span>
                    </button>
                @endif

                {{-- Sync Google Sheet Button --}}
                <form action="{{ route('part.sync') }}" method="POST" style="display:inline;" onsubmit="return confirmSync(this);">
                    @csrf
                    <button type="submit" class="btn-action-primary btn-sync" id="btnSyncGoogleSheet">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Tarik dari Google Sheet</span>
                    </button>
                </form>

                {{-- Out Barang Manual --}}
                <button type="button" class="btn-action-primary btn-manual-out" onclick="openModal('modalOutManual')">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Out Part</span>
                </button>

                {{-- Tambah Part Baru --}}
                <button type="button" class="btn-action-primary btn-add" onclick="openModal('modalTambahPart')">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Part</span>
                </button>
            </div>
        </div>

        {{-- Row 2: Filter Tabs --}}
        <div>
            <div class="filter-tabs">
                <a href="{{ route('part.index', ['status' => 'all', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
                    Semua ({{ $totalSku }})
                </a>
                <a href="{{ route('part.index', ['status' => 'aman', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'aman' ? 'active' : '' }}">
                    Aman ({{ $amanCount }})
                </a>
                <a href="{{ route('part.index', ['status' => 'menipis', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'menipis' ? 'active' : '' }}">
                    Menipis ({{ $menipisCount }})
                </a>
                <a href="{{ route('part.index', ['status' => 'habis', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'habis' ? 'active' : '' }}">
                    Habis ({{ $habisCount }})
                </a>
                <a href="{{ route('part.index', ['status' => 'ada_pp', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'ada_pp' ? 'active' : '' }}">
                    Ada Usulan PP ({{ $items->total() }})
                </a>
                <a href="{{ route('part.index', ['status' => 'pp_pending', 'search' => $search, 'divisi' => $divisi, 'moving' => $moving]) }}" class="filter-tab {{ $status === 'pp_pending' ? 'active' : '' }}">
                    PP Pending ({{ $ppPendingCount }})
                </a>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 36px; text-align: center;">No</th>
                    <th style="width: 80px;">PLU</th>
                    <th>Nama Sparepart / Barang</th>
                    <th style="width: 100px;">Divisi</th>
                    <th style="width: 100px;">Moving</th>
                    <th style="width: 95px; text-align: right;">Stok Fisik</th>
                    <th style="width: 85px; text-align: center;">PKM / DSI</th>
                    <th style="width: 130px;">Usulan PP</th>
                    <th style="width: 105px; text-align: right;">Harga Satuan</th>
                    <th>Keterangan / Status</th>
                    <th style="width: 80px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    @php
                        $isHabis = ($item->qty_stock <= 0);
                        $isMenipis = ($item->qty_stock > 0 && $item->qty_stock <= 5);
                        $stockClass = $isHabis ? 'habis' : ($isMenipis ? 'menipis' : 'aman');

                        $mov = strtoupper(trim((string)$item->moving));
                        $badgeClass = 'spec';
                        if ($mov === 'FAST MOVING') $badgeClass = 'fast';
                        elseif ($mov === 'SLOW MOVING') $badgeClass = 'slow';
                        elseif ($mov === 'NOT MOVING') $badgeClass = 'not';
                        elseif ($mov === 'KIRIM HO') $badgeClass = 'ho';
                    @endphp
                    <tr class="part-row"
                        data-plu="{{ strtolower($item->kode_plu ?? '') }}"
                        data-nama="{{ strtolower($item->nama_barang ?? '') }}"
                        data-divisi="{{ strtolower($item->divisi ?? '') }}"
                        data-moving="{{ strtolower($item->moving ?? '') }}"
                        data-ket="{{ strtolower(($item->keterangan ?? '') . ' ' . ($item->keterangan_khusus ?? '')) }}">
                        <td style="color: var(--text-muted); font-weight: 600; text-align: center; font-size: 0.74rem;">
                            {{ $item->no_urut ?: ($items->firstItem() + $index) }}
                        </td>
                        <td>
                            <span class="badge-plu">{{ $item->kode_plu ?: '-' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.82rem; line-height: 1.25;">
                                {{ $item->nama_barang }}
                            </div>
                            @if($item->keterangan_khusus)
                                <div style="font-size: 0.70rem; color: #64748b; margin-top: 2px;">
                                    📌 {{ $item->keterangan_khusus }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge-divisi">{{ $item->divisi ?: 'Umum' }}</span>
                        </td>
                        <td>
                            <span class="badge-moving {{ $badgeClass }}">
                                {{ $item->moving ?: '-' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="stock-chip {{ $stockClass }} font-mono">
                                <span>{{ number_format($item->qty_stock) }}</span>
                                <small style="font-size:0.68rem; opacity:0.75;">{{ $item->satuan ?: 'PCS' }}</small>
                            </div>
                        </td>
                        <td style="text-align: center; font-size: 0.73rem;">
                            <div style="font-weight: 700; color: #334155;">PKM: {{ $item->pkm ?: 0 }}</div>
                            <div style="font-size: 0.67rem; color: #64748b;">DSI: {{ $item->dsi ?: 0 }} hr</div>
                        </td>
                        <td>
                            @if($item->qty_pp > 0)
                                <div class="pp-box">
                                    <span class="badge-pp-qty">
                                        🛒 PP: {{ number_format($item->qty_pp) }} {{ $item->satuan ?: 'PCS' }}
                                    </span>
                                    <span class="pp-nominal font-mono">
                                        {{ $item->total_harga_format }}
                                    </span>
                                    @if($item->qty_pp_belum_realisasi > 0)
                                        <span class="pp-pending-chip">
                                            ⏳ Pending: {{ $item->qty_pp_belum_realisasi }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span style="color: #cbd5e1; font-size: 0.75rem;">-</span>
                            @endif
                        </td>
                        <td style="text-align: right; font-size: 0.76rem; font-weight: 600; color: #334155;" class="font-mono">
                            {{ $item->harga_satuan > 0 ? $item->harga_satuan_format : '-' }}
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.74rem; max-width: 220px;">
                            @if($item->keterangan)
                                <span style="color: #475569; font-weight: 500;">{{ $item->keterangan }}</span>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="btn-action-group" style="justify-content: center;">
                                {{-- Quick Restock --}}
                                <button type="button" class="btn-tbl-action btn-tbl-restock"
                                    title="Tambah / Restock Stok"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ htmlspecialchars($item->nama_barang, ENT_QUOTES, 'UTF-8') }}"
                                    data-plu="{{ $item->kode_plu }}"
                                    data-stock="{{ $item->qty_stock }}"
                                    data-satuan="{{ $item->satuan ?: 'PCS' }}"
                                    onclick="triggerRestockModal(this)">
                                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>

                                {{-- Edit --}}
                                <button type="button" class="btn-tbl-action btn-tbl-edit"
                                    title="Edit Informasi Part"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ htmlspecialchars($item->nama_barang, ENT_QUOTES, 'UTF-8') }}"
                                    data-plu="{{ $item->kode_plu }}"
                                    data-divisi="{{ htmlspecialchars($item->divisi ?? '', ENT_QUOTES, 'UTF-8') }}"
                                    data-satuan="{{ $item->satuan ?: 'PCS' }}"
                                    data-moving="{{ htmlspecialchars($item->moving ?? '', ENT_QUOTES, 'UTF-8') }}"
                                    data-stock="{{ $item->qty_stock }}"
                                    data-pkm="{{ $item->pkm }}"
                                    data-leadtime="{{ $item->lead_time }}"
                                    data-qtypp="{{ $item->qty_pp }}"
                                    data-harga="{{ $item->harga_satuan }}"
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
                        <td colspan="11" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <svg style="width:40px;height:40px;margin:0 auto 10px;opacity:0.4;display:block;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p style="font-weight: 600;">Tidak ada data part yang sesuai dengan kriteria filter</p>
                        </td>
                    </tr>
                @endforelse

                {{-- Live Search Empty State --}}
                <tr id="noResultsRowPart" style="display:none;">
                    <td colspan="11" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <svg style="width:36px;height:36px;margin:0 auto 8px;opacity:0.45;display:block;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                        <p style="font-weight: 700; color: #334155; margin: 0; font-size:0.86rem;">Tidak ada part yang cocok dengan pencarian "<span id="searchQueryTextPart" style="color:#0284c7;"></span>"</p>
                        <p style="font-size: 0.74rem; color: #94a3b8; margin-top: 4px;">Coba gunakan kata kunci PLU, nama barang, atau kategori lain.</p>
                    </td>
                </tr>
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
                    Tambah Part / Sparepart Baru
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
                        <label>Kode PLU</label>
                        <input type="text" name="kode_plu" class="form-control font-mono" placeholder="Contoh: 60387">
                    </div>
                    <div class="form-group">
                        <label>Nama Barang / Part <span class="req">*</span></label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Head Printer TM-T82" required>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Divisi Item</label>
                        <input type="text" name="divisi" list="listDivisiTambah" class="form-control" placeholder="Pilih divisi">
                        <datalist id="listDivisiTambah">
                            @foreach($divisiList as $div)
                                <option value="{{ $div }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Satuan <span class="req">*</span></label>
                        <input type="text" name="satuan" list="listSatuanTambah" class="form-control" value="PCS" required>
                        <datalist id="listSatuanTambah">
                            <option value="PCS"></option>
                            <option value="Unit"></option>
                            <option value="Meter"></option>
                            <option value="Roll"></option>
                            <option value="Set"></option>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Moving Status</label>
                        <select name="moving" class="form-control">
                            <option value="SPECIAL">SPECIAL</option>
                            <option value="FAST MOVING">FAST MOVING</option>
                            <option value="SLOW MOVING">SLOW MOVING</option>
                            <option value="NOT MOVING">NOT MOVING</option>
                            <option value="KIRIM HO">KIRIM HO</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Stok Awal <span class="req">*</span></label>
                        <input type="number" name="qty_stock" class="form-control font-mono" value="0" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan" class="form-control font-mono" placeholder="0" min="0">
                    </div>
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
                <div style="background:#fef3c7; border:1px solid #fde68a; border-radius:10px; padding:10px 12px; margin-bottom:14px; font-size:0.77rem; color:#92400e; display:flex; align-items:center; gap:8px;">
                    <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Form pengeluaran part ke Toko / Divisi. Memotong stok di database & mencatat log riwayat pengeluaran.</span>
                </div>

                <div class="form-group">
                    <label>Pilih Barang / Part <span class="req">*</span></label>
                    <select name="barang_id" id="manualOutBarangId" class="form-control" required onchange="updateMaxQtyOut(this)">
                        <option value="">-- Pilih Barang / Sparepart --</option>
                        @foreach($allParts as $p)
                            <option value="{{ $p->id }}" data-stok="{{ $p->qty_stock }}" data-satuan="{{ $p->satuan ?: 'PCS' }}">
                                [PLU: {{ $p->kode_plu ?: '-' }}] {{ $p->nama_barang }} (Sisa Stok: {{ $p->qty_stock }} {{ $p->satuan ?: 'PCS' }})
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
                    <label>Out Ke / Tujuan Pengeluaran (Toko / Divisi) <span class="req">*</span></label>
                    <input type="text" name="tujuan_out" list="listTokoManualOut" class="form-control" placeholder="Pilih Toko atau ketik divisi tujuan..." required>
                    <datalist id="listTokoManualOut">
                        @foreach($tokoList as $toko)
                            <option value="KDTK: {{ $toko->kode_toko }} ({{ $toko->nama_toko }})"></option>
                        @endforeach
                        <option value="Keperluan Divisi EDP"></option>
                        <option value="Project Server"></option>
                        <option value="Penggantian Sparepart Internal"></option>
                    </datalist>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>No Aktiva / No DAT <span style="font-size:0.70rem; color:#64748b; font-weight:500;">(Opsional - Kosongkan jika non-aktiva)</span></label>
                        <input type="text" name="aktiva" class="form-control font-mono" placeholder="Contoh: C26.011256 / DAT">
                    </div>
                    <div class="form-group">
                        <label>No BKB <span style="font-size:0.70rem; color:#64748b; font-weight:500;">(Opsional - Kosongkan jika tanpa BKB)</span></label>
                        <input type="text" name="no_bkb" class="form-control font-mono" placeholder="Nomor BKB (jika ada)">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal BKB <span style="font-size:0.70rem; color:#64748b; font-weight:500;">(Opsional - Kosongkan jika belum ada BKB)</span></label>
                    <input type="date" name="tgl_bkb" class="form-control">
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
    <div class="modal-card" style="max-width: 500px;">
        <form id="formRestock" method="POST">
            @csrf
            <div class="modal-header" style="background:#f0fdf4;">
                <h3 style="color:#166534;">
                    <svg style="width:18px;height:18px;color:#16a34a;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Restock / Tambah Stok Part (Barang Masuk)
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
                    <div id="restockNamaBarang" style="font-size:0.92rem; font-weight:800; color:#0f172a; margin-top:2px;">-</div>
                    <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">
                        PLU: <strong id="restockPlu" class="font-mono">-</strong> | Sisa Stok Saat Ini: <strong id="restockCurrentStock" class="font-mono text-emerald-600">0</strong> <span id="restockSatuan">PCS</span>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Jumlah Penambahan Stok <span class="req">*</span></label>
                        <input type="number" name="qty_add" class="form-control font-mono" placeholder="Jumlah unit" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Datang <span class="req">*</span></label>
                        <input type="date" name="tgl_datang" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>No BTB <span style="font-size:0.70rem; color:#64748b; font-weight:500;">(Opsional - Kosongkan jika tanpa BTB)</span></label>
                        <input type="text" name="no_btb" class="form-control font-mono" placeholder="Contoh: 2140620">
                    </div>
                    <div class="form-group">
                        <label>Tanggal BTB <span style="font-size:0.70rem; color:#64748b; font-weight:500;">(Opsional)</span></label>
                        <input type="date" name="tgl_btb" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Sumber Restock / Supplier</label>
                    <input type="text" name="sumber" list="listSumberRestock" class="form-control" placeholder="Contoh: Supplier Epson / Gudang Pusat Batam">
                    <datalist id="listSumberRestock">
                        <option value="Gudang Supplier"></option>
                        <option value="Gudang Pusat Batam"></option>
                        <option value="Pengadaan Baru (PO)"></option>
                        <option value="Retur Toko"></option>
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Keterangan / No Usulan PP (Opsional)</label>
                    <input type="text" name="catatan" class="form-control" placeholder="Contoh: PP Sep 2026 / No Invoice...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalRestock')">Batal</button>
                <button type="submit" class="btn-submit">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>/div>

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
                    Edit Data Part & Perencanaan
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
                        <label>Kode PLU</label>
                        <input type="text" name="kode_plu" id="editKodePlu" class="form-control font-mono">
                    </div>
                    <div class="form-group">
                        <label>Nama Barang / Part <span class="req">*</span></label>
                        <input type="text" name="nama_barang" id="editNamaBarang" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Divisi Item</label>
                        <input type="text" name="divisi" id="editDivisi" list="listDivisiTambah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Satuan <span class="req">*</span></label>
                        <input type="text" name="satuan" id="editSatuan" list="listSatuanTambah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Moving Status</label>
                        <select name="moving" id="editMoving" class="form-control">
                            <option value="SPECIAL">SPECIAL</option>
                            <option value="FAST MOVING">FAST MOVING</option>
                            <option value="SLOW MOVING">SLOW MOVING</option>
                            <option value="NOT MOVING">NOT MOVING</option>
                            <option value="KIRIM HO">KIRIM HO</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Kuantitas Stok <span class="req">*</span></label>
                        <input type="number" name="qty_stock" id="editQtyStock" class="form-control font-mono" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>PKM</label>
                        <input type="number" name="pkm" id="editPkm" class="form-control font-mono" min="0">
                    </div>
                    <div class="form-group">
                        <label>Lead Time (Hari)</label>
                        <input type="number" name="lead_time" id="editLeadTime" class="form-control font-mono" min="0" value="45">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Usulan PP (Qty)</label>
                        <input type="number" name="qty_pp" id="editQtyPp" class="form-control font-mono" min="0">
                    </div>
                    <div class="form-group">
                        <label>Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan" id="editHargaSatuan" class="form-control font-mono" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan / Status Khusus</label>
                    <textarea name="keterangan" id="editKeterangan" class="form-control" placeholder="Catatan part, rak, discontinue, kirim HO..."></textarea>
                </div>

                <div class="form-group">
                    <label>Alasan Perubahan / Catatan Edit <span style="font-size:0.72rem; color:#64748b; font-weight:500;">(Dicatat ke Log Transit)</span></label>
                    <input type="text" name="alasan_edit" id="editAlasanEdit" class="form-control" placeholder="Contoh: Koreksi stok opname / update harga / PP pengadaan">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalEditPart')">Batal</button>
                <button type="submit" class="btn-submit" style="background:#2563eb;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MODAL GOOGLE SHEETS SETUP & DIAGNOSTIK LIVE (TAHAP 2)    --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalGoogleGuide">
    <div class="modal-box" style="max-width: 650px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:10px; background:rgba(16, 185, 129, 0.2); display:flex; align-items:center; justify-content:center; color:#34d399;">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:1.0rem; font-weight:800; color:#fff;">Integrasi Google Sheets (Tahap 2)</h3>
                    <p style="margin:2px 0 0; font-size:0.72rem; color:#94a3b8;">Two-Way Synchronization & Live Write-Back API</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('modalGoogleGuide')" style="color:#94a3b8;">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="modal-body" style="padding: 18px 22px;">
            {{-- Status Banner --}}
            <div style="background: {{ $isGoogleConfigured ? '#ecfdf5' : '#f8fafc' }}; border: 1px solid {{ $isGoogleConfigured ? '#a7f3d0' : '#e2e8f0' }}; border-radius: 12px; padding: 12px 14px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 12px;">
                <div style="width: 28px; height: 28px; border-radius: 8px; background: {{ $isGoogleConfigured ? '#10b981' : '#64748b' }}; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                    @if($isGoogleConfigured)
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    @endif
                </div>
                <div style="flex:1;">
                    <div style="font-size: 0.85rem; font-weight: 800; color: {{ $isGoogleConfigured ? '#065f46' : '#1e293b' }};">
                        {{ $isGoogleConfigured ? 'Google Service Account Terpasang' : 'Kredensial Service Account Belum Terpasang' }}
                    </div>
                    <div style="font-size: 0.74rem; color: {{ $isGoogleConfigured ? '#047857' : '#64748b' }}; margin-top: 2px; line-height: 1.4;">
                        {{ $isGoogleConfigured 
                            ? 'Setiap penambahan stok, edit data, dan pengeluaran manual otomatis tersinkronisasi ke Google Sheets secara real-time.' 
                            : 'Sistem saat ini menggunakan database MySQL lokal dan sinkronisasi tarik (pull) CSV. Pasang file Service Account JSON untuk mengaktifkan write-back otomatis.' }}
                    </div>
                </div>
            </div>

            {{-- 4 Langkah Setup Cepat --}}
            <div style="font-size: 0.78rem; font-weight: 800; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                <span>Panduan Langkah Pemasangan:</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px;">
                <div style="display: flex; gap: 10px; align-items: flex-start; font-size: 0.77rem;">
                    <div style="width: 22px; height: 22px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.70rem; flex-shrink: 0;">1</div>
                    <div style="color: #334155; line-height: 1.4;">
                        Buka <a href="https://console.cloud.google.com/" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: underline;">Google Cloud Console</a>, buat project baru, lalu aktifkan API <strong>"Google Sheets API"</strong>.
                    </div>
                </div>

                <div style="display: flex; gap: 10px; align-items: flex-start; font-size: 0.77rem;">
                    <div style="width: 22px; height: 22px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.70rem; flex-shrink: 0;">2</div>
                    <div style="color: #334155; line-height: 1.4;">
                        Masuk menu <strong>IAM & Admin ➔ Service Accounts</strong>, buat service account, lalu masuk tab <strong>Keys ➔ Add Key ➔ Create new key (JSON)</strong>.
                    </div>
                </div>

                <div style="display: flex; gap: 10px; align-items: flex-start; font-size: 0.77rem;">
                    <div style="width: 22px; height: 22px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.70rem; flex-shrink: 0;">3</div>
                    <div style="color: #334155; line-height: 1.4;">
                        Simpan dan letakkan file JSON tersebut di folder proyek:
                        <div style="background: #f1f5f9; padding: 5px 8px; border-radius: 6px; font-family: monospace; font-size: 0.72rem; color: #0f172a; margin-top: 4px; border: 1px solid #cbd5e1; word-break: break-all;">
                            storage/app/google/service-account.json
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; align-items: flex-start; font-size: 0.77rem;">
                    <div style="width: 22px; height: 22px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.70rem; flex-shrink: 0;">4</div>
                    <div style="color: #334155; line-height: 1.4;">
                        Buka file <a href="https://docs.google.com/spreadsheets/d/1l15LkNvLJYNNkfh2CqQn1na1KkFFn-fHgg35OVKMVm0" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: underline;">Google Sheets Monitoring EDP</a>, klik tombol <strong>Share / Bagikan</strong>, dan undang email Service Account tersebut dengan hak akses <strong>Editor</strong>.
                    </div>
                </div>
            </div>

            {{-- Live Test Diagnostic Box --}}
            <div style="border-top: 1px dashed #cbd5e1; padding-top: 14px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 0.78rem; font-weight: 800; color: #0f172a;">Live API Diagnostic:</span>
                    <button type="button" onclick="runGoogleDiagnostic()" id="btnRunDiagnostic" style="background: #0f172a; color: #fff; border: none; padding: 5px 12px; border-radius: 7px; font-size: 0.73rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: background 0.2s;">
                        <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Uji Koneksi Sekarang</span>
                    </button>
                </div>
                <div id="diagnosticOutput" style="background: #0f172a; color: #e2e8f0; font-family: monospace; font-size: 0.73rem; padding: 10px 12px; border-radius: 8px; min-height: 50px; max-height: 150px; overflow-y: auto; line-height: 1.4;">
                    <span style="color: #94a3b8;">Klik "Uji Koneksi Sekarang" untuk memeriksa status komunikasi langsung ke Google API...</span>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 10px 20px;">
            <button type="button" class="btn-cancel" onclick="closeModal('modalGoogleGuide')">Tutup</button>
        </div>
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

    function runGoogleDiagnostic() {
        const out = document.getElementById('diagnosticOutput');
        const btn = document.getElementById('btnRunDiagnostic');
        
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin" style="width:13px;height:13px;animation:spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>Memeriksa...</span>
        `;
        out.innerHTML = '<span style="color:#38bdf8;">⏳ Menguji komunikasi ke Google Sheets API & kredensial...</span>';

        fetch('{{ route("part.google.test") }}')
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Uji Koneksi Sekarang</span>
                `;

                if (data.success) {
                    out.innerHTML = `
                        <div style="color:#4ade80; font-weight:bold;">✅ KONEKSI BERHASIL TERHUBUNG!</div>
                        <div style="color:#e2e8f0; margin-top:4px;">• Judul Spreadsheet : ${data.spreadsheet_title || '-'}</div>
                        <div style="color:#e2e8f0;">• Sheet Name        : ${data.sheet_name || '-'}</div>
                        <div style="color:#e2e8f0;">• Service Account   : ${data.client_email || '-'}</div>
                        <div style="color:#e2e8f0;">• Sampel Data Read  : ${data.sample_count || 0} baris terverifikasi</div>
                        <div style="color:#34d399; margin-top:4px; font-weight:bold;">Sistem siap sinkronisasi 2 arah secara real-time!</div>
                    `;
                } else {
                    let solHtml = data.solution ? `<div style="color:#fde047; margin-top:4px;">💡 Solusi: ${data.solution}</div>` : '';
                    let emailHtml = data.client_email ? `<div style="color:#94a3b8;">Email Service Account: ${data.client_email}</div>` : '';
                    out.innerHTML = `
                        <div style="color:#f87171; font-weight:bold;">❌ KONEKSI GAGAL:</div>
                        <div style="color:#fca5a5; margin-top:2px;">${data.message}</div>
                        ${emailHtml}
                        ${solHtml}
                    `;
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Uji Koneksi Sekarang</span>
                `;
                out.innerHTML = `<div style="color:#f87171;">❌ Terjadi kesalahan jaringan / server: ${err.message}</div>`;
            });
    }

    function confirmSync(form) {
        if (confirm("Apakah Anda yakin ingin menyinkronkan data stok dari Google Sheets?")) {
            const btn = document.getElementById('btnSyncGoogleSheet');
            if (btn) {
                btn.innerHTML = `
                    <svg class="animate-spin" style="width:14px;height:14px;animation:spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Sinkronisasi...</span>
                `;
                btn.disabled = true;
            }
            return true;
        }
        return false;
    }

    function triggerRestockModal(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const plu = btn.getAttribute('data-plu') || '-';
        const currentStock = btn.getAttribute('data-stock');
        const satuan = btn.getAttribute('data-satuan') || 'PCS';
        openRestockModal(id, nama, plu, currentStock, satuan);
    }

    function triggerEditModal(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const plu = btn.getAttribute('data-plu') || '';
        const divisi = btn.getAttribute('data-divisi') || '';
        const satuan = btn.getAttribute('data-satuan') || 'PCS';
        const moving = btn.getAttribute('data-moving') || 'SPECIAL';
        const qty = btn.getAttribute('data-stock') || 0;
        const pkm = btn.getAttribute('data-pkm') || 0;
        const leadtime = btn.getAttribute('data-leadtime') || 45;
        const qtypp = btn.getAttribute('data-qtypp') || 0;
        const harga = btn.getAttribute('data-harga') || 0;
        const ket = btn.getAttribute('data-keterangan') || '';

        openEditModal(id, nama, plu, divisi, satuan, moving, qty, pkm, leadtime, qtypp, harga, ket);
    }

    function openRestockModal(id, nama, plu, currentStock, satuan) {
        document.getElementById('restockNamaBarang').innerText = nama;
        document.getElementById('restockPlu').innerText = plu;
        document.getElementById('restockCurrentStock').innerText = currentStock;
        document.getElementById('restockSatuan').innerText = satuan;
        document.getElementById('formRestock').action = '/part/add-stock/' + id;
        openModal('modalRestock');
    }

    function openEditModal(id, nama, plu, divisi, satuan, moving, qty, pkm, leadtime, qtypp, harga, ket) {
        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editKodePlu').value = plu;
        document.getElementById('editDivisi').value = divisi;
        document.getElementById('editSatuan').value = satuan;
        document.getElementById('editMoving').value = moving;
        document.getElementById('editQtyStock').value = qty;
        document.getElementById('editPkm').value = pkm;
        document.getElementById('editLeadTime').value = leadtime;
        document.getElementById('editQtyPp').value = qtypp;
        document.getElementById('editHargaSatuan').value = harga;
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

    // Close on backdrop click & Initialize Instant Live Search
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });

        // ── INSTANT LIVE SEARCH LPP STOCK (REAL-TIME AS YOU TYPE) ──
        const searchInput   = document.getElementById('liveSearchInputPart');
        const clearBtn      = document.getElementById('btnClearSearchPart');
        const resultCountEl = document.getElementById('searchResultCountPart');
        const rows          = document.querySelectorAll('.part-row');
        const noResults     = document.getElementById('noResultsRowPart');
        const queryText     = document.getElementById('searchQueryTextPart');

        function doLiveSearch() {
            if (!searchInput) return;
            const q = (searchInput.value || '').trim().toLowerCase();

            if (clearBtn) {
                clearBtn.style.display = q ? 'inline-flex' : 'none';
            }

            const words = q.split(/\s+/).filter(w => w.length > 0);
            let visibleCount = 0;

            rows.forEach(row => {
                if (words.length === 0) {
                    row.style.display = '';
                    visibleCount++;
                    return;
                }

                const plu    = row.getAttribute('data-plu') || '';
                const nama   = row.getAttribute('data-nama') || '';
                const divisi = row.getAttribute('data-divisi') || '';
                const moving = row.getAttribute('data-moving') || '';
                const ket    = row.getAttribute('data-ket') || '';
                const text   = (row.innerText || '').toLowerCase();

                const combined = `${plu} ${nama} ${divisi} ${moving} ${ket} ${text}`;

                // Check if all search words match (multi-word support)
                const match = words.every(w => combined.includes(w));

                if (match) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (resultCountEl) {
                if (words.length > 0) {
                    resultCountEl.textContent = `${visibleCount} item`;
                    resultCountEl.style.display = 'inline-block';
                } else {
                    resultCountEl.style.display = 'none';
                }
            }

            if (noResults) {
                if (visibleCount === 0 && words.length > 0) {
                    noResults.style.display = '';
                    if (queryText) queryText.innerText = searchInput.value;
                } else {
                    noResults.style.display = 'none';
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    doLiveSearch();
                }
            });
            searchInput.addEventListener('input', doLiveSearch);
            searchInput.addEventListener('keyup', doLiveSearch);
            if (searchInput.value.trim()) {
                doLiveSearch();
            }
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = '';
                doLiveSearch();
                searchInput.focus();
            });
        }
    });
</script>

@endsection
