<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('types')->nullable();
            $table->string('numbers')->nullable();
            $table->string('verification')->nullable();
            $table->integer('received')->nullable();
            $table->integer('send')->nullable();
            $table->integer('skip')->nullable();
            $table->timestamp('last_send')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('newsletters');
    }
}
