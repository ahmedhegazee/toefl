<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesStudentReservationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_reservation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('reservation_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('student_documents_id');
            $table->integer('required_score')->default(400);
            $table->integer('studying');
            $table->integer('verified')->default(0);
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('student_documents_id')->references('id')->on('student_documents');


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
        Schema::dropIfExists('student_reservation');
    }
}
