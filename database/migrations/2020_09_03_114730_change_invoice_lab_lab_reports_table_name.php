<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInvoiceLabLabReportsTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_lab_lab_reports', function (Blueprint $table) {
            Schema::rename('invoice_lab_lab_reports', 'invoice_lab_reports');
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
            Schema::rename('invoice_lab_reports', 'invoice_lab_lab_reports');
        });
    }
}