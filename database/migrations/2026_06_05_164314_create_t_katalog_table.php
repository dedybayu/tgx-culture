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
        Schema::create('t_katalog', function (Blueprint $table) {
            $table->id('katalog_id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('pencipta');
            $table->string('subjek');
            $table->string('penerbit');
            $table->string('kontribusi');
            $table->date('tanggal');
            $table->string('tipe');
            $table->string('format');
            $table->string('identitas');
            $table->string('sumber');
            $table->string('bahasa');
            $table->string('hubungan');
            $table->string('lokasi');
            $table->string('hak_cipta');
            $table->string('path_gambar');
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_katalog');
    }
};
