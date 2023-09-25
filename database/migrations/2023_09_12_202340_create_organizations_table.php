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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('world_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained();
            $table->foreignId('leader_id')->nullable()->references('id')->on('characters')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->foreignId('organization_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
