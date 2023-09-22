<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
        Schema::table('characters', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
        Schema::table('items', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
        SChema::table('events', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        SChema::table('events', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
