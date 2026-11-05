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
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('no_sj', 60)->unique();
            $table->enum('tipe_sj', ['GO', 'NORMAL'])->default('GO');
            $table->date('tanggal');
            $table->string('kepada', 255)->default('');
            $table->string('perihal', 255)->default('');
            $table->string('kode_toko', 50)->nullable();
            $table->string('nama_toko', 255)->nullable();
            $table->longText('items'); // JSON array of items
            $table->longText('signatures')->nullable(); // JSON object for signature names/roles
            $table->text('catatan')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan');
    }
};
