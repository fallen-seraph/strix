<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('account_information', function (Blueprint $table) {
            $table->increments('account_id');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('account_type');
			$table->boolean('service');
			$table->string('company')->nullable();
			$table->string('email')->unique();
			$table->string('phone')->nullable();//111-222-3333
			$table->string('address_one')->nullable();
			$table->string('address_two')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->integer('zip')->unsigned()->nullable();
			$table->string('country')->nullable();
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
        Schema::connection('mysql')->drop('account_information');
    }
}
