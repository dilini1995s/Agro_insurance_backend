<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->string('NIC')->primary();
            $table->string('Name');
            $table->string('Address')->nullable();
            $table->integer('Phone');
            $table->string('DOB')->nullable();
            $table->string('Password');
			$table->float('rating_number')->default(0);
            $table->foreignId('Agent_id')->nullable();
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
        Schema::dropIfExists('farmers');
    }
}
