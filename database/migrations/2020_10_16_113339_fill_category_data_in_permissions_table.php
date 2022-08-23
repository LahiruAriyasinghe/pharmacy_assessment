<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FillCategoryDataInPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            DB::table('permissions')
              ->where('name', 'like', '%user')
              ->update(['category' => 'user']);

            DB::table('permissions')
              ->where('name', 'like', '%reset user password')
              ->update(['category' => 'user']);
              
            DB::table('permissions')
              ->where('name', 'like', '%role')
              ->update(['category' => 'role']);

            DB::table('permissions')
              ->where('name', 'like', '%doctor')
              ->update(['category' => 'doctor']);

            DB::table('permissions')
              ->where('name', 'like', '%patient')
              ->update(['category' => 'patient']);

            DB::table('permissions')
              ->where('name', 'like', '%service')
              ->update(['category' => 'other service']);

            DB::table('permissions')
              ->where('name', 'like', '%session')
              ->update(['category' => 'chanel session']);

            DB::table('permissions')
              ->where('name', 'like', '%product')
              ->update(['category' => 'pharmacy product']);

            DB::table('permissions')
              ->where('name', 'like', '%lab report')
              ->update(['category' => 'lab report']);

            DB::table('permissions')
              ->where('name', 'like', '%unit')
              ->update(['category' => 'lab report']);

            DB::table('permissions')
              ->where('name', 'like', '%result category')
              ->update(['category' => 'lab report']);

            DB::table('permissions')
              ->where('name', 'like', '%test data%')
              ->update(['category' => 'lab report']);

            DB::table('permissions')
              ->where('name', 'like', '%invoice')
              ->update(['category' => 'invoice']);

            DB::table('permissions')
              ->where('name', 'like', '%reports')
              ->update(['category' => 'reports']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
          DB::table('permissions')
          ->where('id', '>', 0)
          ->update(['category' => 'other']);
        });
    }
}
