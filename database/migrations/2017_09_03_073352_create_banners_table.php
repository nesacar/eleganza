<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->boolean('publish')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('banner_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banner_id')->unsigned();

            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->string('locale')->index();

            $table->unique(['banner_id','locale']);
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
        });

        Schema::create('banner_newsletter', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('banner_id')->unsigned()->index();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');

            $table->integer('newsletter_id')->unsigned()->index();
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade');

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
        Schema::dropIfExists('banners');
        Schema::dropIfExists('banner_translations');
        Schema::dropIfExists('banner_newsletter');
    }
}
