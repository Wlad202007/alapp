<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c3e5a69a32d2RelationshipsToCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function(Blueprint $table) {
            if (!Schema::hasColumn('comments', 'post_id')) {
                $table->integer('post_id')->unsigned()->nullable();
                $table->foreign('post_id', '25678_5c3e5a6941733')->references('id')->on('posts')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25678_5c3e5a6945409')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('comments', function(Blueprint $table) {
            
        });
    }
}
