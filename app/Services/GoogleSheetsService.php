<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangMutasiBulanan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    protected ?Client $client = null;
    protected ?Sheets $service = null;
    protected string $spreadsheetId;
    protected string $sheetName;
    protected string $credentialsPath;

    public function __construct()
    {
        $this->spreadsheetId = config('services.google_sheets.spreadsheet_id', env('GOOGLE_SHEETS_SPREADSHEET_ID', '1l15LkNvLJYNNkfh2CqQn1na1KkFFn-fHgg35OVKMVm0'));
        $this->sheetName = config('services.google_sheets.sheet_name', env('GOOGLE_SHEETS_SHEET_NAME', 'LPP STOCK (SPAREPART EDP)'));
        
        $credPath = env('GOOGLE_SERVICE_ACCOUNT_JSON', 'google/service-account.json');
        $this->credentialsPath = storage_path('app/' . ltrim($credPath, '/'));

        $this->registerAutoloaderFallback();
    }

    /**
     * Pastikan namespace Google API selalu dapat di-load
     */
    protected function registerAutoloaderFallback(): void
    {
        if (!class_exists('Google\Client')) {
            spl_autoload_register(function ($class) {
                $prefixes = [
                    'Google\\Service\\' => base_path('vendor/google/apiclient-services/src/'),
                    'Google\\Auth\\'    => base_path('vendor/google/auth/src/'),
                    'Google\\'          => base_path('vendor/google/apiclient/src/'),
                    'Firebase\\JWT\\'   => base_path('vendor/firebase/php-jwt/src/'),
                ];
                foreach ($prefixes as $prefix => $base_dir) {
                    $len = strlen($prefix);
                    if (strncmp($prefix, $class, $len) !== 0) {
                        continue;
                    }
                    $relative_class = substr($class, $len);
                    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
                    if (file_exists($file)) {
                        require_once $file;
                        return;
                    }
                }
            });
        }
    }

    /**
     * Cek apakah file kredensial Service Account Google Cloud sudah tersedia
     */
    public function isConfigured(): bool
    {
        return file_exists($this->credentialsPath) && is_readable($this->credentialsPath);
    }

    /**
     * Dapatkan path kredensial
     */
    public function getCredentialsPath(): string
    {
        return $this->credentialsPath;
    }

    /**
     * Inisialisasi Google Sheets Client
     */
    public function getService(): ?Sheets
    {
        if ($this->service !== null) {
            return $this->service;
        }

        if (!$this->isConfigured()) {
            return null;
        }

        $this->registerAutoloaderFallback();

        try {
            $this->client = new Client();
            $this->client->setApplicationName('MasterIP Stock Sync');
            $this->client->setScopes([Sheets::SPREADSHEETS]);
            $this->client->setAuthConfig($this->credentialsPath);
            $this->client->setAccessType('offline');

            $this->service = new Sheets($this->client);
            return $this->service;
        } catch (\Exception $e) {
            Log::error('Google Sheets Client Init Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Dapatkan email Client dari file kredensial service account
     */
    public function getClientEmail(): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        try {
            $json = json_decode(file_get_contents($this->credentialsPath), true);
            return $json['client_email'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Dapatkan detail Project ID dari file kredensial
     */
    public function getProjectId(): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        try {
            $json = json_decode(file_get_contents($this->credentialsPath), true);
            return $json['project_id'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Uji koneksi ke Google Sheets API dan baca sampel data
     */
    public function testConnection(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => "File service-account.json belum ditemukan di: {$this->credentialsPath}",
                'help'    => 'Silakan letakkan file service-account.json dari Google Cloud Console ke direktori storage/app/google/service-account.json'
            ];
        }

        $clientEmail = $this->getClientEmail();
        $service = $this->getService();
        if (!$service) {
            return [
                'success' => false,
                'message' => 'Gagal menginisialisasi Google API Client. Periksa format file JSON kredensial.',
                'email'   => $clientEmail,
            ];
        }

        try {
            // Coba baca metadata spreadsheet
            $spreadsheet = $service->spreadsheets->get($this->spreadsheetId);
            $title = $spreadsheet->getProperties()->getTitle();

            // Coba baca sample 5 baris pertama data LPP Stock
            $sampleRange = "'{$this->sheetName}'!A9:E13";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $sampleRange);
            $sampleRows = $response->getValues() ?? [];

            return [
                'success'          => true,
                'message'          => "Koneksi Google Sheets Berhasil!",
                'spreadsheet_title'=> $title,
                'sheet_name'       => $this->sheetName,
                'client_email'     => $clientEmail,
                'sample_count'     => count($sampleRows),
                'sample_data'      => $sampleRows,
            ];
        } catch (\Google\Service\Exception $gEx) {
            $errBody = json_decode($gEx->getMessage(), true);
            $errMsg = $errBody['error']['message'] ?? $gEx->getMessage();
            $status = $gEx->getCode();

            $solution = '';
            if ($status === 403 || str_contains($errMsg, 'permission') || str_contains($errMsg, 'IAM')) {
                $solution = "Akses ditolak (403). Pastikan spreadsheet Google Sheet sudah di-Share dengan email [{$clientEmail}] dengan role 'Editor'. Serta pastikan 'Google Sheets API' sudah diaktifkan (Enable) di Google Cloud Console.";
            } elseif ($status === 404) {
                $solution = "Spreadsheet tidak ditemukan (404). Periksa SPREADSHEET_ID di .env [{$this->spreadsheetId}].";
            }

            return [
                'success'      => false,
                'status_code'  => $status,
                'message'      => "Google API Error ({$status}): {$errMsg}",
                'client_email' => $clientEmail,
                'solution'     => $solution,
            ];
        } catch (\Exception $e) {
            return [
                'success'      => false,
                'message'      => 'Error: ' . $e->getMessage(),
                'client_email' => $clientEmail,
            ];
        }
    }

    /**
     * Baca range tertentu dari Google Sheets
     */
    public function readRange(string $range): ?array
    {
        $service = $this->getService();
        if (!$service) return null;

        try {
            $fullRange = "'{$this->sheetName}'!{$range}";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $fullRange);
            return $response->getValues();
        } catch (\Exception $e) {
            Log::error("Gagal membaca Google Sheet range [{$range}]: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Konversi 0-based column index ke A1 notation (0 -> A, 1 -> B, 92 -> CO, 104 -> DA)
     */
    public static function columnIndexToA1(int $colIndex): string
    {
        $letters = '';
        while ($colIndex >= 0) {
            $letters = chr(($colIndex % 26) + 65) . $letters;
            $colIndex = intdiv($colIndex, 26) - 1;
        }
        return $letters;
    }

    /**
     * Update single cell / range di Google Sheets
     */
    public function updateRange(string $range, array $values): bool
    {
        $service = $this->getService();
        if (!$service) {
            Log::info("Google Sheets Service Account belum dikonfigurasi. Update range [{$range}] dilewati.");
            return false;
        }

        try {
            $body = new ValueRange([
                'values' => $values
            ]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $fullRange = "'{$this->sheetName}'!{$range}";

            $service->spreadsheets_values->update(
                $this->spreadsheetId,
                $fullRange,
                $body,
                $params
            );

            return true;
        } catch (\Exception $e) {
            Log::error("Gagal update Google Sheet range [{$range}]: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Tulis pembaruan data barang ke baris Google Sheets yang bersangkutan (Write-Back)
     */
    public function syncBarangToSheet(Barang $barang, array $customFields = []): array
    {
        if (!$this->isConfigured()) {
            return [
                'status' => 'local_only',
                'message' => 'Tersimpan di database lokal. Untuk update otomatis ke Google Sheets, pasang Google Service Account key.'
            ];
        }

        $row = $barang->google_sheet_row;

        // Jika row belum tercatat, cari baris berdasarkan nomor urut (A) atau PLU (B)
        if (!$row || $row < 9) {
            $row = $this->findRowByPluOrName($barang->kode_plu, $barang->nama_barang);
            if ($row) {
                $barang->google_sheet_row = $row;
                $barang->saveQuietly();
            }
        }

        if (!$row) {
            return [
                'status' => 'not_found_in_sheet',
                'message' => 'Barang berhasil disimpan di database lokal, namun barisnya tidak ditemukan di Google Sheets.'
            ];
        }

        $successUpdates = [];

        // 1. Update Saldo Akhir / Stok Fisik (Kolom CO = Col Index 92)
        $rangeStok = "CO{$row}";
        if ($this->updateRange($rangeStok, [[$barang->qty_stock]])) {
            $successUpdates[] = "Stok ({$barang->qty_stock})";
        }

        // 2. Update PKM (Kolom G = Col Index 6) jika ada di payload
        if (isset($customFields['pkm'])) {
            if ($this->updateRange("G{$row}", [[$barang->pkm]])) {
                $successUpdates[] = "PKM ({$barang->pkm})";
            }
        }

        // 3. Update Usulan PP (Kolom CU = Col Index 98) jika ada di payload
        if (isset($customFields['qty_pp'])) {
            if ($this->updateRange("CU{$row}", [[$barang->qty_pp]])) {
                $successUpdates[] = "Qty PP ({$barang->qty_pp})";
            }
        }

        // 4. Update Keterangan (Kolom DA = Col Index 104) jika ada di payload
        if (isset($customFields['keterangan'])) {
            if ($this->updateRange("DA{$row}", [[$barang->keterangan ?? '']])) {
                $successUpdates[] = "Keterangan";
            }
        }

        return [
            'status' => !empty($successUpdates) ? 'synced' : 'error',
            'message' => !empty($successUpdates) 
                ? 'Berhasil sinkronisasi ke Google Sheets baris ' . $row . ' (' . implode(', ', $successUpdates) . ')'
                : 'Gagal memperbarui sel di Google Sheets.'
        ];
    }

    /**
     * Append row ke sheet tertentu (Sheet IN atau OUT)
     */
    public function appendRow(string $sheetName, array $rowValues): ?int
    {
        $service = $this->getService();
        if (!$service) {
            Log::info("Google Sheets Service Account belum dikonfigurasi. Append row [{$sheetName}] dilewati.");
            return null;
        }

        try {
            $body = new ValueRange([
                'values' => [$rowValues]
            ]);
            $params = [
                'valueInputOption' => 'USER_ENTERED',
                'insertDataOption' => 'INSERT_ROWS'
            ];
            $range = "'{$sheetName}'!A:A";

            $result = $service->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );

            $updatedRange = $result->getUpdates() ? $result->getUpdates()->getUpdatedRange() : null;
            if ($updatedRange && preg_match('/!A(\d+):/', $updatedRange, $matches)) {
                return (int) $matches[1];
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Gagal append row ke Google Sheet [{$sheetName}]: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Dapatkan nomor urut terakhir di Sheet tertentu (IN atau OUT)
     */
    public function getLastNoUrut(string $sheetName): int
    {
        $service = $this->getService();
        if (!$service) return 0;

        try {
            $range = "'{$sheetName}'!A7:A";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues() ?? [];

            $maxNo = 0;
            foreach ($values as $row) {
                $val = trim($row[0] ?? '');
                if (is_numeric($val)) {
                    $maxNo = max($maxNo, (int) $val);
                }
            }
            return $maxNo;
        } catch (\Exception $e) {
            Log::error("Gagal membaca last No Urut dari [{$sheetName}]: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Tulis transaksi barang masuk ke Sheet 6 [IN]
     */
    public function appendBarangMasuk(array $data): array
    {
        if (!$this->isConfigured()) {
            return [
                'status' => 'local_only',
                'message' => 'Tersimpan di database lokal. Pasang Google Service Account untuk sync ke Sheet IN.'
            ];
        }

        $lastNo = $this->getLastNoUrut('IN');
        $nextNo = $lastNo + 1;

        $tglDatangRaw = !empty($data['tgl_datang']) ? $data['tgl_datang'] : date('Y-m-d');
        $tglDatang = date('d/m/Y', strtotime($tglDatangRaw));
        
        $tglBtb = !empty($data['tgl_btb']) 
            ? date('d/m/Y', strtotime($data['tgl_btb'])) 
            : (!empty($data['no_btb']) ? $tglDatang : $tglDatang);

        $periode = !empty($data['periode']) 
            ? strtoupper($data['periode']) 
            : strtoupper(date('My', strtotime($tglDatangRaw)));

        $harga = (float) ($data['harga_satuan'] ?? 0);
        $qty   = (int) ($data['qty'] ?? 1);
        $total = (float) ($data['total_harga'] ?? ($qty * $harga));

        $hargaFormatted = 'Rp' . number_format($harga, 0, '', ',');
        $totalFormatted = 'Rp' . number_format($total, 0, '', ',');

        // Jika No BTB kosong, tulis "-" sesuai format historis Sheet IN
        $noBtb = !empty($data['no_btb']) ? trim((string)$data['no_btb']) : '-';

        $rowValues = [
            $nextNo,                                        // Col A: NO
            (string) ($data['kode_plu'] ?? ''),             // Col B: PLU
            (string) ($data['nama_barang'] ?? ''),          // Col C: NAMA BARANG
            $tglDatang,                                     // Col D: TGL DATANG
            $tglBtb,                                        // Col E: TGL BTB
            $periode,                                       // Col F: PERIODE (e.g. SEP26)
            (string) ($data['divisi'] ?? 'CPU'),            // Col G: KTGR BRG
            (string) ($data['satuan'] ?? 'PCS'),            // Col H: SATUAN
            $noBtb,                                         // Col I: NO BTB (Nomor BTB atau "-")
            $qty,                                           // Col J: QTY
            $hargaFormatted,                                // Col K: HARGA
            $totalFormatted,                                // Col L: TOTAL
            (string) ($data['keterangan'] ?? '')            // Col M: KETERANGAN
        ];

        $insertedRow = $this->appendRow('IN', $rowValues);

        return [
            'status'       => $insertedRow ? 'synced' : 'error',
            'no_urut'      => $nextNo,
            'inserted_row' => $insertedRow,
            'message'      => $insertedRow 
                ? "Berhasil dicatat ke Google Sheets [IN] baris {$insertedRow} (No #{$nextNo})" 
                : "Gagal menambahkan baris ke Sheet IN."
        ];
    }

    /**
     * Tulis transaksi barang keluar ke Sheet 7 [OUT]
     */
    public function appendBarangKeluar(array $data): array
    {
        if (!$this->isConfigured()) {
            return [
                'status' => 'local_only',
                'message' => 'Tersimpan di database lokal. Pasang Google Service Account untuk sync ke Sheet OUT.'
            ];
        }

        $lastNo = $this->getLastNoUrut('OUT');
        $nextNo = $lastNo + 1;

        $tglKeluarRaw = !empty($data['tgl_keluar']) ? $data['tgl_keluar'] : date('Y-m-d');
        // Format tanggal keluar sesuai pola Sheet OUT (contoh: 10-Sep-2026)
        $tglKeluar = date('j-M-Y', strtotime($tglKeluarRaw));
        
        // Tanggal BKB hanya diisi jika ada; jika tidak ada, biarkan kosong string ("")
        $tglBkb = !empty($data['tgl_bkb']) ? date('j-M-Y', strtotime($data['tgl_bkb'])) : '';
        
        $periode = !empty($data['periode']) 
            ? strtoupper($data['periode']) 
            : strtoupper(date('My', strtotime($tglKeluarRaw)));

        $harga = (float) ($data['harga_satuan'] ?? 0);
        $qty   = (int) ($data['qty'] ?? 1);
        $total = (float) ($data['total_harga'] ?? ($qty * $harga));

        $hargaFormatted = 'Rp' . number_format($harga, 0, '', ',');
        $totalFormatted = 'Rp' . number_format($total, 0, '', ',');

        // No Aktiva hanya diisi jika barang bertipe aktiva / memiliki no DAT; kosongkan jika non-aktiva
        $aktiva = !empty($data['aktiva']) ? trim((string)$data['aktiva']) : '';

        $rowValues = [
            $nextNo,                                        // Col A: NO
            (string) ($data['kode_plu'] ?? ''),             // Col B: PLU
            (string) ($data['nama_barang'] ?? ''),          // Col C: NAMA BARANG
            $tglKeluar,                                     // Col D: TGL KELUAR
            $tglBkb,                                        // Col E: TGL BKB (kosong jika tanpa BKB)
            $periode,                                       // Col F: PERIODE (e.g. SEP26)
            (string) ($data['divisi'] ?? 'CPU'),            // Col G: KTGR BRG
            (string) ($data['satuan'] ?? 'PCS'),            // Col H: SATUAN
            (string) ($data['kdtk'] ?? ''),                 // Col I: KDTK
            (string) ($data['nama_toko'] ?? ''),            // Col J: NAMA TOKO
            $aktiva,                                        // Col K: AKTIVA (kosong jika non-aktiva)
            $qty,                                           // Col L: QTY
            $hargaFormatted,                                // Col M: HARGA
            $totalFormatted,                                // Col N: TOTAL
            (string) ($data['keterangan'] ?? '')            // Col O: KETERANGAN
        ];

        $insertedRow = $this->appendRow('OUT', $rowValues);

        return [
            'status'       => $insertedRow ? 'synced' : 'error',
            'no_urut'      => $nextNo,
            'inserted_row' => $insertedRow,
            'message'      => $insertedRow 
                ? "Berhasil dicatat ke Google Sheets [OUT] baris {$insertedRow} (No #{$nextNo})" 
                : "Gagal menambahkan baris ke Sheet OUT."
        ];
    }

    /**
     * Tulis transaksi pengambilan part onhand ke Sheet 8 [ONHAND OPR]
     */
    public function appendOnhandRow(array $data): array
    {
        if (!$this->isConfigured()) {
            return [
                'status' => 'local_only',
                'message' => 'Tersimpan di database lokal. Pasang Google Service Account untuk sync ke Sheet ONHAND OPR.'
            ];
        }

        $lastNo = $this->getLastNoUrut('ONHAND OPR');
        $nextNo = $lastNo + 1;

        $tglRaw = !empty($data['tanggal_ambil']) ? $data['tanggal_ambil'] : date('Y-m-d');
        $tglFormatted = date('j-M-Y', strtotime($tglRaw));

        $plu      = trim((string)($data['kode_plu'] ?? ''));
        $teknisi  = strtoupper(trim((string)($data['teknisi'] ?? 'RAIHAN')));
        $qty      = (int)($data['qty_ambil'] ?? 1);
        $ket      = trim((string)($data['keterangan'] ?? ''));

        // Cek baris berikutnya untuk formula VLOOKUP
        $service = $this->getService();
        $nextRow = 6;
        try {
            $range = "'ONHAND OPR'!A:A";
            $resp = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $nextRow = count($resp->getValues() ?? []) + 1;
        } catch (\Exception $e) {
            $nextRow = 255;
        }

        // Formula VLOOKUP ke LPP Stock
        $formulaNama   = "=VLOOKUP(B{$nextRow},'LPP STOCK (SPAREPART EDP)'!\$B\$9:\$C\$122,2,0)";
        $formulaDivisi = "=VLOOKUP(B{$nextRow},'LPP STOCK (SPAREPART EDP)'!\$B\$9:\$F\$122,3,0)";
        $formulaSatuan = "=VLOOKUP(B{$nextRow},'LPP STOCK (SPAREPART EDP)'!\$B\$9:\$G\$122,4,0)";
        $formulaTTL    = "=SUM(G{$nextRow}:J{$nextRow})-K{$nextRow}";

        $raihan = ($teknisi === 'RAIHAN') ? $qty : '';
        $ojak   = ($teknisi === 'OJAK') ? $qty : '';
        $rizki  = ($teknisi === 'RIZKI') ? $qty : '';
        $zega   = ($teknisi === 'ZEGA') ? $qty : '';

        // Jika teknisi selain 4 di atas, masukkan ke Raihan atau catat di keterangan
        if ($teknisi !== 'RAIHAN' && $teknisi !== 'OJAK' && $teknisi !== 'RIZKI' && $teknisi !== 'ZEGA') {
            $raihan = $qty;
            $ket = $ket ? "[{$teknisi}] " . $ket : "[{$teknisi}]";
        }

        $rowValues = [
            $nextNo,                                        // Col A: NO
            $plu,                                           // Col B: PLU
            $formulaNama,                                   // Col C: NAMA BARANG (VLOOKUP)
            $tglFormatted,                                  // Col D: TGL
            $formulaDivisi,                                 // Col E: DIV ITEM (VLOOKUP)
            $formulaSatuan,                                 // Col F: SATUAN (VLOOKUP)
            $raihan,                                        // Col G: RAIHAN
            $ojak,                                          // Col H: OJAK
            $rizki,                                         // Col I: RIZKI
            $zega,                                          // Col J: ZEGA
            0,                                              // Col K: Barang OUT
            $formulaTTL,                                    // Col L: TTL (SUM - OUT)
            $ket                                            // Col M: KETERANGAN
        ];

        $insertedRow = $this->appendRow('ONHAND OPR', $rowValues);

        return [
            'status'       => $insertedRow ? 'synced' : 'error',
            'no_urut'      => $nextNo,
            'inserted_row' => $insertedRow,
            'message'      => $insertedRow 
                ? "Berhasil dicatat ke Google Sheets [ONHAND OPR] baris {$insertedRow} (No #{$nextNo})" 
                : "Gagal menambahkan baris ke Sheet ONHAND OPR."
        ];
    }

    /**
     * Update kolom Barang OUT dan Keterangan pada Sheet ONHAND OPR
     */
    public function updateOnhandRow(int $row, array $fields): bool
    {
        $service = $this->getService();
        if (!$service || $row < 6) return false;

        try {
            $ttlFormula = "=SUM(G{$row}:J{$row})-K{$row}";
            $outVal = isset($fields['qty_out']) ? (int)$fields['qty_out'] : 0;
            $ketVal = isset($fields['keterangan']) ? (string)$fields['keterangan'] : '';

            $values = [[$outVal, $ttlFormula, $ketVal]];
            $range = "'ONHAND OPR'!K{$row}:M{$row}";

            $body = new ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            $service->spreadsheets_values->update(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );

            return true;
        } catch (\Exception $e) {
            Log::error("Gagal update baris [{$row}] di Sheet ONHAND OPR: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cari nomor baris di Google Sheets berdasarkan PLU atau Nama Barang
     */
    protected function findRowByPluOrName(?string $plu, string $nama): ?int
    {
        $service = $this->getService();
        if (!$service) return null;

        try {
            $range = "'{$this->sheetName}'!A9:C150";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) return null;

            foreach ($values as $index => $r) {
                $currentRow = 9 + $index;
                $rowPlu = trim($r[1] ?? '');
                $rowNama = trim($r[2] ?? '');

                if ($plu && $rowPlu === $plu) {
                    return $currentRow;
                }
                if ($rowNama && strcasecmp($rowNama, $nama) === 0) {
                    return $currentRow;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error searching row in Google Sheets: ' . $e->getMessage());
        }

        return null;
    }
}
