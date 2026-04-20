<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spekpc;

class SpekpcController extends Controller
{
    // =======================
    // INDEX (LIST + SEARCH + SORT)
    // =======================
    public function index(Request $request)
    {
        $search    = trim($request->search);
        $sort      = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        $data = Spekpc::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ip',       'like', "%{$search}%")
                      ->orWhere('compname','like', "%{$search}%")  // ← BARU
                      ->orWhere('nama',    'like', "%{$search}%")
                      ->orWhere('nik',     'like', "%{$search}%")  // ← BARU
                      ->orWhere('dept',    'like', "%{$search}%")
                      ->orWhere('status',  'like', "%{$search}%");
                });
            });

        // SORT KHUSUS STATUS
        if ($sort === 'status') {
            $data = $data->orderByRaw("
                CASE
                    WHEN status = 'UNDER' THEN 1
                    WHEN status = 'AMAN'  THEN 2
                    WHEN status = 'BAGUS' THEN 3
                    ELSE 4
                END {$direction}
            ");
        } else {
            $data = $data->orderBy($sort, $direction);
        }

        $data = $data->paginate(10)->withQueryString();

        return view('pages.spekpc', compact('data', 'search', 'sort', 'direction'));
    }

    // =======================
    // STORE (TAMBAH)
    // =======================
    public function store(Request $request)
    {
        $request->validate([
            'ip'     => 'required',
            'nama'   => 'required',
            'dept'   => 'required',
            'status' => 'required|in:UNDER,AMAN,BAGUS',
        ]);

        Spekpc::create([
            'ip'              => $request->ip,
            'compname'        => $request->compname,                          // ← BARU
            'nama'            => $request->nama,
            'nik'             => $request->nik,                               // ← BARU
            'dept'            => $request->dept === 'Other' ? $request->dept_custom : $request->dept,
            'dat'             => $request->dat,
            'sn'              => $request->sn,
            'merk'            => $request->merk === 'Other' ? $request->merk_custom : $request->merk,
            'processor'       => $request->processor === 'Other' ? $request->processor_custom : $request->processor,
            'ram'             => $request->ram === 'Other' ? $request->ram_custom : $request->ram,
            'storage'         => $request->storage === 'Other' ? $request->storage_custom : $request->storage,
            'windows'         => $request->windows === 'Other' ? $request->windows_custom : $request->windows,
            'lisensi_windows' => $request->lisensi_windows,
            'lisensi_office'  => $request->lisensi_office,
            'status'          => strtoupper(trim($request->status)),
            'keterangan'      => $request->keterangan,
        ]);

        return redirect('/spekpc')->with('success', 'Data berhasil ditambahkan');
    }

    // =======================
    // UPDATE (EDIT)
    // =======================
    public function update(Request $request, $id)
    {
        $data = Spekpc::findOrFail($id);

        $data->update([
            'ip'              => $request->ip              ?? $data->ip,
            'compname'        => $request->compname        ?? $data->compname,   // ← BARU
            'nama'            => $request->nama            ?? $data->nama,
            'nik'             => $request->nik             ?? $data->nik,         // ← BARU
            'dept'            => $request->dept === 'Other'
                                    ? $request->dept_custom
                                    : ($request->dept ?: $data->dept),
            'dat'             => $request->dat,
            'sn'              => $request->sn,
            'merk'            => $request->merk === 'Other'
                                    ? $request->merk_custom
                                    : ($request->merk ?: $data->merk),
            'processor'       => $request->processor === 'Other'
                                    ? $request->processor_custom
                                    : ($request->processor ?: $data->processor),
            'ram'             => $request->ram === 'Other'
                                    ? $request->ram_custom
                                    : ($request->ram ?: $data->ram),
            'storage'         => $request->storage === 'Other'
                                    ? $request->storage_custom
                                    : ($request->storage ?: $data->storage),
            'windows'         => $request->windows === 'Other'
                                    ? $request->windows_custom
                                    : ($request->windows ?: $data->windows),
            'lisensi_windows' => $request->lisensi_windows,
            'lisensi_office'  => $request->lisensi_office,
            'status'          => strtoupper(trim($request->status)),
            'keterangan'      => $request->keterangan,
        ]);

        return redirect('/spekpc')->with('success', 'Data berhasil diupdate');
    }

    // =======================
    // DELETE (HAPUS)
    // =======================
    public function destroy($id)
    {
        Spekpc::findOrFail($id)->delete();
        return redirect('/spekpc')->with('success', 'Data berhasil dihapus');
    }

    // =======================
    // EXPORT EXCEL
    // =======================
    public function exportExcel()
    {
        $data     = Spekpc::all();
        $filename = 'spekpc.xlsx';
        $headers  = [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'IP','Computer Name','Nama','NIK','Dept','DAT','SN','Merk',
                'Processor','RAM','Storage','Windows',
                'Lisensi Windows','Lisensi Office','Status','Keterangan',
            ]);
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->ip, $row->compname, $row->nama, $row->nik,
                    $row->dept, $row->dat, $row->sn, $row->merk,
                    $row->processor, $row->ram, $row->storage, $row->windows,
                    $row->lisensi_windows, $row->lisensi_office,
                    $row->status, $row->keterangan,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =======================
    // EXPORT CSV
    // =======================
    public function exportCsv()
    {
        $data     = Spekpc::all();
        $filename = 'spekpc.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'IP','Computer Name','Nama','NIK','Dept','DAT','SN','Merk',
                'Processor','RAM','Storage','Windows',
                'Lisensi Windows','Lisensi Office','Status','Keterangan',
            ]);
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->ip, $row->compname, $row->nama, $row->nik,
                    $row->dept, $row->dat, $row->sn, $row->merk,
                    $row->processor, $row->ram, $row->storage, $row->windows,
                    $row->lisensi_windows, $row->lisensi_office,
                    $row->status, $row->keterangan,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}