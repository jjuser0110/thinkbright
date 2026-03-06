<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->after('class');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->double('tuition_deduct')->nullable()->after('tuition_extra');
            $table->double('food_extra')->nullable()->after('food');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['tuition_deduct','food_extra']);
        });
    }
};
