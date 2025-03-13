<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubField extends Model
{
    use HasFactory;
    protected $fillable = ['field_id', 'name', 'type', 'status'];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    protected static function booted()
    {
        static::created(function ($subField) {
            // Thêm giá mặc định
            $subField->prices()->create([
                'start_time' => '00:00',
                'end_time' => '23:59',
                'price' => 200000, // Giá mặc định 200K
            ]);
        });
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
