<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('c_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('ic')->nullable();
            $table->integer('level')->nullable();
            $table->string('class')->nullable();
            $table->integer('school_id')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_contact')->nullable();
            $table->string('parent_relation')->nullable();
            $table->string('parent_name_2')->nullable();
            $table->string('parent_contact_2')->nullable();
            $table->string('parent_relation_2')->nullable();
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
        Schema::dropIfExists('students');
    }
}
