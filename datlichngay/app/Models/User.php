<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory; // Sử dụng HasFactory ở đây

    protected $fillable = ['name', 'phone', 'dob', 'email', 'password', 'role'];
    protected $hidden = ['password'];
}
