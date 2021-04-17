<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPackageListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_package_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->smallInteger('package_id')->unsigned()->index();
            $table->foreign('package_id')->references('id')->on('list_packages')->onDelete('cascade');
            $table->smallInteger('testservice_id')->unsigned()->index();
            $table->foreign('testservice_id')->references('id')->on('list_test_services')->onDelete('cascade');
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
        Schema::dropIfExists('list_package_lists');
    }
}
