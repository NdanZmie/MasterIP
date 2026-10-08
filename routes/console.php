<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sheet:test', function () {
    $service = app(\App\Services\GoogleSheetsService::class);

    $this->info('==================================================');
    $this->info('   MASTER IP - GOOGLE SHEETS CONNECTION DIAGNOSTIC');
    $this->info('==================================================');
    $this->line("Target Spreadsheet ID: " . config('services.google_sheets.spreadsheet_id', env('GOOGLE_SHEETS_SPREADSHEET_ID')));
    $this->line("Target Sheet Name    : " . config('services.google_sheets.sheet_name', env('GOOGLE_SHEETS_SHEET_NAME')));
    $this->line("Credentials Path     : " . $service->getCredentialsPath());
    $this->newLine();

    if (!$service->isConfigured()) {
        $this->error('❌ File kredensial service-account.json BELUM DITEMUKAN!');
        $this->warn('Petunjuk Setup:');
        $this->line('1. Buka Google Cloud Console -> IAM & Admin -> Service Accounts');
        $this->line('2. Buat Service Account dan download file kunci JSON');
        $this->line('3. Simpan file tersebut di: ' . $service->getCredentialsPath());
        $this->line('4. Share Spreadsheet Google Sheet Anda ke email Service Account tersebut dengan akses "Editor"');
        $this->newLine();
        return 1;
    }

    $this->info('🔍 Menguji koneksi ke Google Cloud & Google Sheets API...');
    $res = $service->testConnection();

    if ($res['success']) {
        $this->info('✅ KONEKSI BERHASIL TERHUBUNG!');
        $this->line("• Judul Spreadsheet : " . ($res['spreadsheet_title'] ?? '-'));
        $this->line("• Sheet Name        : " . ($res['sheet_name'] ?? '-'));
        $this->line("• Service Account   : " . ($res['client_email'] ?? '-'));
        $this->line("• Jumlah Sampel Data: " . ($res['sample_count'] ?? 0) . " baris");
        $this->newLine();
        $this->info('Sistem siap melakukan Real-Time Two-Way Sync antara Laravel dan Google Sheets!');
        return 0;
    } else {
        $this->error('❌ KONEKSI GAGAL!');
        $this->line("Pesan: " . $res['message']);
        if (!empty($res['client_email'])) {
            $this->warn("Email Service Account Anda: " . $res['client_email']);
        }
        if (!empty($res['solution'])) {
            $this->newLine();
            $this->comment("Solusi:");
            $this->line($res['solution']);
        }
        return 1;
    }
})->purpose('Uji koneksi ke Google Sheets API via Service Account');

Artisan::command('sheet:sync', function () {
    $this->info('Memulai sinkronisasi data LPP Stock dari Google Sheets...');
    $request = new \Illuminate\Http\Request();
    $controller = app(\App\Http\Controllers\BarangController::class);
    
    // Panggil fungsi sync
    $response = $controller->syncGoogleSheet($request);
    $this->info('Sinkronisasi selesai!');
})->purpose('Tarik data master sparepart terbaru dari Google Sheets ke database lokal');
