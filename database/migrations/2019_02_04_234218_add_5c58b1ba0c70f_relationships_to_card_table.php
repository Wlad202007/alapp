<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c58b1ba0c70fRelationshipsToCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function(Blueprint $table) {
            if (!Schema::hasColumn('cards', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '27794_5c58b1b9856df')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('cards', function(Blueprint $table) {
            
        });
    }
}
