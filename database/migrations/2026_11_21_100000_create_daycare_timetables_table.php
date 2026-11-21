<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Weekly daycare schedule (Monday to Friday). day: 1 = Monday ... 5 = Friday (ISO). */
    public function up(): void
    {
        Schema::create('daycare_timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('activity');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->index(['day', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daycare_timetables');
    }
};
