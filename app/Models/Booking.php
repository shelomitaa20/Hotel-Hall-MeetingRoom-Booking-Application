<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_tlp',
        'jml_orang',
        'tgl',
        'jam_mulai',
        'jam_selesai',
        'user_id',
        'room_id',
        'snack_id'
    ];

    protected $attributes = [
        'snack_id' => null,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function snack()
    {
        return $this->belongsTo(Snack::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function checkin()
    {
        return $this->hasOne(Checkin::class);
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    public function calculateTotalPrice()
    {
        $room_price = $this->room->harga;
        $hours = (strtotime($this->jam_selesai) - strtotime($this->jam_mulai)) / 3600;
        $room_total = $room_price * $hours;

        $snack_price = $this->snack ? $this->snack->harga * $this->jml_orang : 0;

        return $room_total + $snack_price;
    }

    protected static function boot() {
        parent::boot();

        static::created(function ($booking) {
            $room = $booking->room;
            if ($room->jumlah > 0) {
                $room->jumlah -= 1;
                $room->save();
            }
        });

        static::deleted(function ($booking) {
            $room = $booking->room;
            $room->jumlah += 1;
            $room->save();
        });
    }
}
