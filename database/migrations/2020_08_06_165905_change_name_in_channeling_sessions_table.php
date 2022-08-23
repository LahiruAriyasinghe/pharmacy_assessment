<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameInChannelingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channeling_sessions', function (Blueprint $table) {
            $table->renameColumn('session_name', 'name');
            $table->unsignedBigInteger('nurse_id')->nullable()->change();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channeling_sessions', function (Blueprint $table) {
            $table->renameColumn('name', 'session_name');
            $table->unsignedBigInteger('nurse_id')->change();
        });
    }
}
