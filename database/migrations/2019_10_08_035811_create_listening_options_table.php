<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListeningOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listening_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listening_question_id');
            $table->string('content');
            $table->unsignedInteger('correct')->default(0);
            $table->foreign('listening_question_id')->on('listening_questions')->references('id');

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
        Schema::dropIfExists('listening_options');
    }
}
