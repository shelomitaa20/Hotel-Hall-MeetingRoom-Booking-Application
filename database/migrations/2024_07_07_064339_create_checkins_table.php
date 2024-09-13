<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkins');
    }
};
