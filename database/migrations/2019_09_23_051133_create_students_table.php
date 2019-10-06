<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->unsignedBigInteger('res_id');
            $table->unsignedBigInteger('group_id');
            $table->string('phone')->unique();
            $table->string('personalimage');
            $table->string('nidimage');
            $table->string('certificateimage');
            $table->string('messageimage');
            $table->integer('verified')->default(0);
            $table->integer('active')->default(0);//is log in or not
            $table->integer('startexam')->default(0); // the student can start the exam or not
            $table->integer('enterexam')->default(0); // the student can enter the exam or not
            $table->foreign('uid')->references('id')->on('users');
            $table->foreign('res_id')->references('id')->on('reservations');
            $table->foreign('group_id')->references('id')->on('groups');

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
        Schema::dropIfExists('students');
    }
}
