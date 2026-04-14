@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <h2 class="text-2xl font-bold text-gray-800">Command Clipboard</h2>
    <p class="text-sm text-gray-500">Klik tombol untuk copy command</p>

    {{-- LIST COMMAND --}}
    <div class="bg-white rounded-xl shadow border p-4 space-y-3">

        {{-- ITEM --}}
        @php
        $commands = [
            "wmic cpu get name",
            "wmic bios get serialnumber",
            "powershell \"[math]::Round((Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory/1GB)\"",
            "wmic diskdrive get size",
            "powershell \"Get-CimInstance Win32_DiskDrive | Select Model,@{Name='Size(GB)';Expression={[math]::Round(\$_.Size/1GB)}}\"",
            "wmic os get osarchitecture",
            "wmic path softwarelicensingservice get OA3xOriginalProductKey"
        ];
        @endphp

        @foreach($commands as $index => $cmd)
        <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">

            <code class="text-sm text-gray-800 break-all">
                {{ $cmd }}
            </code>

            <button onclick="copyText({{ $index }})"
                class="ml-3 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                Copy
            </button>

            <input type="hidden" id="cmd-{{ $index }}" value="{{ $cmd }}">
        </div>
        @endforeach

    </div>

    {{-- COPY ALL --}}
    <div class="text-center">
        <button onclick="copyAll()"
            class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded">
            Copy All
        </button>
    </div>

</div>


{{-- SCRIPT --}}
<script>
function copyText(index) {
    const text = document.getElementById('cmd-' + index).value;

    navigator.clipboard.writeText(text).then(() => {
        alert('Copied!');
    });
}

function copyAll() {
    let all = '';

    @foreach($commands as $index => $cmd)
        all += document.getElementById('cmd-{{ $index }}').value + "\n";
    @endforeach

    navigator.clipboard.writeText(all).then(() => {
        alert('Semua command berhasil dicopy!');
    });
}
</script>

@endsection