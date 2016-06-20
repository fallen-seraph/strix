<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('strixProducts')->create('services', function (Blueprint $table) {
		$table->increments('service_id');
		$table->string('service_name');
		$table->string('command_name');
		$table->text('description');
		$table->integer('available_arguments');
		$table->string('argument_one')->nullable();
		$table->string('argument_two')->nullable();
		$table->string('argument_three')->nullable();
		$table->string('argument_four')->nullable();
		$table->string('argument_five')->nullable();
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
        Schema::connection('strixProducts')->drop('services');
    }
}
