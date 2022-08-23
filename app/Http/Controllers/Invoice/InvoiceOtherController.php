<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Invoice\InvoiceOther;
use App\OtherService;
use App\Patient;
use App\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Storage;

class InvoiceOtherController extends Controller
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
            'services' => 'required|array',
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
            $invoiceTypeDetails = $createdUserHospital->hospitalFee->where('invoice_type_id', 4)->first();

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

            try {
                $lastToken = (int) InvoiceOther::orderBy('id', 'desc')->firstOrFail()->token;
            } catch (ModelNotFoundException $e) {
                $lastToken = 0;
            }

            $otherServices = OtherService::whereIn('id', $request->services)->get();
            $otherServiceFee = $otherServices->sum('fee');

            // Invoice
            $invoiceOther = new InvoiceOther;
            $invoiceOther->patient_id = $patient->id;
            $invoiceOther->printed_at = Carbon::now()->toDateTimeString();
            $invoiceOther->issued_at = Carbon::now()->toDateTimeString();
            $invoiceOther->hospital_id = $createdUserHospital->id;
            $invoiceOther->created_user_id = $createdUser->id;
            $invoiceOther->service_fee = $otherServiceFee;
            $invoiceOther->hospital_fee = $invoiceTypeDetails->fee;
            $invoiceOther->vat = 0;
            $invoiceTotal = floatval($invoiceOther->hospital_fee + $invoiceOther->vat + $otherServiceFee);
            $invoiceOther->total = $invoiceTotal;
            $token = ++$lastToken;
            $invoiceOther->token = $token;
            $invoiceOther->save();

            foreach ($otherServices as $service) {
                $invoiceOther->otherServices()->attach($service->id, ['fee' => $service->fee]);
            }

            $invoiceStorePath = $this->generatePdf($invoiceOther, $patient, $createdUserHospital, $otherServices);

            // save invoice pdf file path
            $invoiceOther->pdfFile()->create([
                'path' => $invoiceStorePath,
            ]);

            // Transaction
            $transaction = new Transaction;
            $transaction->patient_id = $patient->id;
            $transaction->note = $request->note;
            $transaction->type = $request->payment_method;
            $transaction->credit = $invoiceTotal;
            $transaction->debit = 0;
            $invoiceOther->transaction()->save($transaction);

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

    private function generatePdf($invoice, $patient, $hospital, $services)
    {
        $pdfName = $invoice->id;
        $date = Carbon::now()->toDateString();
        $filePath = "invoice-pdfs/{$date}/other/{$pdfName}.pdf";

        $pdf = PDF::loadView('invoices.pdf.other', [
            'invoice' => $invoice,
            'patient' => $patient,
            'hospital' => $hospital,
            'services' => $services,
        ])->setPaper('a6', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        return Storage::disk('public')->url($filePath);
    }
}
