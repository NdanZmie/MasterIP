<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Koneksi database yang digunakan.
     */
    protected $connection = 'masterip';

    public function up(): void
    {
        Schema::connection('masterip')->create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->string('kode_toko')->nullable();
            $table->string('ip')->nullable();
            $table->string('pic')->nullable();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('area')->nullable();
            $table->enum('status', ['AKTIF', 'NONAKTIF', 'MAINTENANCE'])->default('AKTIF');
            $table->string('keterangan', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('masterip')->dropIfExists('toko');
    }
};