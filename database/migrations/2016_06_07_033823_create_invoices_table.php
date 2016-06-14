<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('invoices', function (Blueprint $table) {
        	$table->increments('invoice_number');
            $table->integer('account_id')->unsigned();
            $table->string('invoice_status');
            $table->date('due_date');
            $table->decimal('total', 6, 2);
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
        Schema::connection('mysql')->drop('invoices');
    }
}
