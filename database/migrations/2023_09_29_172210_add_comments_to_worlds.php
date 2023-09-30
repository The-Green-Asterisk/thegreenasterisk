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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['blog_post_id']);
            $table->string('commentable_type')->nullable();
            $table->unsignedBigInteger('commentable_id')->nullable();
        });

        DB::table('comments')->where('id', 2)->update([
            'commentable_type' => 'App\Models\BlogPost',
            'commentable_id' => 10,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table
                ->foreignId('blog_post_id')
                ->constrained()
                ->onDelete('cascade');
            $table->dropColumn('commentable_type');
            $table->dropColumn('commentable_id');
        });

        DB::table('comments')->where('id', 2)->update([
            'blog_post_id' => 10,
        ]);
    }
};
