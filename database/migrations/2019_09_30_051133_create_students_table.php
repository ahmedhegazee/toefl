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
            $table->string('arabic_name');
            $table->string('personalimage');
            $table->string('nidimage');
            $table->string('certificateimage');
            $table->string('messageimage');
            $table->integer('gender');
            $table->integer('required_score')->default(400);
            $table->integer('verified')->default(0);
            $table->integer('studying');
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
