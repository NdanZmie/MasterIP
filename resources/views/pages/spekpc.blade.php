@extends('layouts.app')

@section('content')
<div class="space-y-6">

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



@php
function sort_link($column, $label, $sort, $direction) {
    $newDirection = ($sort == $column && $direction == 'asc') ? 'desc' : 'asc';
    $arrow = '';

    if ($sort == $column) {
        $arrow = $direction == 'asc' ? '↑' : '↓';
    }

    $query = request()->query();
    $query['sort'] = $column;
    $query['direction'] = $newDirection;

    $url = '?' . http_build_query($query);

    return "<a href='$url' class='hover:text-blue-500'>$label $arrow</a>";
}
@endphp




    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">{!! sort_link('ip','IP',$sort,$direction) !!}</th>
                        <th class="px-4 py-3">{!! sort_link('nama','Nama',$sort,$direction) !!}</th>
                        <th class="px-4 py-3">{!! sort_link('dept','Dept',$sort,$direction) !!}</th>
                        <th class="px-4 py-3 text-center">Detail</th>
                        <th class="px-4 py-3 text-center">{!! sort_link('status','Status',$sort,$direction) !!}</th>
                        <th class="px-4 py-3 w-[220px] max-w-[220px]">
    {!! sort_link('keterangan','Keterangan',$sort,$direction) !!}
</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($data as $item)

                        @php
                            $status = strtoupper(trim($item->status));

                            if ($status == 'UNDER') {
                                $color = 'bg-red-100 text-red-700';
                            } elseif ($status == 'AMAN') {
                                $color = 'bg-yellow-100 text-yellow-700';
                            } elseif ($status == 'BAGUS') {
                                $color = 'bg-green-100 text-green-700';
                            } else {
                                $color = 'bg-gray-100 text-gray-500';
                            }
                        @endphp

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
                                <span class="px-3 py-1 rounded-full text-xs {{ $color }}">
                                    {{ $status }}
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


// EDIT (AMAN - TIDAK GANGGU SCRIPT LAIN)
function openEditModal(data){
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('editForm').action = '/spekpc/update/' + data.id;

    for (const key in data) {
        const el = document.getElementById('edit_' + key);
        if (el) {
            el.value = data[key] ?? '';
        }
    }
}

function closeEditModal(){
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

@endsection