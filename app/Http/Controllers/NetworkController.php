<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spekpc;

class NetworkController extends Controller
{
    /**
     * Halaman Network Monitor.
     * Ambil ip, nama, dept, compname dari tabel spekpc.
     */
    public function index()
    {
        $devices = Spekpc::select('id', 'ip', 'nama', 'dept', 'compname', 'nik')
            ->whereNotNull('ip')
            ->where('ip', '!=', '')
            ->orderBy('dept')
            ->orderBy('nama')
            ->get();

        return view('pages.network', compact('devices'));
    }

    /**
     * Ping satu IP — dipanggil AJAX dari JS.
     * POST /network/ping  { ip: "192.168.x.x" }
     * Return JSON: { ip, online, latency }
     */
    public function ping(Request $request)
    {
        $request->validate(['ip' => ['required', 'ip']]);

        $ip = $request->input('ip');
        [$isOnline, $latency] = $this->doPing($ip);

        return response()->json([
            'ip'      => $ip,
            'online'  => $isOnline,
            'latency' => $latency,   // ms atau null kalau offline
        ]);
    }

    /* ─── Internal ping helper ─────────────────── */
    private function doPing(string $ip): array
    {
        $os = PHP_OS_FAMILY;

        if ($os === 'Windows') {
            $cmd    = 'ping -n 1 -w 1000 ' . escapeshellarg($ip) . ' 2>&1';
            $marker = 'TTL=';
        } else {
            // Linux / Mac
            $cmd    = 'ping -c 1 -W 1 ' . escapeshellarg($ip) . ' 2>&1';
            $marker = 'ttl=';
        }

        $output   = shell_exec($cmd) ?? '';
        $isOnline = stripos($output, $marker) !== false;
        $latency  = null;

        if ($isOnline) {
            if ($os === 'Windows') {
                if (preg_match('/(?:[Ww]aktu|[Tt]ime)[<=](\d+)/', $output, $m)) {
                    $latency = (int) $m[1];
                }
            } else {
                if (preg_match('/time=([\d.]+)\s*ms/', $output, $m)) {
                    $latency = (int) round((float) $m[1]);
                }
            }
        }

        return [$isOnline, $latency];
    }
}