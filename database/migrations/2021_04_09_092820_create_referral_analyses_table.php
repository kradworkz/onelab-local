<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_analyses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('fee',12,2);
            $table->string('status')->default('Pending');
            $table->boolean('is_package')->default('1'); 
            $table->boolean('is_view')->default('1'); 
            $table->bigInteger('sample_id')->unsigned()->index();
            $table->foreign('sample_id')->references('id')->on('request_samples')->onDelete('cascade');
            $table->smallInteger('testservice_id')->nullable()->unsigned()->index();
            $table->foreign('testservice_id')->references('id')->on('list_test_services')->onDelete('cascade');
            $table->smallInteger('package_id')->nullable()->unsigned()->index();
            $table->foreign('package_id')->references('id')->on('list_packages')->onDelete('cascade');
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
        Schema::dropIfExists('referral_analyses');
    }
}
