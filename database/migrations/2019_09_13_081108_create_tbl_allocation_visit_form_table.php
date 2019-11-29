<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAllocationVisitFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_allocation_visit_form', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tester_id');
            $table->bigInteger('patient_id');
            $table->string('symptoms')->nullable();
            $table->string('disease')->nullable();
            $table->string('treatment')->nullable();
            $table->string('visit_purpose')->nullable();
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
        Schema::dropIfExists('tbl_allocation_visit_form');
    }
}
