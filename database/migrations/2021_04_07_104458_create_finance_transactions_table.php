<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('transaction_no')->unique();
            $table->string('status')->default('Pending');
            $table->smallInteger('payment_id')->nullable()->unsigned()->index();
            $table->foreign('payment_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('collection_id')->nullable()->unsigned()->index();
            $table->foreign('collection_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('addresses')->onDelete('cascade');
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
        Schema::dropIfExists('finance_transactions');
    }
}
