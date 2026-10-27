<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spekpc;
use App\Models\ServiceBarang;
use App\Models\Barang;
use App\Models\BarangLogTransit;
use App\Models\Toko;

class DashboardController extends Controller
{
    public function index()
    {
        // ── 1. Spek PC Fleet Stats ──────────────────────
        $totalPc    = Spekpc::count();
        $bagusCount = Spekpc::where('status', 'BAGUS')->count();
        $amanCount  = Spekpc::where('status', 'AMAN')->count();
        $underCount = Spekpc::where('status', 'UNDER')->count();
        $deptCount  = Spekpc::whereNotNull('dept')->where('dept', '!=', '')->distinct('dept')->count('dept');

        $topDepts = Spekpc::selectRaw('dept, count(*) as total')
            ->whereNotNull('dept')->where('dept', '!=', '')
            ->groupBy('dept')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $osStats = Spekpc::selectRaw('windows, count(*) as total')
            ->whereNotNull('windows')->where('windows', '!=', '')
            ->groupBy('windows')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $recentPc = Spekpc::latest('id')->take(12)->get();
        $underPcList = Spekpc::where('status', 'UNDER')->latest('id')->take(5)->get();
        $allPcList = Spekpc::orderBy('ip', 'asc')->get();

        // ── 2. Service Monitoring Stats ────────────────
        $totalService   = ServiceBarang::count();
        $belumCekCount  = ServiceBarang::where('status', 'Belum Cek')->count();
        $sudahCekCount  = ServiceBarang::where('status', 'Sudah Cek')->count();
        $suplierCount   = ServiceBarang::where('status', 'Service Suplier')->count();
        $selesaiCount   = ServiceBarang::where('status', 'Selesai Service')->count();

        $recentServices = ServiceBarang::with('toko')->latest('id')->take(8)->get();

        // ── 3. Spare Parts & Inventory Stats ───────────
        $totalParts       = Barang::count();
        $totalStockQty    = (int) Barang::sum('qty_stock');
        $partHabisCount   = Barang::where('qty_stock', '<=', 0)->count();
        $partMenipisCount = Barang::where('qty_stock', '>', 0)->where('qty_stock', '<=', 5)->count();
        $partAmanCount    = Barang::where('qty_stock', '>', 5)->count();
        $totalPartValuation = (float) Barang::sum('total_harga');

        $partMovingStats = Barang::selectRaw('moving, count(*) as total')
            ->whereNotNull('moving')->where('moving', '!=', '')
            ->groupBy('moving')
            ->orderByDesc('total')
            ->get();

        $criticalParts = Barang::where('qty_stock', '<=', 5)
            ->orderBy('qty_stock', 'asc')
            ->take(8)
            ->get();

        $lastSyncPart = Barang::max('last_synced_at');

        // ── 4. Log Transit Stats ───────────────────────
        $totalLogs   = BarangLogTransit::count();
        $logInCount  = BarangLogTransit::where('tipe', 'IN')->count();
        $logOutCount = BarangLogTransit::where('tipe', 'OUT')->count();

        $recentLogs = BarangLogTransit::latest('id')->take(8)->get();

        // ── 5. Toko Network ───────────────────────────
        $totalToko = Toko::count();

        // ── 6. Health Index Score ─────────────────────
        $pcHealthScore = $totalPc > 0 ? round((($bagusCount + ($amanCount * 0.7)) / $totalPc) * 100) : 100;
        $stockHealthScore = $totalParts > 0 ? round((($partAmanCount + ($partMenipisCount * 0.5)) / $totalParts) * 100) : 100;
        $serviceResolutionRate = $totalService > 0 ? round(($selesaiCount / $totalService) * 100) : 100;
        $overallHealthScore = round(($pcHealthScore * 0.5) + ($stockHealthScore * 0.5));

        return view('pages.dashboard', compact(
            'totalPc',
            'bagusCount',
            'amanCount',
            'underCount',
            'deptCount',
            'topDepts',
            'osStats',
            'recentPc',
            'underPcList',
            'allPcList',
            'totalService',
            'belumCekCount',
            'sudahCekCount',
            'suplierCount',
            'selesaiCount',
            'recentServices',
            'serviceResolutionRate',
            'totalParts',
            'totalStockQty',
            'partHabisCount',
            'partMenipisCount',
            'partAmanCount',
            'totalPartValuation',
            'partMovingStats',
            'criticalParts',
            'lastSyncPart',
            'totalLogs',
            'logInCount',
            'logOutCount',
            'recentLogs',
            'totalToko',
            'pcHealthScore',
            'stockHealthScore',
            'overallHealthScore'
        ));
    }
}