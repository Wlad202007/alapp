<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c52e3c53244eRelationshipsToSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function(Blueprint $table) {
            if (!Schema::hasColumn('sessions', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '25666_5c3e4a3d950b3')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('sessions', 'event_id')) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', '25666_5c3e4a3d9a539')->references('id')->on('events')->onDelete('cascade');
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
        Schema::table('sessions', function(Blueprint $table) {
            
        });
    }
}
