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
        Schema::create('barang_onhand_opr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable()->index();
            $table->integer('no_urut')->nullable()->index(); // Nomor urut baris di Google Sheets
            $table->string('kode_plu', 50)->nullable()->index();
            $table->string('nama_barang', 255);
            $table->date('tanggal_ambil')->nullable()->index();
            $table->string('divisi', 100)->nullable();
            $table->string('satuan', 50)->default('PCS');
            $table->string('teknisi', 100)->index(); // RAIHAN, OJAK, RIZKI, ZEGA, dll.
            $table->integer('qty_ambil')->default(0); // Kuantitas yang diambil teknisi
            $table->integer('qty_out')->default(0); // Kuantitas yang sudah keluar/terpakai
            $table->integer('qty_sisa')->default(0); // Sisa onhand yang masih dipegang
            $table->enum('status', ['ONHAND', 'SELESAI_OUT', 'PEMUTIHAN'])->default('ONHAND')->index();
            $table->text('keterangan')->nullable();
            $table->string('tujuan_pemakaian', 255)->nullable(); // Toko/Unit jika di-out
            $table->integer('google_sheet_row')->nullable()->index(); // Baris di Sheet ONHAND OPR
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_onhand_opr');
    }
};
