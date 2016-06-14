<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('invoice_items', function (Blueprint $table) {
            $table->integer('account_id')->unsigned();
            $table->integer('invoice_number')->unsigned();
            $table->integer('line_number')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();
        });

        Schema::connection('mysql')->table('invoice_items', function($table) {
            $table->foreign('account_id')->references('account_id')->on('account_information');
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->drop('invoice_items');
    }
}
