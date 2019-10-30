<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('survey_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('industry_id')->unsigned();
            $table->string('email')->nullable();
            $table->boolean('agree')->nullable()->default('0');
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
