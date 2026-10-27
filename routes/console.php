<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sheet:test', function () {
    $this->warn('Integrasi Google Sheets telah diputuskan / dinonaktifkan.');
    return 0;
})->purpose('Google Sheets telah dinonaktifkan');

Artisan::command('sheet:sync', function () {
    $this->warn('Sinkronisasi Google Sheets telah diputuskan / dinonaktifkan.');
    return 0;
})->purpose('Google Sheets telah dinonaktifkan');

