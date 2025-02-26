<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('account_month_id');
            $table->double('tuition')->nullable();
            $table->double('tuition_extra')->nullable();
            $table->double('food')->nullable();
            $table->double('transport')->nullable();
            $table->double('transport_extra')->nullable();
            $table->double('deposit')->nullable();
            $table->double('material')->nullable();
            $table->double('registration')->nullable();
            $table->double('extra')->nullable();
            $table->double('extra_2')->nullable();
            $table->double('total')->nullable();
            $table->datetime('paid')->nullable();
            $table->datetime('sent')->nullable();
            $table->string('remarks')->nullable();
            $table->string('receipt_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
