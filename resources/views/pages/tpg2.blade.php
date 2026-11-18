@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap');

    .simple-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 24px 16px 60px;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ─── JUDUL & SEARCH ─── */
    .top-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
    }

    /* ─── SEARCH BOX ─── */
    .search-box {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .search-input {
        padding: 8px 14px;
        font-size: 0.88rem;
        color: #0f172a;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        width: 220px;
        transition: all 0.2s;
    }
    .search-input:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }
    .btn-search {
        padding: 8px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        background: #0284c7;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-search:hover {
        background: #0369a1;
    }
    .btn-reset {
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        border-radius: 8px;
        text-decoration: none;
    }

    /* ─── LIST CONTAINER ─── */
    .program-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .program-row {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.15s ease;
    }
    .program-row:hover {
        border-color: #bae6fd;
        background: #f8fafc;
    }
    .program-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }
    .program-name {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
        line-height: 1.3;
        word-break: break-word;
    }
    .program-name:hover {
        color: #0284c7;
    }
    .program-size {
        font-size: 0.8rem;
        font-family: 'JetBrains Mono', monospace;
        color: #64748b;
    }
    .btn-unduh {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: #0284c7;
        color: #ffffff;
        border-radius: 8px;
        font-size: 0.84rem;
        font-weight: 700;
        text-decoration: none;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }
    .btn-unduh:hover {
        background: #0369a1;
        color: #ffffff;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        color: #64748b;
        font-size: 0.9rem;
    }
</style>

<div class="simple-wrap">

    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.85rem;">
            {{ session('error') }}
        </div>
    @endif

    {{-- JUDUL & SEARCH --}}
    <div class="top-header">
        <h1 class="page-title">Data Tampung</h1>
        <form action="{{ route('tpg2.index') }}" method="GET" class="search-box">
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Cari program..."
                   class="search-input">
            <button type="submit" class="btn-search">Cari</button>
            @if(!empty($search))
                <a href="{{ route('tpg2.index') }}" class="btn-reset" title="Reset">✕</a>
            @endif
        </form>
    </div>

    {{-- LIST: NAMA PROGRAM & UKURAN --}}
    <div class="program-list">
        @forelse($programs as $prog)
            <div class="program-row">
                <div class="program-info">
                    <a href="{{ route('tampung.download', $prog->id) }}"
                       class="program-name"
                       target="{{ $prog->tipe_sumber === 'link' ? '_blank' : '_self' }}">
                        {{ $prog->nama_program }}
                    </a>
                    <span class="program-size">
                        Ukuran: {{ $prog->formatted_size }}
                    </span>
                </div>
                <a href="{{ route('tampung.download', $prog->id) }}"
                   class="btn-unduh"
                   target="{{ $prog->tipe_sumber === 'link' ? '_blank' : '_self' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Unduh</span>
                </a>
            </div>
        @empty
            <div class="empty-state">
                Tidak ada program ditemukan.
            </div>
        @endforelse
    </div>

    @if($programs->hasPages())
        <div style="margin-top: 20px;">
            {{ $programs->links() }}
        </div>
    @endif

</div>

@endsection
