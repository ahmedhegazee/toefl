<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrammarQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question_text');
            $table->unsignedBigInteger('grammar_question_type_id');
            $table->foreign('grammar_question_type_id')->references('id')->on('grammar_question_types');
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
        Schema::dropIfExists('grammar_questions');
    }
}
