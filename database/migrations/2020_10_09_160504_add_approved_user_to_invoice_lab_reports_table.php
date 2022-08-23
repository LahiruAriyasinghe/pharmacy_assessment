<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedUserToInvoiceLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_lab_reports', function (Blueprint $table) {
            $table->foreignId('updated_user_id')
            ->nullable()
            ->after('created_at')
            ->constrained('users');

            $table->foreignId('approved_user_id')
            ->nullable()
            ->after('updated_at')
            ->constrained('users');

            $table->dateTime('approved_at', 0)
            ->nullable()
            ->after('approved_user_id');
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
            $table->dropForeign('invoice_lab_reports_approved_user_id_foreign');
            $table->dropForeign('invoice_lab_reports_updated_user_id_foreign');

            $table->dropColumn(['updated_user_id', 'approved_user_id', 'approved_at']);
        });
    }
}
