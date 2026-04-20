{{-- MODAL TAMBAH --}}
<div id="modal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0" onclick="closeModal()"
        style="background:rgba(15,23,42,0.6); backdrop-filter:blur(6px);"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4 w-full">

        {{-- CONTAINER --}}
        <div style="
            background:#fff;
            width:100%; max-width:740px;
            border-radius:20px;
            box-shadow:0 32px 80px rgba(15,23,42,0.22), 0 0 0 1px rgba(16,185,129,0.12);
            display:flex; flex-direction:column;
            max-height:92vh; overflow:hidden;
            animation: modalIn 0.3s cubic-bezier(0.16,1,0.3,1) both;
        ">
            {{-- @keyframes modalIn {
                from { opacity:0; transform:translateY(24px) scale(0.97); }
                to   { opacity:1; transform:translateY(0) scale(1); }
            } --}}

            {{-- TOP STRIPE --}}
            <div style="height:4px; background:linear-gradient(90deg,#059669,#10b981,#34d399,#6ee7b7); flex-shrink:0;"></div>

            {{-- HEADER --}}
            <div style="
                display:flex; justify-content:space-between; align-items:center;
                padding:20px 28px 16px;
                border-bottom:1px solid #f1f5f9;
                flex-shrink:0;
                background:linear-gradient(135deg, #f0fdf4 0%, #fff 60%);
            ">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="
                        width:44px; height:44px; border-radius:14px;
                        background:linear-gradient(135deg,#059669,#10b981);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 18px rgba(16,185,129,0.32);
                    ">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:1rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">Tambah Data PC</div>
                        <div style="font-size:0.75rem; color:#94a3b8; font-weight:500; margin-top:1px;">Isi spesifikasi komputer baru</div>
                    </div>
                </div>
                <button onclick="closeModal()" style="
                    width:34px; height:34px; border-radius:10px; border:none; cursor:pointer;
                    background:#f8fafc; color:#94a3b8; font-size:1rem;
                    display:flex; align-items:center; justify-content:center;
                    transition:background 0.2s, color 0.2s;
                " onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'"
                   onmouseout="this.style.background='#f8fafc'; this.style.color='#94a3b8'">✕</button>
            </div>

            {{-- BODY --}}
            <div style="padding:24px 28px; overflow-y:auto; flex:1;">

                <form id="formTambah" method="POST" action="/spekpc/store" class="space-y-4">
                    @csrf

                    {{-- SECTION: Identitas --}}
                    <div style="
                        font-size:0.65rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase;
                        color:#10b981; margin-bottom:10px; display:flex; align-items:center; gap:8px;
                    ">
                        <div style="height:1px; flex:1; background:linear-gradient(90deg,#d1fae5,transparent);"></div>
                        Identitas & Departemen
                        <div style="height:1px; flex:1; background:linear-gradient(270deg,#d1fae5,transparent);"></div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                        <div>
                            <label class="modal-label">IP Address</label>
                            <input name="ip" class="modal-input" required placeholder="Contoh: 192.168.1.10">
                        </div>

                        <div>
                            <label class="modal-label">Departemen</label>
                            <select name="dept" id="deptSelect" class="modal-input" onchange="toggleDeptInput(this)" required>
                                <option value="">-- Pilih Dept --</option>
                                <option value="EDP">EDP</option>
                                <option value="BIC">BIC</option>
                                <option value="HRD">HRD</option>
                                <option value="GA">GA</option>
                                <option value="FIN">FIN</option>
                                <option value="DEV">DEV</option>
                                <option value="LOC">LOC</option>
                                <option value="LICENSE">LICENSE</option>
                                <option value="MKT-FRC">MKT-FRC</option>
                                <option value="PROJ">PROJ</option>
                                <option value="MTC">MTC</option>
                                <option value="AREA">AREA</option>
                                <option value="MD">MD</option>
                                <option value="DC">DC</option>
                                <option value="HRD-TC">HRD-TC</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="dept_custom" id="deptCustom"
                                class="modal-input hidden" style="margin-top:8px;" placeholder="Isi dept lainnya...">
                        </div>

                        <div>
                            <label class="modal-label">Nama Pengguna</label>
                            <input name="nama" class="modal-input" required placeholder="Nama pengguna">
                        </div>

                        <div>
                            <label class="modal-label">Status</label>
                            <select name="status" id="statusSelect" class="modal-input" required onchange="changeStatusColor(this)">
                                <option value="">-- Pilih Status --</option>
                                <option value="UNDER">UNDER</option>
                                <option value="AMAN">AMAN</option>
                                <option value="BAGUS">BAGUS</option>
                            </select>
                        </div>
                    </div>

                    {{-- SECTION: Hardware --}}
                    <div style="
                        font-size:0.65rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase;
                        color:#10b981; margin:18px 0 10px; display:flex; align-items:center; gap:8px;
                    ">
                        <div style="height:1px; flex:1; background:linear-gradient(90deg,#d1fae5,transparent);"></div>
                        Spesifikasi Hardware
                        <div style="height:1px; flex:1; background:linear-gradient(270deg,#d1fae5,transparent);"></div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                        <div>
                            <label class="modal-label">Merk</label>
                            <select name="merk" id="merkSelect" class="modal-input" onchange="toggleMerkInput(this)">
                                <option value="">-- Pilih Merk --</option>
                                <option value="ZYREX">ZYREX</option>
                                <option value="WEARNES">WEARNES</option>
                                <option value="GEAR">GEAR</option>
                                <option value="ACER">ACER</option>
                                <option value="HP">HP</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="merk_custom" id="merkCustom"
                                placeholder="Isi merk lainnya..." class="modal-input hidden" style="margin-top:8px;">
                        </div>

                        <div>
                            <label class="modal-label">Serial Number (SN)</label>
                            <input name="sn" class="modal-input" placeholder="SN perangkat">
                        </div>

                        <div>
                            <label class="modal-label">Processor</label>
                            <select name="processor" id="processorSelect" class="modal-input" onchange="toggleProcessorInput(this)">
                                <option value="">-- Pilih Processor --</option>
                                <option value="Intel(R) Pentium(R) G3220 CPU @ 3.20GHz">Intel Pentium G3220 @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) G3230 CPU @ 3.20GHz">Intel Pentium G3230 @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) G3240 CPU @ 3.10GHz">Intel Pentium G3240 @ 3.10GHz</option>
                                <option value="Intel(R) Pentium(R) G3250 CPU @ 3.20GHz">Intel Pentium G3250 @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G6400 CPU @ 4.00GHz">Intel Pentium Gold G6400 @ 4.00GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G7400 CPU @ 3.70GHz">Intel Pentium Gold G7400 @ 3.70GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G4400 CPU @ 3.30GHz">Intel Pentium Gold G4400 @ 3.30GHz</option>
                                <option value="Intel(R) Core(TM) i5-7400 CPU @ 3.00GHz">Intel Core i5-7400 @ 3.00GHz</option>
                                <option value="Intel(R) Core(TM) i3-10100 CPU @ 4.30GHz">Intel Core i3-10100 @ 4.30GHz</option>
                                <option value="Intel(R) Core(TM) i3-10105 CPU @ 4.40GHz">Intel Core i3-10105 @ 4.40GHz</option>
                                <option value="Intel(R) Core(TM) i5-10400 CPU @ 4.30GHz">Intel Core i5-10400 @ 4.30GHz</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="processor_custom" id="processorCustom"
                                class="modal-input hidden" style="margin-top:8px;" placeholder="Isi processor lainnya...">
                        </div>

                        <div>
                            <label class="modal-label">DAT</label>
                            <input name="dat" class="modal-input" placeholder="No. DAT">
                        </div>

                        <div>
                            <label class="modal-label">RAM</label>
                            <select name="ram" id="ramSelect" class="modal-input" onchange="toggleRamInput(this)">
                                <option value="">-- Pilih RAM --</option>
                                <option value="2 GB">2 GB</option>
                                <option value="4 GB">4 GB</option>
                                <option value="6 GB">6 GB</option>
                                <option value="8 GB">8 GB</option>
                                <option value="12 GB">12 GB</option>
                                <option value="16 GB">16 GB</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="ram_custom" id="ramCustom"
                                class="modal-input hidden" style="margin-top:8px;" placeholder="Isi RAM lainnya...">
                        </div>

                        <div>
                            <label class="modal-label">Storage</label>
                            <select name="storage" id="storageSelect" class="modal-input" onchange="toggleStorageInput(this)">
                                <option value="">-- Pilih Storage --</option>
                                <option value="HDD 500 GB">HDD 500 GB</option>
                                <option value="HDD 1 TB">HDD 1 TB</option>
                                <option value="SSD Sata 500GB">SSD Sata 500GB</option>
                                <option value="SSD Sata 1 TB">SSD Sata 1 TB</option>
                                <option value="NVME 500GB">NVME 500GB</option>
                                <option value="NVME 1 TB">NVME 1 TB</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="storage_custom" id="storageCustom"
                                class="modal-input hidden" style="margin-top:8px;" placeholder="Isi storage lainnya...">
                        </div>

                    </div>

                    {{-- SECTION: Lisensi --}}
                    <div style="
                        font-size:0.65rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase;
                        color:#10b981; margin:18px 0 10px; display:flex; align-items:center; gap:8px;
                    ">
                        <div style="height:1px; flex:1; background:linear-gradient(90deg,#d1fae5,transparent);"></div>
                        Lisensi & Software
                        <div style="height:1px; flex:1; background:linear-gradient(270deg,#d1fae5,transparent);"></div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                        <div>
                            <label class="modal-label">Windows</label>
                            <select name="windows" id="windowsSelect" class="modal-input" onchange="toggleWindowsInput(this)">
                                <option value="">-- Pilih Windows --</option>
                                <option value="Windows 7 32 Bit">Windows 7 32 Bit</option>
                                <option value="Windows 7 64 Bit">Windows 7 64 Bit</option>
                                <option value="Windows 10 32 Bit">Windows 10 32 Bit</option>
                                <option value="Windows 10 64 Bit">Windows 10 64 Bit</option>
                                <option value="Windows 11 64 Bit">Windows 11 64 Bit</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="windows_custom" id="windowsCustom"
                                class="modal-input hidden" style="margin-top:8px;" placeholder="Isi Windows lainnya...">
                        </div>

                        <div>
                            <label class="modal-label">Lisensi Windows</label>
                            <input name="lisensi_windows" class="modal-input" placeholder="Key lisensi Windows">
                        </div>

                        <div style="grid-column:1/-1;">
                            <label class="modal-label">Lisensi Office</label>
                            <input name="lisensi_office" class="modal-input" placeholder="Key lisensi Office">
                        </div>

                    </div>

                    {{-- KETERANGAN --}}
                    <div style="margin-top:6px;">
                        <label class="modal-label">Keterangan <span style="color:#cbd5e1; font-weight:400;">(opsional)</span></label>
                        <textarea
                            name="keterangan"
                            id="keteranganInput"
                            class="modal-input"
                            rows="3"
                            maxlength="100"
                            oninput="updateCharCount()"
                            style="resize:none; width:100%;"
                            placeholder="Catatan tambahan..."
                        ></textarea>
                        <div style="display:flex; justify-content:flex-end; margin-top:4px;">
                            <span style="font-size:0.72rem; color:#94a3b8;">
                                <span id="charCount" style="font-weight:700; color:#10b981;">0</span> / 100
                            </span>
                        </div>
                    </div>

                </form>
            </div>

            {{-- FOOTER --}}
            <div style="
                display:flex; justify-content:flex-end; gap:10px;
                padding:16px 28px;
                border-top:1px solid #f1f5f9;
                background:#fafafa;
                flex-shrink:0;
            ">
                <button type="button" onclick="closeModal()" style="
                    padding:10px 22px; background:#fff; border:1.5px solid #e2e8f0;
                    border-radius:12px; font-size:0.83rem; font-weight:600; color:#64748b;
                    cursor:pointer; transition:all 0.2s; font-family:inherit;
                " onmouseover="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#fff'">
                    Batal
                </button>
                <button type="submit" form="formTambah" style="
                    padding:10px 26px;
                    background:linear-gradient(135deg,#059669,#10b981);
                    border:none; border-radius:12px;
                    font-size:0.83rem; font-weight:700; color:#fff;
                    cursor:pointer; font-family:inherit;
                    box-shadow:0 4px 16px rgba(16,185,129,0.35);
                    transition:transform 0.15s, box-shadow 0.2s;
                    display:flex; align-items:center; gap:7px;
                " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 24px rgba(16,185,129,0.4)'"
                   onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(16,185,129,0.35)'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Data
                </button>
            </div>

        </div>
    </div>
</div>

<style>
.modal-label {
    display:block;
    font-size:0.7rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.07em;
    color:#64748b; margin-bottom:5px;
}
.modal-input {
    width:100%; padding:9px 12px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:0.84rem; color:#334155;
    transition:border-color 0.2s, box-shadow 0.2s;
    outline:none; background:#fff;
    box-sizing:border-box;
}
.modal-input:focus {
    border-color:#10b981;
    box-shadow:0 0 0 3px rgba(16,185,129,0.1);
}
.modal-input.hidden { display:none; }
</style>

<script>
function changeStatusColor(select) {
    const value = select.value;
    select.style.backgroundColor = '';
    select.style.color = '';
    if (value === 'UNDER') { select.style.backgroundColor = '#fee2e2'; select.style.color = '#b91c1c'; }
    else if (value === 'AMAN') { select.style.backgroundColor = '#fef9c3'; select.style.color = '#92400e'; }
    else if (value === 'BAGUS') { select.style.backgroundColor = '#dcfce7'; select.style.color = '#166534'; }
}

function updateCharCount() {
    const input = document.getElementById('keteranganInput');
    const counter = document.getElementById('charCount');
    const len = input.value.length;
    counter.innerText = len;
    counter.style.color = len > 80 ? '#ef4444' : '#10b981';
}

function toggleMerkInput(select) {
    const custom = document.getElementById('merkCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); }
    else { custom.classList.add('hidden'); custom.value = ''; }
}
function toggleDeptInput(select) {
    const custom = document.getElementById('deptCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); custom.required = true; }
    else { custom.classList.add('hidden'); custom.value = ''; custom.required = false; }
}
function toggleRamInput(select) {
    const custom = document.getElementById('ramCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); custom.required = true; }
    else { custom.classList.add('hidden'); custom.value = ''; custom.required = false; }
}
function toggleStorageInput(select) {
    const custom = document.getElementById('storageCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); custom.required = true; }
    else { custom.classList.add('hidden'); custom.value = ''; custom.required = false; }
}
function toggleWindowsInput(select) {
    const custom = document.getElementById('windowsCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); custom.required = true; }
    else { custom.classList.add('hidden'); custom.value = ''; custom.required = false; }
}
function toggleProcessorInput(select) {
    const custom = document.getElementById('processorCustom');
    if (select.value === 'Other') { custom.classList.remove('hidden'); custom.required = true; }
    else { custom.classList.add('hidden'); custom.value = ''; custom.required = false; }
}
</script>