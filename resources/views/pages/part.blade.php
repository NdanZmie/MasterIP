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

    .toolbar-row-bottom {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-top: 1px solid rgba(226, 232, 240, 0.6);
        padding-top: 10px;
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
    .modern-table th.sortable {
        cursor: pointer;
        user-select: none;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .modern-table th.sortable:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .modern-table th.sortable.sorted-asc,
    .modern-table th.sortable.sorted-desc {
        background: #ecfdf5;
        color: #059669;
        border-bottom-color: #10b981;
    }
    .th-sort-wrap {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .sort-icon {
        display: inline-flex;
        align-items: center;
        font-size: 0.72rem;
        color: #94a3b8;
        transition: color 0.15s, transform 0.15s;
    }
    .sortable.sorted-asc .sort-icon,
    .sortable.sorted-desc .sort-icon {
        color: #059669;
        font-weight: 800;
    }

    /* ── TAB-TAB PAGINATION CONTAINER (10 Data Per Tab) ── */
    .table-pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 18px;
        background: #ffffff;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }
    .pagination-info {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pagination-info strong {
        color: #0f172a;
        font-weight: 700;
    }
    .per-page-select-wrap {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.76rem;
        color: #64748b;
        font-weight: 600;
    }
    .per-page-select {
        padding: 5px 9px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 700;
        color: #0f172a;
        background: #f8fafc;
        cursor: pointer;
        outline: none;
        transition: border-color 0.2s;
    }
    .per-page-select:focus {
        border-color: #059669;
    }
    .tab-pagination-tabs {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }
    .page-tab-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 32px;
        padding: 0 11px;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 700;
        cursor: pointer;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: all 0.15s ease;
        user-select: none;
    }
    .page-tab-btn:hover:not(:disabled):not(.active) {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }
    .page-tab-btn.active {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #ffffff;
        border-color: #059669;
        box-shadow: 0 3px 10px rgba(5, 150, 105, 0.28);
    }
    .page-tab-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f8fafc;
    }
    .page-tab-ellipsis {
        padding: 0 4px;
        color: #94a3b8;
        font-weight: bold;
        font-size: 0.8rem;
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
                        Monitoring master data stok part, kontrol buffer, analisis mutasi, dan perencanaan pengadaan (PP)
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
            <div class="toolbar-filters-group">
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
        <div class="toolbar-row-bottom">
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
                    Ada Usulan PP ({{ $ppItemCount ?? $items->total() }})
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
                    <th class="sortable" data-sort="no" style="width: 48px; text-align: center;" title="Klik untuk mengurutkan nomor">
                        <span class="th-sort-wrap" style="justify-content: center;">No <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="plu" style="width: 85px;" title="Klik untuk mengurutkan PLU">
                        <span class="th-sort-wrap">PLU <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="nama" title="Klik untuk mengurutkan Nama Part">
                        <span class="th-sort-wrap">Nama Sparepart / Barang <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="divisi" style="width: 100px;" title="Klik untuk mengurutkan Divisi">
                        <span class="th-sort-wrap">Divisi <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="moving" style="width: 105px;" title="Klik untuk mengurutkan Moving status">
                        <span class="th-sort-wrap">Moving <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="stock" style="width: 105px; text-align: right;" title="Klik untuk mengurutkan Stok Fisik">
                        <span class="th-sort-wrap" style="justify-content: flex-end;">Stok Fisik <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="pkm" style="width: 90px; text-align: center;" title="Klik untuk mengurutkan PKM">
                        <span class="th-sort-wrap" style="justify-content: center;">PKM / DSI <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="pp" style="width: 130px;" title="Klik untuk mengurutkan Usulan PP">
                        <span class="th-sort-wrap">Usulan PP <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="harga" style="width: 110px; text-align: right;" title="Klik untuk mengurutkan Harga Satuan">
                        <span class="th-sort-wrap" style="justify-content: flex-end;">Harga Satuan <span class="sort-icon">↕</span></span>
                    </th>
                    <th class="sortable" data-sort="ket" title="Klik untuk mengurutkan Keterangan">
                        <span class="th-sort-wrap">Keterangan / Status <span class="sort-icon">↕</span></span>
                    </th>
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
                        data-no="{{ $item->no_urut ?: ($index + 1) }}"
                        data-plu="{{ strtolower($item->kode_plu ?? '') }}"
                        data-nama="{{ strtolower($item->nama_barang ?? '') }}"
                        data-divisi="{{ strtolower($item->divisi ?? '') }}"
                        data-moving="{{ strtolower($item->moving ?? '') }}"
                        data-stock="{{ (float) $item->qty_stock }}"
                        data-pkm="{{ (float) ($item->pkm ?? 0) }}"
                        data-dsi="{{ (float) ($item->dsi ?? 0) }}"
                        data-pp="{{ (float) ($item->qty_pp ?? 0) }}"
                        data-harga="{{ (float) ($item->harga_satuan ?? 0) }}"
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

        {{-- Interactive Tab-Tab Pagination Bar (10 data per tab) --}}
        <div class="table-pagination-bar" id="partTablePaginationBar">
            <div class="pagination-info" id="paginationInfoText">
                Menampilkan <strong>1 - 10</strong> dari <strong>{{ $items->total() }}</strong> part
            </div>
            <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
                <div class="per-page-select-wrap">
                    <span>Tampilkan:</span>
                    <select id="rowsPerPageSelect" class="per-page-select">
                        <option value="10" selected>10 per tab</option>
                        <option value="25">25 per tab</option>
                        <option value="50">50 per tab</option>
                        <option value="100">100 per tab</option>
                        <option value="-1">Semua</option>
                    </select>
                </div>
                <div class="tab-pagination-tabs" id="tabPaginationContainer">
                    {{-- Dynamically populated tab buttons --}}
                </div>
            </div>
        </div>
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

        // ── TABLE ENGINE: SORTING, TAB-TAB PAGINATION (10 PER TAB), & LIVE SEARCH ──
        const searchInput    = document.getElementById('liveSearchInputPart');
        const clearBtn       = document.getElementById('btnClearSearchPart');
        const resultCountEl  = document.getElementById('searchResultCountPart');
        const allRows        = Array.from(document.querySelectorAll('.part-row'));
        const noResults      = document.getElementById('noResultsRowPart');
        const queryText      = document.getElementById('searchQueryTextPart');
        const perPageSelect  = document.getElementById('rowsPerPageSelect');
        const tableContainer = document.querySelector('.table-container');

        let currentPage    = 1;
        let rowsPerPage    = 10; // Default 10 rows per tab/table
        let currentSortKey = 'no';
        let currentSortDir = 'asc';
        let visibleRows    = [...allRows];

        // Sort function
        function sortRows(key, dir) {
            visibleRows.sort((a, b) => {
                let valA = a.getAttribute('data-' + key) || '';
                let valB = b.getAttribute('data-' + key) || '';

                const numKeys = ['no', 'stock', 'pkm', 'dsi', 'pp', 'harga'];
                if (numKeys.includes(key)) {
                    valA = parseFloat(valA) || 0;
                    valB = parseFloat(valB) || 0;
                    return dir === 'asc' ? valA - valB : valB - valA;
                }

                return dir === 'asc'
                    ? valA.localeCompare(valB, undefined, { numeric: true, sensitivity: 'base' })
                    : valB.localeCompare(valA, undefined, { numeric: true, sensitivity: 'base' });
            });

            // Re-order rows in DOM tbody
            const tbody = document.querySelector('.modern-table tbody');
            if (tbody) {
                visibleRows.forEach(row => tbody.appendChild(row));
                if (noResults) tbody.appendChild(noResults);
            }
        }

        // Render current 10 rows and tab pagination
        function renderTable(shouldScroll = false) {
            const total = visibleRows.length;
            const totalPages = rowsPerPage === -1 ? 1 : (Math.ceil(total / rowsPerPage) || 1);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIdx = (currentPage - 1) * (rowsPerPage === -1 ? total : rowsPerPage);
            const endIdx   = rowsPerPage === -1 ? total : startIdx + rowsPerPage;

            allRows.forEach(row => { row.style.display = 'none'; });

            visibleRows.forEach((row, idx) => {
                if (idx >= startIdx && idx < endIdx) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update Info Text
            const infoEl = document.getElementById('paginationInfoText');
            if (infoEl) {
                if (total === 0) {
                    infoEl.innerHTML = 'Tidak ada part yang ditampilkan';
                } else {
                    const dispStart = startIdx + 1;
                    const dispEnd   = Math.min(endIdx, total);
                    infoEl.innerHTML = `Menampilkan <strong>${dispStart} - ${dispEnd}</strong> dari <strong>${total}</strong> part`;
                }
            }

            renderTabs(totalPages);

            if (shouldScroll && tableContainer) {
                const rect = tableContainer.getBoundingClientRect();
                if (rect.top < 0) {
                    tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }

        function renderTabs(totalPages) {
            const container = document.getElementById('tabPaginationContainer');
            if (!container) return;
            container.innerHTML = '';

            if (totalPages <= 1) {
                const tabBtn = document.createElement('button');
                tabBtn.type = 'button';
                tabBtn.className = 'page-tab-btn active';
                tabBtn.textContent = 'Tab 1';
                container.appendChild(tabBtn);
                return;
            }

            // Prev Button
            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = 'page-tab-btn';
            prevBtn.innerHTML = '‹ Prev';
            prevBtn.title = 'Halaman Sebelumnya';
            prevBtn.disabled = (currentPage === 1);
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable(true);
                }
            };
            container.appendChild(prevBtn);

            function addTab(p) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'page-tab-btn' + (p === currentPage ? ' active' : '');
                btn.textContent = 'Tab ' + p;
                btn.onclick = () => {
                    currentPage = p;
                    renderTable(true);
                };
                container.appendChild(btn);
            }

            function addEllipsis() {
                const span = document.createElement('span');
                span.className = 'page-tab-ellipsis';
                span.textContent = '...';
                container.appendChild(span);
            }

            if (totalPages <= 8) {
                for (let i = 1; i <= totalPages; i++) {
                    addTab(i);
                }
            } else {
                addTab(1);
                if (currentPage > 3) addEllipsis();

                const start = Math.max(2, currentPage - 1);
                const end   = Math.min(totalPages - 1, currentPage + 1);

                for (let i = start; i <= end; i++) {
                    addTab(i);
                }

                if (currentPage < totalPages - 2) addEllipsis();
                addTab(totalPages);
            }

            // Next Button
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'page-tab-btn';
            nextBtn.innerHTML = 'Next ›';
            nextBtn.title = 'Halaman Selanjutnya';
            nextBtn.disabled = (currentPage === totalPages);
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable(true);
                }
            };
            container.appendChild(nextBtn);
        }

        // Column Sort Click Handler
        document.querySelectorAll('th.sortable').forEach(th => {
            th.addEventListener('click', function() {
                const key = this.getAttribute('data-sort');
                if (currentSortKey === key) {
                    currentSortDir = (currentSortDir === 'asc' ? 'desc' : 'asc');
                } else {
                    currentSortKey = key;
                    currentSortDir = (['stock', 'harga', 'pp', 'pkm'].includes(key) ? 'desc' : 'asc');
                }

                document.querySelectorAll('th.sortable').forEach(otherTh => {
                    otherTh.classList.remove('sorted-asc', 'sorted-desc');
                    const icon = otherTh.querySelector('.sort-icon');
                    if (icon) icon.textContent = '↕';
                });

                this.classList.add(currentSortDir === 'asc' ? 'sorted-asc' : 'sorted-desc');
                const activeIcon = this.querySelector('.sort-icon');
                if (activeIcon) {
                    activeIcon.textContent = (currentSortDir === 'asc' ? '▲' : '▼');
                }

                currentPage = 1;
                sortRows(currentSortKey, currentSortDir);
                renderTable();
            });
        });

        // Rows per page selector
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                rowsPerPage = parseInt(this.value, 10);
                currentPage = 1;
                renderTable();
            });
        }

        // Live Search Handler
        function doLiveSearch() {
            if (!searchInput) return;
            const q = (searchInput.value || '').trim().toLowerCase();

            if (clearBtn) {
                clearBtn.style.display = q ? 'inline-flex' : 'none';
            }

            const words = q.split(/\s+/).filter(w => w.length > 0);

            visibleRows = allRows.filter(row => {
                if (words.length === 0) return true;
                const plu    = row.getAttribute('data-plu') || '';
                const nama   = row.getAttribute('data-nama') || '';
                const divisi = row.getAttribute('data-divisi') || '';
                const moving = row.getAttribute('data-moving') || '';
                const ket    = row.getAttribute('data-ket') || '';
                const text   = (row.innerText || '').toLowerCase();
                const combined = `${plu} ${nama} ${divisi} ${moving} ${ket} ${text}`;
                return words.every(w => combined.includes(w));
            });

            if (resultCountEl) {
                if (words.length > 0) {
                    resultCountEl.textContent = `${visibleRows.length} item`;
                    resultCountEl.style.display = 'inline-block';
                } else {
                    resultCountEl.style.display = 'none';
                }
            }

            if (noResults) {
                if (visibleRows.length === 0 && words.length > 0) {
                    noResults.style.display = '';
                    if (queryText) queryText.innerText = searchInput.value;
                } else {
                    noResults.style.display = 'none';
                }
            }

            currentPage = 1;
            sortRows(currentSortKey, currentSortDir);
            renderTable();
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

        // Initial setup: Default sorted by No (asc) & 10 rows per tab
        sortRows(currentSortKey, currentSortDir);
        renderTable();
    });
</script>

@endsection
