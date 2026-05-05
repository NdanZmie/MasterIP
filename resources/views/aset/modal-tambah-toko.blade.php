{{-- views/aset/modal-tambah-toko.blade.php --}}
<div id="modalTambahToko" class="fixed inset-0 hidden items-center justify-center z-[9999]">
    <div class="absolute inset-0" onclick="closeModalTambahToko()"
        style="background:rgba(15,23,42,0.6); backdrop-filter:blur(6px);"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4 w-full">
        <div style="
            background:#fff; width:100%; max-width:700px; border-radius:20px;
            box-shadow:0 32px 80px rgba(15,23,42,0.22), 0 0 0 1px rgba(16,185,129,0.12);
            display:flex; flex-direction:column; max-height:92vh; overflow:hidden;
            animation: tokoModalIn 0.3s cubic-bezier(0.16,1,0.3,1) both;
        ">
            <div style="height:4px; background:linear-gradient(90deg,#059669,#10b981,#34d399,#6ee7b7); flex-shrink:0;"></div>

            <div style="
                display:flex; justify-content:space-between; align-items:center;
                padding:20px 28px 16px; border-bottom:1px solid #f1f5f9; flex-shrink:0;
                background:linear-gradient(135deg,#f0fdf4 0%,#fff 60%);
            ">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="
                        width:44px; height:44px; border-radius:14px;
                        background:linear-gradient(135deg,#059669,#10b981);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 18px rgba(16,185,129,0.32);
                    ">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:1rem; font-weight:800; color:#0f172a;">Tambah Data Toko</div>
                        <div style="font-size:0.75rem; color:#94a3b8; margin-top:1px;">Isi informasi koneksi toko baru</div>
                    </div>
                </div>
                <button onclick="closeModalTambahToko()" style="
                    width:34px; height:34px; border-radius:10px; border:none; cursor:pointer;
                    background:#f8fafc; color:#94a3b8; font-size:1rem;
                    display:flex; align-items:center; justify-content:center;
                " onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'"
                   onmouseout="this.style.background='#f8fafc'; this.style.color='#94a3b8'">✕</button>
            </div>

            <div style="padding:24px 28px; overflow-y:auto; flex:1;">
                <form id="formTambahToko" method="POST" action="/koneksitoko/store" class="space-y-4">
                    @csrf

                    {{-- Identitas --}}
                    <div class="toko-section-label" style="color:#10b981;">
                        <div class="toko-section-line" style="background:linear-gradient(90deg,#d1fae5,transparent);"></div>
                        Identitas Toko
                        <div class="toko-section-line" style="background:linear-gradient(270deg,#d1fae5,transparent);"></div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="toko-label">Nama Toko <span style="color:#ef4444">*</span></label>
                            <input name="nama_toko" class="toko-input" required placeholder="Contoh: Toko ABC">
                        </div>
                        <div>
                            <label class="toko-label">Kode Toko <span style="color:#ef4444">*</span></label>
                            <input name="kode_toko" class="toko-input" required placeholder="Contoh: TK-001">
                        </div>
                    </div>

                    {{-- IP Addresses --}}
                    <div class="toko-section-label" style="color:#10b981; margin-top:18px;">
                        <div class="toko-section-line" style="background:linear-gradient(90deg,#d1fae5,transparent);"></div>
                        Alamat IP Perangkat
                        <div class="toko-section-line" style="background:linear-gradient(270deg,#d1fae5,transparent);"></div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="toko-label">IP CCTV</label>
                            <input name="ip_cctv" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP STB</label>
                            <input name="ip_stb" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 1</label>
                            <input name="ip_station_1" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 2</label>
                            <input name="ip_station_2" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 3</label>
                            <input name="ip_station_3" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 4</label>
                            <input name="ip_station_4" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 5</label>
                            <input name="ip_station_5" class="toko-input" placeholder="192.168.x.x">
                        </div>
                    </div>
                </form>
            </div>

            <div style="
                display:flex; justify-content:flex-end; gap:10px;
                padding:16px 28px; border-top:1px solid #f1f5f9; background:#fafafa; flex-shrink:0;
            ">
                <button type="button" onclick="closeModalTambahToko()" class="toko-btn-cancel">Batal</button>
                <button type="submit" form="formTambahToko" class="toko-btn-submit"
                    style="background:linear-gradient(135deg,#059669,#10b981); box-shadow:0 4px 16px rgba(16,185,129,0.35);"
                    onmouseover="this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.transform=''">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function closeModalTambahToko() {
    document.getElementById('modalTambahToko').classList.add('hidden');
    document.getElementById('modalTambahToko').classList.remove('flex');
}
function openModalTambahToko() {
    document.getElementById('modalTambahToko').classList.remove('hidden');
    document.getElementById('modalTambahToko').classList.add('flex');
}
</script>