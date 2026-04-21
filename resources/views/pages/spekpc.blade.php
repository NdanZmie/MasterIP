{{-- spekpc.blade.php --}}
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-glow: rgba(37,99,235,0.12);
        --surface: rgba(255,255,255,0.72);
        --surface-hover: rgba(255,255,255,0.92);
        --border: rgba(37,99,235,0.10);
        --border-strong: rgba(37,99,235,0.22);
        --text-head: #0f172a;
        --text-body: #334155;
        --text-muted: #94a3b8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --radius: 14px;
    }

    .spekpc-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── PAGE WRAPPER ── */
    .spekpc-wrap {
        min-height: 100vh;
        padding-bottom: 40px;
    }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 24px;
        animation: slideDown 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .page-title-block { display:flex; align-items:center; gap:14px; }
    .page-icon {
        width:48px; height:48px; border-radius:14px;
        background: linear-gradient(135deg,#2563eb,#60a5fa);
        display:flex; align-items:center; justify-content:center;
        box-shadow: 0 6px 20px rgba(37,99,235,0.28);
        flex-shrink:0;
    }
    .page-icon svg { width:22px; height:22px; stroke:#fff; }
    .page-title { font-size:1.5rem; font-weight:800; color:var(--text-head); letter-spacing:-0.03em; }
    .page-subtitle { font-size:0.8rem; color:var(--text-muted); font-weight:500; margin-top:1px; }

    /* ── TOOLBAR ── */
    .toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    /* Search */
    .search-form {
        display:flex; align-items:center;
        background: var(--surface);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-strong);
        border-radius: 50px;
        overflow:hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        flex:1; min-width:220px; max-width:320px;
        transition: box-shadow 0.2s, border-color 0.2s;
    }
    .search-form:focus-within {
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12), 0 2px 10px rgba(0,0,0,0.06);
        border-color: rgba(37,99,235,0.4);
    }
    .search-form .search-icon {
        padding: 0 0 0 14px;
        display:flex; align-items:center;
        color: var(--text-muted);
    }
    .search-form .search-icon svg { width:15px; height:15px; stroke:currentColor; }
    .search-form input {
        border:none; outline:none; background:transparent;
        padding:10px 10px 10px 8px;
        font-size:0.82rem; font-weight:500; color:var(--text-body);
        width:100%;
    }
    .search-form input::placeholder { color:var(--text-muted); }
    .search-form button {
        background: var(--primary);
        color:#fff; border:none;
        padding:9px 18px;
        font-size:0.78rem; font-weight:600;
        cursor:pointer; white-space:nowrap;
        transition: background 0.2s;
        border-radius:0 50px 50px 0;
    }
    .search-form button:hover { background:#1d4ed8; }

    /* Buttons */
    .btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 18px; border-radius:50px;
        font-size:0.8rem; font-weight:600; white-space:nowrap;
        cursor:pointer; border:none; text-decoration:none;
        transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    }
    .btn:hover { transform:translateY(-1px); filter:brightness(1.06); box-shadow:0 6px 18px rgba(0,0,0,0.13); }
    .btn:active { transform:translateY(0); }
    .btn svg { width:14px; height:14px; stroke:currentColor; flex-shrink:0; }

    .btn-green  { background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
    .btn-blue   { background:linear-gradient(135deg,#2563eb,#60a5fa); color:#fff; }
    .btn-slate  { background:linear-gradient(135deg,#475569,#64748b); color:#fff; }

    /* ── SUCCESS TOAST ── */
    .toast-success {
        display:flex; align-items:center; gap:10px;
        background:rgba(16,185,129,0.10);
        border:1px solid rgba(16,185,129,0.25);
        border-radius:12px; padding:12px 18px;
        margin-bottom:16px; color:#065f46;
        font-size:0.85rem; font-weight:500;
        animation: toastIn 0.4s cubic-bezier(0.16,1,0.3,1) both;
    }
    @keyframes toastIn {
        from { opacity:0; transform:translateY(-8px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .toast-success svg { width:17px; height:17px; stroke:#10b981; flex-shrink:0; }

    /* ── CARD ── */
    .table-card {
        background: var(--surface);
        backdrop-filter: blur(16px) saturate(160%);
        -webkit-backdrop-filter: blur(16px) saturate(160%);
        border: 1px solid var(--border-strong);
        border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(15,23,42,0.08), 0 1px 0 rgba(255,255,255,0.8) inset;
        overflow: hidden;
        animation: fadeIn 0.5s 0.1s cubic-bezier(0.16,1,0.3,1) both;
    }
    @keyframes fadeIn {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }

    /* ── TABLE ── */
    .data-table { width:100%; border-collapse:collapse; font-size:0.82rem; }

    .data-table thead tr {
        background: rgba(37,99,235,0.04);
        border-bottom: 1.5px solid rgba(37,99,235,0.10);
    }
    .data-table thead th {
        padding: 13px 14px;
        font-size:0.68rem; font-weight:700; letter-spacing:0.08em;
        text-transform:uppercase; color:var(--text-muted);
        white-space:nowrap;
    }
    .data-table thead th a {
        color:inherit; text-decoration:none;
        display:inline-flex; align-items:center; gap:3px;
        transition:color 0.15s;
    }
    .data-table thead th a:hover { color:var(--primary); }

    .data-table tbody tr {
        border-bottom: 1px solid rgba(37,99,235,0.06);
        transition: background 0.15s;
    }
    .data-table tbody tr:last-child { border-bottom:none; }
    .data-table tbody tr:hover { background:rgba(37,99,235,0.04); }
    .data-table tbody tr:hover .row-num { color:var(--primary); }

    .data-table td { padding:12px 14px; vertical-align:middle; color:var(--text-body); }

    /* Row number */
    .row-num {
        font-family:'JetBrains Mono',monospace;
        font-size:0.7rem; font-weight:500;
        color:var(--text-muted);
        transition:color 0.15s;
    }

    /* IP cell */
    .ip-cell {
        font-family:'JetBrains Mono',monospace;
        font-size:0.78rem; font-weight:500;
        background:rgba(37,99,235,0.07);
        color:#1d4ed8;
        padding:3px 8px; border-radius:6px;
        display:inline-block;
        border:1px solid rgba(37,99,235,0.12);
    }

    /* Nama */
    .nama-cell { font-weight:700; color:var(--text-head); font-size:0.85rem; }

    /* Dept badge */
    .dept-badge {
        background:rgba(99,102,241,0.08);
        color:#4f46e5;
        border:1px solid rgba(99,102,241,0.18);
        border-radius:6px;
        padding:2px 9px;
        font-size:0.7rem; font-weight:700;
        letter-spacing:0.04em;
    }

    /* Detail toggle */
    .detail-toggle {
        display:inline-flex; align-items:center; gap:5px;
        background:rgba(37,99,235,0.07);
        color:var(--primary);
        border:1px solid rgba(37,99,235,0.14);
        border-radius:8px; padding:4px 10px;
        font-size:0.74rem; font-weight:600;
        cursor:pointer; white-space:nowrap;
        transition:background 0.2s, color 0.2s;
    }
    .detail-toggle:hover { background:rgba(37,99,235,0.13); }
    .detail-toggle svg { width:12px; height:12px; stroke:currentColor; flex-shrink:0; transition:transform 0.25s; }
    .detail-toggle.open svg { transform:rotate(180deg); }

    /* Detail panel */
    .detail-panel {
        max-height:0; overflow:hidden;
        transition: max-height 0.35s cubic-bezier(0.16,1,0.3,1);
    }
    .detail-grid {
        display:grid; grid-template-columns:repeat(2,1fr); gap:6px 14px;
        margin-top:10px; padding:12px;
        background:rgba(37,99,235,0.04);
        border:1px solid rgba(37,99,235,0.08);
        border-radius:10px;
    }
    .detail-item { display:flex; flex-direction:column; gap:1px; }
    .detail-label { font-size:0.63rem; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:var(--text-muted); }
    .detail-value { font-size:0.78rem; font-weight:600; color:var(--text-body); }
    .detail-value.mono { font-family:'JetBrains Mono',monospace; font-size:0.7rem; }

    /* Status badges */
    .status-badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 11px; border-radius:50px;
        font-size:0.7rem; font-weight:700; letter-spacing:0.04em;
        white-space:nowrap;
    }
    .status-badge::before {
        content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0;
    }
    .status-bagus  { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
    .status-bagus::before  { background:#16a34a; box-shadow:0 0 5px #16a34a; }
    .status-aman   { background:#fef9c3; color:#854d0e; border:1px solid #fde68a; }
    .status-aman::before   { background:#d97706; box-shadow:0 0 5px #d97706; }
    .status-under  { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
    .status-under::before  { background:#ef4444; box-shadow:0 0 5px #ef4444; animation:blink 1.2s infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    /* Keterangan */
    .keterangan-cell {
        font-size:0.78rem; color:var(--text-muted);
        max-width:200px; white-space:normal; word-break:break-word;
        line-height:1.5;
    }
    .keterangan-cell:empty::before { content:'—'; }

    /* Action buttons */
    .action-group { display:flex; flex-direction:column; gap:6px; align-items:center; }
    .btn-action {
        display:inline-flex; align-items:center; justify-content:center; gap:4px;
        width:76px; padding:6px 0; border-radius:8px;
        font-size:0.72rem; font-weight:700; cursor:pointer;
        border:none; transition:transform 0.15s, box-shadow 0.15s, filter 0.15s;
        letter-spacing:0.02em;
    }
    .btn-action:hover { transform:translateY(-1px); filter:brightness(1.08); }
    .btn-action svg { width:11px; height:11px; stroke:currentColor; }
    .btn-del  { background:linear-gradient(135deg,#ef4444,#f87171); color:#fff; box-shadow:0 2px 8px rgba(239,68,68,0.22); }
    .btn-edit { background:linear-gradient(135deg,#f59e0b,#fbbf24); color:#fff; box-shadow:0 2px 8px rgba(245,158,11,0.22); }

    /* ── PAGINATION ── */
    .pagination-wrap {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:12px;
        padding:16px 20px;
        border-top:1px solid rgba(37,99,235,0.08);
        background:rgba(248,250,252,0.6);
    }
    .pagination-info {
        font-size:0.78rem; color:var(--text-muted); font-weight:500;
    }
    .pagination-info strong { color:var(--text-body); font-weight:700; }
    .pagination-btns { display:flex; align-items:center; gap:4px; }
    .pg-btn {
        display:flex; align-items:center; justify-content:center;
        min-width:34px; height:34px; border-radius:9px;
        font-size:0.8rem; font-weight:600;
        text-decoration:none; border:1px solid transparent;
        transition: background 0.15s, color 0.15s, border-color 0.15s, transform 0.1s;
    }
    .pg-btn:hover { transform:translateY(-1px); }
    .pg-btn-default {
        background:#fff; border-color:rgba(37,99,235,0.14);
        color:var(--text-body);
    }
    .pg-btn-default:hover { background:var(--primary-light); color:var(--primary); border-color:rgba(37,99,235,0.3); }
    .pg-btn-active {
        background:linear-gradient(135deg,#2563eb,#60a5fa);
        color:#fff; box-shadow:0 3px 10px rgba(37,99,235,0.28);
    }
    .pg-btn-disabled { background:#f1f5f9; color:#cbd5e1; cursor:default; pointer-events:none; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align:center; padding:60px 24px;
        display:flex; flex-direction:column; align-items:center; gap:10px;
    }
    .empty-icon { width:56px; height:56px; stroke:#cbd5e1; margin-bottom:4px; }
    .empty-title { font-size:1rem; font-weight:700; color:#94a3b8; }
    .empty-sub { font-size:0.82rem; color:#cbd5e1; }

    @media(max-width:768px) {
        .toolbar { flex-direction:column; align-items:stretch; }
        .search-form { max-width:100%; }
        .detail-grid { grid-template-columns:1fr; }
        .page-header { flex-direction:column; }
    }
</style>

<div class="spekpc-wrap">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-header">

        <div class="page-title-block">
            <div class="page-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <path d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <div>
                <div class="page-title">Data Spek PC</div>
                <div class="page-subtitle">Manajemen spesifikasi & inventori komputer</div>
            </div>
        </div>

        <div class="toolbar">
            {{-- SEARCH --}}
            <form method="GET" class="search-form">
                <span class="search-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari IP, nama, dept...">
                <button type="submit">Cari</button>
            </form>

            {{-- ACTION BUTTONS --}}
            <button onclick="openModal()" class="btn btn-green">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah
            </button>

            <a href="/spekpc/export/excel" class="btn btn-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Excel
            </a>

            <a href="/spekpc/export/csv" class="btn btn-slate">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                CSV
            </a>
        </div>
    </div>

    {{-- ── TOAST ── --}}
    @if(session('success'))
        <div class="toast-success">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── TABLE CARD ── --}}
    <div class="table-card">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:44px; text-align:center;">#</th>
                        <th>
                            <a href="?sort=ip&direction={{ $sort=='ip' && $direction=='asc' ? 'desc':'asc' }}&search={{ $search }}">
                                IP
                                @if($sort=='ip') <span>{{ $direction=='asc' ? '↑' : '↓' }}</span> @endif
                            </a>
                        </th>
                        <th>
                            <a href="?sort=nama&direction={{ $sort=='nama' && $direction=='asc' ? 'desc':'asc' }}&search={{ $search }}">
                                Nama
                                @if($sort=='nama') <span>{{ $direction=='asc' ? '↑' : '↓' }}</span> @endif
                            </a>
                        </th>
                        <th>
                            <a href="?sort=dept&direction={{ $sort=='dept' && $direction=='asc' ? 'desc':'asc' }}&search={{ $search }}">
                                Dept
                                @if($sort=='dept') <span>{{ $direction=='asc' ? '↑' : '↓' }}</span> @endif
                            </a>
                        </th>
                        <th>Detail Spesifikasi</th>
                        <th style="text-align:center;">
                            <a href="?sort=status&direction={{ $sort=='status' && $direction=='asc' ? 'desc':'asc' }}&search={{ $search }}">
                                Status
                                @if($sort=='status') <span>{{ $direction=='asc' ? '↑' : '↓' }}</span> @endif
                            </a>
                        </th>
                        <th>
                            <a href="?sort=keterangan&direction={{ $sort=='keterangan' && $direction=='asc' ? 'desc':'asc' }}&search={{ $search }}">
                                Keterangan
                                @if($sort=='keterangan') <span>{{ $direction=='asc' ? '↑' : '↓' }}</span> @endif
                            </a>
                        </th>
                        <th style="text-align:center; width:96px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            {{-- No --}}
                            <td style="text-align:center;">
                                <span class="row-num">{{ $data->firstItem() + $loop->index }}</span>
                            </td>

                            {{-- IP --}}
                            <td>
                                <span class="ip-cell">{{ $item->ip }}</span>
                            </td>

                            {{-- Nama --}}
                            <td>
                                <span class="nama-cell">{{ $item->nama }}</span>
                            </td>

                            {{-- Dept --}}
                            <td>
                                <span class="dept-badge">{{ $item->dept }}</span>
                            </td>

                            {{-- Detail Accordion --}}
                            <td>
                                <button onclick="toggleDetail({{ $item->id }}, this)"
                                    class="detail-toggle">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                    Lihat Detail
                                </button>

                                <div id="detail-{{ $item->id }}" class="detail-panel">
                                    <div class="detail-grid">
                                            {{-- ← BARU: Computer Name --}}
                                            <div class="detail-item">
                                                <span class="detail-label">Computer Name</span>
                                                <span class="detail-value mono">{{ $item->compname ?? '—' }}</span>
                                            </div>
                                            {{-- ← BARU: NIK --}}
                                            <div class="detail-item">
                                                <span class="detail-label">NIK</span>
                                                <span class="detail-value mono">{{ $item->nik ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">DAT</span>
                                                <span class="detail-value mono">{{ $item->dat ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Serial Number</span>
                                                <span class="detail-value mono">{{ $item->sn ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Merk</span>
                                                <span class="detail-value">{{ $item->merk ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Processor</span>
                                                <span class="detail-value" style="font-size:0.72rem;">{{ $item->processor ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">RAM</span>
                                                <span class="detail-value">{{ $item->ram ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Storage</span>
                                                <span class="detail-value">{{ $item->storage ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Windows</span>
                                                <span class="detail-value">{{ $item->windows ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Lisensi Windows</span>
                                                <span class="detail-value mono" style="font-size:0.7rem;">{{ $item->lisensi_windows ?? '—' }}</span>
                                            </div>
                                            <div class="detail-item" style="grid-column:1/-1;">
                                                <span class="detail-label">Lisensi Office</span>
                                                <span class="detail-value mono" style="font-size:0.7rem;">{{ $item->lisensi_office ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td style="text-align:center;">
                                @php
                                    $st = strtolower($item->status);
                                    $cls = $st === 'bagus' ? 'status-bagus' : ($st === 'aman' ? 'status-aman' : 'status-under');
                                @endphp
                                <span class="status-badge {{ $cls }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>

                            {{-- Keterangan --}}
                            <td>
                                <span class="keterangan-cell">
                                    {{ \Illuminate\Support\Str::limit($item->keterangan, 100) }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td style="text-align:center; vertical-align:middle;">
                                <div class="action-group">
                                    <button onclick="openDeleteModal({{ $item->id }})" class="btn-action btn-del">
                                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>
                                        </svg>
                                        Hapus
                                    </button>
                                    <button onclick='openEditModal(@json($item))' class="btn-action btn-edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                                        <path d="M8 21h8M12 17v4"/>
                                        <line x1="9" y1="9" x2="15" y2="9"/>
                                    </svg>
                                    <div class="empty-title">Tidak ada data ditemukan</div>
                                    <div class="empty-sub">Coba ubah kata kunci pencarian atau tambah data baru</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ── --}}
        @if($data->total() > 0)
        <div class="pagination-wrap">
            <div class="pagination-info">
                Menampilkan <strong>{{ $data->firstItem() }}–{{ $data->lastItem() }}</strong>
                dari <strong>{{ $data->total() }}</strong> data
            </div>
            <div class="pagination-btns">
                @if ($data->onFirstPage())
                    <span class="pg-btn pg-btn-disabled">←</span>
                @else
                    <a href="{{ $data->previousPageUrl() }}" class="pg-btn pg-btn-default">←</a>
                @endif

                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if ($page == $data->currentPage())
                        <span class="pg-btn pg-btn-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pg-btn pg-btn-default">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}" class="pg-btn pg-btn-default">→</a>
                @else
                    <span class="pg-btn pg-btn-disabled">→</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

{{-- MODALS --}}
@include('aset.modal_tambah_spekpc')
@include('aset.modal_delete_spekpc')
@include('aset.modal_edit_spekpc')

<style>
.input {
    width:100%; padding:9px 12px;
    border:1px solid #d1d5db; border-radius:8px;
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:0.85rem; color:#334155;
    transition:border-color 0.2s, box-shadow 0.2s;
    outline:none;
}
.input:focus {
    border-color:rgba(37,99,235,0.45);
    box-shadow:0 0 0 3px rgba(37,99,235,0.08);
}
</style>

<script>
/* ── ACCORDION DETAIL ── */
let activeDetail = null;
let activeBtn    = null;

function toggleDetail(id, btn) {
    const el = document.getElementById('detail-' + id);

    if (activeDetail && activeDetail !== el) {
        activeDetail.style.maxHeight = '0px';
        if (activeBtn) activeBtn.classList.remove('open');
    }

    if (el.style.maxHeight && el.style.maxHeight !== '0px') {
        el.style.maxHeight = '0px';
        btn.classList.remove('open');
        activeDetail = null; activeBtn = null;
    } else {
        el.style.maxHeight = el.scrollHeight + 200 + 'px';
        btn.classList.add('open');
        activeDetail = el; activeBtn = btn;
    }
}

/* ── MODAL TAMBAH ── */
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}
function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

/* ── MODAL DELETE ── */
function openDeleteModal(id) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
    document.getElementById('deleteForm').action = '/spekpc/delete/' + id;
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    document.getElementById('deletePassword').value = '';
}

document.getElementById('deleteForm').addEventListener('submit', function(e) {
    if (document.getElementById('deletePassword').value !== '@nt@riks@') {
        e.preventDefault();
        alert('Password salah!');
    }
});

/* ── MODAL EDIT ── */
function openEditModal(data) {
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('editForm').action = '/spekpc/update/' + data.id;
 
    // Isi semua field teks/input biasa
    const fields = [
        'ip','compname','nama','nik',  // ← compname & nik BARU
        'dat','sn','lisensi_windows','lisensi_office','keterangan'
    ];
    fields.forEach(key => {
        const el = document.getElementById('edit_' + key);
        if (el) el.value = data[key] ?? '';
    });
 
    // Update char counter keterangan
    updateEditCharCount();
 
    // DEPT
    const deptSelect = document.getElementById('edit_dept_select');
    const deptCustom = document.getElementById('edit_dept_custom');
    const deptOptions = ["EDP","BIC","HRD","GA","FIN","DEV","LOC","LICENSE","MKT-FRC","PROJ","MTC","AREA","MD","DC","HRD-TC"];
    if (deptOptions.includes(data.dept)) {
        deptSelect.value = data.dept;
        deptCustom.classList.add('hidden'); deptCustom.value = '';
    } else {
        deptSelect.value = 'Other';
        deptCustom.classList.remove('hidden'); deptCustom.value = data.dept || '';
    }
 
    // MERK
    const merkSelect = document.getElementById('edit_merk_select');
    const merkCustom = document.getElementById('edit_merk_custom');
    const merkOptions = ["ZYREX","WEARNES","GEAR","ACER","HP"];
    if (merkOptions.includes(data.merk)) {
        merkSelect.value = data.merk;
        merkCustom.classList.add('hidden'); merkCustom.value = '';
    } else {
        merkSelect.value = 'Other';
        merkCustom.classList.remove('hidden'); merkCustom.value = data.merk || '';
    }
 
    // RAM
    const ramSelect = document.getElementById('edit_ram_select');
    const ramCustom = document.getElementById('edit_ram_custom');
    const ramOptions = ["2 GB","4 GB","6 GB","8 GB","12 GB","16 GB"];
    if (ramOptions.includes(data.ram)) {
        ramSelect.value = data.ram;
        ramCustom.classList.add('hidden'); ramCustom.value = '';
    } else {
        ramSelect.value = 'Other';
        ramCustom.classList.remove('hidden'); ramCustom.value = data.ram || '';
    }
 
    // STORAGE
    const storageSelect = document.getElementById('edit_storage_select');
    const storageCustom = document.getElementById('edit_storage_custom');
    const storageOptions = ["HDD 500 GB","HDD 1 TB","SSD Sata 500GB","SSD Sata 1 TB","NVME 500GB","NVME 1 TB"];
    if (storageOptions.includes(data.storage)) {
        storageSelect.value = data.storage;
        storageCustom.classList.add('hidden'); storageCustom.value = '';
    } else {
        storageSelect.value = 'Other';
        storageCustom.classList.remove('hidden'); storageCustom.value = data.storage || '';
    }
 
    // WINDOWS
    const winSelect = document.getElementById('edit_windows_select');
    const winCustom = document.getElementById('edit_windows_custom');
    const winOptions = ["Windows 7 32 Bit","Windows 7 64 Bit","Windows 10 32 Bit","Windows 10 64 Bit","Windows 11 64 Bit"];
    if (winOptions.includes(data.windows)) {
        winSelect.value = data.windows;
        winCustom.classList.add('hidden'); winCustom.value = '';
    } else {
        winSelect.value = 'Other';
        winCustom.classList.remove('hidden'); winCustom.value = data.windows || '';
    }
 
    // PROCESSOR
    const procSelect = document.getElementById('edit_processor_select');
    const procCustom = document.getElementById('edit_processor_custom');
    const procOptions = [
        "Intel(R) Pentium(R) G3220 CPU @ 3.20GHz","Intel(R) Pentium(R) G3230 CPU @ 3.20GHz",
        "Intel(R) Pentium(R) G3240 CPU @ 3.10GHz","Intel(R) Pentium(R) G3250 CPU @ 3.20GHz",
        "Intel(R) Pentium(R) Gold G6400 CPU @ 4.00GHz","Intel(R) Pentium(R) Gold G7400 CPU @ 3.70GHz",
        "Intel(R) Pentium(R) Gold G4400 CPU @ 3.30GHz","Intel(R) Core(TM) i5-7400 CPU @ 3.00GHz",
        "Intel(R) Core(TM) i3-10100 CPU @ 4.30GHz","Intel(R) Core(TM) i3-10105 CPU @ 4.40GHz",
        "Intel(R) Core(TM) i5-10400 CPU @ 4.30GHz"
    ];
    if (procOptions.includes(data.processor)) {
        procSelect.value = data.processor;
        procCustom.classList.add('hidden'); procCustom.value = '';
    } else {
        procSelect.value = 'Other';
        procCustom.classList.remove('hidden'); procCustom.value = data.processor || '';
    }
 
    // STATUS color
    const status = document.getElementById('edit_status');
    if (status) {
        status.value = data.status ?? '';
        changeEditStatusColor(status);
    }
}
</script>

@endsection