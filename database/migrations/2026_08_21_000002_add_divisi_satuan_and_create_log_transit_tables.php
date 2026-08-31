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
        // 1. Tambahkan kolom divisi dan satuan pada tabel barang
        Schema::table('barang', function (Blueprint $table) {
            if (!Schema::hasColumn('barang', 'divisi')) {
                $table->string('divisi', 100)->nullable()->after('nama_barang');
            }
            if (!Schema::hasColumn('barang', 'satuan')) {
                $table->string('satuan', 50)->default('PCS')->after('divisi');
            }
        });

        // 2. Buat tabel audit trail log transit barang (keluar / masuk)
        if (!Schema::hasTable('barang_log_transit')) {
            Schema::create('barang_log_transit', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('barang_id')->nullable();
                $table->string('kode_plu', 50)->nullable();
                $table->string('nama_barang', 200);
                $table->string('divisi', 100)->nullable();
                $table->string('satuan', 50)->default('PCS');
                $table->enum('tipe', ['IN', 'OUT']); // IN = Masuk / Restock, OUT = Keluar / Service / Toko
                $table->string('kategori', 100); // e.g. 'Barang Baru Masuk', 'Restock Stok', 'Service Unit Selesai', 'Out Manual Toko / Divisi'
                $table->integer('qty');
                $table->integer('stok_awal')->default(0);
                $table->integer('stok_akhir')->default(0);
                $table->string('tujuan_sumber', 255)->nullable(); // e.g. 'KDTK: T9D4', 'Service: Epson LX 310', 'Restock Supplier'
                $table->unsignedBigInteger('referensi_id')->nullable(); // ID relasi service_barang atau lainnya
                $table->string('pic', 100)->nullable(); // Nama user / teknisi
                $table->text('keterangan')->nullable();
                $table->date('tanggal_transaksi');
                $table->timestamps();

                $table->foreign('barang_id')->references('id')->on('barang')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_log_transit');

        Schema::table('barang', function (Blueprint $table) {
            if (Schema::hasColumn('barang', 'divisi')) {
                $table->dropColumn('divisi');
            }
            if (Schema::hasColumn('barang', 'satuan')) {
                $table->dropColumn('satuan');
            }
        });
    }
};
