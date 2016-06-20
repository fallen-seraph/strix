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
            $table->integer('available_arguments');
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
