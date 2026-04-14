{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    {{-- BACKDROP --}}
    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">

        {{-- CONTAINER --}}
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg flex flex-col max-h-[90vh]">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-4 border-b bg-white">
                <h3 class="text-lg font-bold">Edit Data</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500">✕</button>
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

                        <div>
                            <label class="text-sm font-medium">Nama</label>
                            <input id="edit_nama" name="nama" class="input" required>
                        </div>

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
                            <label class="text-sm font-medium">DAT</label>
                            <input id="edit_dat" name="dat" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Serial Number (SN)</label>
                            <input id="edit_sn" name="sn" class="input">
                        </div>

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
                            <label class="text-sm font-medium">Processor</label>
                            <input id="edit_processor" name="processor" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">RAM</label>
                            <input id="edit_ram" name="ram" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Storage</label>
                            <input id="edit_storage" name="storage" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Windows</label>
                            <input id="edit_windows" name="windows" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Lisensi Windows</label>
                            <input id="edit_lisensi_windows" name="lisensi_windows" class="input">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Lisensi Office</label>
                            <input id="edit_lisensi_office" name="lisensi_office" class="input">
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
                <button onclick="document.getElementById('editForm').submit()"
                    class="px-4 py-2 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>


<script>
// OPEN MODAL
function openEditModal(data){
    
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('editForm').action = '/spekpc/update/' + data.id;

    for (const key in data) {
        const el = document.getElementById('edit_' + key);
        if (el) el.value = data[key] ?? '';
    }

    // 🔥 SET WARNA STATUS SAAT LOAD
    const status = document.getElementById('edit_status');
    if (status) changeEditStatusColor(status);
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
