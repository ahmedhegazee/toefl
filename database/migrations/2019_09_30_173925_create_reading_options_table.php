<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reading_question_id');
            $table->string('content');
            $table->unsignedInteger('correct')->default(0);
            $table->foreign('reading_question_id')->on('reading_questions')->references('id');
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
        Schema::dropIfExists('reading_options');
    }
}
