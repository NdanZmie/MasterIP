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
        $search = trim($request->search);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        $data = Spekpc::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ip', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('dept', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            });

        // SORT KHUSUS
        if ($sort == 'status') {
            $data = $data->orderByRaw("
                CASE 
                    WHEN status = 'UNDER' THEN 1
                    WHEN status = 'AMAN' THEN 2
                    WHEN status = 'BAGUS' THEN 3
                    ELSE 4
                END $direction
            ");
        } else {
            $data = $data->orderBy($sort, $direction);
        }

        $data = $data->paginate(10)->withQueryString();

        return view('pages.spekpc', compact('data','search','sort','direction'));
    }

    // =======================
    // STORE (TAMBAH)
    // =======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip' => 'required',
            'nama' => 'required',
            'dept' => 'required',
            'status' => 'required|in:UNDER,AMAN,BAGUS',
        ]);

        // HANDLE DEPT
        $validated['dept'] = $request->dept === 'Other'
            ? $request->dept_custom
            : $request->dept;

        // HANDLE MERK
        $validated['merk'] = $request->merk === 'Other'
            ? $request->merk_custom
            : $request->merk;

        // HANDLE RAM
        $validated['ram'] = $request->ram === 'Other'
            ? $request->ram_custom
            : $request->ram;

        // Handle Storage
        $validated['storage'] = $request->storage === 'Other'
        ? $request->storage_custom
        : $request->storage;

        // Handle Windows
        $validated['windows'] = $request->windows === 'Other'
        ? $request->windows_custom
        : $request->windows;

        // Handle Processor
        $validated['processor'] = $request->processor === 'Other'
        ? $request->processor_custom
        : $request->processor;
        
        $validated['status'] = strtoupper(trim($request->status));
        Spekpc::create($request->merge($validated)->all());

        return redirect('/spekpc')->with('success', 'Data berhasil ditambahkan');
    }

    // =======================
    // UPDATE (EDIT)
    // =======================
    public function update(Request $request, $id)
    {
    $data = Spekpc::findOrFail($id);

    $validated = $request->all();

    // DEPT
    $validated['dept'] = $request->dept === 'Other'
        ? $request->dept_custom
        : ($request->dept ?: $data->dept);

    // MERK
    $validated['merk'] = $request->merk === 'Other'
        ? $request->merk_custom
        : ($request->merk ?: $data->merk);

    // RAM
    $validated['ram'] = $request->ram === 'Other'
        ? $request->ram_custom
        : ($request->ram ?: $data->ram);
    
    // Storage
    $validated['storage'] = $request->storage === 'Other'
        ? $request->storage_custom
        : ($request->storage ?: $data->storage);

    // Windows
    $validated['windows'] = $request->windows === 'Other'
        ? $request->windows_custom
        : ($request->windows ?: $data->windows);
    
    // Processor
    $validated['processor'] = $request->processor === 'Other'
        ? $request->processor_custom
        : ($request->processor ?: $data->processor);


    $validated['status'] = strtoupper(trim($request->status));
    $data->update($validated);

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

// FUNCTION EXPORT KE EXCEL
    public function exportExcel()
    {
    $data = Spekpc::all();

    $filename = "spekpc.xlsx";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {
        $file = fopen('php://output', 'w');

        // HEADER KOLOM
        fputcsv($file, [
            'IP','Nama','Dept','DAT','SN','Merk',
            'Processor','RAM','Storage','Windows',
            'Lisensi Windows','Lisensi Office','Status','Keterangan'
        ]);

        // DATA
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
    }

// EXPORT KE CSV
public function exportCsv()
    {
    $data = Spekpc::all();

    $filename = "spekpc.csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {
        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'IP','Nama','Dept','DAT','SN','Merk',
            'Processor','RAM','Storage','Windows',
            'Lisensi Windows','Lisensi Office','Status','Keterangan'
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
    }
}