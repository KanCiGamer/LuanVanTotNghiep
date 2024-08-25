<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'invoice_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'invoice_id',
        'date_created',
        'email_kh',
        'phone_kh',
        'user_id',
        'price_total',
        'discount_code_id',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    public function discountCode()
    {
        return $this->belongsTo(discount_code::class, 'discount_code_id');
    }
    public function invoice_detail()
    {
        return $this->hasMany(invoice_detail::class,'invoice_id','invoice_id');
    }
    public function discount_use()
    {
        return $this->hasMany(discount_use::class, 'invoice_id', 'invoice_id');
    }
}
