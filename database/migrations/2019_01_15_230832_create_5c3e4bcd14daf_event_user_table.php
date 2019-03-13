<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c3e4bcd14dafEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('event_user')) {
            Schema::create('event_user', function (Blueprint $table) {
                $table->integer('event_id')->unsigned()->nullable();
                $table->foreign('event_id', 'fk_p_25665_25662_user_eve_5c3e4bcd14e88')->references('id')->on('events')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_p_25662_25665_event_us_5c3e4bcd14eeb')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('event_user');
    }
}
