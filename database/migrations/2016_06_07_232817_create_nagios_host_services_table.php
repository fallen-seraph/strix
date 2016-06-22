<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateNagiosHostServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nagidb')->create('nagios_host_services', function (Blueprint $table) {
        	$table->increments('host_service_id');
        	$table->integer('host_id')->unsigned();
        	$table->integer('account_id')->unsigned();
        	$table->integer('service_id')->unsigned();
        	$table->string('host_name');
        	$table->text('service_description');
        	$table->string('check_command');
        	$table->text('contacts')->nullable();
        	$table->text('contact_groups')->nullable();
            $table->string('argument_one')->nullable();
            $table->string('argument_two')->nullable();
            $table->string('argument_three')->nullable();
            $table->string('argument_four')->nullable();
            $table->string('argument_five')->nullable();
        	$table->timestamps();
        });
        Schema::connection('nagidb')->table('nagios_host_services', function($table) {
            $table->foreign('account_id')->references('account_id')->on(new Expression('strixdb.account_information'));
            $table->foreign('service_id')->references('service_id')->on(new Expression('strixProducts.services'));
            $table->foreign('host_id')->references('host_id')->on('nagios_host');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nagidb')->drop('nagios_host_services');
    }
}
