<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_samples', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->default('n/a');
            $table->string('name');
            $table->string('description')->default('n/a');
            $table->string('customer_description')->default('n/a');
            $table->smallInteger('sampletype_id')->unsigned()->index();
            $table->foreign('sampletype_id')->references('id')->on('list_sample_tests')->onDelete('cascade');
            $table->smallInteger('laboratory_id')->unsigned()->index();
            $table->foreign('laboratory_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
            $table->bigInteger('request_id')->unsigned()->index();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
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
        Schema::dropIfExists('referral_samples');
    }
}
