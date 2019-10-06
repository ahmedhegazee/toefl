<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrammarAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('grammar_question_id');
            $table->unsignedBigInteger('grammar_option_id');
            $table->foreign('grammar_question_id')->references('id')->on('grammar_questions');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('grammar_option_id')->references('id')->on('grammar_options');

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
        Schema::dropIfExists('grammar_answers');
    }
}
