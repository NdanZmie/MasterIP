@extends('layouts.app')

@section('content')
<div class="space-y-6 min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('aset/bgwhite.jpg') }}');">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Spek PC</h2>
            <p class="text-sm text-gray-500">Daftar spesifikasi komputer</p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">

            {{-- SEARCH --}}
            <form method="GET" class="flex items-center bg-white border rounded-full shadow-sm overflow-hidden">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}" 
                    placeholder="Cari data..."
                    class="px-4 py-2 w-48 md:w-64 outline-none"
                >
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2">
                    Cari
                </button>
            </form>

            {{-- TAMBAH --}}
            <div class="flex gap-2">

    <button onclick="openModal()" 
        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full shadow">
        + Tambah
    </button>

    <a href="/spekpc/export/excel"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full shadow">
        Export Excel
    </a>

    <a href="/spekpc/export/csv"
        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-full shadow">
        Export CSV
    </a>

</div>

        </div>

    </div>

    {{-- NOTIF --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif


    {{-- TABLE --}}
    <div class="bg-white/50 backdrop-blur-sm rounded-xl shadow border border-white/30 overflow-hidden">        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>

                            <th class="px-4 py-3">
                                <a href="?sort=ip&direction={{ $sort=='ip' && $direction=='asc' ? 'desc':'asc' }}">
                                    IP
                                </a>
                            </th>

                            <th class="px-4 py-3">
                                <a href="?sort=nama&direction={{ $sort=='nama' && $direction=='asc' ? 'desc':'asc' }}">
                                    Nama
                                </a>
                            </th>

                            <th class="px-4 py-3">
                                <a href="?sort=dept&direction={{ $sort=='dept' && $direction=='asc' ? 'desc':'asc' }}">
                                    Dept
                                </a>
                            </th>

                            <th class="px-4 py-3 text-center">Detail</th>

                            <th class="px-4 py-3 text-center">
                                <a href="?sort=status&direction={{ $sort=='status' && $direction=='asc' ? 'desc':'asc' }}">
                                    Status
                                </a>
                            </th>

                            <th class="px-4 py-3 w-[220px] max-w-[220px]">
                                <a href="?sort=keterangan&direction={{ $sort=='keterangan' && $direction=='asc' ? 'desc':'asc' }}">
                                    Keterangan
                                </a>
                            </th>

                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                <tbody class="divide-y">
                    @foreach ($data as $item)
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-3">
                                {{ $data->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3">{{ $item->ip }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $item->nama }}</td>
                            <td class="px-4 py-3">{{ $item->dept }}</td>

                            {{-- DETAIL ACCORDION --}}
                            <td class="px-4 py-3">
                                <button onclick="toggleDetail({{ $item->id }}, this)"
                                    class="text-blue-500 hover:underline text-sm">
                                    ▼ View Detail
                                </button>

                                <div id="detail-{{ $item->id }}" 
                                     class="max-h-0 overflow-hidden transition-all duration-300 text-xs leading-relaxed">

                                    <div class="mt-2">
                                        <div><b>DAT:</b> {{ $item->dat ?? '-' }}</div>
                                        <div><b>SN:</b> {{ $item->sn ?? '-' }}</div>
                                        <div><b>Merk:</b> {{ $item->merk ?? '-' }}</div>
                                        <div><b>CPU:</b> {{ $item->processor ?? '-' }}</div>
                                        <div><b>RAM:</b> {{ $item->ram ?? '-' }}</div>
                                        <div><b>Storage:</b> {{ $item->storage ?? '-' }}</div>
                                        <div><b>Windows:</b> {{ $item->windows ?? '-' }}</div>
                                        <div><b>Lisensi Win:</b> {{ $item->lisensi_windows ?? '-' }}</div>
                                        <div><b>Lisensi Office:</b> {{ $item->lisensi_office ?? '-' }}</div>
                                    </div>

                                </div>

                            </td>

                           <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs {{ $item->status_color }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 w-[220px] max-w-[220px] text-xs break-words whitespace-normal align-top">
                                {{ \Illuminate\Support\Str::limit($item->keterangan, 100) }}
                            </td>
                            <td class="px-4 py-3 text-center align-top">
                                <div class="flex flex-col items-center gap-2">
                                    <button onclick="openDeleteModal({{ $item->id }})"
                                        class="w-[80px] bg-red-500 hover:bg-red-600 text-white py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                    <button onclick='openEditModal(@json($item))'
                                        class="w-[80px] bg-yellow-500 hover:bg-yellow-600 text-white py-1 rounded text-xs">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} 
                of {{ $data->total() }} results
            </div>
            <div class="flex items-center gap-1">
                @if ($data->onFirstPage())
                    <span class="px-3 py-1 bg-gray-200 text-gray-400 rounded">←</span>
                @else
                    <a href="{{ $data->previousPageUrl() }}" 
                       class="px-3 py-1 bg-white border rounded hover:bg-gray-100">←</a>
                @endif
                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if ($page == $data->currentPage())
                        <span class="px-3 py-1 bg-blue-500 text-white rounded">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-3 py-1 bg-white border rounded hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if ($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}" 
                       class="px-3 py-1 bg-white border rounded hover:bg-gray-100">→</a>
                @else
                    <span class="px-3 py-1 bg-gray-200 text-gray-400 rounded">→</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
@include('aset.modal_tambah_spekpc')
@include('aset.modal_delete_spekpc')
@include('aset.modal_edit_spekpc')

<style>
.input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}
</style>

<script>
let activeDetail = null;

function toggleDetail(id, btn) {
    const el = document.getElementById('detail-' + id);

    // tutup yang lain
    if (activeDetail && activeDetail !== el) {
        activeDetail.style.maxHeight = '0px';
        activeDetail.previousElementSibling.innerText = '▼ View Detail';
    }

    if (el.style.maxHeight && el.style.maxHeight !== '0px') {
        el.style.maxHeight = '0px';
        btn.innerText = '▼ View Detail';
        activeDetail = null;
    } else {
        el.style.maxHeight = el.scrollHeight + "px";
        btn.innerText = '▲ Hide Detail';
        activeDetail = el;
    }
}

// MODAL TAMBAH
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

// DELETE
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
    if (document.getElementById('deletePassword').value !== '121233') {
        e.preventDefault();
        alert('Password salah!');
    }
});

// FUNCTION EDIT

function openEditModal(data){
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('editForm').action = '/spekpc/update/' + data.id;
    for (const key in data) {
        const el = document.getElementById('edit_' + key);
        if (el) el.value = data[key] ?? '';
    }
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
    const status = document.getElementById('edit_status');
    if (status) changeEditStatusColor(status);
    // ======================
    // STORAGE
    // ======================
    const storageSelect = document.getElementById('edit_storage_select');
    const storageCustom = document.getElementById('edit_storage_custom');

    const storageOptions = [
        "HDD 500 GB","HDD 1 TB",
        "SSD Sata 500GB","SSD Sata 1 TB",
        "NVME 500GB","NVME 1 TB"
    ];

    if (storageOptions.includes(data.storage)) {
        storageSelect.value = data.storage;
        storageCustom.classList.add('hidden');
        storageCustom.value = '';
    } else {
        storageSelect.value = 'Other';
        storageCustom.classList.remove('hidden');
        storageCustom.value = data.storage || '';
    }
    // ======================
    // WINDOWS
    // ======================
    const winSelect = document.getElementById('edit_windows_select');
    const winCustom = document.getElementById('edit_windows_custom');

    const winOptions = [
        "Windows 7 32 Bit",
        "Windows 7 64 Bit",
        "Windows 10 32 Bit",
        "Windows 10 64 Bit",
        "Windows 11 64 Bit"
    ];

    if (winOptions.includes(data.windows)) {
        winSelect.value = data.windows;
        winCustom.classList.add('hidden');
        winCustom.value = '';
    } else {
        winSelect.value = 'Other';
        winCustom.classList.remove('hidden');
        winCustom.value = data.windows || '';
    }


    // ======================
    // PROCESSOR
    // ======================
    const procSelect = document.getElementById('edit_processor_select');
    const procCustom = document.getElementById('edit_processor_custom');

    const procOptions = [
        "Intel(R) Pentium(R) G3220 CPU @ 3.20GHz",
        "Intel(R) Pentium(R) G3230 CPU @ 3.20GHz",
        "Intel(R) Pentium(R) G3240 CPU @ 3.10GHz",
        "Intel(R) Pentium(R) G3250 CPU @ 3.20GHz",
        "Intel(R) Pentium(R) Gold G6400 CPU @ 4.00GHz",
        "Intel(R) Pentium(R) Gold G7400 CPU @ 3.70GHz",
        "Intel(R) Pentium(R) Gold G4400 CPU @ 3.30GHz",
        "Intel(R) Core(TM) i5-7400 CPU @ 3.00GHz",
        "Intel(R) Core(TM) i3-10100 CPU @ 4.30GHz",
        "Intel(R) Core(TM) i3-10105 CPU @ 4.40GHz",
        "Intel(R) Core(TM) i5-10400 CPU @ 4.30GHz"
    ];

    if (procOptions.includes(data.processor)) {
        procSelect.value = data.processor;
        procCustom.classList.add('hidden');
        procCustom.value = '';
    } else {
        procSelect.value = 'Other';
        procCustom.classList.remove('hidden');
        procCustom.value = data.processor || '';
    }
}
</script>

@endsection