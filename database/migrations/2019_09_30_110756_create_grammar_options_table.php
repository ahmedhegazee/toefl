<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrammarOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->string('content');
            $table->unsignedInteger('correct')->default(0);
            $table->foreign('question_id')->references('id')->on('grammar_questions');
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
        Schema::dropIfExists('grammar_options');
    }
}
