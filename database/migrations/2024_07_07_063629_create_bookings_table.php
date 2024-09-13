<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('no_tlp');
            $table->integer('jml_orang');
            $table->date('tgl');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('snack_id')->constrained('snacks');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
