<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('survey_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('description');
            $table->unique(['survey_id', 'locale']);
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_translations');
    }
}
