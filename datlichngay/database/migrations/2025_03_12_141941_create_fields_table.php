<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ward'); // Phường/Xã
            $table->string('district'); // Quận/Huyện
            $table->string('city'); // Tỉnh/Thành phố
            $table->timestamps();
        });
    
        Schema::create('sub_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // 7 vs 7, 9 vs 9
            $table->string('status'); // Đang hoạt động, Đang bảo trì
            $table->timestamps();
        });
    }
    
};
