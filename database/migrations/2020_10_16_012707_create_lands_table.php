<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->string('land_number')->primary();
            $table->string('Gramaseva_division');
            $table->string('District');
            $table->string('Owership');
            $table->string('Address')->nullable();
            $table->integer('Size');
            $table->string('Crop');
            $table->string('Agrarian_centre')->nullable();
            $table->string('NIC')->foreign();
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
        Schema::dropIfExists('lands');
    }
}
