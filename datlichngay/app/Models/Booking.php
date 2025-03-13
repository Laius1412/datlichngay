<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'sub_field_id', 'date', 'start_time', 'end_time', 'price', 'status'];

    public function subField()
    {
        return $this->belongsTo(SubField::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
