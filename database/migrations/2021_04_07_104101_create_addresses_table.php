<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('address');
            $table->string('type')->default('Main');
            $table->string('longitude')->default('n/a');
            $table->string('latitude')->default('n/a');
            $table->smallInteger('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('location_regions')->onDelete('cascade');
            $table->smallInteger('province_id')->unsigned()->index();
            $table->foreign('province_id')->references('id')->on('location_provinces')->onDelete('cascade');
            $table->smallInteger('municipality_id')->unsigned()->index();
            $table->foreign('municipality_id')->references('id')->on('location_municipalities')->onDelete('cascade');
            $table->unsignedInteger('addressable_id');
            $table->string('addressable_type');
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
        Schema::dropIfExists('addresses');
    }
}
