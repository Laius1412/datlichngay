<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'phone', 'dob', 'cccd', 'gender', 'city', 'district', 'ward', 'address', 'avatar', 'password',
    ];
    

    
    protected $hidden = ['password'];
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
