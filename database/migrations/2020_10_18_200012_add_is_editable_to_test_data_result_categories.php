<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsEditableToTestDataResultCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_data_result_categories', function (Blueprint $table) {
            $table->boolean('is_editable')->default(1)->after('result_category_types')->comment('0 - default result type');
            $table->boolean('is_range')->default(0)->after('is_editable')->comment('0 - does not have ranges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_data_result_categories', function (Blueprint $table) {
            $table->dropColumn('is_editable');
            $table->dropColumn('is_range');
        });
    }
}
