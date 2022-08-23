<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPharmacyToInvoiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_types', function (Blueprint $table) {
            DB::table('invoice_types')->insertOrIgnore([
                [
                    'id' => 5,
                    'type' => 'App\Invoice\InvoicePharmacy',
                    'name' => 'Pharmacy Invoice',
                ],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_types', function (Blueprint $table) {
            DB::table('invoice_types')->where('type', 'like', 'App\Invoice\InvoicePharmacy')->delete();
        });
    }
}
