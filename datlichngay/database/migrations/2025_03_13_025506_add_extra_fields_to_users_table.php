<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable(); // Giới tính
            $table->string('cccd')->unique()->nullable(); // CCCD
            $table->string('city')->nullable(); // Tỉnh/Thành phố
            $table->string('district')->nullable(); // Quận/Huyện
            $table->string('ward')->nullable(); // Phường/Xã
            $table->string('address')->nullable(); // Số nhà + Đường
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'cccd', 'city', 'district', 'ward', 'address']);
        });
    }
};

