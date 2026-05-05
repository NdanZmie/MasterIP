{{-- views/aset/modal-edit-toko.blade.php --}}
<div id="modalEditToko" class="fixed inset-0 hidden items-center justify-center z-[9999]">
    <div class="absolute inset-0" onclick="closeModalEditToko()"
        style="background:rgba(15,23,42,0.6); backdrop-filter:blur(6px);"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4 w-full">
        <div style="
            background:#fff; width:100%; max-width:700px; border-radius:20px;
            box-shadow:0 32px 80px rgba(15,23,42,0.22), 0 0 0 1px rgba(245,158,11,0.12);
            display:flex; flex-direction:column; max-height:92vh; overflow:hidden;
            animation: tokoModalIn 0.3s cubic-bezier(0.16,1,0.3,1) both;
        ">
            <div style="height:4px; background:linear-gradient(90deg,#d97706,#f59e0b,#fbbf24,#fde68a); flex-shrink:0;"></div>

            <div style="
                display:flex; justify-content:space-between; align-items:center;
                padding:20px 28px 16px; border-bottom:1px solid #f1f5f9; flex-shrink:0;
                background:linear-gradient(135deg,#fffbeb 0%,#fff 60%);
            ">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="
                        width:44px; height:44px; border-radius:14px;
                        background:linear-gradient(135deg,#d97706,#f59e0b);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 18px rgba(245,158,11,0.32);
                    ">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:1rem; font-weight:800; color:#0f172a;">Edit Data Toko</div>
                        <div style="font-size:0.75rem; color:#94a3b8; margin-top:1px;">Ubah informasi koneksi toko</div>
                    </div>
                </div>
                <button onclick="closeModalEditToko()" style="
                    width:34px; height:34px; border-radius:10px; border:none; cursor:pointer;
                    background:#f8fafc; color:#94a3b8; font-size:1rem;
                    display:flex; align-items:center; justify-content:center;
                " onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'"
                   onmouseout="this.style.background='#f8fafc'; this.style.color='#94a3b8'">✕</button>
            </div>

            <div style="padding:24px 28px; overflow-y:auto; flex:1;">
                <form id="formEditToko" method="POST" class="space-y-4">
                    @csrf

                    {{-- Identitas --}}
                    <div class="toko-section-label" style="color:#f59e0b;">
                        <div class="toko-section-line" style="background:linear-gradient(90deg,#fde68a,transparent);"></div>
                        Identitas Toko
                        <div class="toko-section-line" style="background:linear-gradient(270deg,#fde68a,transparent);"></div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="toko-label">Nama Toko <span style="color:#ef4444">*</span></label>
                            <input id="edit_nama_toko" name="nama_toko" class="toko-input" required>
                        </div>
                        <div>
                            <label class="toko-label">Kode Toko</label>
                            <input id="edit_kode_toko" name="kode_toko" class="toko-input" placeholder="Contoh: TK-001">
                        </div>
                    </div>

                    {{-- IP Addresses --}}
                    <div class="toko-section-label" style="color:#f59e0b; margin-top:18px;">
                        <div class="toko-section-line" style="background:linear-gradient(90deg,#fde68a,transparent);"></div>
                        Alamat IP Perangkat
                        <div class="toko-section-line" style="background:linear-gradient(270deg,#fde68a,transparent);"></div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="toko-label">IP CCTV</label>
                            <input id="edit_ip_cctv" name="ip_cctv" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP STB</label>
                            <input id="edit_ip_stb" name="ip_stb" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 1</label>
                            <input id="edit_ip_station_1" name="ip_station_1" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 2</label>
                            <input id="edit_ip_station_2" name="ip_station_2" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 3</label>
                            <input id="edit_ip_station_3" name="ip_station_3" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 4</label>
                            <input id="edit_ip_station_4" name="ip_station_4" class="toko-input" placeholder="192.168.x.x">
                        </div>
                        <div>
                            <label class="toko-label">IP Station 5</label>
                            <input id="edit_ip_station_5" name="ip_station_5" class="toko-input" placeholder="192.168.x.x">
                        </div>
                    </div>
                </form>
            </div>

            <div style="
                display:flex; justify-content:flex-end; gap:10px;
                padding:16px 28px; border-top:1px solid #f1f5f9; background:#fafafa; flex-shrink:0;
            ">
                <button type="button" onclick="closeModalEditToko()" class="toko-btn-cancel">Batal</button>
                <button type="submit" form="formEditToko" class="toko-btn-submit"
                    style="background:linear-gradient(135deg,#d97706,#f59e0b); box-shadow:0 4px 16px rgba(245,158,11,0.35);"
                    onmouseover="this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.transform=''">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function closeModalEditToko() {
    document.getElementById('modalEditToko').classList.add('hidden');
    document.getElementById('modalEditToko').classList.remove('flex');
}
function openModalEditToko(data) {
    document.getElementById('edit_nama_toko').value    = data.nama_toko    || '';
    document.getElementById('edit_kode_toko').value    = data.kode_toko    || '';
    document.getElementById('edit_ip_cctv').value      = data.ip_cctv      || '';
    document.getElementById('edit_ip_stb').value       = data.ip_stb       || '';
    document.getElementById('edit_ip_station_1').value = data.ip_station_1 || '';
    document.getElementById('edit_ip_station_2').value = data.ip_station_2 || '';
    document.getElementById('edit_ip_station_3').value = data.ip_station_3 || '';
    document.getElementById('edit_ip_station_4').value = data.ip_station_4 || '';
    document.getElementById('edit_ip_station_5').value = data.ip_station_5 || '';

    document.getElementById('formEditToko').action = '/koneksitoko/update/' + data.id_toko;
    document.getElementById('modalEditToko').classList.remove('hidden');
    document.getElementById('modalEditToko').classList.add('flex');
}
</script>