<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'ward', 'district', 'city'
    ];
    

    public function subFields()
    {
        return $this->hasMany(SubField::class);
    }
}

