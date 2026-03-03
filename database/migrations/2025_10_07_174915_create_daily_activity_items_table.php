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
        Schema::create('daily_activity_items', function (Blueprint $table) {
            $table->id();
            $table->integer('daily_activity_id');
            $table->string('no_job_sheet')->nullable();
            $table->string('nama_product')->nullable();
            $table->string('kod_product')->nullable();
            $table->string('kelompok_no')->nullable();
            $table->integer('quantity')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('kod_kerja_id')->nullable();
            $table->double('cost')->nullable();
            $table->double('grand_cost')->nullable();
            $table->double('price')->nullable();
            $table->double('grand_price')->nullable();
            $table->double('profit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_items');
    }
};
