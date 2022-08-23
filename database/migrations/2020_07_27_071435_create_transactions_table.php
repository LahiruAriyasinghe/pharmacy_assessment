<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->morphs('invoice');
            $table->string('note', 500)->nullable();
            $table->enum('type', ['cash', 'card']);
            $table->boolean('reversed')->default(0);
            $table->decimal('credit', 10, 2);
            $table->decimal('debit', 10, 2);
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
        Schema::dropIfExists('transactions');
    }
}
