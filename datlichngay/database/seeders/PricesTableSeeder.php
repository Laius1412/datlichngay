<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubField;
use App\Models\Price;

class PricesTableSeeder extends Seeder
{
    public function run()
    {
        // Lấy tất cả các SubField
        $subFields = SubField::all();

        // Thêm giá mặc định cho mỗi SubField
        foreach ($subFields as $subField) {
            $subField->prices()->create([
                'start_time' => '00:00',
                'end_time' => '23:59',
                'price' => 200000, // Giá mặc định 200K
            ]);
        }
    }
}