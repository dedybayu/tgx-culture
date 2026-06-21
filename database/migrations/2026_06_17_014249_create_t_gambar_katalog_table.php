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
        Schema::create('t_media_katalog', function (Blueprint $table) {
            $table->id('media_katalog_id');
            $table->unsignedBigInteger('katalog_id');
            $table->enum('type', ['image', 'video', 'youtube']);
            $table->string('path_link');
            $table->timestamps();

            $table->foreign('katalog_id')->references('katalog_id')->on('t_katalog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_katalog');
    }
};
