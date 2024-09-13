<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('metode');
            $table->integer('total_harga');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status')->default('pending'); 
            $table->timestamps();
            $table->foreignId('booking_id')->constrained('bookings');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

