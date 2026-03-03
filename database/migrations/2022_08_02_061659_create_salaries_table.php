<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->double('basic')->nullable();
            $table->double('overtime')->nullable();
            $table->double('commission')->nullable();
            $table->double('allowances')->nullable();
            $table->double('extra')->nullable();
            $table->double('gross_pay')->nullable();
            $table->double('epf')->nullable();
            $table->double('socso')->nullable();
            $table->double('advance')->nullable();
            $table->double('income_tax')->nullable();
            $table->double('total_deduction')->nullable();
            $table->double('reimbursement')->nullable();
            $table->double('total_additions')->nullable();
            $table->double('net_pay')->nullable();
            $table->double('employer_epf')->nullable();
            $table->double('employer_socso')->nullable();
            $table->double('employer_s_p')->nullable();
            $table->double('total_contribution')->nullable();
            $table->double('employer_total_paid')->nullable();  
            $table->text('remarks')->nullable();  
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('year_month')->nullable();
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
        Schema::dropIfExists('salaries');
    }
}
