<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->string('keywords')->after('title')->nullable();
            $table->string('desc')->after('keywords')->nullable();
            $table->text('footer')->after('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('keywords');
            $table->dropColumn('desc');
            $table->dropColumn('footer');
        });
    }
}
