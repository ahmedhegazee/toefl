<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParagraphAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraph_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('paragraph_id');
            $table->unsignedBigInteger('paragraph_question_id');
            $table->unsignedBigInteger('paragraph_question_option_id')->nullable();
            $table->foreign('paragraph_question_id')->references('id')->on('paragraph_questions');
            $table->foreign('paragraph_id')->references('id')->on('paragraphs');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('paragraph_question_option_id')->references('id')->on('paragraph_question_options');

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
        Schema::dropIfExists('paragraph_answers');
    }
}
