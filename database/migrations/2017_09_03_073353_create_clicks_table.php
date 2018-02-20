<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('newsletter_id')->unsigned()->index();
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade');

            $table->integer('post_id')->unsigned()->index()->nullable();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('banner_id')->unsigned()->index()->nullable();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');

            $table->integer('subscriber_id')->unsigned()->index()->nullable();
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');

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
        Schema::dropIfExists('clicks');
    }
}
