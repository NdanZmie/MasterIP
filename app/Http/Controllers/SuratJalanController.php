<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Toko;
use App\Models\Barang;
use Carbon\Carbon;

class SuratJalanController extends Controller
{
    /**
     * Display a listing of the Surat Jalan (Tracking list)
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $tipe = strtoupper(trim($request->input('tipe', 'ALL')));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = SuratJalan::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_sj', 'like', "%{$search}%")
                  ->orWhere('kepada', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('kode_toko', 'like', "%{$search}%")
                  ->orWhere('nama_toko', 'like', "%{$search}%")
                  ->orWhere('created_by', 'like', "%{$search}%")
                  ->orWhere('items', 'like', "%{$search}%");
            });
        }

        if ($tipe === 'GO' || $tipe === 'NORMAL') {
            $query->where('tipe_sj', $tipe);
        }

        if (!empty($startDate)) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        // Stats summary
        $totalSj     = SuratJalan::count();
        $totalGo     = SuratJalan::where('tipe_sj', 'GO')->count();
        $totalNormal = SuratJalan::where('tipe_sj', 'NORMAL')->count();
        $todaySj     = SuratJalan::whereDate('tanggal', Carbon::today())->count();

        $suratJalanList = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();

        // Autocomplete / Quick Picker helpers
        $tokoList = Toko::select('kode_toko', 'nama_toko')
            ->whereNotNull('kode_toko')
            ->where('kode_toko', '!=', '')
            ->orderBy('kode_toko')
            ->get();

        $barangList = Barang::select('nama_barang')
            ->whereNotNull('nama_barang')
            ->where('nama_barang', '!=', '')
            ->distinct()
            ->orderBy('nama_barang')
            ->limit(100)
            ->pluck('nama_barang');

        $kepadaHistory = SuratJalan::whereNotNull('kepada')
            ->where('kepada', '!=', '')
            ->where('kepada', '!=', '-')
            ->distinct()
            ->orderBy('kepada')
            ->pluck('kepada');

        return view('pages.surat_jalan', compact(
            'suratJalanList',
            'totalSj',
            'totalGo',
            'totalNormal',
            'todaySj',
            'search',
            'tipe',
            'startDate',
            'endDate',
            'tokoList',
            'barangList',
            'kepadaHistory'
        ));
    }

    /**
     * Store a newly created Surat Jalan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe_sj' => 'required|in:GO,NORMAL',
            'tanggal' => 'required|date',
        ]);

        $tipe = strtoupper($request->tipe_sj);

        // Auto generate No SJ if not provided
        $noSj = trim($request->input('no_sj', ''));
        if (empty($noSj)) {
            $noSj = SuratJalan::generateNoSj($tipe);
        }

        // Parse items from request
        $rawItems = $request->input('items', []);
        if (is_string($rawItems)) {
            $rawItems = json_decode($rawItems, true) ?: [];
        }

        $cleanedItems = [];
        $counter = 1;
        foreach ($rawItems as $item) {
            if ($tipe === 'GO') {
                $namaBarang = trim($item['nama_barang'] ?? $item['deskripsi'] ?? '');
                $jml = trim($item['jml'] ?? $item['qty'] ?? '');
                $keterangan = trim($item['ket'] ?? $item['keterangan'] ?? '');
                if ($namaBarang === '' && $keterangan === '') {
                    continue;
                }
                $cleanedItems[] = [
                    'no'          => $item['no'] ?? $counter++,
                    'nama_barang' => $namaBarang,
                    'deskripsi'   => $namaBarang,
                    'jml'         => $jml,
                    'qty'         => $jml,
                    'keterangan'  => $keterangan,
                ];
            } else {
                $namaBarang = trim($item['nama_barang'] ?? '');
                $snMac = trim($item['sn_mac'] ?? '');
                $keterangan = trim($item['keterangan'] ?? '');
                if ($namaBarang === '' && $snMac === '' && $keterangan === '') {
                    continue;
                }
                $cleanedItems[] = [
                    'no'          => $item['no'] ?? $counter++,
                    'nama_barang' => $namaBarang,
                    'jlh'         => $item['jlh'] ?? '',
                    'sn_mac'      => $snMac,
                    'keterangan'  => $keterangan,
                ];
            }
        }

        // Parse signatures
        $rawSignatures = $request->input('signatures', []);
        if (is_string($rawSignatures)) {
            $rawSignatures = json_decode($rawSignatures, true) ?: [];
        }

        $currentUserName = session('user_nama') ?: 'EDP';

        if ($tipe === 'GO') {
            $signatures = [
                'gam'     => trim($rawSignatures['gam'] ?? 'AWS'),
                'edpm'    => trim($rawSignatures['edpm'] ?? 'MJA'),
                'edps'    => trim($rawSignatures['edps'] ?? 'SETIAWAN'),
                'gas'     => trim($rawSignatures['gas'] ?? 'BOBBY'),
                'ga'      => trim($rawSignatures['ga'] ?? ''),
                'edpadm'  => trim($rawSignatures['edpadm'] ?? 'NANDA'),
            ];
        } else {
            $signatures = [
                'edpm'          => trim($rawSignatures['edpm'] ?? ''),
                'edps'          => trim($rawSignatures['edps'] ?? ''),
                'edp'           => trim($rawSignatures['edp'] ?? $currentUserName),
                'penerima_nama' => trim($rawSignatures['penerima_nama'] ?? ''),
                'penerima_nik'  => trim($rawSignatures['penerima_nik'] ?? ''),
            ];
        }

        $kodeToko = trim($request->input('kode_toko', ''));
        $namaToko = trim($request->input('nama_toko', ''));

        $kepada = trim($request->input('kepada', ''));
        if (empty($kepada)) {
            $kepada = ($tipe === 'GO') ? 'GA DEPT' : '-';
        }

        $perihal = trim($request->input('perihal', ''));
        if (empty($perihal) && $tipe === 'GO') {
            $perihal = "SERAH TERIMA BARANG EDP UNTUK TOKO BARU" . ($kodeToko ? " {$kodeToko}" : "") . ($namaToko ? " - {$namaToko}" : "");
        }

        $sj = SuratJalan::create([
            'no_sj'      => $noSj,
            'tipe_sj'    => $tipe,
            'tanggal'    => $request->tanggal,
            'kepada'     => $kepada,
            'perihal'    => $perihal,
            'kode_toko'  => $kodeToko,
            'nama_toko'  => $namaToko,
            'items'      => $cleanedItems,
            'signatures' => $signatures,
            'catatan'    => trim($request->input('catatan', '')),
            'created_by' => $currentUserName,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Surat Jalan {$sj->no_sj} berhasil dibuat!",
                'data'    => $sj,
            ]);
        }

        return redirect()->route('surat_jalan.index')
            ->with('success', "Surat Jalan {$sj->no_sj} berhasil dibuat!")
            ->with('preview_sj_id', $sj->id);
    }

    /**
     * Get specific Surat Jalan for Preview JSON
     */
    public function show($id)
    {
        $sj = SuratJalan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $sj,
        ]);
    }

    /**
     * Print-ready view for Surat Jalan
     */
    public function print($id)
    {
        $sj = SuratJalan::findOrFail($id);

        return view('pages.surat_jalan_print', compact('sj'));
    }

    /**
     * Remove the specified Surat Jalan from storage.
     */
    public function destroy(Request $request, $id)
    {
        $sj = SuratJalan::findOrFail($id);
        $noSj = $sj->no_sj;
        $sj->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Surat Jalan {$noSj} berhasil dihapus.",
            ]);
        }

        return redirect()->route('surat_jalan.index')
            ->with('success', "Surat Jalan {$noSj} berhasil dihapus.");
    }
}
