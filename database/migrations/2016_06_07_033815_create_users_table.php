<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
		$table->increments('id');
        	$table->integer('account_id')->unsigned();
        	$table->string('email')->unique();
        	$table->string('password');
        	$table->string('type');
        	$table->rememberToken();
        	$table->timestamps();
        	$table->foreign('account_id')->references('account_id')->on('account_information');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->drop('users');
    }
}
