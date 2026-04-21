<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spekpc;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Spek PC Stats ──────────────────────
        $totalPc    = Spekpc::count();
        $bagusCount = Spekpc::where('status', 'BAGUS')->count();
        $amanCount  = Spekpc::where('status', 'AMAN')->count();
        $underCount = Spekpc::where('status', 'UNDER')->count();
        $deptCount  = Spekpc::whereNotNull('dept')->where('dept', '!=', '')->distinct('dept')->count('dept');

        // ── Recent PC (10 terbaru) ─────────────
        $recentPc = Spekpc::select('id', 'ip', 'nama', 'dept', 'status')
            ->latest('id')
            ->take(10)
            ->get();

        // ── Network Devices ────────────────────
        $networkDevices = Spekpc::select('id', 'ip', 'nama', 'dept', 'compname', 'nik')
            ->whereNotNull('ip')
            ->where('ip', '!=', '')
            ->orderBy('dept')
            ->orderBy('nama')
            ->get();

        $totalIp = $networkDevices->count();

        return view('pages.dashboard', compact(
            'totalPc',
            'bagusCount',
            'amanCount',
            'underCount',
            'deptCount',
            'recentPc',
            'networkDevices',
            'totalIp'
        ));
    }
}