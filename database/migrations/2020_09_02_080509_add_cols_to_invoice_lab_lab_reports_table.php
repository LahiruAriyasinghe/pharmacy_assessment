<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToInvoiceLabLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_lab_lab_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('sample_no')->nullable();
            $table->text('result')->nullable();
            $table->foreignId('hospital_id')->nullable()->constrained();
            $table->foreignId('created_user_id')->nullable()->constrained('users');
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
        Schema::table('invoice_lab_lab_reports', function (Blueprint $table) {
            $table->dropColumn('sample_no');
            $table->dropColumn('result');
            $table->dropColumn('hospital_id');
            $table->dropColumn('created_user_id');
            $table->dropColumn('deleted_at');
            $table->dropTimestamps();
        });
    }
}
