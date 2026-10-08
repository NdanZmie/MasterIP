<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah status menjadi string agar fleksibel mendukung PENDING_APPROVAL, OUT_MANUAL, REJECTED, dll.
        Schema::table('barang_onhand_opr', function (Blueprint $table) {
            $table->string('status', 50)->default('ONHAND')->change();
            $table->string('serial_number', 100)->nullable()->after('tujuan_pemakaian');
            $table->string('out_method', 50)->nullable()->after('serial_number'); // AUTO, MANUAL, TELEGRAM
            $table->timestamp('tanggal_keluar')->nullable()->after('tanggal_ambil');
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->string('approved_by', 100)->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_onhand_opr', function (Blueprint $table) {
            $table->dropColumn(['serial_number', 'out_method', 'tanggal_keluar', 'approved_at', 'approved_by']);
        });
    }
};
