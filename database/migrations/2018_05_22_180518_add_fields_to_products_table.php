<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->string('slug')->after('title')->nullable();
            $table->string('short')->after('slug')->nullable();
            $table->text('body')->after('short')->nullable();
            $table->text('body2')->after('body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('slug');
            $table->dropColumn('short');
            $table->dropColumn('body');
            $table->dropColumn('body2');
        });
    }
}
