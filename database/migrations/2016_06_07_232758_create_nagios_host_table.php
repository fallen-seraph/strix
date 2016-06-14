<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateNagiosHostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nagidb')->create('nagios_host', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('host_id')->unsigned();
            $table->string('host_name');
            $table->string('alias');
            $table->string('address');
            $table->text('contacts');
            $table->string('contact_groups');
            $table->timestamps();
        });
        Schema::connection('nagidb')->table('nagios_host', function($table) {
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
        Schema::connection('nagidb')->drop('nagios_host');
    }
}
