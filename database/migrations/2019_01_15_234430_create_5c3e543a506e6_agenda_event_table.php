<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c3e543a506e6AgendaEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('agenda_event')) {
            Schema::create('agenda_event', function (Blueprint $table) {
                $table->integer('agenda_id')->unsigned()->nullable();
                $table->foreign('agenda_id', 'fk_p_25669_25665_event_ag_5c3e543a5078c')->references('id')->on('agendas')->onDelete('cascade');
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', 'fk_p_25665_25669_agenda_e_5c3e543a507d1')->references('id')->on('events')->onDelete('cascade');
                
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
        Schema::dropIfExists('agenda_event');
    }
}
