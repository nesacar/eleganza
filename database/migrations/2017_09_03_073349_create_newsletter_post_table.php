<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_post', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('newsletter_id')->unsigned()->index();
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade');

            $table->integer('post_id')->unsigned()->index();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

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
        Schema::dropIfExists('newsletter_post');
    }
}
