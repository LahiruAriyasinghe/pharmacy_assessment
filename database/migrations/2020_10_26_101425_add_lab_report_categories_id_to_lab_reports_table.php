<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabReportCategoriesIdToLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            $table->foreignId('lab_report_categories_id')
                ->nullable()
                ->after('fee')
                ->constrained();
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
            $table->dropColumn('lab_report_categories_id');
        });
    }
}
