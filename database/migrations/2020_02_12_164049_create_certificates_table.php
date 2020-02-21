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
            $table->string('start_date');
            $table->string('end_date');
            $table->string('studying_degree');

            $table->foreign('student_id')->on('students')->references('id');
            $table->foreign('reservation_id')->on('reservations')->references('id');
            $table->foreign('result_id')->on('results')->references('id');
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
