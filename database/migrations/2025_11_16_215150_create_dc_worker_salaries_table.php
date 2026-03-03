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
        Schema::create('dc_worker_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('daily_cleaning_closing_id')->nullable();
            $table->integer('user_id');
            $table->date('daily_date');
            $table->string('salary_type');
            $table->double('duration_hours')->default(0);
            $table->double('normal')->default(0);
            $table->double('overtime')->default(0);
            $table->double('salary_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dc_worker_salaries');
    }
};
