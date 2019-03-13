<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1549316275PlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planners', function (Blueprint $table) {
            if(Schema::hasColumn('planners', 'text')) {
                $table->dropColumn('text');
            }
            
        });
Schema::table('planners', function (Blueprint $table) {
            
if (!Schema::hasColumn('planners', 'body')) {
                $table->text('body')->nullable();
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
            $table->dropColumn('body');
            
        });
Schema::table('planners', function (Blueprint $table) {
                        $table->string('text')->nullable();
                
        });

    }
}
