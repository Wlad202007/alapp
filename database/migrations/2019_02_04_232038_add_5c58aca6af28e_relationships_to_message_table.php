<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c58aca6af28eRelationshipsToMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table) {
            if (!Schema::hasColumn('messages', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25664_5c58aaeabb09d')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('messages', 'group_id')) {
                $table->integer('group_id')->unsigned()->nullable();
                $table->foreign('group_id', '25664_5c58aca63692d')->references('id')->on('events')->onDelete('cascade');
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
        Schema::table('messages', function(Blueprint $table) {
            
        });
    }
}
