<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c3e59be0ee5bRelationshipsToLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function(Blueprint $table) {
            if (!Schema::hasColumn('likes', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25677_5c3e59bd99def')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('likes', 'post_id')) {
                $table->integer('post_id')->unsigned()->nullable();
                $table->foreign('post_id', '25677_5c3e59bd9ee73')->references('id')->on('posts')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function(Blueprint $table) {
            
        });
    }
}
