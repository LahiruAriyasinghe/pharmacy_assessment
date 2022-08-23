<?php

namespace App\Http\Controllers\Invoice;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Invoice\InvoiceOpd;
use App\Patient;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Storage;

class InvoiceOpdController extends Controller
{
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
            'patient_id' => 'nullable|exists:patients,id',
            'doctor' => 'required|exists:doctors,id',
            'drug_fee' => 'nullable|numeric|min:0',
            'title' => 'required|in:Mr,Miss,Mrs,Dr',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'contact' => 'required',
            'age' => 'required|numeric|min:1|max:150',
            'gender' => 'required|in:M,F,O',
            'payment_method' => 'required|in:card,cash',
            'note' => 'nullable',
        ]);

        $returnedValues = DB::transaction(function () use ($request) {

            $createdUser = Auth::user();
            $createdUserHospital = $createdUser->hospital;
            $invoiceTypeDetails = $createdUserHospital->hospitalFee->where('invoice_type_id', 1)->first();

            if (is_null($request->patient_id)) {
                $patient = new Patient;
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->last_name = $request->last_name;
                $patient->contact = $request->contact;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $patient->created_user_id = $createdUser->id;
                $patient->hospital_id = $createdUser->hospital->id;
                $patient->save();
            } else {
                $patient = Patient::find($request->patient_id);
            }       

            $doctor = Doctor::findOrFail($request->doctor);

            // Invoice
            $invoiceOpd = new InvoiceOpd;
            $invoiceOpd->patient_id = $patient->id;
            $invoiceOpd->doctor_id = $request->doctor;
            $invoiceOpd->printed_at = Carbon::now()->toDateTimeString();
            $invoiceOpd->issued_at = Carbon::now()->toDateTimeString();
            $invoiceOpd->hospital_id = $createdUserHospital->id;
            $invoiceOpd->created_user_id = $createdUser->id;
            $invoiceOpd->drug_fee = $request->drug_fee > 0 ? $request->drug_fee : 0 ;
            $invoiceOpd->doctor_fee = $doctor->fee;
            $invoiceOpd->hospital_fee = $invoiceTypeDetails->fee;
            $invoiceOpd->vat = 0;
            $invoiceTotal = floatval($invoiceOpd->doctor_fee + $invoiceOpd->hospital_fee + $invoiceOpd->drug_fee + $invoiceOpd->vat);
            $invoiceOpd->total = $invoiceTotal;
            $token = 0; //HACK: fot MVP release
            $invoiceOpd->token = $token;
            $invoiceOpd->save();

            $invoiceStorePath = $this->generatePdf($invoiceOpd, $patient, $createdUserHospital, $doctor);
             
            // save invoice pdf file path
            $invoiceOpd->pdfFile()->create([
                'path' => $invoiceStorePath,
            ]);

            // Transaction
            $transaction = new Transaction;
            $transaction->patient_id = $patient->id;
            $transaction->note = $request->note;
            $transaction->type = $request->payment_method;
            $transaction->credit = $invoiceTotal;
            $transaction->debit = 0;
            $invoiceOpd->transaction()->save($transaction);

            return compact('invoiceStorePath', 'token');
        });

        return [
            'success' => true,
            'next' => route('invoice'),
            'msg' => 'Transaction successful',
            'data' => [
                'invoice_pdf_url' => $returnedValues['invoiceStorePath'],
                'token' => $returnedValues['token'],
            ],
        ];
    }

    private function generatePdf($invoice, $patient, $hospital, $doctor)
    {
        $pdfName = $invoice->id;
        $date = Carbon::now()->toDateString();
        $filePath = "invoice-pdfs/{$date}/opd/{$pdfName}.pdf";

        $pdf = PDF::loadView('invoices.pdf.opd', [
            'invoice' => $invoice,
            'patient' => $patient,
            'hospital' => $hospital,
            'doctor' => $doctor,
        ])->setPaper('a6', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        return Storage::disk('public')->url($filePath);
    }
}
