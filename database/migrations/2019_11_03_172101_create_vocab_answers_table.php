<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocabAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('vocab_question_id');
            $table->unsignedBigInteger('vocab_option_id')->nullable();
            $table->foreign('vocab_question_id')->references('id')->on('vocab_questions');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('vocab_option_id')->references('id')->on('vocab_options');

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
        Schema::dropIfExists('vocab_answers');
    }
}
