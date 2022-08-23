<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToInvoiceLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_lab_reports', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')
                ->default(1)
                ->after('sample_no')
                ->comment('1=incomplete, 2=completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_lab_reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
