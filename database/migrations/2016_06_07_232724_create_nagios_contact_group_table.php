<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateNagiosContactGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nagidb')->create('nagios_contact_group', function (Blueprint $table) {
            $table->increments('group_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('contact_group_name')->unique();
            $table->string('alias');
            $table->text('members');
            $table->timestamps();
        });

        Schema::connection('nagidb')->table('nagios_contact_group', function($table) {
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
        Schema::connection('nagidb')->drop('nagios_contact_group');
    }
}