<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paragraph_id')->nullable();
            $table->string('content');
            $table->unsignedBigInteger('reading_question_type_id');
            $table->foreign('reading_question_type_id')->references('id')->on('reading_question_types');

            $table->foreign('paragraph_id')->on('paragraphs')->references('id');
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
        Schema::dropIfExists('reading_questions');
    }
}
