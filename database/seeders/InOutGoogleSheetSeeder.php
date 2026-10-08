<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\BarangLogTransit;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InOutGoogleSheetSeeder extends Seeder
{
    /**
     * Import seluruh riwayat transaksi Sheet IN dan Sheet OUT ke MySQL
     */
    public function run(): void
    {
        $sheetsService = app(GoogleSheetsService::class);
        $service = $sheetsService->getService();
        $spreadsheetId = config('services.google_sheets.spreadsheet_id', env('GOOGLE_SHEETS_SPREADSHEET_ID'));

        if (!$service) {
            $this->command?->error('Google Sheets Service belum terkonfigurasi.');
            return;
        }

        // Cache barang untuk lookup cepat by PLU atau Nama
        $allBarang = Barang::all();
        $barangByPlu = $allBarang->whereNotNull('kode_plu')->keyBy('kode_plu');
        $barangByName = $allBarang->keyBy(fn($b) => strtolower(trim($b->nama_barang)));

        DB::beginTransaction();
        try {
            // Hapus log lama yang bersumber dari Google Sheet agar seeder idempotent
            BarangLogTransit::whereNotNull('google_sheet_name')->delete();

            // 1. IMPORT SHEET [IN]
            $this->command?->info('Mengunduh dan mengimpor Sheet 6 [IN]...');
            $rangeIn = "'IN'!A7:M";
            $resIn = $service->spreadsheets_values->get($spreadsheetId, $rangeIn);
            $rowsIn = $resIn->getValues() ?? [];

            $countIn = 0;
            foreach ($rowsIn as $idx => $row) {
                $no = trim($row[0] ?? '');
                if (!is_numeric($no)) continue;

                $plu          = trim($row[1] ?? '');
                $namaBarang   = trim($row[2] ?? '');
                $tglDatang    = self::parseFlexibleDate($row[3] ?? '');
                $tglBtb       = self::parseFlexibleDate($row[4] ?? '') ?: $tglDatang;
                $periode      = trim($row[5] ?? '');
                $divisi       = trim($row[6] ?? 'CPU') ?: 'CPU';
                $satuan       = trim($row[7] ?? 'PCS') ?: 'PCS';
                $noBtb        = trim($row[8] ?? '');
                $qty          = (int) self::cleanNumber($row[9] ?? 1) ?: 1;
                $harga        = self::cleanCurrency($row[10] ?? 0);
                $total        = self::cleanCurrency($row[11] ?? 0) ?: ($qty * $harga);
                $keterangan   = trim($row[12] ?? '');

                $tglTrans     = $tglBtb ?: $tglDatang ?: date('Y-m-d');

                // Cari barang_id
                $barangId = null;
                if ($plu && isset($barangByPlu[$plu])) {
                    $barangId = $barangByPlu[$plu]->id;
                } elseif (isset($barangByName[strtolower($namaBarang)])) {
                    $barangId = $barangByName[strtolower($namaBarang)]->id;
                }

                BarangLogTransit::create([
                    'no_urut'           => (int) $no,
                    'barang_id'         => $barangId,
                    'kode_plu'          => $plu ?: null,
                    'nama_barang'       => $namaBarang,
                    'divisi'            => $divisi,
                    'satuan'            => $satuan,
                    'periode'           => $periode,
                    'tgl_datang'        => $tglDatang,
                    'tgl_btb'           => $tglBtb,
                    'no_btb'            => ($noBtb && $noBtb !== '-') ? $noBtb : null,
                    'tgl_keluar'        => null,
                    'tgl_bkb'           => null,
                    'no_bkb'            => null,
                    'kdtk'              => null,
                    'nama_toko'         => null,
                    'aktiva'            => null,
                    'tipe'              => 'IN',
                    'kategori'          => 'Penerimaan BTB (Sheet IN)',
                    'qty'               => $qty,
                    'harga_satuan'      => $harga,
                    'total_harga'       => $total,
                    'stok_awal'         => 0,
                    'stok_akhir'        => $qty,
                    'tujuan_sumber'     => ($noBtb && $noBtb !== '-') ? "BTB No: {$noBtb}" : 'Penerimaan Supplier',
                    'referensi_id'      => null,
                    'pic'               => 'Teknisi EDP',
                    'keterangan'        => $keterangan ?: null,
                    'tanggal_transaksi' => $tglTrans,
                    'google_sheet_name' => 'IN',
                    'google_sheet_row'  => 7 + $idx,
                ]);

                $countIn++;
            }
            $this->command?->info("Berhasil mengimpor {$countIn} riwayat barang masuk dari Sheet [IN].");

            // 2. IMPORT SHEET [OUT]
            $this->command?->info('Mengunduh dan mengimpor Sheet 7 [OUT]...');
            $rangeOut = "'OUT'!A7:O";
            $resOut = $service->spreadsheets_values->get($spreadsheetId, $rangeOut);
            $rowsOut = $resOut->getValues() ?? [];

            $countOut = 0;
            foreach ($rowsOut as $idx => $row) {
                $no = trim($row[0] ?? '');
                if (!is_numeric($no)) continue;

                $plu          = trim($row[1] ?? '');
                $namaBarang   = trim($row[2] ?? '');
                $tglKeluar    = self::parseFlexibleDate($row[3] ?? '');
                $tglBkb       = self::parseFlexibleDate($row[4] ?? '') ?: $tglKeluar;
                $periode      = trim($row[5] ?? '');
                $divisi       = trim($row[6] ?? 'CPU') ?: 'CPU';
                $satuan       = trim($row[7] ?? 'PCS') ?: 'PCS';
                $kdtk         = trim($row[8] ?? '');
                $namaToko     = trim($row[9] ?? '');
                $aktiva       = trim($row[10] ?? '');
                $qty          = (int) self::cleanNumber($row[11] ?? 1) ?: 1;
                $harga        = self::cleanCurrency($row[12] ?? 0);
                $total        = self::cleanCurrency($row[13] ?? 0) ?: ($qty * $harga);
                $keterangan   = trim($row[14] ?? '');

                $tglTrans     = $tglKeluar ?: $tglBkb ?: date('Y-m-d');

                // Cari barang_id
                $barangId = null;
                if ($plu && isset($barangByPlu[$plu])) {
                    $barangId = $barangByPlu[$plu]->id;
                } elseif (isset($barangByName[strtolower($namaBarang)])) {
                    $barangId = $barangByName[strtolower($namaBarang)]->id;
                }

                $tujuan = $namaToko ?: ($kdtk ?: 'Pengeluaran Toko/Divisi');
                if ($kdtk && $namaToko) {
                    $tujuan = "{$kdtk} - {$namaToko}";
                }

                BarangLogTransit::create([
                    'no_urut'           => (int) $no,
                    'barang_id'         => $barangId,
                    'kode_plu'          => $plu ?: null,
                    'nama_barang'       => $namaBarang,
                    'divisi'            => $divisi,
                    'satuan'            => $satuan,
                    'periode'           => $periode,
                    'tgl_datang'        => null,
                    'tgl_btb'           => null,
                    'no_btb'            => null,
                    'tgl_keluar'        => $tglKeluar,
                    'tgl_bkb'           => $tglBkb,
                    'no_bkb'            => null,
                    'kdtk'              => $kdtk ?: null,
                    'nama_toko'         => $namaToko ?: null,
                    'aktiva'            => $aktiva ?: null,
                    'tipe'              => 'OUT',
                    'kategori'          => 'Pengeluaran BKB (Sheet OUT)',
                    'qty'               => $qty,
                    'harga_satuan'      => $harga,
                    'total_harga'       => $total,
                    'stok_awal'         => $qty,
                    'stok_akhir'        => 0,
                    'tujuan_sumber'     => $tujuan,
                    'referensi_id'      => null,
                    'pic'               => 'Teknisi EDP',
                    'keterangan'        => $keterangan ?: null,
                    'tanggal_transaksi' => $tglTrans,
                    'google_sheet_name' => 'OUT',
                    'google_sheet_row'  => 7 + $idx,
                ]);

                $countOut++;
            }
            $this->command?->info("Berhasil mengimpor {$countOut} riwayat barang keluar dari Sheet [OUT].");

            DB::commit();
            $this->command?->info("🎉 Selesai! Total {$countIn} IN dan {$countOut} OUT berhasil disinkronkan ke database MySQL.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("InOutGoogleSheetSeeder Error: " . $e->getMessage());
            $this->command?->error("Gagal mengimpor data: " . $e->getMessage());
        }
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

    private static function parseFlexibleDate(?string $val): ?string
    {
        if (empty($val) || $val === '-' || $val === '?') return null;
        $val = trim($val);

        // Format: d/m/Y or d-m-Y
        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $val, $m)) {
            return sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        }

        // Format: d-M-Y (e.g. 8-Sep-2026 or 10-Sep-2026)
        if (preg_match('/^(\d{1,2})\-([A-Za-z]+)\-(\d{4})$/', $val, $m)) {
            $ts = strtotime("{$m[1]} {$m[2]} {$m[3]}");
            return $ts ? date('Y-m-d', $ts) : null;
        }

        // Format: Month Year (e.g. July 2024)
        if (preg_match('/^([A-Za-z]+)\s+(\d{4})$/', $val, $m)) {
            $ts = strtotime("1 {$m[1]} {$m[2]}");
            return $ts ? date('Y-m-d', $ts) : null;
        }

        $ts = strtotime($val);
        return $ts ? date('Y-m-d', $ts) : null;
    }
}
