<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDataRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_data_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_data_id')->constrained();
            $table->enum('gender', ['M', 'F'])->comment('Male, Female');
            $table->unsignedTinyInteger('age_min');
            $table->unsignedTinyInteger('age_max')->nullable();
            $table->decimal('range_min', 20, 10);
            $table->decimal('range_max', 20, 10)->nullable();
            $table->string('condition', 500);
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
        Schema::dropIfExists('test_data_ranges');
    }
}
