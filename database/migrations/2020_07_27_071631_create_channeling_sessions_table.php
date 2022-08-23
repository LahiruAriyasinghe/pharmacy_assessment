<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channeling_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_name');
            $table->string('room_no');
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('nurse_id')->constrained('users');;
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedMediumInteger('maximum_patients');
            $table->foreignId('hospital_id')->constrained();
            $table->foreignId('created_user_id')->constrained('users');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channeling_sessions');
    }
}
