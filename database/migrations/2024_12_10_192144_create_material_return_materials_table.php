<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialReturnMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_return_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_return_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('quantity_returned')->default(0);
            $table->timestamps();

            $table->foreign('material_return_id')
                ->references('id')
                ->on('material_returns')
                ->onDelete('cascade');

            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_return_materials');
    }
}
