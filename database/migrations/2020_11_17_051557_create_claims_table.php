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
            $table->Integer('policy_number');
            $table->float('loss_amount');
            $table->string('NIC');
			$table->string('incident_date');
			$table->Integer('phone');
            $table->Integer('account_number');
			$table->string('bank_name');
			$table->string('branch');
            $table->string('loan_number');
			$table->string('status')->default("pending");
			$table->string('organization_verification')->nullable();
            $table->foreignId('organization_id');
            $table->foreignId('company_id');
			$table->longText('image');
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
