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
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('student_documents_id');
            $table->integer('required_score')->default(400);
            $table->integer('studying');
            $table->integer('verified')->default(0);
            $table->foreign('reservation_id')->on('reservations')->references('id');
            $table->foreign('student_id')->on('students')->references('id');
            $table->foreign('student_documents_id')->on('student_documents')->references('id');


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
