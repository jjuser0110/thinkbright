<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * What each student is enrolled in. A NULL fee means "use the default"
     * (Fee Setting for daycare / bath & lunch, the school's fee for transport).
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('daycare')->default(false);
            $table->decimal('daycare_fee', 10, 2)->nullable();
            $table->boolean('bath_lunch')->default(false);
            $table->decimal('bath_lunch_fee', 10, 2)->nullable();
            $table->boolean('transport')->default(false);
            $table->decimal('transport_fee', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['daycare', 'daycare_fee', 'bath_lunch', 'bath_lunch_fee', 'transport', 'transport_fee']);
        });
    }
};
