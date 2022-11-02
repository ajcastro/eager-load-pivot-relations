<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_user', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnDelete();

            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->cascadeOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('car_user');
    }
}
