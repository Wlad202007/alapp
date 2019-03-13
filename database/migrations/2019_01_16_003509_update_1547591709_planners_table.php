<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1547591709PlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planners', function (Blueprint $table) {
            
if (!Schema::hasColumn('planners', 'done')) {
                $table->tinyInteger('done')->nullable()->default('0');
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
        Schema::table('planners', function (Blueprint $table) {
            $table->dropColumn('done');
            
        });

    }
}
