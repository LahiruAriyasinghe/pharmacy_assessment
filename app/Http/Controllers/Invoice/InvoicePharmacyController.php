<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Invoice\InvoicePharmacy;
use Illuminate\Http\Request;

use App\Patient;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Storage;

class InvoicePharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create invoice', Auth::user());

        $request->validate([

            'name' => 'required|array|min:1',

        ]);

        $returnedValues = DB::transaction(function () use ($request) {

            $createdUser = Auth::user();
            $createdUserHospital = $createdUser->hospital;
            $invoiceTypeDetails = $createdUserHospital->hospitalFee->where('invoice_type_id', 3)->first();

            $name = $request->name;

            $reportList = [];
            $total_cal = 0;
            $data = json_decode($name[0],true); # json string to Array
            
            // echo json_encode($data);
            for ($i=0; $i < count($data) ; $i++) { 
            if(!($data[$i] === [])){
                $reportList[] = (object)[
                    'name' => $data[$i]['name'],
                    'quantity' => $data[$i]['quantity'],
                    'price' =>  $data[$i]['price'],
                ];
                $total_cal = $total_cal + $data[$i]['price'];
            }
            }


            $invoicePharmacy = new InvoicePharmacy;
            $invoicePharmacy->patient_id = 1;
            $invoicePharmacy->hospital_fee = 0;
            $invoicePharmacy->vat = 0;
            $invoiceTotal = $request -> total;
            $invoicePharmacy->total = $total_cal;
            $invoicePharmacy->printed_at = Carbon::now()->toDateTimeString();
            $invoicePharmacy->issued_at = Carbon::now()->toDateTimeString();
            $invoicePharmacy->hospital_id = $createdUserHospital->id;
            $invoicePharmacy->created_user_id = $createdUser->id;
            // $invoicePharmacy->pharmacy_fee = 0;
            $invoicePharmacy->save();

            $invoiceStorePath = $this->generatePdf($invoicePharmacy, $createdUserHospital, $reportList);

            // save invoice pdf file path
            $invoicePharmacy->pdfFile()->create([
                'path' => $invoiceStorePath,
            ]);

            // Transaction
            $transaction = new Transaction;
            $transaction->patient_id = "1";
            $transaction->note = $request->note;
            $transaction->type = $request->payment_method;
            $transaction->credit = $invoiceTotal;
            $transaction->debit = 0;
            $invoicePharmacy->transaction()->save($transaction);

            return compact('invoiceStorePath');
        });
        
        // return [
        //     'success' => true,
        // ];

        return [
            'success' => true,
            // 'next' => route('invoice'),
            'msg' => 'Transaction successful',
            'data' => [
                'invoice_pdf_url' => $returnedValues['invoiceStorePath'],
            ],
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice\InvoicePharmacy  $invoicePharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePharmacy $invoicePharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice\InvoicePharmacy  $invoicePharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicePharmacy $invoicePharmacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice\InvoicePharmacy  $invoicePharmacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePharmacy $invoicePharmacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice\InvoicePharmacy  $invoicePharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePharmacy $invoicePharmacy)
    {
        //
    }

    private function generatePdf($invoice, $hospital, $reportList)
    {
        $pdfName = $invoice->id;
        $date = Carbon::now()->toDateString();
        $filePath = "invoice-pdfs/{$date}/pharmacy/{$pdfName}.pdf";

        $pdf = PDF::loadView('invoices.pdf.pharmacy', [
            'invoice' => $invoice,
            'hospital' => $hospital,
            'reports' => $reportList,
        ])->setPaper('a6', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        return Storage::disk('public')->url($filePath);

    }
}
