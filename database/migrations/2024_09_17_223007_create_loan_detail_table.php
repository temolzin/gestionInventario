<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('amountBorrowed_detail');
            $table->text('loanPurpose');
            $table->timestamps();
            
            $table->foreign('loan_id')->references('id')->on('loan')->onDelete('cascade');           
            $table->foreign('material_id')->references('id')->on('material')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_detail');
    }
}
