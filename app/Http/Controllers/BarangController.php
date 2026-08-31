<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangLogTransit;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Tampilkan halaman monitoring stok part / barang
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $status = $request->get('status', 'all');
        $divisi = $request->get('divisi', 'all');
        $sort   = $request->get('sort', 'nama_barang');
        $dir    = $request->get('direction', 'asc');

        $query = Barang::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_plu', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('divisi', 'like', "%{$search}%")
                  ->orWhere('satuan', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($divisi !== 'all' && !empty($divisi)) {
            $query->where('divisi', $divisi);
        }

        if ($status === 'habis') {
            $query->where('qty_stock', '<=', 0);
        } elseif ($status === 'menipis') {
            $query->where('qty_stock', '>', 0)->where('qty_stock', '<=', 5);
        } elseif ($status === 'aman') {
            $query->where('qty_stock', '>', 5);
        }

        $allowedSorts = ['id', 'kode_plu', 'nama_barang', 'divisi', 'satuan', 'qty_stock', 'updated_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, strtolower($dir) === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('nama_barang', 'asc');
        }

        $items = $query->paginate(15)->withQueryString();

        // Statistik
        $totalSku = Barang::count();
        $totalStock = (int) Barang::sum('qty_stock');
        $habisCount = Barang::where('qty_stock', '<=', 0)->count();
        $menipisCount = Barang::where('qty_stock', '>', 0)->where('qty_stock', '<=', 5)->count();
        $amanCount = Barang::where('qty_stock', '>', 5)->count();

        // Daftar Toko untuk Datalist Out Manual & Datalist Divisi
        $tokoList = Toko::select('kode_toko', 'nama_toko')->orderBy('kode_toko', 'asc')->get();
        $divisiList = Barang::whereNotNull('divisi')->where('divisi', '!=', '')->distinct()->pluck('divisi');
        $allParts = Barang::orderBy('nama_barang', 'asc')->get();

        return view('pages.part', compact(
            'items',
            'search',
            'status',
            'divisi',
            'sort',
            'dir',
            'totalSku',
            'totalStock',
            'habisCount',
            'menipisCount',
            'amanCount',
            'tokoList',
            'divisiList',
            'allParts'
        ));
    }

    /**
     * Tambah data part / barang baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_plu'    => 'required|string|max:50|unique:barang,kode_plu',
            'nama_barang' => 'required|string|max:150',
            'divisi'      => 'nullable|string|max:100',
            'satuan'      => 'required|string|max:50',
            'qty_stock'   => 'required|integer|min:0',
            'keterangan'  => 'nullable|string',
        ], [
            'kode_plu.required'    => 'Kode PLU wajib diisi.',
            'kode_plu.unique'      => 'Kode PLU ini sudah terdaftar.',
            'nama_barang.required' => 'Nama barang/part wajib diisi.',
            'satuan.required'      => 'Satuan barang wajib dipilih/diisi.',
            'qty_stock.required'   => 'Jumlah stok awal wajib diisi.',
            'qty_stock.min'        => 'Jumlah stok minimal 0.',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::create([
                'kode_plu'    => trim($request->kode_plu),
                'nama_barang' => trim($request->nama_barang),
                'divisi'      => $request->divisi ? trim($request->divisi) : 'Umum',
                'satuan'      => trim($request->satuan) ?: 'PCS',
                'qty_stock'   => (int) $request->qty_stock,
                'keterangan'  => $request->keterangan ? trim($request->keterangan) : null,
            ]);

            // Jika stok awal > 0, catat mutasi masuk awal
            if ($barang->qty_stock > 0) {
                BarangLogTransit::create([
                    'barang_id'         => $barang->id,
                    'kode_plu'          => $barang->kode_plu,
                    'nama_barang'       => $barang->nama_barang,
                    'divisi'            => $barang->divisi,
                    'satuan'            => $barang->satuan,
                    'tipe'              => 'IN',
                    'kategori'          => 'Barang Baru Masuk',
                    'qty'               => $barang->qty_stock,
                    'stok_awal'         => 0,
                    'stok_akhir'        => $barang->qty_stock,
                    'tujuan_sumber'     => 'Pendaftaran Master Baru',
                    'pic'               => session('user_name') ?? 'Teknisi EDP',
                    'keterangan'        => 'Input stok awal saat pendaftaran item baru',
                    'tanggal_transaksi' => date('Y-m-d'),
                ]);
            }

            DB::commit();
            return redirect()->route('part.index')->with('success', "Part baru \"{$barang->nama_barang}\" berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan part: ' . $e->getMessage());
        }
    }

    /**
     * Tambah / Restock Qty part yang sudah ada
     */
    public function addStock(Request $request, $id)
    {
        $request->validate([
            'qty_add' => 'required|integer|min:1',
            'sumber'  => 'nullable|string|max:150',
            'catatan' => 'nullable|string',
        ], [
            'qty_add.required' => 'Jumlah penambahan stok wajib diisi.',
            'qty_add.min'      => 'Jumlah penambahan minimal 1 unit.',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::lockForUpdate()->findOrFail($id);
            $qtyBefore = (int) $barang->qty_stock;
            $qtyAdd = (int) $request->qty_add;
            $qtyAfter = $qtyBefore + $qtyAdd;

            $barang->qty_stock = $qtyAfter;
            if ($request->catatan) {
                $existingKet = $barang->keterangan ? $barang->keterangan . " | " : "";
                $barang->keterangan = $existingKet . "Restock +" . $qtyAdd . " (" . date('d/m/Y') . ": " . trim($request->catatan) . ")";
            }
            $barang->save();

            // Catat log transit IN
            BarangLogTransit::create([
                'barang_id'         => $barang->id,
                'kode_plu'          => $barang->kode_plu,
                'nama_barang'       => $barang->nama_barang,
                'divisi'            => $barang->divisi,
                'satuan'            => $barang->satuan ?: 'PCS',
                'tipe'              => 'IN',
                'kategori'          => 'Restock Tambah Stok',
                'qty'               => $qtyAdd,
                'stok_awal'         => $qtyBefore,
                'stok_akhir'        => $qtyAfter,
                'tujuan_sumber'     => $request->sumber ? trim($request->sumber) : 'Restock Gudang / Supplier',
                'pic'               => session('user_name') ?? 'Teknisi EDP',
                'keterangan'        => $request->catatan ? trim($request->catatan) : 'Penambahan kuantitas stok part',
                'tanggal_transaksi' => date('Y-m-d'),
            ]);

            DB::commit();
            return redirect()->route('part.index')->with('success', "Stok untuk \"{$barang->nama_barang}\" berhasil ditambah +{$qtyAdd} (Total Stok: {$qtyAfter} {$barang->satuan}).");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah stok: ' . $e->getMessage());
        }
    }

    /**
     * Out Barang Manual (Pengeluaran part ke Toko KDTK / Divisi / Proyek)
     */
    public function manualOut(Request $request)
    {
        $request->validate([
            'barang_id'         => 'required|exists:barang,id',
            'qty_out'           => 'required|integer|min:1',
            'tujuan_out'        => 'required|string|max:200',
            'tanggal_keluar'    => 'required|date',
            'keterangan'        => 'nullable|string',
        ], [
            'barang_id.required'      => 'Pilih barang/part yang akan dikeluarkan.',
            'qty_out.required'        => 'Jumlah barang keluar wajib diisi.',
            'qty_out.min'             => 'Jumlah barang keluar minimal 1 unit.',
            'tujuan_out.required'     => 'Tujuan pengeluaran (Kode Toko/Divisi) wajib diisi.',
            'tanggal_keluar.required' => 'Tanggal pengeluaran wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::lockForUpdate()->findOrFail($request->barang_id);
            $qtyOut = (int) $request->qty_out;

            if ($barang->qty_stock < $qtyOut) {
                DB::rollBack();
                return redirect()->back()->with('error', "Stok \"{$barang->nama_barang}\" tidak mencukupi. Sisa stok saat ini: {$barang->qty_stock} {$barang->satuan}.");
            }

            $qtyBefore = (int) $barang->qty_stock;
            $qtyAfter = $qtyBefore - $qtyOut;

            $barang->qty_stock = $qtyAfter;
            $barang->save();

            // Catat log transit OUT
            BarangLogTransit::create([
                'barang_id'         => $barang->id,
                'kode_plu'          => $barang->kode_plu,
                'nama_barang'       => $barang->nama_barang,
                'divisi'            => $barang->divisi,
                'satuan'            => $barang->satuan ?: 'PCS',
                'tipe'              => 'OUT',
                'kategori'          => 'Out Manual Toko / Divisi',
                'qty'               => $qtyOut,
                'stok_awal'         => $qtyBefore,
                'stok_akhir'        => $qtyAfter,
                'tujuan_sumber'     => trim($request->tujuan_out),
                'pic'               => session('user_name') ?? 'Teknisi EDP',
                'keterangan'        => $request->keterangan ? trim($request->keterangan) : 'Pengeluaran part manual',
                'tanggal_transaksi' => $request->tanggal_keluar,
            ]);

            DB::commit();
            return redirect()->route('part.index')->with('success', "Berhasil mengeluarkan {$qtyOut} {$barang->satuan} \"{$barang->nama_barang}\" ke {$request->tujuan_out}. Sisa stok: {$qtyAfter}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pengeluaran part: ' . $e->getMessage());
        }
    }

    /**
     * Update data part
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_plu'    => 'required|string|max:50|unique:barang,kode_plu,' . $id,
            'nama_barang' => 'required|string|max:150',
            'divisi'      => 'nullable|string|max:100',
            'satuan'      => 'required|string|max:50',
            'qty_stock'   => 'required|integer|min:0',
            'keterangan'  => 'nullable|string',
            'alasan_edit' => 'nullable|string|max:200',
        ], [
            'kode_plu.required'    => 'Kode PLU wajib diisi.',
            'kode_plu.unique'      => 'Kode PLU ini sudah terdaftar pada part lain.',
            'nama_barang.required' => 'Nama barang/part wajib diisi.',
            'satuan.required'      => 'Satuan barang wajib diisi.',
            'qty_stock.required'   => 'Jumlah stok wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::lockForUpdate()->findOrFail($id);

            // Simpan data lama untuk perbandingan audit trail
            $oldPlu    = (string) $barang->kode_plu;
            $oldNama   = (string) $barang->nama_barang;
            $oldDivisi = (string) ($barang->divisi ?: 'Umum');
            $oldSatuan = (string) ($barang->satuan ?: 'PCS');
            $oldStock  = (int) $barang->qty_stock;
            $oldKet    = (string) ($barang->keterangan ?? '');

            // Data baru dari input form
            $newPlu     = trim($request->kode_plu);
            $newNama    = trim($request->nama_barang);
            $newDivisi  = $request->divisi ? trim($request->divisi) : 'Umum';
            $newSatuan  = trim($request->satuan) ?: 'PCS';
            $newStock   = (int) $request->qty_stock;
            $newKet     = $request->keterangan ? trim($request->keterangan) : '';
            $alasanEdit = $request->alasan_edit ? trim($request->alasan_edit) : '';

            // Deteksi perubahan tiap field
            $changes = [];
            if ($oldPlu !== $newPlu) {
                $changes[] = "Kode PLU: [{$oldPlu}] ➔ [{$newPlu}]";
            }
            if ($oldNama !== $newNama) {
                $changes[] = "Nama Barang: [{$oldNama}] ➔ [{$newNama}]";
            }
            if ($oldDivisi !== $newDivisi) {
                $changes[] = "Divisi: [{$oldDivisi}] ➔ [{$newDivisi}]";
            }
            if ($oldSatuan !== $newSatuan) {
                $changes[] = "Satuan: [{$oldSatuan}] ➔ [{$newSatuan}]";
            }
            $stockChanged = ($oldStock !== $newStock);
            if ($stockChanged) {
                $diff = $newStock - $oldStock;
                $diffSign = $diff > 0 ? "+{$diff}" : "{$diff}";
                $changes[] = "Stok: {$oldStock} ➔ {$newStock} ({$diffSign} {$newSatuan})";
            }
            if ($oldKet !== $newKet) {
                $oldKetDisp = $oldKet !== '' ? "[{$oldKet}]" : "(kosong)";
                $newKetDisp = $newKet !== '' ? "[{$newKet}]" : "(kosong)";
                $changes[] = "Keterangan: {$oldKetDisp} ➔ {$newKetDisp}";
            }

            // Simpan update ke master barang
            $barang->update([
                'kode_plu'    => $newPlu,
                'nama_barang' => $newNama,
                'divisi'      => $newDivisi,
                'satuan'      => $newSatuan,
                'qty_stock'   => $newStock,
                'keterangan'  => $newKet !== '' ? $newKet : null,
            ]);

            // Jika ada perubahan atau ada catatan alasan edit, catat ke Log Transit
            if (!empty($changes) || $alasanEdit !== '') {
                $onlyStock = $stockChanged && (count($changes) === 1);
                $noStock   = !$stockChanged;

                if ($onlyStock) {
                    $kategori = 'Penyesuaian Stok (Edit)';
                } elseif ($noStock) {
                    $kategori = 'Edit Informasi Master Part';
                } else {
                    $kategori = 'Edit Data Part & Stok';
                }

                $logKet = '';
                if ($alasanEdit !== '') {
                    $logKet .= "[Catatan: {$alasanEdit}] ";
                }
                $logKet .= !empty($changes) ? implode(" • ", $changes) : 'Update data part tanpa perubahan spesifik';

                BarangLogTransit::create([
                    'barang_id'         => $barang->id,
                    'kode_plu'          => $newPlu,
                    'nama_barang'       => $newNama,
                    'divisi'            => $newDivisi,
                    'satuan'            => $newSatuan,
                    'tipe'              => 'EDIT',
                    'kategori'          => $kategori,
                    'qty'               => abs($newStock - $oldStock),
                    'stok_awal'         => $oldStock,
                    'stok_akhir'        => $newStock,
                    'tujuan_sumber'     => $alasanEdit !== '' ? $alasanEdit : 'Edit / Penyesuaian Data Part',
                    'pic'               => session('user_name') ?? 'Teknisi EDP',
                    'keterangan'        => $logKet,
                    'tanggal_transaksi' => date('Y-m-d'),
                ]);
            }

            DB::commit();
            return redirect()->route('part.index')->with('success', "Data part \"{$barang->nama_barang}\" berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data part: ' . $e->getMessage());
        }
    }

    /**
     * Hapus part (dinonaktifkan dari UI, disimpan sebagai fallback)
     */
    public function destroy(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $nama = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('part.index')->with('success', "Part \"{$nama}\" berhasil dihapus.");
    }

    /**
     * Tampilkan Halaman Log Transit Barang (Audit Trail Keluar Masuk / Edit)
     */
    public function logTransit(Request $request)
    {
        $search   = trim($request->get('search', ''));
        $tipe     = $request->get('tipe', 'all'); // all, IN, OUT, EDIT
        $kategori = $request->get('kategori', 'all');
        $dateFrom = $request->get('date_from', '');
        $dateTo   = $request->get('date_to', '');

        $query = BarangLogTransit::with('barang');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_plu', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('divisi', 'like', "%{$search}%")
                  ->orWhere('tujuan_sumber', 'like', "%{$search}%")
                  ->orWhere('pic', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if (in_array($tipe, ['IN', 'OUT', 'EDIT'])) {
            $query->where('tipe', $tipe);
        }

        if ($kategori !== 'all' && !empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($dateFrom)) {
            $query->whereDate('tanggal_transaksi', '>=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $query->whereDate('tanggal_transaksi', '<=', $dateTo);
        }

        $logs = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();

        // Statistik Log
        $totalLogs     = BarangLogTransit::count();
        $totalInQty    = (int) BarangLogTransit::where('tipe', 'IN')->sum('qty');
        $totalOutQty   = (int) BarangLogTransit::where('tipe', 'OUT')->sum('qty');
        $totalEditLogs = BarangLogTransit::where('tipe', 'EDIT')->count();
        $todayLogs     = BarangLogTransit::whereDate('tanggal_transaksi', date('Y-m-d'))->count();

        $kategoriList = BarangLogTransit::distinct()->pluck('kategori');

        return view('pages.part_log', compact(
            'logs',
            'search',
            'tipe',
            'kategori',
            'dateFrom',
            'dateTo',
            'totalLogs',
            'totalInQty',
            'totalOutQty',
            'totalEditLogs',
            'todayLogs',
            'kategoriList'
        ));
    }

    /**
     * Export Log Transit ke CSV
     */
    public function exportLogTransit(Request $request)
    {
        $search   = trim($request->get('search', ''));
        $tipe     = $request->get('tipe', 'all');
        $kategori = $request->get('kategori', 'all');

        $query = BarangLogTransit::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_plu', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('divisi', 'like', "%{$search}%")
                  ->orWhere('tujuan_sumber', 'like', "%{$search}%");
            });
        }

        if (in_array($tipe, ['IN', 'OUT', 'EDIT'])) {
            $query->where('tipe', $tipe);
        }

        if ($kategori !== 'all' && !empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $logs = $query->orderBy('id', 'desc')->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="log_transit_barang_' . date('Ymd_His') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID Log', 'Tanggal Transaksi', 'Tipe', 'Kategori Mutasi', 'Kode PLU',
                'Nama Barang', 'Divisi', 'Satuan', 'Qty', 'Stok Awal', 'Stok Akhir',
                'Tujuan / Sumber', 'PIC', 'Keterangan'
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->tanggal_transaksi ? $log->tanggal_transaksi->format('d/m/Y') : '-',
                    $log->tipe,
                    $log->kategori,
                    $log->kode_plu ?: '-',
                    $log->nama_barang,
                    $log->divisi ?: '-',
                    $log->satuan ?: 'PCS',
                    $log->qty,
                    $log->stok_awal,
                    $log->stok_akhir,
                    $log->tujuan_sumber ?: '-',
                    $log->pic ?: '-',
                    $log->keterangan ?: '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * API JSON untuk pencarian part saat menyelesaikan service
     */
    public function apiList(Request $request)
    {
        $search = trim($request->get('q', ''));
        $query = Barang::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_plu', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('divisi', 'like', "%{$search}%");
            });
        }

        $parts = $query->orderBy('nama_barang', 'asc')->take(50)->get([
            'id', 'kode_plu', 'nama_barang', 'divisi', 'satuan', 'qty_stock'
        ]);

        return response()->json($parts);
    }
}
