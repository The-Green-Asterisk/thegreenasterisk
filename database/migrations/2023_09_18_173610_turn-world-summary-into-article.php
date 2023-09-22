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
        Schema::table('worlds', function (Blueprint $table) {
            $table->renameColumn('summary', 'article');
        });
        Schema::table('worlds', function (Blueprint $table) {
            $table->text('article')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worlds', function (Blueprint $table) {
            $table->renameColumn('article', 'summary');
        });
        Schema::table('worlds', function (Blueprint $table) {
            $table->string('summary')->change();
        });
    }
};
