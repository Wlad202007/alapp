<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c3e5b8eba7abMessageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('message_user')) {
            Schema::create('message_user', function (Blueprint $table) {
                $table->integer('message_id')->unsigned()->nullable();
                $table->foreign('message_id', 'fk_p_25664_25662_user_mes_5c3e5b8eba869')->references('id')->on('messages')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_p_25662_25664_message__5c3e5b8eba8e5')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('message_user');
    }
}
