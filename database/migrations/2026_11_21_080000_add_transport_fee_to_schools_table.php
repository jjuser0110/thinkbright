<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Each school has its own monthly transport charge (e.g. CH2 RM80, Lodge RM100). */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->decimal('transport_fee', 10, 2)->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('transport_fee');
        });
    }
};
