<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Monthly bill column for one-to-one class fees. */
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->double('one_to_one')->nullable()->after('tuition_extra');
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('one_to_one');
        });
    }
};
