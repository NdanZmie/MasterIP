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
        Schema::create('tampung_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program', 255);
            $table->string('kategori', 100)->default('Aplikasi / Tools');
            $table->string('versi', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_sumber', ['upload', 'link'])->default('upload');
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 500)->nullable();
            $table->bigInteger('file_size')->unsigned()->default(0); // in bytes
            $table->string('file_extension', 20)->nullable();
            $table->text('external_link')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->string('uploader', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tampung_programs');
    }
};
