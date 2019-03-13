<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c3e543a4e1d4EventSponsorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('event_sponsor')) {
            Schema::create('event_sponsor', function (Blueprint $table) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', 'fk_p_25665_25670_sponsor__5c3e543a4e284')->references('id')->on('events')->onDelete('cascade');
                $table->integer('sponsor_id')->unsigned()->nullable();
                $table->foreign('sponsor_id', 'fk_p_25670_25665_event_sp_5c3e543a4e2c8')->references('id')->on('sponsors')->onDelete('cascade');
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_sponsor');
    }
}
