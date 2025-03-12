<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->string('location')->after('name'); // Thêm cột location
        });
    }

    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->dropColumn('location'); // Xóa cột location nếu rollback
        });
    }
};

