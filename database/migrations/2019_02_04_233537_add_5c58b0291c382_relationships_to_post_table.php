<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c58b0291c382RelationshipsToPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function(Blueprint $table) {
            if (!Schema::hasColumn('posts', 'event_id')) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', '25676_5c3e596f6c764')->references('id')->on('events')->onDelete('cascade');
                }
                if (!Schema::hasColumn('posts', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25676_5c3e596f6fea0')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('posts', function(Blueprint $table) {
            
        });
    }
}
