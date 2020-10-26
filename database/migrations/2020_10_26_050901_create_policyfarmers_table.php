<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyfarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policyfarmers', function (Blueprint $table) {
            $table->increments('id')->start_from(1000);
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('premium')->nullable();
            $table->string('risk_type')->nullable();
            $table->string('NIC')->nullable();
			$table->string('status')->default("pending");
			$table->boolean('agent_verification')->default(false);
            $table->integer('policy_id')->nullable();
			$table->integer('Size');
			$table->string('Crop');
			$table->string('land_number');
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
        Schema::dropIfExists('policyfarmers');
    }
}
