<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\BarangMutasiBulanan;
use Illuminate\Support\Facades\DB;

class LppStockGoogleSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('seeders/data/lpp_stock.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("CSV file not found: {$csvPath}");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BarangMutasiBulanan::truncate();
        Barang::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->command->error("Cannot open CSV file.");
            return;
        }

        // List 27 bulan dan offset kolomnya
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

        $rowIndex = 0;
        $importedCount = 0;

        while (($row = fgetcsv($handle, 10000, ',')) !== false) {
            $rowIndex++;
            if ($rowIndex <= 8) {
                // Header rows (lines 1 to 8)
                continue;
            }

            $no = trim($row[0] ?? '');
            if (!is_numeric($no)) {
                // TOTAL row or empty row
                continue;
            }

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

            $barang = Barang::create([
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
            ]);

            // Masukkan riwayat mutasi 27 bulan
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

            if (!empty($mutasiBatch)) {
                BarangMutasiBulanan::insert($mutasiBatch);
            }

            $importedCount++;
        }

        fclose($handle);
        $this->command->info("Berhasil mengimpor {$importedCount} data sparepart dari LPP Google Sheets.");
    }

    private static function cleanNumber($val): float
    {
        if (is_numeric($val)) {
            return (float) $val;
        }
        $val = trim((string) $val);
        $val = str_replace([',', ' ', '%'], '', $val);
        return is_numeric($val) ? (float) $val : 0.0;
    }

    private static function cleanCurrency($val): float
    {
        if (is_numeric($val)) {
            return (float) $val;
        }
        $val = trim((string) $val);
        if (strpos($val, '-') !== false && preg_match('/^[^\d]*-[^\d]*$/', $val)) {
            return 0.0;
        }
        $digits = preg_replace('/[^\d]/', '', $val);
        return is_numeric($digits) && $digits !== '' ? (float) $digits : 0.0;
    }
}
