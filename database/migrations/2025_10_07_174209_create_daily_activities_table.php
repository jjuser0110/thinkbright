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
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->string('daily_activity_no');
            $table->date('daily_activity_date');
            $table->string('line');
            $table->integer('leader_id');
            $table->text('operator_ids');
            $table->double('number_of_worker')->default(0);
            $table->double('sales_total')->default(0);
            $table->double('expenses_total')->default(0);
            $table->double('expenses_total_per_pax')->default(0);
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
        Schema::dropIfExists('daily_activities');
    }
};
