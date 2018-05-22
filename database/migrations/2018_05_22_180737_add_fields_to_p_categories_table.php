<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_categories', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->string('slug')->after('title')->nullable();
            $table->string('desc')->after('slug')->nullable();
            $table->text('body')->after('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p_categories', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('slug');
            $table->dropColumn('desc');
            $table->dropColumn('body');
        });
    }
}
