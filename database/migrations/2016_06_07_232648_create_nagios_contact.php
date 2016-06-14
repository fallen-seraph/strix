<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateNagiosContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nagidb')->create('nagios_contact', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->string('contact_name');
            $table->string('alias');
            $table->text('contact_groups');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('misc')->nullable();
            $table->boolean('receive');
            $table->timestamps();
        });

        Schema::connection('nagidb')->table('nagios_contact', function($table) {
            $table->foreign('account_id')->references('account_id')->on(new Expression('strixdb.account_information'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nagidb')->drop('nagios_contact');
    }
}