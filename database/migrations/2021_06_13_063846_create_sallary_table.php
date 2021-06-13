<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sallary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("division_id")->nullable();
            $table->unsignedBigInteger("position_id")->nullable();
            $table->float("sallary_per_hour")->nullable();
            $table->float("sallary_overtime")->nullable();
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
        Schema::dropIfExists('sallary');
    }
}
