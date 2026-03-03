<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('shortname')->nullable();
            $table->integer('bank_id')->nullablle();
            $table->string('bank_account')->nullable();
            $table->integer('no_of_annual_leave')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('shortname');
            $table->dropColumn('bank_id');
            $table->dropColumn('bank_account');
            $table->dropColumn('no_of_annual_leave');
        });
    }
}
