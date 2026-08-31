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
        Schema::create('service_barang', function (Blueprint $table) {
            $table->id();
            $table->string('no_dat', 100)->nullable();
            $table->string('sn', 100)->nullable();
            $table->string('nama_barang', 200);
            $table->string('kode_toko', 50);
            $table->text('kerusakan')->nullable();
            $table->text('tindakan')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', [
                'Belum Cek',
                'Sudah Cek',
                'Service Suplier',
                'Selesai Service'
            ])->default('Belum Cek');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('service_part_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_barang_id')->constrained('service_barang')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('kode_plu', 50)->nullable();
            $table->string('nama_barang', 200);
            $table->integer('qty')->default(1);
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();

            // Foreign key to barang table if exists
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_part_keluar');
        Schema::dropIfExists('service_barang');
    }
};
