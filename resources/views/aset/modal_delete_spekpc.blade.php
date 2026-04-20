{{-- MODAL DELETE --}}
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0" onclick="closeDeleteModal()"
        style="background:rgba(15,23,42,0.65); backdrop-filter:blur(6px);"></div>

    <div class="relative z-10 w-full" style="max-width:400px; margin:0 16px;">
        <div style="
            background:#fff;
            border-radius:20px;
            box-shadow:0 32px 80px rgba(239,68,68,0.18), 0 0 0 1px rgba(239,68,68,0.1);
            overflow:hidden;
            animation: deleteModalIn 0.3s cubic-bezier(0.16,1,0.3,1) both;
        ">

            {{-- TOP STRIPE --}}
            <div style="height:4px; background:linear-gradient(90deg,#b91c1c,#ef4444,#f87171,#fca5a5);"></div>

            {{-- HEADER AREA --}}
            <div style="
                padding:28px 28px 0;
                background:linear-gradient(160deg,#fff5f5 0%,#fff 55%);
                text-align:center;
            ">
                {{-- ICON --}}
                <div style="
                    width:64px; height:64px; border-radius:50%;
                    background:linear-gradient(135deg,#fee2e2,#fecaca);
                    border:3px solid #fca5a5;
                    display:flex; align-items:center; justify-content:center;
                    margin:0 auto 14px;
                    box-shadow:0 8px 24px rgba(239,68,68,0.18);
                ">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                        stroke="#ef4444" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>
                </div>

                <div style="font-size:1.1rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin-bottom:6px;">
                    Hapus Data?
                </div>
                <div style="font-size:0.8rem; color:#94a3b8; font-weight:500; margin-bottom:20px; line-height:1.5;">
                    Tindakan ini <strong style="color:#ef4444;">tidak dapat dibatalkan</strong>.<br>
                    Data akan dihapus secara permanen.
                </div>
            </div>

            {{-- BODY --}}
            <div style="padding:0 28px 28px;">

                {{-- WARNING BOX --}}
                <div style="
                    background:#fff5f5;
                    border:1.5px solid #fecaca;
                    border-radius:12px;
                    padding:12px 14px;
                    margin-bottom:20px;
                    display:flex; align-items:flex-start; gap:10px;
                ">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#f87171" stroke-width="2" stroke-linecap="round"
                        style="flex-shrink:0; margin-top:1px;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p style="font-size:0.78rem; color:#b91c1c; font-weight:500; margin:0; line-height:1.5;">
                        Masukkan password EDP untuk mengkonfirmasi penghapusan data ini.
                    </p>
                </div>

                {{-- FORM --}}
                <form id="deleteForm" method="POST">
                    @csrf
                    {{-- TIDAK PAKAI @method('DELETE') karena route pakai POST --}}

                    {{-- PASSWORD INPUT --}}
                    <div style="position:relative; margin-bottom:20px;">
                        <div style="
                            position:absolute; left:12px; top:50%; transform:translateY(-50%);
                            display:flex; align-items:center; pointer-events:none;
                        ">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="deletePassword"
                            placeholder="Masukkan password EDP"
                            required
                            style="
                                width:100%; padding:11px 14px 11px 38px;
                                border:1.5px solid #fecaca; border-radius:10px;
                                font-size:0.85rem; color:#374151; outline:none;
                                background:#fff8f8;
                                font-family:'Plus Jakarta Sans',sans-serif;
                                transition:border-color 0.2s, box-shadow 0.2s;
                                box-sizing:border-box;
                            "
                            onfocus="this.style.borderColor='#ef4444'; this.style.boxShadow='0 0 0 3px rgba(239,68,68,0.1)'; this.style.background='#fff'"
                            onblur="this.style.borderColor='#fecaca'; this.style.boxShadow='none'; this.style.background='#fff8f8'"
                        >
                    </div>

                    {{-- BUTTONS --}}
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="closeDeleteModal()" style="
                            flex:1; padding:11px;
                            background:#f8fafc; border:1.5px solid #e2e8f0;
                            border-radius:11px; font-size:0.83rem; font-weight:600; color:#64748b;
                            cursor:pointer; font-family:inherit; transition:all 0.2s;
                        " onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#cbd5e1'"
                           onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'">
                            Batal
                        </button>
                        <button type="submit" style="
                            flex:1.6; padding:11px;
                            background:linear-gradient(135deg,#dc2626,#ef4444);
                            border:none; border-radius:11px;
                            font-size:0.83rem; font-weight:700; color:#fff;
                            cursor:pointer; font-family:inherit;
                            box-shadow:0 4px 16px rgba(239,68,68,0.32);
                            transition:transform 0.15s, box-shadow 0.2s;
                            display:flex; align-items:center; justify-content:center; gap:7px;
                        " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 24px rgba(239,68,68,0.4)'"
                           onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(239,68,68,0.32)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/><path d="M14 11v6"/>
                            </svg>
                            Ya, Hapus Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes deleteModalIn {
    from { opacity:0; transform:translateY(20px) scale(0.96); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}
</style>