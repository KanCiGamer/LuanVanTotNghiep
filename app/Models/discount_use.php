<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount_use extends Model
{
    use HasFactory;
    // protected $table = 'discount_uses';
    public $timestamps = true;
    const UPDATED_AT = null; 
    // protected $fillable = [
    //     'user_id',
    //     'discount_code_id',
    //     'invoice_id',
    // ];

   
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'user_id');
    // }

    
    // public function discountCode()
    // {
    //     return $this->belongsTo(discount_code::class, 'discount_code_id');
    // }

   
    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class, 'invoice_id', 'invoice_id');
    // }
}
