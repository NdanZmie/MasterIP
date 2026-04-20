<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spekpc', function (Blueprint $table) {
            // Tambah setelah kolom 'ip'
            $table->string('compname')->nullable()->after('ip');
            $table->string('nik')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('spekpc', function (Blueprint $table) {
            $table->dropColumn(['compname', 'nik']);
        });
    }
};