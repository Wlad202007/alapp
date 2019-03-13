<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c41029211e43RelationshipsToUsersLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_likes', function(Blueprint $table) {
            if (!Schema::hasColumn('users_likes', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '26052_5c41029198bf5')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('users_likes', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '26052_5c4102919c484')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('users_likes', function(Blueprint $table) {
            
        });
    }
}
