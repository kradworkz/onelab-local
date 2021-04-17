<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListTestServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_test_services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->tinyInteger('agency_id')->unsigned()->index();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->smallInteger('sampletype_id')->unsigned()->index();
            $table->foreign('sampletype_id')->references('id')->on('list_sample_tests')->onDelete('cascade');
            $table->smallInteger('testname_id')->unsigned()->index();
            $table->foreign('testname_id')->references('id')->on('list_sample_tests')->onDelete('cascade');
            $table->smallInteger('method_id')->unsigned()->index();
            $table->foreign('method_id')->references('id')->on('list_method_refs')->onDelete('cascade');
            $table->smallInteger('reference_id')->unsigned()->index();
            $table->foreign('reference_id')->references('id')->on('list_method_refs')->onDelete('cascade');
            $table->decimal('fee',12,2);
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
        Schema::dropIfExists('list_test_services');
    }
}
