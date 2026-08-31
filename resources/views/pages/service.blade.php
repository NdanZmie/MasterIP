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

    .service-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }

    .service-wrap {
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

    .page-title-block { display:flex; align-items:center; gap:14px; }
    .page-icon {
        width:46px; height:46px; border-radius:14px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display:flex; align-items:center; justify-content:center;
        box-shadow: 0 6px 20px rgba(139,92,246,0.3);
        flex-shrink:0;
    }
    .page-icon svg { width:22px; height:22px; stroke:#fff; }
    .page-title { font-size:1.45rem; font-weight:800; color:var(--text-head); letter-spacing:-0.03em; }
    .page-subtitle { font-size:0.80rem; color:var(--text-muted); font-weight:500; margin-top:1px; }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }
    @media (max-width: 1280px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.03);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(0,0,0,0.07);
        border-color: var(--border-strong);
    }
    .stat-icon {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 18px; height: 18px; }
    .stat-icon.slate { background: rgba(100,116,139,0.12); color: #475569; }
    .stat-icon.amber { background: rgba(245,158,11,0.12); color: #d97706; }
    .stat-icon.blue { background: rgba(37,99,235,0.12); color: #2563eb; }
    .stat-icon.purple { background: rgba(139,92,246,0.12); color: #7c3aed; }
    .stat-icon.emerald { background: rgba(16,185,129,0.12); color: #059669; }

    .stat-info { display: flex; flex-direction: column; }
    .stat-val { font-size: 1.25rem; font-weight: 800; color: var(--text-head); line-height: 1.1; }
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
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
        background: #3b82f6; color: #fff; border: none;
        padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: background 0.2s;
    }
    .search-box button:hover { background: #2563eb; }

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
        color: #2563eb;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .toolbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-export {
        display: flex;
        align-items: center;
        gap: 5px;
        background: rgba(37,99,235,0.08);
        color: #2563eb;
        border: 1px solid rgba(37,99,235,0.2);
        padding: 7px 13px;
        font-size: 0.78rem;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-export:hover {
        background: #2563eb; color: #fff;
    }
    .btn-export svg { width: 14px; height: 14px; }

    .btn-add {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        border: none;
        padding: 7px 16px;
        font-size: 0.80rem;
        font-weight: 700;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 3px 12px rgba(59,130,246,0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(59,130,246,0.4);
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
        padding: 10px 10px;
        font-size: 0.71rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .modern-table td {
        padding: 10px 10px;
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
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .badge-status.belum-cek {
        background: rgba(245,158,11,0.12);
        color: #b45309;
        border-color: rgba(245,158,11,0.25);
    }
    .badge-status.sudah-cek {
        background: rgba(37,99,235,0.12);
        color: #1d4ed8;
        border-color: rgba(37,99,235,0.25);
    }
    .badge-status.service-suplier {
        background: rgba(139,92,246,0.12);
        color: #6d28d9;
        border-color: rgba(139,92,246,0.25);
    }
    .badge-status.selesai-service {
        background: rgba(16,185,129,0.12);
        color: #047857;
        border-color: rgba(16,185,129,0.25);
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-status.belum-cek .badge-dot { background: #f59e0b; }
    .badge-status.sudah-cek .badge-dot { background: #3b82f6; }
    .badge-status.service-suplier .badge-dot { background: #8b5cf6; }
    .badge-status.selesai-service .badge-dot { background: #10b981; }

    .badge-kdtk {
        background: rgba(2,132,199,0.1);
        color: #0369a1;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 5px;
        border: 1px solid rgba(2,132,199,0.2);
    }

    .badge-duration {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.70rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 5px;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .badge-duration.finished {
        background: rgba(16,185,129,0.08);
        color: #047857;
        border-color: rgba(16,185,129,0.2);
    }
    .badge-duration.ongoing {
        background: rgba(245,158,11,0.08);
        color: #b45309;
        border-color: rgba(245,158,11,0.2);
    }

    .part-pill-list {
        display: flex;
        flex-direction: column;
        gap: 3px;
        margin-top: 4px;
    }
    .part-pill-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.70rem;
        background: rgba(16,185,129,0.08);
        color: #047857;
        border: 1px solid rgba(16,185,129,0.22);
        padding: 1px 6px;
        border-radius: 5px;
        width: fit-content;
    }

    /* Action Buttons */
    .btn-action-group {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 5px 8px;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-tindakan {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        box-shadow: 0 2px 6px rgba(37,99,235,0.25);
    }
    .btn-tindakan:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(37,99,235,0.35);
    }
    .btn-detail {
        background: rgba(100,116,139,0.12);
        color: #334155;
        border: 1px solid rgba(100,116,139,0.22);
        padding: 5px 7px;
    }
    .btn-detail:hover { background: #334155; color: #fff; }
    .btn-edit {
        background: rgba(59,130,246,0.12);
        color: #1d4ed8;
        border: 1px solid rgba(59,130,246,0.25);
        padding: 5px 7px;
    }
    .btn-edit:hover { background: #2563eb; color: #fff; }
    .btn-delete {
        background: rgba(239,68,68,0.12);
        color: #dc2626;
        border: 1px solid rgba(239,68,68,0.25);
        padding: 5px 7px;
    }
    .btn-delete:hover { background: #dc2626; color: #fff; }

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
        border-radius: 20px;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.8);
        overflow: hidden;
        animation: scaleUp 0.25s cubic-bezier(0.16,1,0.3,1);
    }
    .modal-card.large { max-width: 720px; }
    @keyframes scaleUp {
        from { transform: scale(0.94) translateY(10px); opacity:0; }
        to   { transform: scale(1) translateY(0); opacity:1; }
    }
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
    }
    .modal-header h3 {
        font-size: 1.1rem; font-weight: 800; color: #0f172a;
        display: flex; align-items: center; gap: 10px;
    }
    .modal-close {
        background: transparent; border: none; cursor: pointer;
        color: #94a3b8; padding: 4px; border-radius: 8px;
        transition: color 0.2s, background 0.2s;
    }
    .modal-close:hover { color: #0f172a; background: #e2e8f0; }
    .modal-body { padding: 24px; max-height: 78vh; overflow-y: auto; }
    .modal-footer {
        padding: 16px 24px; border-top: 1px solid #e2e8f0;
        background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;
    }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media (max-width: 580px) { .form-grid-2 { grid-template-columns: 1fr; } }

    .form-group { margin-bottom: 16px; }
    .form-group label {
        display: block; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 6px;
    }
    .form-group label span.req { color: #ef4444; }
    .form-control {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #cbd5e1; border-radius: 10px;
        font-size: 0.86rem; color: #0f172a; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .form-control:focus {
        border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }
    textarea.form-control { resize: vertical; min-height: 75px; }

    .btn-cancel {
        padding: 9px 18px; font-size: 0.82rem; font-weight: 600;
        color: #475569; background: #e2e8f0; border: none; border-radius: 10px;
        cursor: pointer; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #cbd5e1; }
    .btn-submit {
        padding: 9px 20px; font-size: 0.82rem; font-weight: 700;
        color: #fff; background: #2563eb; border: none; border-radius: 10px;
        cursor: pointer; transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover { background: #1d4ed8; box-shadow: 0 4px 14px rgba(37,99,235,0.3); }

    /* Part Row dynamic */
    .part-row {
        display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
        background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;
    }
    .btn-remove-row {
        background: #fee2e2; color: #dc2626; border: none; padding: 8px 10px;
        border-radius: 8px; cursor: pointer; transition: background 0.2s;
    }
    .btn-remove-row:hover { background: #fecaca; }

    /* ── CUSTOM AUTOCOMPLETE DROPDOWN ── */
    .autocomplete-wrap {
        position: relative;
    }
    .autocomplete-dropdown {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1.5px solid #3b82f6;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15), 0 4px 10px rgba(59, 130, 246, 0.08);
        max-height: 230px;
        overflow-y: auto;
        z-index: 100000;
        display: none;
        animation: dropDownAnim 0.18s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes dropDownAnim {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .autocomplete-dropdown.show {
        display: block !important;
    }
    .autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        font-size: 0.82rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.12s ease;
    }
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    .autocomplete-item:hover,
    .autocomplete-item.active {
        background: #eff6ff;
    }
    .autocomplete-item-highlight {
        color: #2563eb;
        font-weight: 800;
        text-decoration: underline;
    }
    .autocomplete-badge-code {
        background: rgba(37, 99, 235, 0.12);
        color: #1d4ed8;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.76rem;
        padding: 2px 7px;
        border-radius: 6px;
        border: 1px solid rgba(37, 99, 235, 0.2);
        flex-shrink: 0;
    }
    .autocomplete-toko-name {
        font-size: 0.80rem;
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }
    .autocomplete-barang-name {
        font-size: 0.82rem;
        color: #0f172a;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }
    .toko-info-tag {
        margin-top: 5px;
        font-size: 0.74rem;
        color: #0369a1;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        padding: 3px 8px;
        border-radius: 6px;
        display: none;
        align-items: center;
        gap: 5px;
        font-weight: 600;
    }
    .toko-info-tag.show {
        display: flex !important;
    }

    /* Flash Alerts */
    .alert-banner {
        padding: 14px 18px; border-radius: 12px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 12px; font-size: 0.86rem; font-weight: 600;
        animation: slideDown 0.3s ease-out;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
</style>

<div class="service-wrap">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert-banner alert-success">
            <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error') || (isset($errors) && $errors->any()))
        <div class="alert-banner alert-error">
            <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') ?: ($errors->first() ?? '') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="page-header">
        <div class="page-title-block">
            <div class="page-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Monitoring Service Barang</h1>
                <p class="page-subtitle">Tracking alur service unit toko, tindakan teknisi, durasi pengerjaan, dan alokasi part keluar</p>
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
                <span class="stat-val">{{ number_format($totalService) }}</span>
                <span class="stat-lbl">Total Service</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($belumCekCount) }}</span>
                <span class="stat-lbl">Belum Cek</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($sudahCekCount) }}</span>
                <span class="stat-lbl">Sudah Cek</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($suplierCount) }}</span>
                <span class="stat-lbl">Service Suplier</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon emerald">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($selesaiCount) }}</span>
                <span class="stat-lbl">Selesai Service</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar-wrap">
        <div class="toolbar-left">
            {{-- Search Box --}}
            <form action="{{ route('service.index') }}" method="GET" class="search-box">
                <input type="hidden" name="status" value="{{ $status }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari DAT, SN, Barang, Toko...">
                <button type="submit">Cari</button>
            </form>

            {{-- Filter Tabs --}}
            <div class="filter-tabs">
                <a href="{{ route('service.index', ['status' => 'all', 'search' => $search]) }}" class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
                    Semua ({{ $totalService }})
                </a>
                <a href="{{ route('service.index', ['status' => 'Belum Cek', 'search' => $search]) }}" class="filter-tab {{ $status === 'Belum Cek' ? 'active' : '' }}">
                    Belum Cek ({{ $belumCekCount }})
                </a>
                <a href="{{ route('service.index', ['status' => 'Sudah Cek', 'search' => $search]) }}" class="filter-tab {{ $status === 'Sudah Cek' ? 'active' : '' }}">
                    Sudah Cek ({{ $sudahCekCount }})
                </a>
                <a href="{{ route('service.index', ['status' => 'Service Suplier', 'search' => $search]) }}" class="filter-tab {{ $status === 'Service Suplier' ? 'active' : '' }}">
                    Suplier ({{ $suplierCount }})
                </a>
                <a href="{{ route('service.index', ['status' => 'Selesai Service', 'search' => $search]) }}" class="filter-tab {{ $status === 'Selesai Service' ? 'active' : '' }}">
                    Selesai ({{ $selesaiCount }})
                </a>
            </div>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('service.export') }}" class="btn-export">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </a>

            <button type="button" class="btn-add" onclick="openModal('modalTambahService')">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                <span>Input Barang Service</span>
            </button>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 32px; text-align: center;">No</th>
                    <th style="width: 105px;">No DAT / SN</th>
                    <th style="min-width: 150px;">Nama Barang</th>
                    <th style="width: 115px;">KDTK (Toko)</th>
                    <th style="min-width: 150px;">Kerusakan & Tindakan</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 125px;">Periode & Durasi</th>
                    <th style="width: 150px; text-align: center; white-space: nowrap;">Menu & Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $index => $row)
                    @php
                        $badgeClass = match($row->status) {
                            'Belum Cek' => 'belum-cek',
                            'Sudah Cek' => 'sudah-cek',
                            'Service Suplier' => 'service-suplier',
                            'Selesai Service' => 'selesai-service',
                            default => 'belum-cek',
                        };
                        $isFinished = ($row->status === 'Selesai Service');
                    @endphp
                    <tr>
                        <td style="color: var(--text-muted); font-weight: 600; text-align: center; font-size: 0.76rem;">
                            {{ $services->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="font-mono" style="font-weight: 700; color: #0f172a; font-size: 0.80rem;">
                                {{ $row->no_dat ?: '-' }}
                            </div>
                            <div class="font-mono" style="font-size: 0.70rem; color: var(--text-muted);">
                                SN: {{ $row->sn ?: '-' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.84rem;">{{ $row->nama_barang }}</div>
                        </td>
                        <td>
                            <span class="badge-kdtk">{{ $row->kode_toko }}</span>
                            @if($row->toko)
                                <div style="font-size: 0.70rem; color: #475569; font-weight: 600; margin-top: 2px; line-height: 1.2;">
                                    {{ $row->toko->nama_toko }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.74rem; color: #334155; line-height: 1.25;">
                                <div><span style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.68rem;">Kerusakan:</span> {{ $row->kerusakan ?: '-' }}</div>
                                @if($row->tindakan)
                                    <div style="margin-top: 2px;"><span style="color: #2563eb; font-weight: 600; text-transform: uppercase; font-size: 0.68rem;">Tindakan:</span> <strong style="color: #1d4ed8;">{{ $row->tindakan }}</strong></div>
                                @endif
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="badge-status {{ $badgeClass }}">
                                <span class="badge-dot"></span>
                                <span>{{ $row->status }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.72rem; color: var(--text-body); line-height: 1.2; white-space: nowrap;">
                                <div><span style="color:#64748b;">Masuk:</span> <strong>{{ $row->tanggal_masuk ? $row->tanggal_masuk->format('d/m/Y') : '-' }}</strong></div>
                                <div><span style="color:#64748b;">Selesai:</span> <strong>{{ $row->tanggal_selesai ? $row->tanggal_selesai->format('d/m/Y') : '-' }}</strong></div>
                            </div>
                            <div class="badge-duration {{ $isFinished ? 'finished' : 'ongoing' }}" style="margin-top: 3px;">
                                @if($isFinished)
                                    <svg style="width:10px;height:10px;color:#059669;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg style="width:10px;height:10px;color:#d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @endif
                                <span>{{ $row->durasi_text }}</span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="btn-action-group" style="justify-content: center;">
                                {{-- Tindakan Service --}}
                                <button type="button" class="btn-action btn-tindakan"
                                    title="Tindakan & Update Status Service"
                                    onclick="openTindakanModalById({{ $row->id }})">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Tindakan</span>
                                </button>

                                {{-- Detail Riwayat --}}
                                <button type="button" class="btn-action btn-detail"
                                    title="Lihat Detail Lengkap & Riwayat Part"
                                    onclick="openDetailModalById({{ $row->id }})">
                                    <svg style="width:12.5px;height:12.5px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>

                                {{-- Edit Data Unit --}}
                                <button type="button" class="btn-action btn-edit"
                                    title="Edit Informasi Unit"
                                    onclick="openEditModalById({{ $row->id }})">
                                    <svg style="width:12.5px;height:12.5px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                {{-- Delete --}}
                                <button type="button" class="btn-action btn-delete"
                                    title="Hapus Data Service"
                                    onclick="openDeleteModalById({{ $row->id }})">
                                    <svg style="width:12.5px;height:12.5px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 45px; color: var(--text-muted);">
                            <svg style="width:42px;height:42px;margin:0 auto 10px;opacity:0.4;display:block;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                            <p style="font-weight: 600;">Belum ada data service barang yang sesuai</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($services->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL INPUT BARANG SERVICE (TAMBAH)
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalTambahService">
    <div class="modal-card large">
        <form action="{{ route('service.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h3>
                    <svg style="width:20px;height:20px;color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Barang Service Masuk
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalTambahService')">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:10px 14px; margin-bottom:16px; font-size:0.8rem; color:#1e40af; display:flex; align-items:center; gap:8px;">
                    <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Status awal barang yang baru didaftarkan otomatis menjadi <strong>"Belum Cek"</strong>.</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>No DAT</label>
                        <input type="text" name="no_dat" class="form-control font-mono" placeholder="Contoh: DAT-2026-089">
                    </div>
                    <div class="form-group">
                        <label>Serial Number (SN)</label>
                        <input type="text" name="sn" class="form-control font-mono" placeholder="Contoh: SN-82939023">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group autocomplete-wrap">
                        <label>Nama Barang <span class="req">*</span></label>
                        <input type="text" name="nama_barang" id="inputTambahNamaBarang" class="form-control" placeholder="Contoh: Printer EPSON TM-T82 / UPS" autocomplete="off" required>
                        <div id="dropdownTambahNamaBarang" class="autocomplete-dropdown"></div>
                    </div>
                    <div class="form-group autocomplete-wrap">
                        <label>Kode Toko (KDTK) <span class="req">*</span></label>
                        <input type="text" name="kode_toko" id="inputTambahKodeToko" class="form-control font-mono" placeholder="Ketik Kode (TDCN) / Nama Toko..." autocomplete="off" required>
                        <div id="dropdownTambahKodeToko" class="autocomplete-dropdown"></div>
                        <div id="previewTambahToko" class="toko-info-tag"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Masuk Service <span class="req">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label>Detail Kerusakan</label>
                    <textarea name="kerusakan" class="form-control" placeholder="Keluhan kerusakan barang (contoh: Mati total, hasil print bergaris, roller macet)..."></textarea>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan (Opsional)</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Catatan kelengkapan / adaptor / kabel...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalTambahService')">Batal</button>
                <button type="submit" class="btn-submit">Daftarkan Service</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL TINDAKAN SERVICE & GANTI STATUS
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalTindakanService">
    <div class="modal-card large">
        <form id="formTindakanService" method="POST">
            @csrf
            <div class="modal-header">
                <h3>
                    <svg style="width:20px;height:20px;color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                    Tindakan & Perubahan Status Service
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalTindakanService')">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px; margin-bottom:18px;">
                    <div style="font-size:0.75rem; color:#64748b; font-weight:600; text-transform:uppercase;">Unit Sedang Dikerjakan</div>
                    <div id="tindakanNamaBarang" style="font-size:1.05rem; font-weight:800; color:#0f172a; margin-top:2px;">-</div>
                </div>

                <div class="form-group">
                    <label>Status Pengerjaan Service <span class="req">*</span></label>
                    <select name="status" id="selectStatusTindakan" class="form-control" onchange="toggleSelesaiSection(this.value)" required>
                        <option value="Belum Cek">Belum Cek</option>
                        <option value="Sudah Cek">Sudah Cek</option>
                        <option value="Service Suplier">Service Suplier</option>
                        <option value="Selesai Service">Selesai Service</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tindakan / Diagnosa Teknisi</label>
                    <textarea name="tindakan" id="tindakanText" class="form-control" placeholder="Tindakan yang telah dilakukan (contoh: Pembersihan sensor, ganti adaptor, penggantian gear/head)..."></textarea>
                </div>

                {{-- Section Tambahan Khusus "Selesai Service" --}}
                <div id="sectionSelesaiService" style="display:none; background:#f0fdf4; border:1.5px dashed #86efac; border-radius:14px; padding:16px; margin-top:16px;">
                    <div style="font-size:0.88rem; font-weight:800; color:#166534; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span>Form Penyelesaian Service & Penggunaan Part</span>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Selesai Service <span class="req">*</span></label>
                        <input type="date" name="tanggal_selesai" id="inputTanggalSelesai" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                            <label style="margin-bottom:0;">Part Keluar yang Digunakan (Potong Stok):</label>
                            <button type="button" class="btn-action btn-tindakan" style="padding:4px 10px; font-size:0.74rem;" onclick="addPartRow()">
                                + Tambah Part
                            </button>
                        </div>

                        <div id="partListContainer">
                            {{-- Dynamic rows inserted here --}}
                        </div>
                        <p style="font-size:0.75rem; color:#15803d; margin-top:6px;">
                            * Stok part pada tabel <strong>barang</strong> akan terpotong secara otomatis sesuai kuantitas yang digunakan.
                        </p>
                    </div>
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label>Catatan / Keterangan Lain</label>
                    <input type="text" name="keterangan" id="tindakanKeterangan" class="form-control" placeholder="Catatan tambahan bila ada...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalTindakanService')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Tindakan</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL DETAIL SERVICE & RIWAYAT PART
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalDetailService">
    <div class="modal-card large">
        <div class="modal-header">
            <h3>
                <svg style="width:20px;height:20px;color:#475569;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Detail Informasi & Riwayat Service
            </h3>
            <button type="button" class="modal-close" onclick="closeModal('modalDetailService')">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body" id="detailModalBody">
            {{-- Injected dynamically --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('modalDetailService')">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL EDIT DATA UNIT
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalEditService">
    <div class="modal-card large">
        <form id="formEditService" method="POST">
            @csrf
            <div class="modal-header">
                <h3>
                    <svg style="width:20px;height:20px;color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Data Unit Service
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalEditService')">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>No DAT</label>
                        <input type="text" name="no_dat" id="editNoDat" class="form-control font-mono">
                    </div>
                    <div class="form-group">
                        <label>Serial Number (SN)</label>
                        <input type="text" name="sn" id="editSn" class="form-control font-mono">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group autocomplete-wrap">
                        <label>Nama Barang <span class="req">*</span></label>
                        <input type="text" name="nama_barang" id="editNamaBarang" class="form-control" autocomplete="off" required>
                        <div id="dropdownEditNamaBarang" class="autocomplete-dropdown"></div>
                    </div>
                    <div class="form-group autocomplete-wrap">
                        <label>Kode Toko (KDTK) <span class="req">*</span></label>
                        <input type="text" name="kode_toko" id="editKodeToko" class="form-control font-mono" autocomplete="off" required>
                        <div id="dropdownEditKodeToko" class="autocomplete-dropdown"></div>
                        <div id="previewEditToko" class="toko-info-tag"></div>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Tanggal Masuk <span class="req">*</span></label>
                        <input type="date" name="tanggal_masuk" id="editTanggalMasuk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="editTanggalSelesai" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Detail Kerusakan</label>
                    <textarea name="kerusakan" id="editKerusakan" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Tindakan Teknisi</label>
                    <textarea name="tindakan" id="editTindakan" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" id="editKeterangan" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalEditService')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
   MODAL HAPUS SERVICE
═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalDeleteService">
    <div class="modal-card" style="max-width: 420px;">
        <form id="formDeleteService" method="POST">
            @csrf
            <div class="modal-header" style="background:#fef2f2;">
                <h3 style="color:#991b1b;">
                    <svg style="width:20px;height:20px;color:#dc2626;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Hapus Data Service
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modalDeleteService')">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p style="font-size: 0.9rem; color:#475569;">
                    Apakah Anda yakin ingin menghapus data service unit <strong id="deleteNamaBarang" style="color:#0f172a;"></strong> (<span id="deleteKodeToko" class="font-mono"></span>)?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalDeleteService')">Batal</button>
                <button type="submit" class="btn-submit" style="background:#dc2626;">Hapus Data</button>
            </div>
        </form>
    </div>
</div>

{{-- Pass Master Part & Service Data into Clean JS Scope --}}
<script>
    const MASTER_BARANG = @json($barangList);
    const SERVICES_DATA = @json($services->keyBy('id'));
    const TOKO_LIST = @json($tokoList);
    const NAMA_BARANG_SUGGESTIONS = @json($namaBarangList ?? []);

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function highlightMatch(text, query) {
        if (!query) return escapeHtml(text);
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escapedQuery})`, 'gi');
        return escapeHtml(text).replace(regex, '<span class="autocomplete-item-highlight">$1</span>');
    }

    function updateTokoPreview(previewId, tokoName) {
        const el = document.getElementById(previewId);
        if (!el) return;
        if (tokoName) {
            el.innerHTML = `
                <svg style="width:13px;height:13px;color:#0284c7;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Toko: <strong>${escapeHtml(tokoName)}</strong></span>
            `;
            el.classList.add('show');
        } else {
            el.innerHTML = '';
            el.classList.remove('show');
        }
    }

    function setupTokoAutocomplete(inputId, dropdownId, previewId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        if (!input || !dropdown) return;

        let activeIndex = -1;

        function render(query = '') {
            const q = query.trim().toLowerCase();
            let matches = [];

            if (!q) {
                matches = TOKO_LIST.slice(0, 15);
            } else {
                matches = TOKO_LIST.filter(t => {
                    const k = (t.kode_toko || '').toLowerCase();
                    const n = (t.nama_toko || '').toLowerCase();
                    return k.includes(q) || n.includes(q);
                }).sort((a, b) => {
                    const ka = (a.kode_toko || '').toLowerCase();
                    const kb = (b.kode_toko || '').toLowerCase();
                    const na = (a.nama_toko || '').toLowerCase();
                    const nb = (b.nama_toko || '').toLowerCase();
                    
                    if (ka.startsWith(q) && !kb.startsWith(q)) return -1;
                    if (!ka.startsWith(q) && kb.startsWith(q)) return 1;
                    if (na.startsWith(q) && !nb.startsWith(q)) return -1;
                    if (!na.startsWith(q) && nb.startsWith(q)) return 1;
                    return ka.localeCompare(kb);
                }).slice(0, 25);
            }

            if (matches.length === 0) {
                dropdown.innerHTML = `
                    <div style="padding:10px 14px; color:#64748b; font-size:0.78rem; text-align:center;">
                        Tidak ditemukan toko dengan kode/nama "<strong>${escapeHtml(q)}</strong>"
                    </div>
                `;
                dropdown.classList.add('show');
                activeIndex = -1;
                return;
            }

            let html = '';
            matches.forEach((toko, idx) => {
                html += `
                    <div class="autocomplete-item" data-index="${idx}" data-code="${escapeHtml(toko.kode_toko)}" data-name="${escapeHtml(toko.nama_toko)}">
                        <span class="autocomplete-badge-code">${highlightMatch(toko.kode_toko, q)}</span>
                        <span class="autocomplete-toko-name">${highlightMatch(toko.nama_toko, q)}</span>
                    </div>
                `;
            });

            dropdown.innerHTML = html;
            dropdown.classList.add('show');
            activeIndex = -1;

            dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    const code = this.getAttribute('data-code');
                    const name = this.getAttribute('data-name');
                    input.value = code;
                    updateTokoPreview(previewId, name);
                    dropdown.classList.remove('show');
                });
            });
        }

        input.addEventListener('input', function() {
            render(this.value);
            const val = this.value.trim().toUpperCase();
            const matched = TOKO_LIST.find(t => (t.kode_toko || '').toUpperCase() === val);
            if (matched) {
                updateTokoPreview(previewId, matched.nama_toko);
            } else {
                updateTokoPreview(previewId, null);
            }
        });

        input.addEventListener('focus', function() {
            render(this.value);
        });

        input.addEventListener('blur', function() {
            setTimeout(() => {
                dropdown.classList.remove('show');
            }, 200);
        });

        input.addEventListener('keydown', function(e) {
            const items = dropdown.querySelectorAll('.autocomplete-item');
            if (!dropdown.classList.contains('show') || items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                updateActiveItem(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateActiveItem(items);
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0 && items[activeIndex]) {
                    e.preventDefault();
                    const item = items[activeIndex];
                    const code = item.getAttribute('data-code');
                    const name = item.getAttribute('data-name');
                    input.value = code;
                    updateTokoPreview(previewId, name);
                    dropdown.classList.remove('show');
                }
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('show');
            }
        });

        function updateActiveItem(items) {
            items.forEach((it, i) => {
                if (i === activeIndex) {
                    it.classList.add('active');
                    it.scrollIntoView({ block: 'nearest' });
                } else {
                    it.classList.remove('active');
                }
            });
        }
    }

    function setupBarangAutocomplete(inputId, dropdownId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        if (!input || !dropdown) return;

        let activeIndex = -1;

        function render(query = '') {
            const q = query.trim().toLowerCase();
            let matches = [];

            if (!q) {
                matches = NAMA_BARANG_SUGGESTIONS.slice(0, 15);
            } else {
                matches = NAMA_BARANG_SUGGESTIONS.filter(name => {
                    return (name || '').toLowerCase().includes(q);
                }).sort((a, b) => {
                    const na = a.toLowerCase();
                    const nb = b.toLowerCase();
                    if (na.startsWith(q) && !nb.startsWith(q)) return -1;
                    if (!na.startsWith(q) && nb.startsWith(q)) return 1;
                    return na.localeCompare(nb);
                }).slice(0, 20);
            }

            if (matches.length === 0) {
                dropdown.classList.remove('show');
                return;
            }

            let html = '';
            matches.forEach((nama, idx) => {
                html += `
                    <div class="autocomplete-item" data-index="${idx}" data-name="${escapeHtml(nama)}">
                        <div class="autocomplete-barang-name">
                            <svg style="width:14px;height:14px;color:#3b82f6;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                            </svg>
                            <span>${highlightMatch(nama, q)}</span>
                        </div>
                    </div>
                `;
            });

            dropdown.innerHTML = html;
            dropdown.classList.add('show');
            activeIndex = -1;

            dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    const name = this.getAttribute('data-name');
                    input.value = name;
                    dropdown.classList.remove('show');
                });
            });
        }

        input.addEventListener('input', function() {
            render(this.value);
        });

        input.addEventListener('focus', function() {
            render(this.value);
        });

        input.addEventListener('blur', function() {
            setTimeout(() => {
                dropdown.classList.remove('show');
            }, 200);
        });

        input.addEventListener('keydown', function(e) {
            const items = dropdown.querySelectorAll('.autocomplete-item');
            if (!dropdown.classList.contains('show') || items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                updateActiveItem(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateActiveItem(items);
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0 && items[activeIndex]) {
                    e.preventDefault();
                    const item = items[activeIndex];
                    const name = item.getAttribute('data-name');
                    input.value = name;
                    dropdown.classList.remove('show');
                }
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('show');
            }
        });

        function updateActiveItem(items) {
            items.forEach((it, i) => {
                if (i === activeIndex) {
                    it.classList.add('active');
                    it.scrollIntoView({ block: 'nearest' });
                } else {
                    it.classList.remove('active');
                }
            });
        }
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('show');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('show');
        }
    }

    let partRowIndex = 0;
    function addPartRow() {
        const container = document.getElementById('partListContainer');
        const rowId = 'part-row-' + partRowIndex;
        
        let optionsHtml = '<option value="">-- Pilih Part / Sparepart --</option>';
        MASTER_BARANG.forEach(b => {
            optionsHtml += `<option value="${b.id}">[PLU: ${b.kode_plu}] ${b.nama_barang} (Sisa Stok: ${b.qty_stock})</option>`;
        });

        const rowHtml = `
            <div class="part-row" id="${rowId}">
                <div style="flex:1;">
                    <select name="parts[${partRowIndex}][barang_id]" class="form-control" style="font-size:0.82rem;" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div style="width:100px;">
                    <input type="number" name="parts[${partRowIndex}][qty]" class="form-control font-mono" placeholder="Qty" value="1" min="1" required>
                </div>
                <button type="button" class="btn-remove-row" onclick="removePartRow('${rowId}')">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
        partRowIndex++;
    }

    function removePartRow(rowId) {
        const elem = document.getElementById(rowId);
        if (elem) elem.remove();
    }

    function toggleSelesaiSection(status) {
        const sec = document.getElementById('sectionSelesaiService');
        if (status === 'Selesai Service') {
            sec.style.display = 'block';
            if (document.getElementById('partListContainer').children.length === 0) {
                addPartRow();
            }
        } else {
            sec.style.display = 'none';
        }
    }

    function openTindakanModalById(id) {
        const row = SERVICES_DATA[id];
        if (!row) return;

        document.getElementById('tindakanNamaBarang').innerText = row.nama_barang;
        document.getElementById('selectStatusTindakan').value = row.status;
        document.getElementById('tindakanText').value = row.tindakan || '';
        document.getElementById('tindakanKeterangan').value = row.keterangan || '';
        
        let tglSelesai = '';
        if (row.tanggal_selesai) {
            tglSelesai = typeof row.tanggal_selesai === 'string' ? row.tanggal_selesai.substring(0, 10) : '';
        } else {
            tglSelesai = new Date().toISOString().substring(0, 10);
        }
        document.getElementById('inputTanggalSelesai').value = tglSelesai;
        document.getElementById('formTindakanService').action = '/service/tindakan/' + row.id;
        
        document.getElementById('partListContainer').innerHTML = '';
        partRowIndex = 0;
        toggleSelesaiSection(row.status);

        openModal('modalTindakanService');
    }

    function openDetailModalById(id) {
        const row = SERVICES_DATA[id];
        if (!row) return;

        const parts = row.part_keluars || [];
        const isFinished = (row.status === 'Selesai Service');

        let statusClass = 'belum-cek';
        if (row.status === 'Sudah Cek') statusClass = 'sudah-cek';
        else if (row.status === 'Service Suplier') statusClass = 'service-suplier';
        else if (row.status === 'Selesai Service') statusClass = 'selesai-service';

        let tglMasukStr = '-';
        if (row.tanggal_masuk) {
            tglMasukStr = typeof row.tanggal_masuk === 'string' ? row.tanggal_masuk.substring(0, 10) : row.tanggal_masuk;
        }

        let tglSelesaiStr = '-';
        if (row.tanggal_selesai) {
            tglSelesaiStr = typeof row.tanggal_selesai === 'string' ? row.tanggal_selesai.substring(0, 10) : row.tanggal_selesai;
        }

        let partsHtml = '';
        if (parts && parts.length > 0) {
            partsHtml = `
                <div style="margin-top:16px; background:#f0fdf4; border:1.5px solid #86efac; border-radius:14px; padding:16px;">
                    <div style="font-size:0.86rem; font-weight:800; color:#166534; margin-bottom:10px; display:flex; align-items:center; gap:8px;">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span>Daftar Part Keluar yang Digunakan (${parts.length} Item):</span>
                    </div>
                    <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
                        <thead>
                            <tr style="text-align:left; color:#15803d; border-bottom:1.5px solid #bbf7d0;">
                                <th style="padding:6px 0;">Kode PLU</th>
                                <th style="padding:6px 0;">Nama Sparepart</th>
                                <th style="padding:6px 0; text-align:right;">Jumlah Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${parts.map(p => `
                                <tr style="border-bottom:1px dashed #bbf7d0;">
                                    <td style="padding:8px 0;" class="font-mono"><strong>${p.kode_plu || '-'}</strong></td>
                                    <td style="padding:8px 0; font-weight:700; color:#0f172a;">${p.nama_barang}</td>
                                    <td style="padding:8px 0; text-align:right;" class="font-mono"><span style="background:#166534; color:#fff; padding:2px 8px; border-radius:6px; font-weight:700;">${p.qty} Unit</span></td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            partsHtml = `
                <div style="margin-top:16px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:12px 16px; font-size:0.82rem; color:#64748b; display:flex; align-items:center; gap:8px;">
                    <svg style="width:16px;height:16px;color:#94a3b8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Tidak ada part keluar yang tercatat untuk service ini (hanya perbaikan software/mekanik).</span>
                </div>
            `;
        }

        const tokoNama = row.toko ? row.toko.nama_toko : '-';

        const html = `
            <div style="display:flex; flex-direction:column; gap:14px;">
                {{-- Header Card --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start; background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:16px;">
                    <div>
                        <div style="font-size:1.2rem; font-weight:800; color:#0f172a;">${row.nama_barang}</div>
                        <div style="font-size:0.82rem; color:#64748b; margin-top:4px; display:flex; gap:12px; flex-wrap:wrap;">
                            <span>No DAT: <strong class="font-mono" style="color:#0f172a;">${row.no_dat || '-'}</strong></span>
                            <span>SN: <strong class="font-mono" style="color:#0f172a;">${row.sn || '-'}</strong></span>
                            <span>Toko: <strong class="badge-kdtk">${row.kode_toko}</strong> (${tokoNama})</span>
                        </div>
                    </div>
                    <div style="text-align:right; display:flex; flex-direction:column; align-items:flex-end; gap:6px;">
                        <span class="badge-status ${statusClass}">
                            <span class="badge-dot"></span>
                            <span>${row.status}</span>
                        </span>
                        <span class="badge-duration ${isFinished ? 'finished' : 'ongoing'}">
                            ${row.durasi_text || '-'}
                        </span>
                    </div>
                </div>

                {{-- Timeline Box --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 14px;">
                        <div style="font-size:0.72rem; color:#64748b; font-weight:700; text-transform:uppercase;">Tanggal Masuk:</div>
                        <div style="font-size:0.95rem; font-weight:800; color:#0f172a; margin-top:2px;">${tglMasukStr}</div>
                    </div>
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 14px;">
                        <div style="font-size:0.72rem; color:#64748b; font-weight:700; text-transform:uppercase;">Tanggal Selesai:</div>
                        <div style="font-size:0.95rem; font-weight:800; color:#0f172a; margin-top:2px;">${tglSelesaiStr}</div>
                    </div>
                </div>

                {{-- Kerusakan & Tindakan --}}
                <div style="background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; padding:14px;">
                    <div style="color:#9a3412; font-weight:800; font-size:0.75rem; text-transform:uppercase; display:flex; align-items:center; gap:6px;">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Keluhan Kerusakan:</span>
                    </div>
                    <div style="color:#7c2d12; margin-top:4px; font-size:0.86rem; font-weight:500;">${row.kerusakan || '-'}</div>
                </div>

                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:14px;">
                    <div style="color:#1e40af; font-weight:800; font-size:0.75rem; text-transform:uppercase; display:flex; align-items:center; gap:6px;">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Tindakan / Diagnosa Teknisi:</span>
                    </div>
                    <div style="color:#1e3a8a; margin-top:4px; font-size:0.86rem; font-weight:500;">${row.tindakan || '-'}</div>
                </div>

                {{-- Parts Used --}}
                ${partsHtml}

                {{-- Catatan --}}
                ${row.keterangan ? `
                    <div style="font-size:0.82rem; color:#64748b; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px;">
                        <strong style="color:#334155;">Catatan:</strong> ${row.keterangan}
                    </div>
                ` : ''}
            </div>
        `;

        document.getElementById('detailModalBody').innerHTML = html;
        openModal('modalDetailService');
    }

    function openEditModalById(id) {
        const row = SERVICES_DATA[id];
        if (!row) return;

        document.getElementById('editNoDat').value = row.no_dat || '';
        document.getElementById('editSn').value = row.sn || '';
        document.getElementById('editNamaBarang').value = row.nama_barang || '';
        document.getElementById('editKodeToko').value = row.kode_toko || '';
        document.getElementById('editTanggalMasuk').value = row.tanggal_masuk ? (typeof row.tanggal_masuk === 'string' ? row.tanggal_masuk.substring(0, 10) : '') : '';
        document.getElementById('editTanggalSelesai').value = row.tanggal_selesai ? (typeof row.tanggal_selesai === 'string' ? row.tanggal_selesai.substring(0, 10) : '') : '';
        document.getElementById('editKerusakan').value = row.kerusakan || '';
        document.getElementById('editTindakan').value = row.tindakan || '';
        document.getElementById('editKeterangan').value = row.keterangan || '';
        document.getElementById('formEditService').action = '/service/update/' + row.id;

        // Update preview toko untuk modal edit
        const curToko = TOKO_LIST.find(t => (t.kode_toko || '').toUpperCase() === (row.kode_toko || '').toUpperCase());
        if (curToko) {
            updateTokoPreview('previewEditToko', curToko.nama_toko);
        } else if (row.toko) {
            updateTokoPreview('previewEditToko', row.toko.nama_toko);
        } else {
            updateTokoPreview('previewEditToko', null);
        }

        openModal('modalEditService');
    }

    function openDeleteModalById(id) {
        const row = SERVICES_DATA[id];
        if (!row) return;

        document.getElementById('deleteNamaBarang').innerText = row.nama_barang;
        document.getElementById('deleteKodeToko').innerText = row.kode_toko;
        document.getElementById('formDeleteService').action = '/service/delete/' + row.id;
        openModal('modalDeleteService');
    }

    // Close on backdrop click & initialize autocompletes
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });

        // Inisialisasi Autocomplete Toko (KDTK & Nama)
        setupTokoAutocomplete('inputTambahKodeToko', 'dropdownTambahKodeToko', 'previewTambahToko');
        setupTokoAutocomplete('editKodeToko', 'dropdownEditKodeToko', 'previewEditToko');

        // Inisialisasi Autocomplete Nama Barang
        setupBarangAutocomplete('inputTambahNamaBarang', 'dropdownTambahNamaBarang');
        setupBarangAutocomplete('editNamaBarang', 'dropdownEditNamaBarang');
    });
</script>

@endsection
