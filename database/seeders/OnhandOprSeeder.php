<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\BarangOnhandOpr;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnhandOprSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai import data transaksi dari Google Sheet ONHAND OPR...');

        $sheetsService = app(GoogleSheetsService::class);
        $service = $sheetsService->getService();

        if (!$service) {
            $this->command->error('Koneksi Google Sheets Service belum dikonfigurasi.');
            return;
        }

        $spreadsheetId = config('services.google_sheets.spreadsheet_id', env('GOOGLE_SHEETS_SPREADSHEET_ID', '1l15LkNvLJYNNkfh2CqQn1na1KkFFn-fHgg35OVKMVm0'));
        $range = "'ONHAND OPR'!A1:M300";

        try {
            $response = $service->spreadsheets_values->get($spreadsheetId, $range, ['valueRenderOption' => 'FORMATTED_VALUE']);
            $values = $response->getValues() ?? [];

            if (empty($values)) {
                $this->command->warn('Tidak ada data yang ditemukan di sheet ONHAND OPR.');
                return;
            }

            DB::beginTransaction();
            BarangOnhandOpr::query()->delete();

            $importedCount = 0;
            $allBarang = Barang::all()->keyBy('kode_plu');

            for ($i = 5; $i < count($values); $i++) {
                $row = $values[$i];
                $rowNumber = $i + 1;

                $noStr = trim($row[0] ?? '');
                $plu   = trim($row[1] ?? '');
                $nama  = trim($row[2] ?? '');
                $tgl   = trim($row[3] ?? '');
                $div   = trim($row[4] ?? '');
                $sat   = trim($row[5] ?? 'PCS') ?: 'PCS';

                if ($noStr === '' && $plu === '' && $nama === '') {
                    continue;
                }

                $noUrut = is_numeric($noStr) ? (int)$noStr : ($importedCount + 1);

                // Cari barang berdasarkan PLU
                $barang = $plu ? ($allBarang[$plu] ?? null) : null;
                if (!$nama && $barang) {
                    $nama = $barang->nama_barang;
                }
                if (!$div && $barang) {
                    $div = $barang->divisi;
                }
                if (!$sat && $barang) {
                    $sat = $barang->satuan;
                }

                $tglParsed = null;
                if (!empty($tgl)) {
                    $ts = strtotime($tgl);
                    if ($ts) {
                        $tglParsed = date('Y-m-d', $ts);
                    }
                }

                $raihan = (int)($row[6] ?? 0);
                $ojak   = (int)($row[7] ?? 0);
                $rizki  = (int)($row[8] ?? 0);
                $zega   = (int)($row[9] ?? 0);

                $out = (int)($row[10] ?? 0);
                $ttl = (int)($row[11] ?? 0);
                $ket = trim($row[12] ?? '');

                // Tentukan teknisi pemegang
                $techAssigned = [];
                if ($raihan > 0) $techAssigned['RAIHAN'] = $raihan;
                if ($ojak > 0)   $techAssigned['OJAK']   = $ojak;
                if ($rizki > 0)  $techAssigned['RIZKI']  = $rizki;
                if ($zega > 0)   $techAssigned['ZEGA']   = $zega;

                if (empty($techAssigned)) {
                    // Baris historis lama sebelum penyederhanaan kolom
                    $teknisi = 'EDP OPR';
                    $qtyAmbil = max($out, 1);
                    $qtyOut = $out;
                    $qtySisa = 0;
                    $status = (stripos($ket, 'PEMUTIHAN') !== false) ? 'PEMUTIHAN' : 'SELESAI_OUT';

                    BarangOnhandOpr::create([
                        'barang_id'        => $barang ? $barang->id : null,
                        'no_urut'          => $noUrut,
                        'kode_plu'         => $plu ?: null,
                        'nama_barang'      => $nama ?: 'Sparepart EDP',
                        'tanggal_ambil'    => $tglParsed,
                        'divisi'           => $div ?: 'CPU',
                        'satuan'           => $sat ?: 'PCS',
                        'teknisi'          => $teknisi,
                        'qty_ambil'        => $qtyAmbil,
                        'qty_out'          => $qtyOut,
                        'qty_sisa'         => $qtySisa,
                        'status'           => $status,
                        'keterangan'       => $ket ?: null,
                        'google_sheet_row' => $rowNumber,
                        'last_synced_at'   => now(),
                    ]);
                    $importedCount++;
                } else {
                    // Masukkan per teknisi yang mengambil
                    foreach ($techAssigned as $tName => $qtyTaken) {
                        $qtyOut = $out;
                        // Hitung sisa onhand
                        $sisa = max(0, $qtyTaken - $qtyOut);
                        if ($ttl > 0) {
                            $sisa = min($qtyTaken, $ttl);
                        }

                        $status = 'ONHAND';
                        if (stripos($ket, 'PEMUTIHAN') !== false) {
                            $status = 'PEMUTIHAN';
                        } elseif ($sisa <= 0) {
                            $status = 'SELESAI_OUT';
                        }

                        BarangOnhandOpr::create([
                            'barang_id'        => $barang ? $barang->id : null,
                            'no_urut'          => $noUrut,
                            'kode_plu'         => $plu ?: null,
                            'nama_barang'      => $nama ?: 'Sparepart EDP',
                            'tanggal_ambil'    => $tglParsed,
                            'divisi'           => $div ?: 'CPU',
                            'satuan'           => $sat ?: 'PCS',
                            'teknisi'          => $tName,
                            'qty_ambil'        => $qtyTaken,
                            'qty_out'          => $qtyOut,
                            'qty_sisa'         => $sisa,
                            'status'           => $status,
                            'keterangan'       => $ket ?: null,
                            'google_sheet_row' => $rowNumber,
                            'last_synced_at'   => now(),
                        ]);
                        $importedCount++;
                    }
                }
            }

            DB::commit();
            $this->command->info("Berhasil mengimpor {$importedCount} data transaksi ke tabel barang_onhand_opr.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal mengimpor data ONHAND OPR: ' . $e->getMessage());
            Log::error('OnhandOprSeeder Error: ' . $e->getMessage());
        }
    }
}
