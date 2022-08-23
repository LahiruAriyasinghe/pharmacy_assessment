<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceReportToLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('reference_report')
                ->nullable()
                ->after('lab_report_categories_id');

            $table->foreign('reference_report')
                ->references('id')
                ->on('lab_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            $table->dropColumn('reference_report');
        });
    }
}
