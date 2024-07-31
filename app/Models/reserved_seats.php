<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserved_seats extends Model
{
    use HasFactory;

    protected $table = "reserved_seats";
    protected $fillable = [
        'showtime_id',
        'seat_id',
        'expires_at',
    ];
}
