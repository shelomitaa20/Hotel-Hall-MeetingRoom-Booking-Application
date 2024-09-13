<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->string('jenis_ruangan');
            $table->string('fasilitas');
            $table->integer('harga');
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jumlah');
            $table->integer('kapasitas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
