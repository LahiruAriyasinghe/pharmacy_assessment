<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoice_types')->insertOrIgnore([
            [
                'id' => 1,
                'type' => 'App\Invoice\InvoiceOpd',
                'name' => 'OPD Invoice',
            ],
            [
                'id' => 2,
                'type' => 'App\Invoice\InvoiceChanneling',
                'name' => 'Channeling Invoice',
            ],
            [
                'id' => 3,
                'type' => 'App\Invoice\InvoiceLab',
                'name' => 'Lab Invoice',
            ],
            [
                'id' => 4,
                'type' => 'App\Invoice\InvoiceOther',
                'name' => 'Service Invoice',
            ],
            [
                'id' => 5,
                'type' => 'App\Invoice\InvoicePharmacy',
                'name' => 'Pharmacy Invoice',
            ],
        ]);
    }
}
