<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('status')->default('Active');
            $table->boolean('is_sync')->default('1'); 
            $table->smallInteger('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('bussiness_id')->unsigned()->index();
            $table->foreign('bussiness_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('industry_id')->unsigned()->index();
            $table->foreign('industry_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->smallInteger('classification_id')->unsigned()->index();
            $table->foreign('classification_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('customers');
    }
}
