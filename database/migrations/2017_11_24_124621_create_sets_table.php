<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('publish');
            $table->timestamps();
        });

        Schema::create('set_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('set_id')->unsigned();

            $table->string('title')->nullable();
            $table->string('locale')->index();

            $table->unique(['set_id','locale']);
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');
        });

        Schema::create('attribute_set', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('attribute_id')->unsigned()->index();
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');

            $table->integer('set_id')->unsigned()->index();
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('property_set', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('property_id')->unsigned()->index();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->integer('set_id')->unsigned()->index();
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');

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
        Schema::dropIfExists('sets');
        Schema::dropIfExists('set_translations');
        Schema::dropIfExists('attribute_set');
        Schema::dropIfExists('property_set');
    }
}
