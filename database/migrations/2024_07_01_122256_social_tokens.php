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
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_token')->nullable();
            $table->text('github_token')->nullable();
            $table->text('facebook_token')->nullable();
            $table->text('twitter_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_token');
            $table->dropColumn('github_token');
            $table->dropColumn('facebook_token');
            $table->dropColumn('twitter_token');
        });
    }
};
