<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('reference')->default('n/a');
            $table->date('report_due');
            $table->string('status')->default('Pending');
            $table->boolean('is_sync')->default('1'); 
            $table->boolean('is_view')->default('1'); 
            $table->smallInteger('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('laboratory_id')->unsigned()->index();
            $table->foreign('laboratory_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('purpose_id')->unsigned()->index();
            $table->foreign('purpose_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('from_id')->unsigned()->index();
            $table->foreign('from_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('modeofrelease_id')->unsigned()->index();
            $table->foreign('modeofrelease_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('discount_id')->unsigned()->index();
            $table->foreign('discount_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->smallInteger('conforme_id')->unsigned()->index();
            $table->foreign('conforme_id')->references('id')->on('customer_conformes')->onDelete('cascade');
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
        Schema::dropIfExists('requests');
    }
}
