<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c3e505dda9a6RelationshipsToAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function(Blueprint $table) {
            if (!Schema::hasColumn('answers', 'session_id')) {
                $table->integer('session_id')->unsigned()->nullable();
                $table->foreign('session_id', '25668_5c3e505d7c40c')->references('id')->on('sessions')->onDelete('cascade');
                }
                if (!Schema::hasColumn('answers', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25668_5c3e505d80a71')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('answers', function(Blueprint $table) {
            
        });
    }
}
