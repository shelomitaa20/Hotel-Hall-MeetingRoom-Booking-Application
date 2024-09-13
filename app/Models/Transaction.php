<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'metode',
        'total_harga',
        'bukti_pembayaran',
        'booking_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
