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
        Schema::create('daily_cleanings', function (Blueprint $table) {
            $table->id();
            $table->string('daily_cleaning_no');
            $table->date('daily_cleaning_date');
            $table->integer('driver_id');
            $table->text('cleaner_ids');
            $table->text('address')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_contact')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->double('sales')->default(0);
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
        Schema::dropIfExists('daily_cleanings');
    }
};
