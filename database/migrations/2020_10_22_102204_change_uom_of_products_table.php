<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUomOfProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE products MODIFY uom ENUM('B','C', 'K','U','D') NOT NULL DEFAULT 'U'");
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
   
    }
}
