<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('barang_log_transit')) {
            // Gunakan alter table langsung untuk fleksibilitas di MySQL / SQLite
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `barang_log_transit` MODIFY `tipe` VARCHAR(20) NOT NULL DEFAULT 'IN'");
            } else {
                Schema::table('barang_log_transit', function (Blueprint $table) {
                    $table->string('tipe', 20)->default('IN')->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('barang_log_transit')) {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `barang_log_transit` MODIFY `tipe` ENUM('IN', 'OUT') NOT NULL DEFAULT 'IN'");
            } else {
                Schema::table('barang_log_transit', function (Blueprint $table) {
                    $table->string('tipe', 10)->change();
                });
            }
        }
    }
};
