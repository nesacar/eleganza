<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('insta_shop_id')->unsigned()->index();
            $table->foreign('insta_shop_id')->references('id')->on('insta_shops')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index();
            $table->integer('order')->default(1);
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->boolean('publish')->default(1);
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
        Schema::dropIfExists('coordinates');
    }
}
