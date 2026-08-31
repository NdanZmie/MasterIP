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

    .log-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace !important; }

    .log-wrap {
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
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display:flex; align-items:center; justify-content:center;
        box-shadow: 0 6px 20px rgba(79,70,229,0.3);
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
        color: #4f46e5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .nav-switch-btn:hover:not(.active) {
        color: var(--text-head);
    }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }
    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
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
    .stat-icon.red { background: rgba(239,68,68,0.12); color: #dc2626; }
    .stat-icon.indigo { background: rgba(79,70,229,0.12); color: #4f46e5; }
    .stat-icon.blue { background: rgba(37,99,235,0.12); color: #2563eb; }

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
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
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
        background: #4f46e5; color: #fff; border: none;
        padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: background 0.2s;
    }
    .search-box button:hover { background: #4338ca; }

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
        padding: 5px 12px;
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
        color: #4f46e5;
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
        background: rgba(79,70,229,0.08);
        color: #4f46e5;
        border: 1px solid rgba(79,70,229,0.2);
        padding: 7px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-export:hover {
        background: #4f46e5; color: #fff;
    }
    .btn-export svg { width: 14px; height: 14px; }

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
    .badge-in {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 800;
        background: rgba(16,185,129,0.12);
        color: #047857;
        border: 1px solid rgba(16,185,129,0.25);
        white-space: nowrap;
    }
    .badge-out {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 800;
        background: rgba(239,68,68,0.12);
        color: #b91c1c;
        border: 1px solid rgba(239,68,68,0.25);
        white-space: nowrap;
    }
    .badge-edit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 800;
        background: rgba(37,99,235,0.12);
        color: #1d4ed8;
        border: 1px solid rgba(37,99,235,0.25);
        white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-in .badge-dot { background: #10b981; }
    .badge-out .badge-dot { background: #ef4444; }
    .badge-edit .badge-dot { background: #2563eb; }

    .badge-kategori {
        display: inline-block;
        font-size: 0.70rem;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 2px 6px;
        border-radius: 4px;
        margin-top: 3px;
    }

    .badge-plu {
        background: rgba(15,23,42,0.06);
        color: #0f172a;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 5px;
        border: 1px solid rgba(15,23,42,0.12);
        display: inline-block;
    }
    .badge-divisi {
        background: rgba(99,102,241,0.08);
        color: #4f46e5;
        font-size: 0.70rem;
        font-weight: 700;
        padding: 1px 6px;
        border-radius: 4px;
        border: 1px solid rgba(99,102,241,0.2);
        display: inline-block;
    }
    .qty-in {
        color: #047857;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
    }
    .qty-out {
        color: #b91c1c;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
    }
    .qty-edit-up {
        color: #047857;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
    }
    .qty-edit-down {
        color: #b91c1c;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
    }
    .qty-edit-same {
        color: #64748b;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.82rem;
    }
</style>

<div class="log-wrap">

    {{-- Header with Nav Switcher --}}
    <div class="page-header">
        <div class="page-title-block">
            <div class="title-left">
                <div class="page-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">LOG Transit Barang (Keluar / Masuk / Edit)</h1>
                    <p class="page-subtitle">Audit trail mutasi sparepart, riwayat restock masuk, alokasi part keluar, dan riwayat edit part</p>
                </div>
            </div>

            {{-- Tab Switcher --}}
            <div class="nav-switcher">
                <a href="{{ route('part.index') }}" class="nav-switch-btn">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Stok Part Aktif</span>
                </a>
                <a href="{{ route('part.log') }}" class="nav-switch-btn active">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Log Transit (Audit Trail)</span>
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
                <span class="stat-val">{{ number_format($totalLogs) }}</span>
                <span class="stat-lbl">Total Catatan Log</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">+{{ number_format($totalInQty) }}</span>
                <span class="stat-lbl">Item Masuk (IN)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">-{{ number_format($totalOutQty) }}</span>
                <span class="stat-lbl">Item Keluar (OUT)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon indigo">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($totalEditLogs ?? 0) }}</span>
                <span class="stat-lbl">Log Edit / Koreksi</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-val">{{ number_format($todayLogs) }}</span>
                <span class="stat-lbl">Transaksi Hari Ini</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar-wrap">
        <div class="toolbar-left">
            {{-- Search Box --}}
            <form action="{{ route('part.log') }}" method="GET" class="search-box">
                <input type="hidden" name="tipe" value="{{ $tipe }}">
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari PLU, Barang, Toko, PIC...">
                <button type="submit">Cari</button>
            </form>

            {{-- Filter Tabs Tipe --}}
            <div class="filter-tabs">
                <a href="{{ route('part.log', ['tipe' => 'all', 'search' => $search, 'kategori' => $kategori]) }}" class="filter-tab {{ $tipe === 'all' ? 'active' : '' }}">
                    Semua Log ({{ $totalLogs }})
                </a>
                <a href="{{ route('part.log', ['tipe' => 'IN', 'search' => $search, 'kategori' => $kategori]) }}" class="filter-tab {{ $tipe === 'IN' ? 'active' : '' }}" style="{{ $tipe === 'IN' ? 'color:#047857;' : '' }}">
                    📥 Masuk (IN)
                </a>
                <a href="{{ route('part.log', ['tipe' => 'OUT', 'search' => $search, 'kategori' => $kategori]) }}" class="filter-tab {{ $tipe === 'OUT' ? 'active' : '' }}" style="{{ $tipe === 'OUT' ? 'color:#b91c1c;' : '' }}">
                    📤 Keluar (OUT)
                </a>
                <a href="{{ route('part.log', ['tipe' => 'EDIT', 'search' => $search, 'kategori' => $kategori]) }}" class="filter-tab {{ $tipe === 'EDIT' ? 'active' : '' }}" style="{{ $tipe === 'EDIT' ? 'color:#1d4ed8;' : '' }}">
                    ✏️ Edit / Koreksi ({{ $totalEditLogs ?? 0 }})
                </a>
            </div>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('part.log.export', ['tipe' => $tipe, 'search' => $search, 'kategori' => $kategori]) }}" class="btn-export">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 32px; text-align: center;">No</th>
                    <th style="width: 100px;">Tanggal</th>
                    <th style="width: 140px;">Tipe & Mutasi</th>
                    <th style="width: 95px;">Kode PLU</th>
                    <th>Nama Barang / Part</th>
                    <th style="width: 80px; text-align: right;">Jumlah</th>
                    <th style="width: 110px; text-align: center;">Perubahan Stok</th>
                    <th>Tujuan / Sumber Alur</th>
                    <th style="width: 110px;">PIC</th>
                    <th>Keterangan / Detail Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                    <tr>
                        <td style="color: var(--text-muted); font-weight: 600; text-align: center; font-size: 0.76rem;">
                            {{ $logs->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="font-mono" style="font-weight: 700; color: #0f172a; font-size: 0.78rem;">
                                {{ $log->tanggal_transaksi ? $log->tanggal_transaksi->format('d/m/Y') : '-' }}
                            </div>
                            <div style="font-size: 0.70rem; color: var(--text-muted);">
                                {{ $log->created_at ? $log->created_at->format('H:i') : '' }} WIB
                            </div>
                        </td>
                        <td>
                            <div>
                                @if($log->tipe === 'IN')
                                    <span class="badge-in">
                                        <span class="badge-dot"></span>
                                        <span>MASUK (IN)</span>
                                    </span>
                                @elseif($log->tipe === 'OUT')
                                    <span class="badge-out">
                                        <span class="badge-dot"></span>
                                        <span>KELUAR (OUT)</span>
                                    </span>
                                @else
                                    <span class="badge-edit">
                                        <span class="badge-dot"></span>
                                        <span>EDIT / KOREKSI</span>
                                    </span>
                                @endif
                            </div>
                            <div class="badge-kategori">{{ $log->kategori }}</div>
                        </td>
                        <td>
                            <span class="badge-plu">{{ $log->kode_plu ?: '-' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.84rem;">{{ $log->nama_barang }}</div>
                            @if($log->divisi)
                                <div style="margin-top: 2px;">
                                    <span class="badge-divisi">{{ $log->divisi }}</span>
                                </div>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if($log->tipe === 'IN')
                                <span class="qty-in">+{{ number_format($log->qty) }}</span>
                            @elseif($log->tipe === 'OUT')
                                <span class="qty-out">-{{ number_format($log->qty) }}</span>
                            @else
                                @php
                                    $stokDiff = $log->stok_akhir - $log->stok_awal;
                                @endphp
                                @if($stokDiff > 0)
                                    <span class="qty-edit-up">+{{ number_format($stokDiff) }}</span>
                                @elseif($stokDiff < 0)
                                    <span class="qty-edit-down">{{ number_format($stokDiff) }}</span>
                                @else
                                    <span class="qty-edit-same">~ 0</span>
                                @endif
                            @endif
                            <span style="font-size: 0.70rem; color: #64748b; font-weight: 600;">{{ $log->satuan ?: 'PCS' }}</span>
                        </td>
                        <td style="text-align: center; font-size: 0.75rem;">
                            @php
                                $stokDiff = $log->stok_akhir - $log->stok_awal;
                                $stokColor = $stokDiff > 0 ? '#047857' : ($stokDiff < 0 ? '#b91c1c' : '#475569');
                            @endphp
                            <div class="font-mono">
                                <span style="color: #64748b;">{{ $log->stok_awal }}</span>
                                <span style="color: #94a3b8; margin: 0 3px;">&rarr;</span>
                                <strong style="color: {{ $stokColor }};">{{ $log->stok_akhir }}</strong>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.78rem; font-weight: 600; color: #1e293b;">
                                {{ $log->tujuan_sumber ?: '-' }}
                            </div>
                        </td>
                        <td style="font-size: 0.76rem; color: #475569; font-weight: 600;">
                            {{ $log->pic ?: 'Teknisi' }}
                        </td>
                        <td>
                            @php
                                $ketParts = explode(' • ', $log->keterangan ?? '');
                            @endphp
                            @if(count($ketParts) > 1)
                                <div style="font-size: 0.73rem; color: #334155; line-height: 1.45;">
                                    @foreach($ketParts as $kPart)
                                        <div style="display:flex; align-items:flex-start; gap:4px; margin-bottom:2px;">
                                            <span style="color:#2563eb; font-weight:800; font-size:0.65rem; margin-top:2px;">•</span>
                                            <span>{{ $kPart }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.75rem;">{{ $log->keterangan ?: '-' }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <svg style="width:40px;height:40px;margin:0 auto 10px;opacity:0.4;display:block;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <p style="font-weight: 600;">Belum ada catatan log transit keluar / masuk / edit barang</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
            <div style="padding: 14px 18px; border-top: 1px solid var(--border);">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
