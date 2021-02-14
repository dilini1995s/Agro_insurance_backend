<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyfarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companyfarmers', function (Blueprint $table) {
            $table->id();
			$table->string('NIC');
            $table->unsignedBigInteger('company_id');
            $table->string('issues')->nullable();
            $table->string('suggestions')->nullable();
            $table->string('answers')->nullable();
            $table->string('status')->default('pending');
            $table->foreign('NIC')->references('NIC')->on('farmers')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('insurancecoms')->onDelete('cascade');
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
        Schema::dropIfExists('companyfarmers');
    }
}
