<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Datapc;
use Illuminate\Http\Request;
use App\Models\Spekpc;

Route::get('/data', function (Request $request) {

    $search = trim($request->search);

    $data = Datapc::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ip', 'like', "%{$search}%")
                  ->orWhere('computer_name', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('departemen', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%")
                  ->orWhere('merk_cpu', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        })
        ->orderBy('no', 'asc') // 🔥 biar urut rapi
        ->paginate(10)
        ->withQueryString();

    return view('pages.data_all', [
        'data' => $data,
        'search' => $search
    ]);
});


// pages home
Route::get('/home', function () {
    return view('pages.home');
});

// pages logout
Route::get('/logout', function () {
    return view('pages.home');
});

//
// 🔥 STORE DATA
//
Route::post('/spekpc/store', function (Request $request) {

    $validated = $request->validate([
        'ip' => 'required',
        'nama' => 'required',
        'dept' => 'required',

        // 🔥 FIELD BARU
        'dat' => 'nullable',
        'sn' => 'nullable',
        'lisensi_windows' => 'nullable',
        'lisensi_office' => 'nullable',
        'merk' => 'nullable',

        // EXISTING
        'processor' => 'nullable',
        'ram' => 'nullable',
        'storage' => 'nullable',
        'windows' => 'nullable',

        'status' => 'required|in:UNDER,AMAN,BAGUS',
        'keterangan' => 'nullable',
    ]);

    // ✅ Normalisasi status
    $validated['status'] = strtoupper(trim($validated['status']));

    // ✅ Optional field default (hindari error DB)
    $validated['dat'] = $validated['dat'] ?? null;
    $validated['sn'] = $validated['sn'] ?? null;
    $validated['lisensi_windows'] = $validated['lisensi_windows'] ?? null;
    $validated['lisensi_office'] = $validated['lisensi_office'] ?? null;

    $validated['processor'] = $validated['processor'] ?? null;
    $validated['ram'] = $validated['ram'] ?? null;
    $validated['storage'] = $validated['storage'] ?? null;
    $validated['windows'] = $validated['windows'] ?? null;
    $validated['keterangan'] = $validated['keterangan'] ?? null;

    Spekpc::create($validated);

    return redirect('/spekpc')->with('success', 'Data berhasil ditambahkan');
});
// 🔥 GET DATA + SEARCH + PAGINATION
Route::get('/spekpc', function (Request $request) {

    $search = trim($request->search);
    $sort = $request->get('sort', 'id');
    $direction = $request->get('direction', 'asc');

    $data = \App\Models\Spekpc::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ip', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('dept', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        });

// 🔥 FIX SORTING
// 🔥 SORTING UNIVERSAL
if ($sort == 'status') {

    $order = $direction === 'asc' ? 'ASC' : 'DESC';

    $data = $data->orderByRaw("
        CASE 
            WHEN UPPER(TRIM(status)) = 'UNDER' THEN 1
            WHEN UPPER(TRIM(status)) = 'AMAN' THEN 2
            WHEN UPPER(TRIM(status)) = 'BAGUS' THEN 3
            ELSE 4
        END $order
    ")->orderBy('id', 'asc');

} elseif ($sort == 'ip') {

    // 🔥 SORT IP BIAR BENAR (BUKAN STRING)
    $data = $data->orderByRaw("INET_ATON(ip) $direction");

} elseif ($sort == 'nama' || $sort == 'dept' || $sort == 'keterangan') {

    // 🔥 NORMAL TEXT SORT (ANTI SPASI & CASE)
    $data = $data->orderByRaw("LOWER(TRIM($sort)) $direction");

} else {

    // 🔥 DEFAULT
    $data = $data->orderBy($sort, $direction);

}

    $data = $data->paginate(10)->withQueryString();

    return view('pages.spekpc', compact('data','search','sort','direction'));
});

Route::delete('/spekpc/delete/{id}', function ($id) {
    \App\Models\Spekpc::findOrFail($id)->delete();
    return redirect('/spekpc')->with('success', 'Data berhasil dihapus');
});

Route::put('/spekpc/update/{id}', function (Request $request, $id) {
    \App\Models\Spekpc::findOrFail($id)->update($request->all());
    return redirect('/spekpc')->with('success', 'Data berhasil diupdate');
});


// EXPORT KE CSV DAN EXCEL
Route::get('/spekpc/export/excel', function () {

    $data = \App\Models\Spekpc::all();

    $filename = "spekpc.xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $content = "<table border='1'>
        <tr>
            <th>IP</th><th>Nama</th><th>Dept</th><th>DAT</th><th>SN</th><th>Merk</th>
            <th>Processor</th><th>RAM</th><th>Storage</th><th>Windows</th>
            <th>Lisensi Windows</th><th>Lisensi Office</th>
            <th>Status</th><th>Keterangan</th>
        </tr>";

    foreach ($data as $row) {
        $content .= "<tr>
            <td>{$row->ip}</td>
            <td>{$row->nama}</td>
            <td>{$row->dept}</td>
            <td>{$row->dat}</td>
            <td>{$row->sn}</td>
            <td>{$row->merk}</td>
            <td>{$row->processor}</td>
            <td>{$row->ram}</td>
            <td>{$row->storage}</td>
            <td>{$row->windows}</td>
            <td>{$row->lisensi_windows}</td>
            <td>{$row->lisensi_office}</td>
            <td>{$row->status}</td>
            <td>{$row->keterangan}</td>
        </tr>";
    }

    $content .= "</table>";

    return response($content, 200, $headers);
});
Route::get('/spekpc/export/csv', function () {

    $data = \App\Models\Spekpc::all();

    $filename = "spekpc.csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        // header kolom
        fputcsv($file, [
            'IP','Nama','Dept','DAT','SN','Merk',
            'Processor','RAM','Storage','Windows',
            'Lisensi Windows','Lisensi Office',
            'Status','Keterangan'
        ]);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->ip,
                $row->nama,
                $row->dept,
                $row->dat,
                $row->sn,
                $row->merk,
                $row->processor,
                $row->ram,
                $row->storage,
                $row->windows,
                $row->lisensi_windows,
                $row->lisensi_office,
                $row->status,
                $row->keterangan,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
});