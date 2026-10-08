<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMutasiBulanan;
use App\Models\BarangLogTransit;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $moving = $request->get('moving', 'all');
        $sort   = $request->get('sort', 'no_urut');
        $dir    = $request->get('direction', 'asc');

        $query = Barang::query();

        // Catatan: Tidak membatasi $query dengan $search di backend agar semua 114 item
        // selalu ada di DOM untuk instant 0ms client-side live search tanpa reload.
        if ($divisi !== 'all' && !empty($divisi)) {
            $query->where('divisi', $divisi);
        }

        if ($moving !== 'all' && !empty($moving)) {
            $query->where('moving', $moving);
        }

        if ($status === 'habis') {
            $query->where('qty_stock', '<=', 0);
        } elseif ($status === 'menipis') {
            $query->where('qty_stock', '>', 0)->where('qty_stock', '<=', 5);
        } elseif ($status === 'aman') {
            $query->where('qty_stock', '>', 5);
        } elseif ($status === 'ada_pp') {
            $query->where('qty_pp', '>', 0);
        } elseif ($status === 'pp_pending') {
            $query->where('qty_pp_belum_realisasi', '>', 0);
        }

        $allowedSorts = [
            'id', 'no_urut', 'kode_plu', 'nama_barang', 'divisi', 'satuan',
            'moving', 'qty_stock', 'pkm', 'avg_l3m_out', 'dsi', 'qty_pp',
            'harga_satuan', 'total_harga', 'qty_pp_belum_realisasi', 'updated_at'
        ];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, strtolower($dir) === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('no_urut', 'asc');
        }

        $items = $query->paginate(200)->withQueryString();

        // Statistik Keseluruhan
        $totalSku         = Barang::count();
        $totalStock       = (int) Barang::sum('qty_stock');
        $habisCount       = Barang::where('qty_stock', '<=', 0)->count();
        $menipisCount     = Barang::where('qty_stock', '>', 0)->where('qty_stock', '<=', 5)->count();
        $amanCount        = Barang::where('qty_stock', '>', 5)->count();
        $totalPpQty       = (int) Barang::sum('qty_pp');
        $totalPpNominal   = (float) Barang::sum('total_harga');
        $ppPendingCount   = Barang::where('qty_pp_belum_realisasi', '>', 0)->count();
        $lastSyncedAt     = Barang::max('last_synced_at');

        // Daftar Toko untuk Datalist Out Manual
        $tokoList   = Toko::select('kode_toko', 'nama_toko')->orderBy('kode_toko', 'asc')->get();
        $divisiList = Barang::whereNotNull('divisi')->where('divisi', '!=', '')->distinct()->orderBy('divisi')->pluck('divisi');
        $movingList = Barang::whereNotNull('moving')->where('moving', '!=', '')->distinct()->orderBy('moving')->pluck('moving');
        $allParts           = Barang::orderBy('nama_barang', 'asc')->get();
        $isGoogleConfigured = app(\App\Services\GoogleSheetsService::class)->isConfigured();

        return view('pages.part', compact(
            'items',
            'search',
            'status',
            'divisi',
            'moving',
            'sort',
            'dir',
            'totalSku',
            'totalStock',
            'habisCount',
            'menipisCount',
            'amanCount',
            'totalPpQty',
            'totalPpNominal',
            'ppPendingCount',
            'lastSyncedAt',
            'isGoogleConfigured',
            'tokoList',
            'divisiList',
            'movingList',
            'allParts'
        ));
    }

    /**
     * Sinkronisasi data dari Google Sheets (Pull)
     */
    public function syncGoogleSheet(Request $request)
    {
        try {
            $csvUrl = "https://docs.google.com/spreadsheets/d/1l15LkNvLJYNNkfh2CqQn1na1KkFFn-fHgg35OVKMVm0/export?format=csv&gid=750496266";
            
            $csvData = null;
            try {
                $response = Http::timeout(15)->get($csvUrl);
                if ($response->successful()) {
                    $csvData = $response->body();
                }
            } catch (\Exception $e) {
                // Fallback ke file local jika gagal koneksi internet
            }

            if (!$csvData) {
                $fallbackPath = database_path('seeders/data/lpp_stock.csv');
                if (file_exists($fallbackPath)) {
                    $csvData = file_get_contents($fallbackPath);
                }
            }

            if (!$csvData) {
                return redirect()->back()->with('error', 'Gagal mengunduh data Google Sheet dan tidak ditemukan file lokal.');
            }

            $lines = explode("\n", $csvData);
            $months = [
                ['key' => '2024-07', 'name' => "JUL '24", 'col_in' => 12, 'col_out' => 13, 'col_akh' => 14],
                ['key' => '2024-08', 'name' => "AUG '24", 'col_in' => 15, 'col_out' => 16, 'col_akh' => 17],
                ['key' => '2024-09', 'name' => "SEP '24", 'col_in' => 18, 'col_out' => 19, 'col_akh' => 20],
                ['key' => '2024-10', 'name' => "OCT '24", 'col_in' => 21, 'col_out' => 22, 'col_akh' => 23],
                ['key' => '2024-11', 'name' => "NOV '24", 'col_in' => 24, 'col_out' => 25, 'col_akh' => 26],
                ['key' => '2024-12', 'name' => "DES '24", 'col_in' => 27, 'col_out' => 28, 'col_akh' => 29],
                ['key' => '2025-01', 'name' => "JAN '25", 'col_in' => 30, 'col_out' => 31, 'col_akh' => 32],
                ['key' => '2025-02', 'name' => "FEB '25", 'col_in' => 33, 'col_out' => 34, 'col_akh' => 35],
                ['key' => '2025-03', 'name' => "MAR '25", 'col_in' => 36, 'col_out' => 37, 'col_akh' => 38],
                ['key' => '2025-04', 'name' => "APR '25", 'col_in' => 39, 'col_out' => 40, 'col_akh' => 41],
                ['key' => '2025-05', 'name' => "MEI '25", 'col_in' => 42, 'col_out' => 43, 'col_akh' => 44],
                ['key' => '2025-06', 'name' => "JUN '25", 'col_in' => 45, 'col_out' => 46, 'col_akh' => 47],
                ['key' => '2025-07', 'name' => "JUL '25", 'col_in' => 48, 'col_out' => 49, 'col_akh' => 50],
                ['key' => '2025-08', 'name' => "AUG '25", 'col_in' => 51, 'col_out' => 52, 'col_akh' => 53],
                ['key' => '2025-09', 'name' => "SEP '25", 'col_in' => 54, 'col_out' => 55, 'col_akh' => 56],
                ['key' => '2025-10', 'name' => "OKT '25", 'col_in' => 57, 'col_out' => 58, 'col_akh' => 59],
                ['key' => '2025-11', 'name' => "NOV '25", 'col_in' => 60, 'col_out' => 61, 'col_akh' => 62],
                ['key' => '2025-12', 'name' => "DES '25", 'col_in' => 63, 'col_out' => 64, 'col_akh' => 65],
                ['key' => '2026-01', 'name' => "JAN '26", 'col_in' => 66, 'col_out' => 67, 'col_akh' => 68],
                ['key' => '2026-02', 'name' => "FEB '26", 'col_in' => 69, 'col_out' => 70, 'col_akh' => 71],
                ['key' => '2026-03', 'name' => "MAR '26", 'col_in' => 72, 'col_out' => 73, 'col_akh' => 74],
                ['key' => '2026-04', 'name' => "APR '26", 'col_in' => 75, 'col_out' => 76, 'col_akh' => 77],
                ['key' => '2026-05', 'name' => "MEI '26", 'col_in' => 78, 'col_out' => 79, 'col_akh' => 80],
                ['key' => '2026-06', 'name' => "JUNI '26", 'col_in' => 81, 'col_out' => 82, 'col_akh' => 83],
                ['key' => '2026-07', 'name' => "JULI '26", 'col_in' => 84, 'col_out' => 85, 'col_akh' => 86],
                ['key' => '2026-08', 'name' => "AGUSTUS '26", 'col_in' => 87, 'col_out' => 88, 'col_akh' => 89],
                ['key' => '2026-09', 'name' => "SEPTEMBER '26", 'col_in' => 90, 'col_out' => 91, 'col_akh' => 92],
            ];

            DB::beginTransaction();

            $syncedCount = 0;
            $rowIndex = 0;

            foreach ($lines as $line) {
                $rowIndex++;
                if ($rowIndex <= 8) continue;

                $row = str_getcsv($line);
                $no = trim($row[0] ?? '');
                if (!is_numeric($no)) continue;

                $plu        = trim($row[1] ?? '');
                $namaBarang = trim($row[2] ?? '');
                $divisi     = trim($row[3] ?? '');
                $satuan     = trim($row[4] ?? 'PCS') ?: 'PCS';
                $moving     = trim($row[5] ?? '');
                $pkm        = (int) self::cleanNumber($row[6] ?? 0);
                $kebPerToko = (float) self::cleanNumber($row[7] ?? 0);
                $totalToko  = (int) self::cleanNumber($row[8] ?? 254);
                $kriteria   = trim($row[9] ?? '');
                $saldoAwal  = (int) self::cleanNumber($row[10] ?? 0);

                $saldoAkhir = (int) self::cleanNumber($row[92] ?? 0);
                $avgL3mOut  = (float) self::cleanNumber($row[93] ?? 0);
                $dsi        = (int) self::cleanNumber($row[94] ?? 0);
                $leadTime   = (int) self::cleanNumber($row[95] ?? 45) ?: 45;
                $minor      = (int) self::cleanNumber($row[96] ?? 0);
                $reorder    = (int) self::cleanNumber($row[97] ?? 0);
                $qtyPp      = (int) self::cleanNumber($row[98] ?? 0);
                $buffer     = (int) self::cleanNumber($row[99] ?? 0);
                $ketKhusus  = trim($row[100] ?? '');
                $hargaSatuan= self::cleanCurrency($row[101] ?? 0);
                $totalHarga = self::cleanCurrency($row[102] ?? 0);
                $qtyPpPending = (int) self::cleanNumber($row[103] ?? 0);
                $keterangan = trim($row[104] ?? '');

                // Cari barang berdasarkan PLU atau nama_barang
                $barang = Barang::where('kode_plu', $plu)->where('kode_plu', '!=', '')->first();
                if (!$barang) {
                    $barang = Barang::where('nama_barang', $namaBarang)->first();
                }

                $dataPayload = [
                    'no_urut'                => (int) $no,
                    'kode_plu'               => $plu,
                    'nama_barang'            => $namaBarang,
                    'divisi'                 => $divisi,
                    'satuan'                 => $satuan,
                    'moving'                 => $moving,
                    'pkm'                    => $pkm,
                    'keb_per_toko'           => $kebPerToko,
                    'total_toko'             => $totalToko ?: 254,
                    'kriteria_buffer'        => $kriteria,
                    'saldo_awal'             => $saldoAwal,
                    'qty_stock'              => $saldoAkhir,
                    'avg_l3m_out'            => $avgL3mOut,
                    'dsi'                    => $dsi,
                    'lead_time'              => $leadTime,
                    'minor'                  => $minor,
                    'reorder'                => $reorder,
                    'qty_pp'                 => $qtyPp,
                    'buffer'                 => $buffer,
                    'keterangan_khusus'      => $ketKhusus,
                    'harga_satuan'           => $hargaSatuan,
                    'total_harga'            => $totalHarga,
                    'qty_pp_belum_realisasi' => $qtyPpPending,
                    'keterangan'             => $keterangan,
                    'google_sheet_row'       => $rowIndex,
                    'last_synced_at'         => now(),
                ];

                if ($barang) {
                    $barang->update($dataPayload);
                } else {
                    $barang = Barang::create($dataPayload);
                }

                // Update riwayat mutasi bulanan
                BarangMutasiBulanan::where('barang_id', $barang->id)->delete();
                $mutasiBatch = [];
                foreach ($months as $idx => $m) {
                    $qtyIn  = (int) self::cleanNumber($row[$m['col_in']] ?? 0);
                    $qtyOut = (int) self::cleanNumber($row[$m['col_out']] ?? 0);
                    $salAkh = (int) self::cleanNumber($row[$m['col_akh']] ?? 0);

                    $mutasiBatch[] = [
                        'barang_id'    => $barang->id,
                        'kode_plu'     => $plu,
                        'periode_key'  => $m['key'],
                        'nama_bulan'   => $m['name'],
                        'urutan'       => $idx + 1,
                        'qty_in'       => $qtyIn,
                        'qty_out'      => $qtyOut,
                        'saldo_akhir'  => $salAkh,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
                BarangMutasiBulanan::insert($mutasiBatch);

                $syncedCount++;
            }

            DB::commit();
            return redirect()->route('part.index')->with('success', "Sinkronisasi berhasil! {$syncedCount} data sparepart diperbarui dari Google Sheets.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukan sinkronisasi: ' . $e->getMessage());
        }
    }

    /**
     * Tambah data part / barang baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_plu'    => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'divisi'      => 'nullable|string|max:100',
            'satuan'      => 'required|string|max:50',
            'moving'      => 'nullable|string|max:50',
            'qty_stock'   => 'required|integer|min:0',
            'harga_satuan'=> 'nullable|numeric|min:0',
            'keterangan'  => 'nullable|string',
        ], [
            'nama_barang.required' => 'Nama barang/part wajib diisi.',
            'satuan.required'      => 'Satuan barang wajib dipilih/diisi.',
            'qty_stock.required'   => 'Jumlah stok awal wajib diisi.',
            'qty_stock.min'        => 'Jumlah stok minimal 0.',
        ]);

        DB::beginTransaction();
        try {
            $nextNo = (int) (Barang::max('no_urut') ?? 0) + 1;
            $harga  = (float) ($request->harga_satuan ?? 0);
            $qty    = (int) $request->qty_stock;

            $barang = Barang::create([
                'no_urut'                => $nextNo,
                'kode_plu'               => trim($request->kode_plu) ?: null,
                'nama_barang'            => trim($request->nama_barang),
                'divisi'                 => $request->divisi ? trim($request->divisi) : 'Umum',
                'satuan'                 => trim($request->satuan) ?: 'PCS',
                'moving'                 => $request->moving ? trim($request->moving) : 'SPECIAL',
                'qty_stock'              => $qty,
                'saldo_awal'             => $qty,
                'harga_satuan'           => $harga,
                'total_harga'            => 0,
                'keterangan'             => $request->keterangan ? trim($request->keterangan) : null,
                'last_synced_at'         => now(),
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
            'qty_add'    => 'required|integer|min:1',
            'tgl_datang' => 'nullable|date',
            'tgl_btb'    => 'nullable|date',
            'no_btb'     => 'nullable|string|max:100',
            'sumber'     => 'nullable|string|max:150',
            'catatan'    => 'nullable|string',
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

            $tglDatang  = $request->tgl_datang ?: date('Y-m-d');
            $tglBtb     = $request->tgl_btb ?: null;
            $noBtb      = $request->no_btb ? trim($request->no_btb) : null;
            $harga      = (float) $barang->harga_satuan;
            $total      = $qtyAdd * $harga;
            $periodeStr = strtoupper(date('My', strtotime($tglDatang)));

            // Catat log transit IN ke database MySQL
            $log = BarangLogTransit::create([
                'barang_id'         => $barang->id,
                'kode_plu'          => $barang->kode_plu,
                'nama_barang'       => $barang->nama_barang,
                'divisi'            => $barang->divisi,
                'satuan'            => $barang->satuan ?: 'PCS',
                'periode'           => $periodeStr,
                'tgl_datang'        => $tglDatang,
                'tgl_btb'           => $tglBtb,
                'no_btb'            => $noBtb,
                'tipe'              => 'IN',
                'kategori'          => 'Restock Tambah Stok',
                'qty'               => $qtyAdd,
                'harga_satuan'      => $harga,
                'total_harga'       => $total,
                'stok_awal'         => $qtyBefore,
                'stok_akhir'        => $qtyAfter,
                'tujuan_sumber'     => $request->sumber ? trim($request->sumber) : ($noBtb ? "BTB No: {$noBtb}" : 'Restock Gudang / Supplier'),
                'pic'               => session('user_name') ?? 'Teknisi EDP',
                'keterangan'        => $request->catatan ? trim($request->catatan) : ($request->sumber ?: 'Penambahan kuantitas stok part'),
                'tanggal_transaksi' => $tglDatang,
                'google_sheet_name' => 'IN',
            ]);

            DB::commit();

            // Auto Write-back ke Google Sheets (Sheet 5 LPP STOCK & Sheet 6 IN)
            $sheetMsg = '';
            try {
                $sheetsService = app(\App\Services\GoogleSheetsService::class);
                if ($sheetsService->isConfigured()) {
                    // 1. Update Saldo Akhir di Sheet LPP STOCK
                    $syncLpp = $sheetsService->syncBarangToSheet($barang);
                    
                    // 2. Append transaksi ke Sheet 6 [IN]
                    $appendIn = $sheetsService->appendBarangMasuk([
                        'kode_plu'     => $barang->kode_plu,
                        'nama_barang'  => $barang->nama_barang,
                        'tgl_datang'   => $tglDatang,
                        'tgl_btb'      => $tglBtb,
                        'periode'      => $periodeStr,
                        'divisi'       => $barang->divisi ?: 'CPU',
                        'satuan'       => $barang->satuan ?: 'PCS',
                        'no_btb'       => $noBtb ?: '-',
                        'qty'          => $qtyAdd,
                        'harga_satuan' => $harga,
                        'total_harga'  => $total,
                        'keterangan'   => $request->catatan ?: ($request->sumber ?: '')
                    ]);

                    if (!empty($appendIn['inserted_row'])) {
                        $log->update([
                            'no_urut'          => $appendIn['no_urut'] ?? null,
                            'google_sheet_row' => $appendIn['inserted_row'],
                        ]);
                    }

                    $sheetMsg = " | Google Sheets: LPP Stock & Sheet [IN] terupdate otomatis";
                }
            } catch (\Exception $ex) {
                Log::error("Google Sheets Write-back error on addStock: " . $ex->getMessage());
            }

            return redirect()->route('part.index')->with('success', "Stok untuk \"{$barang->nama_barang}\" berhasil ditambah +{$qtyAdd} (Total Stok: {$qtyAfter} {$barang->satuan}){$sheetMsg}.");
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
            'tgl_bkb'           => 'nullable|date',
            'no_bkb'            => 'nullable|string|max:100',
            'aktiva'            => 'nullable|string|max:100',
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

            // Ekstrak KDTK dan Nama Toko
            $tujuanRaw = trim($request->tujuan_out);
            $kdtk = null;
            $namaToko = null;

            if (preg_match('/^KDTK:\s*([A-Za-z0-9]+)\s*\((.*?)\)/i', $tujuanRaw, $m)) {
                $kdtk = trim($m[1]);
                $namaToko = trim($m[2]);
            } elseif (str_contains($tujuanRaw, ' - ')) {
                $parts = explode(' - ', $tujuanRaw, 2);
                $kdtk = trim($parts[0]);
                $namaToko = trim($parts[1]);
            } else {
                // Cek apakah tujuanRaw adalah kode toko
                $toko = Toko::where('kode_toko', strtoupper($tujuanRaw))->first();
                if ($toko) {
                    $kdtk = $toko->kode_toko;
                    $namaToko = $toko->nama_toko;
                } else {
                    $kdtk = $tujuanRaw;
                    $namaToko = $tujuanRaw;
                }
            }

            $harga = (float) $barang->harga_satuan;
            $total = $qtyOut * $harga;
            $tglKeluar = $request->tanggal_keluar;
            $tglBkb = $request->tgl_bkb ?: null;
            $noBkb = $request->no_bkb ? trim($request->no_bkb) : null;
            $periodeStr = strtoupper(date('My', strtotime($tglKeluar)));
            $aktiva = $request->aktiva ? trim($request->aktiva) : null;

            // Catat log transit OUT ke database MySQL
            $log = BarangLogTransit::create([
                'barang_id'         => $barang->id,
                'kode_plu'          => $barang->kode_plu,
                'nama_barang'       => $barang->nama_barang,
                'divisi'            => $barang->divisi,
                'satuan'            => $barang->satuan ?: 'PCS',
                'periode'           => $periodeStr,
                'tgl_keluar'        => $tglKeluar,
                'tgl_bkb'           => $tglBkb,
                'no_bkb'            => $noBkb,
                'kdtk'              => $kdtk,
                'nama_toko'         => $namaToko,
                'aktiva'            => $aktiva,
                'tipe'              => 'OUT',
                'kategori'          => 'Out Manual Toko / Divisi',
                'qty'               => $qtyOut,
                'harga_satuan'      => $harga,
                'total_harga'       => $total,
                'stok_awal'         => $qtyBefore,
                'stok_akhir'        => $qtyAfter,
                'tujuan_sumber'     => $tujuanRaw,
                'pic'               => session('user_name') ?? 'Teknisi EDP',
                'keterangan'        => $request->keterangan ? trim($request->keterangan) : 'Pengeluaran part manual',
                'tanggal_transaksi' => $tglKeluar,
                'google_sheet_name' => null,
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
            'kode_plu'    => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:200',
            'divisi'      => 'nullable|string|max:100',
            'satuan'      => 'required|string|max:50',
            'moving'      => 'nullable|string|max:50',
            'qty_stock'   => 'required|integer|min:0',
            'pkm'         => 'nullable|integer|min:0',
            'lead_time'   => 'nullable|integer|min:0',
            'qty_pp'      => 'nullable|integer|min:0',
            'harga_satuan'=> 'nullable|numeric|min:0',
            'keterangan'  => 'nullable|string',
            'alasan_edit' => 'nullable|string|max:200',
        ], [
            'nama_barang.required' => 'Nama barang/part wajib diisi.',
            'satuan.required'      => 'Satuan barang wajib diisi.',
            'qty_stock.required'   => 'Jumlah stok wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::lockForUpdate()->findOrFail($id);

            $oldPlu    = (string) $barang->kode_plu;
            $oldNama   = (string) $barang->nama_barang;
            $oldDivisi = (string) ($barang->divisi ?: 'Umum');
            $oldSatuan = (string) ($barang->satuan ?: 'PCS');
            $oldStock  = (int) $barang->qty_stock;
            $oldKet    = (string) ($barang->keterangan ?? '');

            $newPlu     = trim((string)$request->kode_plu);
            $newNama    = trim((string)$request->nama_barang);
            $newDivisi  = $request->divisi ? trim($request->divisi) : 'Umum';
            $newSatuan  = trim((string)$request->satuan) ?: 'PCS';
            $newMoving  = $request->moving ? trim($request->moving) : $barang->moving;
            $newStock   = (int) $request->qty_stock;
            $newPkm     = $request->has('pkm') ? (int) $request->pkm : $barang->pkm;
            $newLeadTime= $request->has('lead_time') ? (int) $request->lead_time : $barang->lead_time;
            $newQtyPp   = $request->has('qty_pp') ? (int) $request->qty_pp : $barang->qty_pp;
            $newHarga   = $request->has('harga_satuan') ? (float) $request->harga_satuan : (float) $barang->harga_satuan;
            $newKet     = $request->keterangan ? trim($request->keterangan) : '';
            $alasanEdit = $request->alasan_edit ? trim($request->alasan_edit) : '';

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

            $barang->update([
                'kode_plu'     => $newPlu ?: null,
                'nama_barang'  => $newNama,
                'divisi'       => $newDivisi,
                'satuan'       => $newSatuan,
                'moving'       => $newMoving,
                'qty_stock'    => $newStock,
                'pkm'          => $newPkm,
                'lead_time'    => $newLeadTime,
                'qty_pp'       => $newQtyPp,
                'harga_satuan' => $newHarga,
                'total_harga'  => $newQtyPp * $newHarga,
                'keterangan'   => $newKet !== '' ? $newKet : null,
            ]);

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

            // Auto Write-back ke Google Sheets (jika configured)
            $sheetMsg = '';
            try {
                $sheetsService = app(\App\Services\GoogleSheetsService::class);
                if ($sheetsService->isConfigured()) {
                    $sync = $sheetsService->syncBarangToSheet($barang, [
                        'pkm'        => $newPkm,
                        'qty_pp'     => $newQtyPp,
                        'keterangan' => $barang->keterangan,
                    ]);
                    $sheetMsg = " | " . $sync['message'];
                }
            } catch (\Exception $ex) {
                // Fallback aman
            }

            return redirect()->route('part.index')->with('success', "Data part \"{$barang->nama_barang}\" berhasil diperbarui{$sheetMsg}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data part: ' . $e->getMessage());
        }
    }

    /**
     * Hapus part
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
        $tipe     = $request->get('tipe', 'all');
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
                  ->orWhere('kdtk', 'like', "%{$search}%")
                  ->orWhere('nama_toko', 'like', "%{$search}%")
                  ->orWhere('aktiva', 'like', "%{$search}%")
                  ->orWhere('no_btb', 'like', "%{$search}%")
                  ->orWhere('periode', 'like', "%{$search}%")
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

        $logs = $query->orderBy('id', 'desc')->paginate(25)->withQueryString();

        // Statistik Log
        $totalLogs     = BarangLogTransit::count();
        $totalInLogs   = BarangLogTransit::where('tipe', 'IN')->count();
        $totalOutLogs  = BarangLogTransit::where('tipe', 'OUT')->count();
        $totalEditLogs = BarangLogTransit::where('tipe', 'EDIT')->count();
        $totalInQty    = (int) BarangLogTransit::where('tipe', 'IN')->sum('qty');
        $totalOutQty   = (int) BarangLogTransit::where('tipe', 'OUT')->sum('qty');
        $totalNominalIn= (float) BarangLogTransit::where('tipe', 'IN')->sum('total_harga');
        $totalNominalOut=(float) BarangLogTransit::where('tipe', 'OUT')->sum('total_harga');
        $todayLogs     = BarangLogTransit::whereDate('tanggal_transaksi', date('Y-m-d'))->count();

        $kategoriList = BarangLogTransit::whereNotNull('kategori')->where('kategori', '!=', '')->distinct()->pluck('kategori');

        return view('pages.part_log', compact(
            'logs',
            'search',
            'tipe',
            'kategori',
            'dateFrom',
            'dateTo',
            'totalLogs',
            'totalInLogs',
            'totalOutLogs',
            'totalInQty',
            'totalOutQty',
            'totalNominalIn',
            'totalNominalOut',
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
                'ID Log', 'No Urut Sheet', 'Tanggal Transaksi', 'Periode', 'Tipe', 'Kategori Mutasi', 'Kode PLU',
                'Nama Barang', 'Divisi', 'Satuan', 'Qty', 'Harga Satuan', 'Total Harga', 'Stok Awal', 'Stok Akhir',
                'No BTB', 'Tgl Datang/BTB', 'KDTK', 'Nama Toko', 'No Aktiva/DAT', 'Tgl Keluar/BKB',
                'Tujuan / Sumber', 'PIC', 'Google Sheet Info', 'Keterangan'
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->no_urut ?: '-',
                    $log->tanggal_transaksi ? $log->tanggal_transaksi->format('d/m/Y') : '-',
                    $log->periode ?: '-',
                    $log->tipe,
                    $log->kategori,
                    $log->kode_plu ?: '-',
                    $log->nama_barang,
                    $log->divisi ?: '-',
                    $log->satuan ?: 'PCS',
                    $log->qty,
                    $log->harga_satuan ? number_format($log->harga_satuan, 0, ',', '.') : '0',
                    $log->total_harga ? number_format($log->total_harga, 0, ',', '.') : '0',
                    $log->stok_awal,
                    $log->stok_akhir,
                    $log->no_btb ?: '-',
                    $log->tgl_btb ? $log->tgl_btb->format('d/m/Y') : ($log->tgl_datang ? $log->tgl_datang->format('d/m/Y') : '-'),
                    $log->kdtk ?: '-',
                    $log->nama_toko ?: '-',
                    $log->aktiva ?: '-',
                    $log->tgl_keluar ? $log->tgl_keluar->format('d/m/Y') : '-',
                    $log->tujuan_sumber ?: '-',
                    $log->pic ?: '-',
                    $log->google_sheet_name ? ($log->google_sheet_name . ($log->google_sheet_row ? " (Row: {$log->google_sheet_row})" : '')) : '-',
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
            'id', 'kode_plu', 'nama_barang', 'divisi', 'satuan', 'qty_stock', 'moving', 'harga_satuan'
        ]);

        return response()->json($parts);
    }

    /**
     * Endpoint uji koneksi ke Google Sheets API
     */
    public function testGoogleConnection(Request $request)
    {
        $service = app(\App\Services\GoogleSheetsService::class);
        $result = $service->testConnection();
        return response()->json($result);
    }

    private static function cleanNumber($val): float
    {
        if (is_numeric($val)) return (float) $val;
        $val = trim((string) $val);
        $val = str_replace([',', ' ', '%'], '', $val);
        return is_numeric($val) ? (float) $val : 0.0;
    }

    private static function cleanCurrency($val): float
    {
        if (is_numeric($val)) return (float) $val;
        $val = trim((string) $val);
        if (strpos($val, '-') !== false && preg_match('/^[^\d]*-[^\d]*$/', $val)) {
            return 0.0;
        }
        $digits = preg_replace('/[^\d]/', '', $val);
        return is_numeric($digits) && $digits !== '' ? (float) $digits : 0.0;
    }
}
