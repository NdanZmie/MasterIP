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
        // 1. Matikan sementara foreign key checks agar proses modifikasi/recreate lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Buat atau update struktur tabel barang
        if (!Schema::hasTable('barang')) {
            Schema::create('barang', function (Blueprint $table) {
                $table->id();
                $table->integer('no_urut')->nullable();
                $table->string('kode_plu', 50)->nullable()->index();
                $table->string('nama_barang', 255);
                $table->string('divisi', 100)->nullable()->index();
                $table->string('satuan', 50)->default('PCS');
                $table->string('moving', 50)->nullable()->index();
                $table->integer('pkm')->default(0);
                $table->decimal('keb_per_toko', 8, 2)->default(0);
                $table->integer('total_toko')->default(254);
                $table->string('kriteria_buffer', 20)->nullable();
                $table->integer('saldo_awal')->default(0);
                $table->integer('qty_stock')->default(0); // Saldo Akhir
                $table->decimal('avg_l3m_out', 10, 2)->default(0);
                $table->integer('dsi')->default(0);
                $table->integer('lead_time')->default(45);
                $table->integer('minor')->default(0);
                $table->integer('reorder')->default(0);
                $table->integer('qty_pp')->default(0);
                $table->integer('buffer')->default(0);
                $table->text('keterangan_khusus')->nullable();
                $table->decimal('harga_satuan', 15, 2)->default(0);
                $table->decimal('total_harga', 15, 2)->default(0);
                $table->integer('qty_pp_belum_realisasi')->default(0);
                $table->text('keterangan')->nullable();
                $table->integer('google_sheet_row')->nullable();
                $table->timestamp('last_synced_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('barang', function (Blueprint $table) {
                if (!Schema::hasColumn('barang', 'no_urut')) {
                    $table->integer('no_urut')->nullable()->after('id');
                }
                if (!Schema::hasColumn('barang', 'moving')) {
                    $table->string('moving', 50)->nullable()->index()->after('satuan');
                }
                if (!Schema::hasColumn('barang', 'pkm')) {
                    $table->integer('pkm')->default(0)->after('moving');
                }
                if (!Schema::hasColumn('barang', 'keb_per_toko')) {
                    $table->decimal('keb_per_toko', 8, 2)->default(0)->after('pkm');
                }
                if (!Schema::hasColumn('barang', 'total_toko')) {
                    $table->integer('total_toko')->default(254)->after('keb_per_toko');
                }
                if (!Schema::hasColumn('barang', 'kriteria_buffer')) {
                    $table->string('kriteria_buffer', 20)->nullable()->after('total_toko');
                }
                if (!Schema::hasColumn('barang', 'saldo_awal')) {
                    $table->integer('saldo_awal')->default(0)->after('kriteria_buffer');
                }
                if (!Schema::hasColumn('barang', 'avg_l3m_out')) {
                    $table->decimal('avg_l3m_out', 10, 2)->default(0)->after('qty_stock');
                }
                if (!Schema::hasColumn('barang', 'dsi')) {
                    $table->integer('dsi')->default(0)->after('avg_l3m_out');
                }
                if (!Schema::hasColumn('barang', 'lead_time')) {
                    $table->integer('lead_time')->default(45)->after('dsi');
                }
                if (!Schema::hasColumn('barang', 'minor')) {
                    $table->integer('minor')->default(0)->after('lead_time');
                }
                if (!Schema::hasColumn('barang', 'reorder')) {
                    $table->integer('reorder')->default(0)->after('minor');
                }
                if (!Schema::hasColumn('barang', 'qty_pp')) {
                    $table->integer('qty_pp')->default(0)->after('reorder');
                }
                if (!Schema::hasColumn('barang', 'buffer')) {
                    $table->integer('buffer')->default(0)->after('qty_pp');
                }
                if (!Schema::hasColumn('barang', 'keterangan_khusus')) {
                    $table->text('keterangan_khusus')->nullable()->after('buffer');
                }
                if (!Schema::hasColumn('barang', 'harga_satuan')) {
                    $table->decimal('harga_satuan', 15, 2)->default(0)->after('keterangan_khusus');
                }
                if (!Schema::hasColumn('barang', 'total_harga')) {
                    $table->decimal('total_harga', 15, 2)->default(0)->after('harga_satuan');
                }
                if (!Schema::hasColumn('barang', 'qty_pp_belum_realisasi')) {
                    $table->integer('qty_pp_belum_realisasi')->default(0)->after('total_harga');
                }
                if (!Schema::hasColumn('barang', 'google_sheet_row')) {
                    $table->integer('google_sheet_row')->nullable()->after('keterangan');
                }
                if (!Schema::hasColumn('barang', 'last_synced_at')) {
                    $table->timestamp('last_synced_at')->nullable()->after('google_sheet_row');
                }
            });
        }

        // 3. Buat tabel riwayat mutasi bulanan (27 bulan dari LPP Google Sheets)
        if (!Schema::hasTable('barang_mutasi_bulanan')) {
            Schema::create('barang_mutasi_bulanan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
                $table->string('kode_plu', 50)->nullable()->index();
                $table->string('periode_key', 20)->index(); // e.g. '2024-07'
                $table->string('nama_bulan', 50); // e.g. "JUL '24"
                $table->integer('urutan')->default(0);
                $table->integer('qty_in')->default(0);
                $table->integer('qty_out')->default(0);
                $table->integer('saldo_akhir')->default(0);
                $table->timestamps();
            });
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_mutasi_bulanan');
    }
};
