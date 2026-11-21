<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Let the add-user form save teachers without a bank or an email.
     *
     * - bank_id: meant to be nullable, but a typo (`nullablle()`) in
     *   2025_03_27_061427_add_columns_to_users_table left it NOT NULL.
     * - email: the user form has no email field and login uses username, so
     *   email is optional. It stays unique (MySQL allows many NULLs).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('bank_id')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('users')->whereNull('bank_id')->update(['bank_id' => 0]);
        DB::table('users')->whereNull('email')->update([
            'email' => DB::raw("CONCAT(username, '@no-email.invalid')"),
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->integer('bank_id')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }
};
