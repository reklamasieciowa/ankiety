<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_option_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_option_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['question_option_id', 'locale']);
            $table->foreign('question_option_id')->references('id')->on('question_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_option_translations');
    }
}
