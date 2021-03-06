<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1549314794MessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            if(Schema::hasColumn('messages', 'text')) {
                $table->dropColumn('text');
            }
            
        });
Schema::table('messages', function (Blueprint $table) {
            
if (!Schema::hasColumn('messages', 'body')) {
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('body');
            
        });
Schema::table('messages', function (Blueprint $table) {
                        $table->text('text')->nullable();
                
        });

    }
}
