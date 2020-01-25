<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesParagraphReadingExamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraph_reading_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paragraph_id');
            $table->unsignedBigInteger('reading_exam_id');
            $table->foreign('paragraph_id')->references('id')->on('paragraphs');
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
        Schema::dropIfExists('reading_exam_paragraph');
    }
}
