<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'user_id';
    
    public $timestamps = false;

    protected $fillable = [
        'user_name',
        'user_phone',
        'user_email',
        'user_gender',
        'user_date_of_birth',
        'user_password',
        'verification',
        'block',
        'verification_token',
        'role_id'
    ];
    protected $casts = [
        'user_id' => 'string',
    ];
    public function getAuthPassword()
    {
        return $this->user_password;
    }
    public function user_role()
    {
        return $this->hasOne(user_role::class, 'role_id');
    }
}
