<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_log_transit', function (Blueprint $table) {
            if (!Schema::hasColumn('barang_log_transit', 'no_urut')) {
                $table->integer('no_urut')->nullable()->after('id');
            }
            if (!Schema::hasColumn('barang_log_transit', 'periode')) {
                $table->string('periode', 50)->nullable()->after('satuan');
            }
            if (!Schema::hasColumn('barang_log_transit', 'tgl_datang')) {
                $table->date('tgl_datang')->nullable()->after('periode');
            }
            if (!Schema::hasColumn('barang_log_transit', 'tgl_btb')) {
                $table->date('tgl_btb')->nullable()->after('tgl_datang');
            }
            if (!Schema::hasColumn('barang_log_transit', 'no_btb')) {
                $table->string('no_btb', 100)->nullable()->after('tgl_btb');
            }
            if (!Schema::hasColumn('barang_log_transit', 'tgl_keluar')) {
                $table->date('tgl_keluar')->nullable()->after('no_btb');
            }
            if (!Schema::hasColumn('barang_log_transit', 'tgl_bkb')) {
                $table->date('tgl_bkb')->nullable()->after('tgl_keluar');
            }
            if (!Schema::hasColumn('barang_log_transit', 'no_bkb')) {
                $table->string('no_bkb', 100)->nullable()->after('tgl_bkb');
            }
            if (!Schema::hasColumn('barang_log_transit', 'kdtk')) {
                $table->string('kdtk', 50)->nullable()->after('no_bkb');
            }
            if (!Schema::hasColumn('barang_log_transit', 'nama_toko')) {
                $table->string('nama_toko', 200)->nullable()->after('kdtk');
            }
            if (!Schema::hasColumn('barang_log_transit', 'aktiva')) {
                $table->string('aktiva', 100)->nullable()->after('nama_toko');
            }
            if (!Schema::hasColumn('barang_log_transit', 'harga_satuan')) {
                $table->decimal('harga_satuan', 15, 2)->default(0)->after('qty');
            }
            if (!Schema::hasColumn('barang_log_transit', 'total_harga')) {
                $table->decimal('total_harga', 15, 2)->default(0)->after('harga_satuan');
            }
            if (!Schema::hasColumn('barang_log_transit', 'google_sheet_name')) {
                $table->string('google_sheet_name', 50)->nullable()->after('tanggal_transaksi');
            }
            if (!Schema::hasColumn('barang_log_transit', 'google_sheet_row')) {
                $table->integer('google_sheet_row')->nullable()->after('google_sheet_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_log_transit', function (Blueprint $table) {
            $columns = [
                'no_urut', 'periode', 'tgl_datang', 'tgl_btb', 'no_btb',
                'tgl_keluar', 'tgl_bkb', 'no_bkb', 'kdtk', 'nama_toko',
                'aktiva', 'harga_satuan', 'total_harga', 'google_sheet_name',
                'google_sheet_row'
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('barang_log_transit', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
