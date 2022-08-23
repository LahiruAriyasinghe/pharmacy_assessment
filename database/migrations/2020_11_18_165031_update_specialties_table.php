<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->foreignId('hospital_id')->after('description')->default(11)->constrained();
            $table->foreignId('created_user_id')->after('hospital_id')->default(20000)->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->dropColumn('hospital_id');
            $table->dropColumn('created_user_id');
        });
    }
}
