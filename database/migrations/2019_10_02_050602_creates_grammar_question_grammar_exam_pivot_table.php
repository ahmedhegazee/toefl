<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesGrammarQuestionGrammarExamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_exam_grammar_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grammar_question_id');
            $table->unsignedBigInteger('grammar_exam_id');
            $table->foreign('grammar_question_id')->references('id')->on('grammar_questions');
            $table->foreign('grammar_exam_id')->references('id')->on('grammar_exams');

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
        Schema::dropIfExists('grammar_question_grammar_exam');
    }
}
