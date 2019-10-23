<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scale_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('scale_id')->unsigned();
            $table->integer('value');
            $table->timestamps();

            $table->foreign('scale_id')->references('id')->on('scales')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scale_values');
    }
}
