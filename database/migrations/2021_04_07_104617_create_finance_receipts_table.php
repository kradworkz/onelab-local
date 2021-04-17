<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_receipts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('ornumber')->unique();
            $table->smallInteger('orseries_id')->unsigned()->index();
            $table->foreign('orseries_id')->references('id')->on('finance_orseries')->onDelete('cascade');
            $table->smallInteger('deposit_id')->unsigned()->index();
            $table->foreign('deposit_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->bigInteger('transaction_id')->unsigned()->index();
            $table->foreign('transaction_id')->references('id')->on('finance_transactions')->onDelete('cascade');
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
        Schema::dropIfExists('finance_receipts');
    }
}
