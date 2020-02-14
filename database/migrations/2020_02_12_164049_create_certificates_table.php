<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('reservation_id');
            $table->unsignedInteger('result_id');
            $table->unsignedInteger('no');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('studying_degree');

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('result_id')->references('id')->on('results');
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
        Schema::dropIfExists('certificates');
    }
}
