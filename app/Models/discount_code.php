<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount_code extends Model
{
    use HasFactory;
    protected $table = 'discount_codes'; 

    protected $fillable = [
        'code',
        'discount_percentage',
        'expiry_date' 
    ];
}
