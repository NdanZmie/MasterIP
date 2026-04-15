{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">

        {{-- CONTAINER --}}
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg flex flex-col max-h-[90vh]">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-4 border-b bg-white">
                <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                    Edit Data
                </h3>
                <button onclick="closeEditModal()" 
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-100 text-gray-400 hover:text-red-500 transition">
                    ✕
                </button>
            </div>

            {{-- BODY (SCROLL) --}}
            <div class="p-6 overflow-y-auto">

                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium">IP</label>
                            <input id="edit_ip" name="ip" class="input" required>
                        </div>

{{-- Dept --}}

                        <div>
                            <label class="text-sm font-medium">Dept</label>

                            <select id="edit_dept_select" name="dept" class="input" onchange="toggleEditDeptInput(this)" required>
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

                            <input type="text" id="edit_dept_custom" name="dept_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi dept lainnya...">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Nama</label>
                            <input id="edit_nama" name="nama" class="input" required>
                        </div>

{{-- Merk --}}

                        <div>
                            <label class="text-sm font-medium">Merk</label>

                            <select id="edit_merk_select" name="merk" class="input" onchange="toggleEditMerkInput(this)">
                                <option value="">-- Pilih Merk --</option>
                                <option value="ZYREX">ZYREX</option>
                                <option value="WEARNES">WEARNES</option>
                                <option value="GEAR">GEAR</option>
                                <option value="ACER">ACER</option>
                                <option value="HP">HP</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="text" id="edit_merk_custom" name="merk_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi merk lainnya...">
                        </div>

                        <div>
                            <label class="text-sm font-medium">DAT</label>
                            <input id="edit_dat" name="dat" class="input">
                        </div>


{{-- Processor --}}
                        <div>
                            <label class="text-sm font-medium">Processor</label>

                            <select id="edit_processor_select" name="processor" class="input" onchange="toggleEditProcessorInput(this)">
                                <option value="">-- Pilih Processor --</option>

                                <option value="Intel(R) Pentium(R) G3220 CPU @ 3.20GHz">Intel(R) Pentium(R) G3220 CPU @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) G3230 CPU @ 3.20GHz">Intel(R) Pentium(R) G3230 CPU @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) G3240 CPU @ 3.10GHz">Intel(R) Pentium(R) G3240 CPU @ 3.10GHz</option>
                                <option value="Intel(R) Pentium(R) G3250 CPU @ 3.20GHz">Intel(R) Pentium(R) G3250 CPU @ 3.20GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G6400 CPU @ 4.00GHz">Intel(R) Pentium(R) Gold G6400 CPU @ 4.00GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G7400 CPU @ 3.70GHz">Intel(R) Pentium(R) Gold G7400 CPU @ 3.70GHz</option>
                                <option value="Intel(R) Pentium(R) Gold G4400 CPU @ 3.30GHz">Intel(R) Pentium(R) Gold G4400 CPU @ 3.30GHz</option>
                                <option value="Intel(R) Core(TM) i5-7400 CPU @ 3.00GHz">Intel(R) Core(TM) i5-7400 CPU @ 3.00GHz</option>
                                <option value="Intel(R) Core(TM) i3-10100 CPU @ 4.30GHz">Intel(R) Core(TM) i3-10100 CPU @ 4.30GHz</option>
                                <option value="Intel(R) Core(TM) i3-10105 CPU @ 4.40GHz">Intel(R) Core(TM) i3-10105 CPU @ 4.40GHz</option>
                                <option value="Intel(R) Core(TM) i5-10400 CPU @ 4.30GHz">Intel(R) Core(TM) i5-10400 CPU @ 4.30GHz</option>

                                <option value="Other">Other</option>
                            </select>

                            <input type="text" id="edit_processor_custom" name="processor_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi processor lainnya...">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Serial Number (SN)</label>
                            <input id="edit_sn" name="sn" class="input">
                        </div>



                        <div>
                            <label class="text-sm font-medium">RAM</label>

                            <select id="edit_ram_select" name="ram" class="input" onchange="toggleEditRamInput(this)">
                                <option value="">-- Pilih RAM --</option>
                                <option value="2 GB">2 GB</option>
                                <option value="4 GB">4 GB</option>
                                <option value="6 GB">6 GB</option>
                                <option value="8 GB">8 GB</option>
                                <option value="12 GB">12 GB</option>
                                <option value="16 GB">16 GB</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="text" id="edit_ram_custom" name="ram_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi RAM lainnya...">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Lisensi Windows</label>
                            <input id="edit_lisensi_windows" name="lisensi_windows" class="input">
                        </div>
{{-- Windows --}}
                       <div>
                            <label class="text-sm font-medium">Windows</label>

                            <select id="edit_windows_select" name="windows" class="input" onchange="toggleEditWindowsInput(this)">
                                <option value="">-- Pilih Windows --</option>
                                <option value="Windows 7 32 Bit">Windows 7 32 Bit</option>
                                <option value="Windows 7 64 Bit">Windows 7 64 Bit</option>
                                <option value="Windows 10 32 Bit">Windows 10 32 Bit</option>
                                <option value="Windows 10 64 Bit">Windows 10 64 Bit</option>
                                <option value="Windows 11 64 Bit">Windows 11 64 Bit</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="text" id="edit_windows_custom" name="windows_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi Windows lainnya...">
                        </div>


                        
                        <div>
                            <label class="text-sm font-medium">Lisensi Office</label>
                            <input id="edit_lisensi_office" name="lisensi_office" class="input">
                        </div>

{{-- Storage --}}

                        <div>
                            <label class="text-sm font-medium">Storage</label>

                            <select id="edit_storage_select" name="storage" class="input" onchange="toggleEditStorageInput(this)">
                                <option value="">-- Pilih Storage --</option>
                                <option value="HDD 500 GB">HDD 500 GB</option>
                                <option value="HDD 1 TB">HDD 1 TB</option>
                                <option value="SSD Sata 500GB">SSD Sata 500GB</option>
                                <option value="SSD Sata 1 TB">SSD Sata 1 TB</option>
                                <option value="NVME 500GB">NVME 500GB</option>
                                <option value="NVME 1 TB">NVME 1 TB</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="text" id="edit_storage_custom" name="storage_custom"
                                class="input mt-2 hidden"
                                placeholder="Isi storage lainnya...">
                        </div>


                        {{-- STATUS --}}
                        <div>
                            <label class="text-sm font-medium">Status</label>
                            <select id="edit_status" name="status"
                                class="input" required onchange="changeEditStatusColor(this)">
                                <option value="">-- Pilih Status --</option>
                                <option value="UNDER">UNDER</option>
                                <option value="AMAN">AMAN</option>
                                <option value="BAGUS">BAGUS</option>
                            </select>
                        </div>

                    </div>

                    {{-- KETERANGAN --}}
                    <textarea 
    id="edit_keterangan" 
    name="keterangan" 
    class="input w-full"
    maxlength="100"
    oninput="updateEditCharCount()"
></textarea>

{{-- COUNTER --}}
<div class="text-xs text-gray-400 mt-1 text-right">
    <span id="editCharCount">0</span> / 100 karakter
</div>

                </form>

            </div>

            {{-- FOOTER --}}
            <div class="flex justify-end gap-2 px-6 py-4 border-t bg-white">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </button>
                <button type="submit" form="editForm"
                    class="px-4 py-2 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>


<style>
.input {
    @apply w-full px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-800
    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
    transition duration-200 shadow-sm;
}
</style>

<script>

function openEditModal(data){
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('editForm').action = '/spekpc/update/' + data.id;

    // ======================
    // INPUT BIASA
    // ======================
    for (const key in data) {
        const el = document.getElementById('edit_' + key);
        if (el) el.value = data[key] ?? '';
    }

    // ======================
    // DEPT
    // ======================
    const deptSelect = document.getElementById('edit_dept_select');
    const deptCustom = document.getElementById('edit_dept_custom');

    const deptOptions = [
        "EDP","BIC","HRD","GA","FIN","DEV","LOC","LICENSE",
        "MKT-FRC","PROJ","MTC","AREA","MD","DC","HRD-TC"
    ];

    if (deptOptions.includes(data.dept)) {
        deptSelect.value = data.dept;
        deptCustom.classList.add('hidden');
        deptCustom.value = '';
    } else {
        deptSelect.value = 'Other';
        deptCustom.classList.remove('hidden');
        deptCustom.value = data.dept || '';
    }

    // ======================
    // MERK
    // ======================
    const merkSelect = document.getElementById('edit_merk_select');
    const merkCustom = document.getElementById('edit_merk_custom');

    const merkOptions = ["ZYREX","WEARNES","GEAR","ACER","HP"];

    if (merkOptions.includes(data.merk)) {
        merkSelect.value = data.merk;
        merkCustom.classList.add('hidden');
        merkCustom.value = '';
    } else {
        merkSelect.value = 'Other';
        merkCustom.classList.remove('hidden');
        merkCustom.value = data.merk || '';
    }

    // ======================
    // RAM
    // ======================
    const ramSelect = document.getElementById('edit_ram_select');
    const ramCustom = document.getElementById('edit_ram_custom');

    const ramOptions = ["2 GB","4 GB","6 GB","8 GB","12 GB","16 GB"];

    if (ramOptions.includes(data.ram)) {
        ramSelect.value = data.ram;
        ramCustom.classList.add('hidden');
        ramCustom.value = '';
    } else {
        ramSelect.value = 'Other';
        ramCustom.classList.remove('hidden');
        ramCustom.value = data.ram || '';
    }
}

// CLOSE
function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}

// WARNA STATUS
function changeEditStatusColor(select) {
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
</script>
<script>
function updateEditCharCount() {
    const input = document.getElementById('edit_keterangan');
    const counter = document.getElementById('editCharCount');

    const length = input.value.length;
    counter.innerText = length;

    // OPTIONAL warna
    if (length > 80) {
        counter.style.color = 'red';
    } else {
        counter.style.color = '';
    }
}
</script>
<script>
function toggleEditMerkInput(select) {
    const custom = document.getElementById('edit_merk_custom');

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
<script>
function toggleEditDeptInput(select) {
    const custom = document.getElementById('edit_dept_custom');

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
<script>
function toggleEditRamInput(select) {
    const custom = document.getElementById('edit_ram_custom');

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
<script>
function toggleEditStorageInput(select) {
    const custom = document.getElementById('edit_storage_custom');

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
<script>
function toggleEditWindowsInput(select) {
    const custom = document.getElementById('edit_windows_custom');

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
<script>
function toggleEditProcessorInput(select) {
    const custom = document.getElementById('edit_processor_custom');

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