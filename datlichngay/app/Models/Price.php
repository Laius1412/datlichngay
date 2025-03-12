<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['sub_field_id', 'start_time', 'end_time', 'price'];

    public function subField()
    {
        return $this->belongsTo(SubField::class);
    }
}