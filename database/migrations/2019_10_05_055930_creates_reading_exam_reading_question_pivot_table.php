<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesReadingExamReadingQuestionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_exam_reading_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reading_question_id');
            $table->unsignedBigInteger('reading_exam_id');
            $table->foreign('reading_question_id')->references('id')->on('reading_questions');
            $table->foreign('reading_exam_id')->references('id')->on('reading_exams');

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
        Schema::dropIfExists('reading_exam_reading_question');
    }
}
