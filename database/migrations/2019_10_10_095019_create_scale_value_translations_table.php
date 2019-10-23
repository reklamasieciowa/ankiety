<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleValueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scale_value_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('scale_value_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['scale_value_id', 'locale']);
            $table->foreign('scale_value_id')->references('id')->on('scale_values')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scale_value_translations');
    }
}
