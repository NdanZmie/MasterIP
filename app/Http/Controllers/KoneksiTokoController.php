<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;

class KoneksiTokoController extends Controller
{
    public function index()
    {
        $devices = Toko::select([
                'id_toko', 'kode_toko', 'nama_toko',
                'ip_cctv', 'ip_station_1', 'ip_station_2',
                'ip_station_3', 'ip_station_4', 'ip_station_5', 'ip_stb',
            ])
            ->whereNotNull('nama_toko')
            ->orderBy('nama_toko')
            ->get();

        return view('pages.koneksitoko', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required',
            'kode_toko' => 'required',
        ]);

        Toko::create([
            'kode_toko'    => $request->kode_toko,
            'nama_toko'    => $request->nama_toko,
            'ip_cctv'      => $request->ip_cctv,
            'ip_station_1' => $request->ip_station_1,
            'ip_station_2' => $request->ip_station_2,
            'ip_station_3' => $request->ip_station_3,
            'ip_station_4' => $request->ip_station_4,
            'ip_station_5' => $request->ip_station_5,
            'ip_stb'       => $request->ip_stb,
        ]);

        return redirect('/koneksitoko')->with('success', 'Data toko berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        $toko->update([
            'kode_toko'    => $request->kode_toko    ?? $toko->kode_toko,
            'nama_toko'    => $request->nama_toko    ?? $toko->nama_toko,
            'ip_cctv'      => $request->ip_cctv,
            'ip_station_1' => $request->ip_station_1,
            'ip_station_2' => $request->ip_station_2,
            'ip_station_3' => $request->ip_station_3,
            'ip_station_4' => $request->ip_station_4,
            'ip_station_5' => $request->ip_station_5,
            'ip_stb'       => $request->ip_stb,
        ]);

        return redirect('/koneksitoko')->with('success', 'Data toko berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $password = $request->input('password');
        if ($password !== env('EDP_PASSWORD', 'edp123')) {
            return redirect('/koneksitoko')->with('error', 'Password salah! Data tidak dihapus.');
        }

        Toko::findOrFail($id)->delete();
        return redirect('/koneksitoko')->with('success', 'Data toko berhasil dihapus');
    }

    public function ping(Request $request)
    {
        $request->validate(['ip' => ['required', 'ip']]);
        $ip = $request->input('ip');
        [$isOnline, $latency] = $this->doPing($ip);

        return response()->json([
            'ip'      => $ip,
            'online'  => $isOnline,
            'latency' => $latency,
        ]);
    }

    public function exportExcel()
    {
        $data     = Toko::all();
        $filename = 'koneksi_toko.xlsx';
        $headers  = [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Kode Toko', 'Nama Toko', 'IP CCTV',
                'IP Station 1', 'IP Station 2', 'IP Station 3',
                'IP Station 4', 'IP Station 5', 'IP STB',
            ]);
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->kode_toko, $row->nama_toko, $row->ip_cctv,
                    $row->ip_station_1, $row->ip_station_2, $row->ip_station_3,
                    $row->ip_station_4, $row->ip_station_5, $row->ip_stb,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function doPing(string $ip): array
    {
        $os = PHP_OS_FAMILY;
        if ($os === 'Windows') {
            $cmd    = 'ping -n 1 -w 1000 ' . escapeshellarg($ip) . ' 2>&1';
            $marker = 'TTL=';
        } else {
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