<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->integer('totalAmount');
            $table->integer('amountBorrowed_inventory');
            $table->dateTime('dateTimeRegistration');
            $table->string('statusMaterial_inventory');
            $table->timestamps();

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
        Schema::dropIfExists('inventory');
    }
}
