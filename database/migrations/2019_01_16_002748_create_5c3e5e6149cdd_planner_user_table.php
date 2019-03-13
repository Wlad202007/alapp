<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c3e5e6149cddPlannerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('planner_user')) {
            Schema::create('planner_user', function (Blueprint $table) {
                $table->integer('planner_id')->unsigned()->nullable();
                $table->foreign('planner_id', 'fk_p_25680_25662_user_pla_5c3e5e6149d87')->references('id')->on('planners')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_p_25662_25680_planner__5c3e5e6149dcb')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('planner_user');
    }
}
