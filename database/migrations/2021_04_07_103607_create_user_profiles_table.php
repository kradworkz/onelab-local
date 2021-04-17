<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('firstname',100)->nullable();
            $table->string('lastname',100);
            $table->string('gender',6);
            $table->date('birthday');
            $table->string('avatar',200)->default('avatar.jpg');
            $table->string('signature')->default('n/a');
            $table->smallInteger('laboratory_id')->nullable()->unsigned();
            $table->foreign('laboratory_id')->references('id')->on('dropdown_lists')->onDelete('cascade');
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
        Schema::dropIfExists('user_profiles');
    }
}
