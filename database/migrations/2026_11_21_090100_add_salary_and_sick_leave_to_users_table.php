<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('basic_salary', 10, 2)->nullable()->after('no_of_annual_leave');
            $table->integer('no_of_sick_leave')->nullable()->after('basic_salary');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['basic_salary', 'no_of_sick_leave']);
        });
    }
};
