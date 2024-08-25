<?php

namespace App\Models;

use Carbon\Carbon;
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
    protected $casts = [
        'discount_percentage' => 'int',        
    ];
    public function isValid()
    {
        return $this->expiry_date ? Carbon::parse($this->expiry_date)->endOfDay()->isFuture() : true;
    }
    public function discount_use()
    {
        return $this->hasMany(discount_use::class, 'discount_code_id');
    }
    
}
