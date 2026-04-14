{{-- MODAL TAMBAH --}}
<div id="modal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">

        {{-- CONTAINER --}}
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg flex flex-col max-h-[90vh]">

            {{-- HEADER (FIXED) --}}
            <div class="flex justify-between items-center px-6 py-4 border-b bg-white">
                <h3 class="text-lg font-bold">Tambah Data</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500">✕</button>
            </div>

            {{-- BODY (SCROLL DI SINI) --}}
            <div class="p-6 overflow-y-auto">

                <form method="POST" action="/spekpc/store" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        {{-- BASIC --}}
                        <div>
                            <label class="text-sm font-medium">IP</label>
                            <input name="ip" class="input" required>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Nama</label>
                            <input name="nama" class="input" required>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Dept</label>

                            <select name="dept" id="deptSelect" class="input" onchange="toggleDeptInput(this)" required>
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
                                class="input mt-2 hidden"
                                placeholder="Isi dept lainnya...">
                        </div>

                        {{-- BARU --}}
                        <div>
                            <label class="text-sm font-medium">DAT</label>
                            <input name="dat" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Serial Number (SN)</label>
                            <input name="sn" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Merk</label>

                            <select name="merk" id="merkSelect" class="input" onchange="toggleMerkInput(this)">
                                <option value="">-- Pilih Merk --</option>
                                <option value="ZYREX">ZYREX</option>
                                <option value="WEARNES">WEARNES</option>
                                <option value="GEAR">GEAR</option>
                                <option value="ACER">ACER</option>
                                <option value="HP">HP</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="text" name="merk_custom" id="merkCustom"
                                placeholder="Isi merk lainnya..."
                                class="input mt-2 hidden">
                        </div>

                        {{-- SPEK --}}
                        <div>
                            <label class="text-sm font-medium">Processor</label>
                            <input name="processor" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">RAM</label>
                            <input name="ram" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Storage</label>
                            <input name="storage" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Windows</label>
                            <input name="windows" class="input">
                        </div>

                        {{-- LISENSI --}}
                        <div>
                            <label class="text-sm font-medium">Lisensi Windows</label>
                            <input name="lisensi_windows" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Lisensi Office</label>
                            <input name="lisensi_office" class="input">
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label class="text-sm font-medium">Status</label>
                            <select name="status" id="statusSelect"
                                class="input" required onchange="changeStatusColor(this)">
                                <option value="">-- Pilih Status --</option>
                                <option value="UNDER">UNDER</option>
                                <option value="AMAN">AMAN</option>
                                <option value="BAGUS">BAGUS</option>
                            </select>
                        </div>

                    </div>

                    {{-- KETERANGAN --}}
                    <div>
    <label class="text-sm font-medium">Keterangan</label>

    <textarea 
        name="keterangan" 
        id="keteranganInput"
        class="input w-full"
        maxlength="100"
        oninput="updateCharCount()"
    ></textarea>

    {{-- COUNTER --}}
    <div class="text-xs text-gray-400 mt-1 text-right">
        <span id="charCount">0</span> / 100 karakter
    </div>
</div>

                </form>

            </div>

            {{-- FOOTER (FIXED) --}}
            <div class="flex justify-end gap-2 px-6 py-4 border-t bg-white">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </button>
                <button formmethod="POST" formaction="/spekpc/store"
                    onclick="document.querySelector('#modal form').submit()"
                    class="px-4 py-2 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function changeStatusColor(select) {
    const value = select.value;

    select.style.backgroundColor = '';
    select.style.color = '';

    if (value === 'UNDER') {
        select.style.backgroundColor = '#fee2e2';
        select.style.color = '#b91c1c';
    } 
    else if (value === 'AMAN') {
        select.style.backgroundColor = '#fef9c3';
        select.style.color = '#92400e';
    } 
    else if (value === 'BAGUS') {
        select.style.backgroundColor = '#dcfce7';
        select.style.color = '#166534';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('statusSelect');
    if (select) changeStatusColor(select);
});
</script>
<script>
function updateCharCount() {
    const input = document.getElementById('keteranganInput');
    const counter = document.getElementById('charCount');

    counter.innerText = input.value.length;
}
</script>
<script>
function toggleMerkInput(select) {
    const custom = document.getElementById('merkCustom');

    if (select.value === 'Other') {
        custom.classList.remove('hidden');
    } else {
        custom.classList.add('hidden');
        custom.value = '';
    }
}
</script>
<script>
function toggleDeptInput(select) {
    const custom = document.getElementById('deptCustom');

    if (select.value === 'Other') {
        custom.classList.remove('hidden');
        custom.required = true;
    } else {
        custom.classList.add('hidden');
        custom.value = '';
        custom.required = false;
    }
}
</script>