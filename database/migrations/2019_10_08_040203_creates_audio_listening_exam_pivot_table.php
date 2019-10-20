<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesAudioListeningExamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_listening_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('audio_id');
            $table->unsignedBigInteger('listening_exam_id');
            $table->foreign('audio_id')->references('id')->on('audio');
            $table->foreign('listening_exam_id')->references('id')->on('listening_exams');

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
        Schema::dropIfExists('audio_listening_exam');
    }
}
