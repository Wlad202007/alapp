<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c58aec791f2bRelationshipsToEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function(Blueprint $table) {
            if (!Schema::hasColumn('events', 'industry_id')) {
                $table->integer('industry_id')->unsigned()->nullable();
                $table->foreign('industry_id', '25665_5c3e551eeefe2')->references('id')->on('industries')->onDelete('cascade');
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
        Schema::table('events', function(Blueprint $table) {
            
        });
    }
}
