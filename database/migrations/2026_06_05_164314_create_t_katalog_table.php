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
            $table->unsignedBigInteger('user_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('pencipta');
            $table->string('subjek')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('kontribusi')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tipe')->nullable();
            $table->string('format')->nullable();
            $table->string('identitas')->nullable();
            $table->string('sumber')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('hak_cipta')->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
            //FK User
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
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
