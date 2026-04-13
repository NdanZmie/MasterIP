@extends('layouts.app')

@section('content')

{{-- HEADER + SEARCH --}}
<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold text-gray-800">Data PC</h1>

    <form method="GET" action="/data" class="flex gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari data..."
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <button 
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
        >
            Search
        </button>

        {{-- CLEAR --}}
        @if(request('search'))
        <a href="/data" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
            Reset
        </a>
        @endif
    </form>

</div>

<div class="bg-white rounded-2xl shadow-lg p-6">

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-600 border border-gray-200 rounded-lg overflow-hidden">

            {{-- HEADER --}}
            <thead class="bg-gray-800 text-white text-center">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">IP</th>
                    <th class="px-4 py-3">Computer Name</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIK</th>
                    <th class="px-4 py-3">Dept</th>
                    <th class="px-4 py-3">OS</th>
                    <th class="px-4 py-3">Merk CPU</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="text-center">
                @forelse ($data as $row)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-2">{{ $row->no }}</td>
                    <td class="px-4 py-2">{{ $row->ip }}</td>
                    <td class="px-4 py-2">{{ $row->computer_name }}</td>
                    <td class="px-4 py-2">{{ $row->nama }}</td>
                    <td class="px-4 py-2">{{ $row->nik }}</td>
                    <td class="px-4 py-2">{{ $row->departemen }}</td>
                    <td class="px-4 py-2">{{ $row->os }}</td>
                    <td class="px-4 py-2">{{ $row->merk_cpu }}</td>

                    {{-- STATUS --}}
                    <td class="px-4 py-2">
                        @if ($row->status == 'SUDAH')
                            <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                SUDAH
                            </span>
                        @elseif ($row->status == 'NOK')
                            <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                NOK
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-200 rounded-full">
                                {{ $row->status }}
                            </span>
                        @endif
                    </td>

                    {{-- KETERANGAN --}}
                    <td class="px-4 py-2 text-left">
                        {{ $row->keterangan }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-6 text-gray-500">
                        Data tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6 flex justify-center">
        <nav>
            <ul class="flex items-center -space-x-px text-sm">

                {{-- Previous --}}
                @if ($data->onFirstPage())
                    <li>
                        <span class="px-3 h-9 flex items-center text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg">
                            Previous
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $data->previousPageUrl() }}" 
                           class="px-3 h-9 flex items-center text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 rounded-l-lg">
                            Previous
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $data->lastPage(); $i++)
                    <li>
                        <a href="{{ $data->url($i) }}"
                           class="w-9 h-9 flex items-center justify-center border border-gray-300
                           {{ $data->currentPage() == $i 
                                ? 'bg-blue-500 text-white' 
                                : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                {{-- Next --}}
                @if ($data->hasMorePages())
                    <li>
                        <a href="{{ $data->nextPageUrl() }}" 
                           class="px-3 h-9 flex items-center text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 rounded-r-lg">
                            Next
                        </a>
                    </li>
                @else
                    <li>
                        <span class="px-3 h-9 flex items-center text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg">
                            Next
                        </span>
                    </li>
                @endif

            </ul>
        </nav>
    </div>

</div>

@endsection