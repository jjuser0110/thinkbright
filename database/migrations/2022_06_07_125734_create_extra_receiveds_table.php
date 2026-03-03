<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_receiveds', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->double('amount')->nullable();
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
        Schema::dropIfExists('extra_receiveds');
    }
}
