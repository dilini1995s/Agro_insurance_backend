<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->integer('policy_number');
            $table->float('loss_amount');
            $table->string('NIC');
			$table->string('incident_date');
			$table->string('type_of_loss');
			$table->integer('phone');
            $table->integer('account_number');
			$table->string('bank_name');
			$table->string('branch');
            $table->string('loan_number');
			$table->string('status')->default("pending");
			$table->string('organization_verification')->nullable();
            $table->foreignId('organization_id')->nullable();
            $table->foreignId('company_id');
			$table->longText('image')->nullable();
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
        Schema::dropIfExists('claims');
    }
}
