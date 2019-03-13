<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c3e4df155904RelationshipsToRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function(Blueprint $table) {
            if (!Schema::hasColumn('rates', 'session_id')) {
                $table->integer('session_id')->unsigned()->nullable();
                $table->foreign('session_id', '25667_5c3e4df0e9044')->references('id')->on('sessions')->onDelete('cascade');
                }
                if (!Schema::hasColumn('rates', 'author_id')) {
                $table->integer('author_id')->unsigned()->nullable();
                $table->foreign('author_id', '25667_5c3e4df0ee25e')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('rates', function(Blueprint $table) {
            
        });
    }
}
