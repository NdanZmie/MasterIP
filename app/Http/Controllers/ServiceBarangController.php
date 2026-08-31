<?php

namespace App\Http\Controllers;

use App\Models\ServiceBarang;
use App\Models\ServicePartKeluar;
use App\Models\Barang;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceBarangController extends Controller
{
    /**
     * Tampilkan halaman monitoring alur service barang
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $status = $request->get('status', 'all');
        $sort   = $request->get('sort', 'id');
        $dir    = $request->get('direction', 'desc');

        $query = ServiceBarang::with(['partKeluars', 'toko']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('no_dat', 'like', "%{$search}%")
                  ->orWhere('sn', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_toko', 'like', "%{$search}%")
                  ->orWhere('kerusakan', 'like', "%{$search}%")
                  ->orWhere('tindakan', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($status !== 'all' && in_array($status, ['Belum Cek', 'Sudah Cek', 'Service Suplier', 'Selesai Service'])) {
            $query->where('status', $status);
        }

        $allowedSorts = ['id', 'no_dat', 'sn', 'nama_barang', 'kode_toko', 'tanggal_masuk', 'tanggal_selesai', 'status'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, strtolower($dir) === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $services = $query->paginate(15)->withQueryString();

        // Statistik Counter
        $totalService    = ServiceBarang::count();
        $belumCekCount   = ServiceBarang::where('status', 'Belum Cek')->count();
        $sudahCekCount   = ServiceBarang::where('status', 'Sudah Cek')->count();
        $suplierCount    = ServiceBarang::where('status', 'Service Suplier')->count();
        $selesaiCount    = ServiceBarang::where('status', 'Selesai Service')->count();

        // Data Toko & Barang untuk Form Pilihan & Autocomplete
        $tokoList = Toko::select('id_toko', 'kode_toko', 'nama_toko')
            ->whereNotNull('kode_toko')
            ->where('kode_toko', '!=', '')
            ->orderBy('kode_toko')
            ->get();

        $barangList = Barang::select('id', 'kode_plu', 'nama_barang', 'qty_stock')->orderBy('nama_barang')->get();

        $historyBarang = ServiceBarang::whereNotNull('nama_barang')
            ->where('nama_barang', '!=', '')
            ->distinct()
            ->pluck('nama_barang')
            ->toArray();

        $masterBarang = Barang::whereNotNull('nama_barang')
            ->where('nama_barang', '!=', '')
            ->distinct()
            ->pluck('nama_barang')
            ->toArray();

        $namaBarangList = collect(array_merge($historyBarang, $masterBarang))
            ->map(fn($item) => trim($item))
            ->filter()
            ->unique(fn($item) => strtolower($item))
            ->values()
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        return view('pages.service', compact(
            'services',
            'search',
            'status',
            'sort',
            'dir',
            'totalService',
            'belumCekCount',
            'sudahCekCount',
            'suplierCount',
            'selesaiCount',
            'tokoList',
            'barangList',
            'namaBarangList'
        ));
    }

    /**
     * Input barang masuk service baru (Status awal: Belum Cek)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:200',
            'kode_toko'     => 'required|string|max:50',
            'tanggal_masuk' => 'required|date',
            'no_dat'        => 'nullable|string|max:100',
            'sn'            => 'nullable|string|max:100',
            'kerusakan'     => 'nullable|string',
            'keterangan'    => 'nullable|string',
        ], [
            'nama_barang.required'   => 'Nama barang wajib diisi.',
            'kode_toko.required'     => 'Kode Toko (KDTK) wajib diisi.',
            'tanggal_masuk.required' => 'Tanggal masuk service wajib diisi.',
        ]);

        ServiceBarang::create([
            'no_dat'        => $request->no_dat ? trim($request->no_dat) : null,
            'sn'            => $request->sn ? trim($request->sn) : null,
            'nama_barang'   => trim($request->nama_barang),
            'kode_toko'     => strtoupper(trim($request->kode_toko)),
            'kerusakan'     => $request->kerusakan ? trim($request->kerusakan) : null,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status'        => 'Belum Cek', // Awal selalu Belum Cek
            'keterangan'    => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('service.index')->with('success', 'Barang service baru berhasil didaftarkan dengan status "Belum Cek".');
    }

    /**
     * Menu Tindakan Service & Ubah Status Alur Service
     */
    public function updateTindakan(Request $request, $id)
    {
        $service = ServiceBarang::findOrFail($id);

        $request->validate([
            'status'          => 'required|in:Belum Cek,Sudah Cek,Service Suplier,Selesai Service',
            'tindakan'        => 'nullable|string',
            'keterangan'      => 'nullable|string',
            'tanggal_selesai' => 'nullable|date',
            'parts'           => 'nullable|array',
            'parts.*.barang_id' => 'nullable|exists:barang,id',
            'parts.*.qty'       => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $service->status = $request->status;
            if ($request->filled('tindakan')) {
                $service->tindakan = trim($request->tindakan);
            }
            if ($request->filled('keterangan')) {
                $service->keterangan = trim($request->keterangan);
            }

            // Jika status Selesai Service
            if ($request->status === 'Selesai Service') {
                $service->tanggal_selesai = $request->tanggal_selesai ?: date('Y-m-d');

                // Proses Part Keluar jika ada
                if ($request->has('parts') && is_array($request->parts)) {
                    foreach ($request->parts as $partItem) {
                        if (!empty($partItem['barang_id']) && !empty($partItem['qty'])) {
                            $barangId = (int) $partItem['barang_id'];
                            $qtyUsed  = (int) $partItem['qty'];

                            $barang = Barang::lockForUpdate()->find($barangId);
                            if (!$barang) {
                                continue;
                            }

                            if ($barang->qty_stock < $qtyUsed) {
                                DB::rollBack();
                                return redirect()->back()->with('error', "Stok untuk part \"{$barang->nama_barang}\" tidak mencukupi! Sisa stok: {$barang->qty_stock}, Dibutuhkan: {$qtyUsed}.");
                            }

                            $stkBefore = (int) $barang->qty_stock;
                            $stkAfter = $stkBefore - $qtyUsed;

                            // Kurangi stok barang
                            $barang->qty_stock = $stkAfter;
                            $barang->save();

                            // Catat ke riwayat part keluar service
                            ServicePartKeluar::create([
                                'service_barang_id' => $service->id,
                                'barang_id'         => $barang->id,
                                'kode_plu'          => $barang->kode_plu,
                                'nama_barang'       => $barang->nama_barang,
                                'qty'               => $qtyUsed,
                                'tanggal_keluar'    => $service->tanggal_selesai ?: date('Y-m-d'),
                            ]);

                            // Catat ke Audit Trail Log Transit Barang (OUT)
                            \App\Models\BarangLogTransit::create([
                                'barang_id'         => $barang->id,
                                'kode_plu'          => $barang->kode_plu,
                                'nama_barang'       => $barang->nama_barang,
                                'divisi'            => $barang->divisi,
                                'satuan'            => $barang->satuan ?: 'PCS',
                                'tipe'              => 'OUT',
                                'kategori'          => 'Service Unit Selesai',
                                'qty'               => $qtyUsed,
                                'stok_awal'         => $stkBefore,
                                'stok_akhir'        => $stkAfter,
                                'tujuan_sumber'     => "Unit: {$service->nama_barang} (KDTK: {$service->kode_toko})",
                                'referensi_id'      => $service->id,
                                'pic'               => session('user_name') ?? 'Teknisi Service',
                                'keterangan'        => "Penggunaan part service unit " . ($service->no_dat ? "DAT: {$service->no_dat}" : "SN: {$service->sn}"),
                                'tanggal_transaksi' => $service->tanggal_selesai ?: date('Y-m-d'),
                            ]);
                        }
                    }
                }
            }

            $service->save();
            DB::commit();

            return redirect()->route('service.index')->with('success', "Status unit \"{$service->nama_barang}\" berhasil diperbarui menjadi \"{$service->status}\".");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses tindakan service: ' . $e->getMessage());
        }
    }

    /**
     * Update data informasi service
     */
    public function update(Request $request, $id)
    {
        $service = ServiceBarang::findOrFail($id);

        $request->validate([
            'nama_barang'     => 'required|string|max:200',
            'kode_toko'       => 'required|string|max:50',
            'tanggal_masuk'   => 'required|date',
            'no_dat'          => 'nullable|string|max:100',
            'sn'              => 'nullable|string|max:100',
            'kerusakan'       => 'nullable|string',
            'tindakan'        => 'nullable|string',
            'tanggal_selesai' => 'nullable|date',
            'keterangan'      => 'nullable|string',
        ]);

        $service->update([
            'no_dat'          => $request->no_dat ? trim($request->no_dat) : null,
            'sn'              => $request->sn ? trim($request->sn) : null,
            'nama_barang'     => trim($request->nama_barang),
            'kode_toko'       => strtoupper(trim($request->kode_toko)),
            'kerusakan'       => $request->kerusakan ? trim($request->kerusakan) : null,
            'tindakan'        => $request->tindakan ? trim($request->tindakan) : null,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'keterangan'      => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('service.index')->with('success', 'Data service barang berhasil diperbarui.');
    }

    /**
     * Hapus data service
     */
    public function destroy(Request $request, $id)
    {
        $service = ServiceBarang::findOrFail($id);
        $nama = $service->nama_barang;
        $service->delete();

        return redirect()->route('service.index')->with('success', "Data service \"{$nama}\" berhasil dihapus.");
    }

    /**
     * Export Data Service ke format CSV/Excel
     */
    public function exportExcel()
    {
        $data = ServiceBarang::with(['partKeluars', 'toko'])->orderBy('id', 'desc')->get();
        $filename = 'data_service_barang_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID',
                'No DAT',
                'Serial Number (SN)',
                'Nama Barang',
                'Kode Toko (KDTK)',
                'Nama Toko',
                'Kerusakan',
                'Tindakan / Diagnosa',
                'Status',
                'Tanggal Masuk',
                'Tanggal Selesai',
                'Part Keluar Digunakan',
                'Keterangan'
            ]);

            foreach ($data as $item) {
                $partsUsed = [];
                foreach ($item->partKeluars as $part) {
                    $partsUsed[] = "{$part->nama_barang} (PLU: {$part->kode_plu}, Qty: {$part->qty})";
                }

                fputcsv($file, [
                    $item->id,
                    $item->no_dat ?: '-',
                    $item->sn ?: '-',
                    $item->nama_barang,
                    $item->kode_toko,
                    $item->toko ? $item->toko->nama_toko : '-',
                    $item->kerusakan ?: '-',
                    $item->tindakan ?: '-',
                    $item->status,
                    $item->tanggal_masuk ? $item->tanggal_masuk->format('Y-m-d') : '-',
                    $item->tanggal_selesai ? $item->tanggal_selesai->format('Y-m-d') : '-',
                    !empty($partsUsed) ? implode('; ', $partsUsed) : '-',
                    $item->keterangan ?: '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
