<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceOpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_opds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('doctor_id')->constrained();
            $table->unsignedInteger('token');
            $table->decimal('doctor_fee', 10, 2);
            $table->decimal('hospital_fee', 10, 2);
            $table->decimal('drug_fee', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('total', 10, 2);
            $table->dateTime('printed_at');
            $table->foreignId('hospital_id')->constrained();
            $table->foreignId('created_user_id')->constrained('users');
            $table->dateTime('issued_at');
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
        Schema::dropIfExists('invoice_opds');
    }
}
