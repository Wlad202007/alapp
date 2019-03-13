<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c6534a30c6b4RelationshipsToEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluations', function(Blueprint $table) {
            if (!Schema::hasColumn('evaluations', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '28830_5c6534a27a1bd')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('evaluations', 'event_id')) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', '28830_5c6534a2802f5')->references('id')->on('events')->onDelete('cascade');
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
        Schema::table('evaluations', function(Blueprint $table) {
            
        });
    }
}
