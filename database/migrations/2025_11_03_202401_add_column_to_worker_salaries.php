<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('worker_salaries', function (Blueprint $table) {
            $table->date('daily_date');
            $table->double('normal')->default(0);
            $table->double('overtime')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_salaries', function (Blueprint $table) {
            //
        });
    }
};
