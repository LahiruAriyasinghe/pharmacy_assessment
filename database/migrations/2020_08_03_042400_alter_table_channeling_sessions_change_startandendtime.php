<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableChannelingSessionsChangeStartandendtime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channeling_sessions', function (Blueprint $table) {
            $table->time('start_at')->change();
            $table->time('end_at')->change();
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
            //
        });
    }
}
