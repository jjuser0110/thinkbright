<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A one-to-one class: one student, one teacher, a weekly slot and a monthly fee.
     * day: 1 = Monday ... 7 = Sunday (ISO). Teacher commission = monthly_fee x commission_percent / 100.
     */
    public function up(): void
    {
        Schema::create('one_to_one_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject');
            $table->unsignedTinyInteger('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('monthly_fee', 10, 2);
            $table->decimal('commission_percent', 5, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('one_to_one_classes');
    }
};
