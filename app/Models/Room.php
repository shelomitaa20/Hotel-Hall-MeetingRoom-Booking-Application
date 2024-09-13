<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruangan', 'jenis_ruangan', 'fasilitas', 'harga', 'gambar', 'deskripsi', 'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}
