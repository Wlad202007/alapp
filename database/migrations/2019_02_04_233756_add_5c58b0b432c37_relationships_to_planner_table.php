<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c58b0b432c37RelationshipsToPlannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planners', function(Blueprint $table) {
            if (!Schema::hasColumn('planners', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25680_5c58b0b3b0f36')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('planners', function(Blueprint $table) {
            
        });
    }
}
