<?php

use Illuminate\Database\Seeder;

class LabReportTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_data_result_categories')->insertOrIgnore([
            [
                'id' => 1,
                'result_category' => 'Numerical',
                'result_category_types' => '',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'is_editable' => 0,
                'is_range' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'result_category' => 'Text',
                'result_category_types' => '',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'is_editable' => 0,
                'is_range' => 0,
                'created_at' => now(),
            ],
            // [
            //     'id' => 3,
            //     'result_category' => 'Negative / Positive',
            //     'result_category_types' => 'Negative,Positive',
            //     'hospital_id' => 11,
            //     'created_user_id' => 20000,
            //     'is_editable' => 1,
            //     'is_range' => 0,
            //     'created_at' => now(),
            // ],
            // [
            //     'id' => 4,
            //     'result_category' => 'Blood Type',
            //     'result_category_types' => 'A+,A-,B+,B-,AB+,AB-,O+,O-',
            //     'hospital_id' => 11,
            //     'created_user_id' => 20000,
            //     'is_editable' => 1,
            //     'is_range' => 0,
            //     'created_at' => now(),
            // ],
            // [
            //     'id' => 5,
            //     'result_category' => 'Urine Color',
            //     'result_category_types' => 'Pale yellow,Yellow,Redish yellow,Red,Pink,Brownish,Milky white',
            //     'hospital_id' => 11,
            //     'created_user_id' => 20000,
            //     'is_editable' => 1,
            //     'is_range' => 0,
            //     'created_at' => now(),
            // ],
        ]);

        DB::table('units')->insertOrIgnore([
            [
                'id' => 1,
                'unit' => '%',
                'name' => 'Percentage',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'unit' => 'per cumm',
                'name' => 'per cubic millimeter',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'unit' => 'g/dl',
                'name' => null,
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
        ]);

        // DB::table('test_datas')->insertOrIgnore([
        //     [
        //         'id' => 1,
        //         'name' => 'test a',
        //         'description' => 'test a description',
        //         'unit_id' => '1',
        //         'test_data_category_id' => null,
        //         'test_data_result_category_id' => null,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'test b',
        //         'description' => 'test b description',
        //         'unit_id' => null,
        //         'test_data_category_id' => null,
        //         'test_data_result_category_id' => 1,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'test c',
        //         'description' => 'test c description',
        //         'unit_id' => null,
        //         'test_data_category_id' => null,
        //         'test_data_result_category_id' => 2,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'test d',
        //         'description' => 'test d description',
        //         'unit_id' => 3,
        //         'test_data_category_id' => null,
        //         'test_data_result_category_id' => null,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        // ]);

        // DB::table('lab_report_test_data')->insertOrIgnore([
        //     [
        //         'id' => 1,
        //         'test_datas_id' => 1,
        //         'lab_report_id' => 65,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 2,
        //         'test_datas_id' => 2,
        //         'lab_report_id' => 65,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 3,
        //         'test_datas_id' => 3,
        //         'lab_report_id' => 65,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 1,
        //         'test_datas_id' => 1,
        //         'lab_report_id' => 61,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 2,
        //         'test_datas_id' => 2,
        //         'lab_report_id' => 61,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 3,
        //         'test_datas_id' => 3,
        //         'lab_report_id' => 61,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'id' => 3,
        //         'test_datas_id' => 4,
        //         'lab_report_id' => 61,
        //         'hospital_id' => 11,
        //         'created_user_id' => 20000,
        //         'created_at' => now(),
        //     ],
        // ]);
    }
}
