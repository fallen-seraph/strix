<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateBillingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('strixdb')->create('billing_information', function (Blueprint $table) {
			$table->increments('billing_id')->unique();
			$table->integer('account_id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('address_one');
			$table->string('address_two')->nullable();
			$table->string('city');
			$table->string('state');
			$table->integer('zip');
			$table->string('country');
			$table->boolean('preferred_payment_type');
			$table->boolean('paypal');
			$table->string('cc_num')->nullable();
			$table->integer('cc_num_last_four')->unsigned()->nullable();
			$table->date('cc_exp')->nullable();
			$table->integer('cc_sec_code')->unsigned()->nullable();
			$table->foreign('account_id')->references('account_id')->on('account_information');
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
        Schema::connection('strixdb')->drop('billing_information');
    }
}
