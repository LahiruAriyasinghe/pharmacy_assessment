<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePharmacyProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_pharmacy_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_pharmacies_id')->constrained();
            $table->foreignId('product_stocks_id')->constrained();
            $table->unsignedInteger('quantity');
            $table->decimal('total', 10, 2);
            $table->foreignId('hospital_id')->constrained();
            $table->foreignId('created_user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_pharmacy_product_stocks');
    }
}
