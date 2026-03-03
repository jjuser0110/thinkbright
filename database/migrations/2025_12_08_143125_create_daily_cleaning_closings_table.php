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
        Schema::create('daily_cleaning_closings', function (Blueprint $table) {
            $table->id();
            $table->date('closing_date')->nullable();
            $table->double('no_of_customer')->default(0);
            $table->double('new_customer')->default(0);
            $table->double('cleaning_count')->default(0);
            $table->double('total_sales')->default(0);
            $table->double('total_sst')->default(0);
            $table->double('after_sst')->default(0);
            $table->double('cleaning_tool')->default(0);
            $table->double('expenses')->default(0);
            $table->double('salary')->default(0);
            $table->double('profit')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_cleaning_closings');
    }
};
