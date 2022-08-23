<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Invoice\InvoiceChanneling;
use App\Doctor;
use App\Patient;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PDF;
use Illuminate\Support\Facades\Storage;

class InvoiceChannelingController extends Controller
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
            'session' => 'required|exists:channeling_sessions,id',
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
            $invoiceTypeDetails = $createdUserHospital->hospitalFee->where('invoice_type_id', 2)->first();

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

            // get new token
            $lastToken = 0;
            $lastChandelling = InvoiceChanneling::where('hospital_id', $createdUserHospital->id)
            ->where('channeling_session_id', $request->session)
            ->whereDate('issued_at', Carbon::now())
            ->orderBy('id', 'desc')
            ->first();

            if ($lastChandelling) {
                $lastToken = $lastChandelling->token;
            }

            $token = ++$lastToken;

            $doctor = Doctor::findOrFail($request->doctor);

            // Invoice
            $invoiceChanneling = new InvoiceChanneling;
            $invoiceChanneling->patient_id = $patient->id;
            $invoiceChanneling->doctor_id = $request->doctor;
            $invoiceChanneling->channeling_session_id = $request->session;
            $invoiceChanneling->printed_at = Carbon::now()->toDateTimeString();
            $invoiceChanneling->issued_at = Carbon::now()->toDateTimeString();
            $invoiceChanneling->hospital_id = $createdUserHospital->id;
            $invoiceChanneling->created_user_id = $createdUser->id;
            $invoiceChanneling->doctor_fee = $doctor->fee;
            $invoiceChanneling->hospital_fee = $invoiceTypeDetails->fee;
            $invoiceChanneling->vat = 0;
            $invoiceTotal = floatval($invoiceChanneling->doctor_fee + $invoiceChanneling->hospital_fee + $invoiceChanneling->vat);
            $invoiceChanneling->total = $invoiceTotal;            
            $invoiceChanneling->token = $token;
            $invoiceChanneling->save();

            $invoiceStorePath = $this->generatePdf($invoiceChanneling, $invoiceChanneling->channelingSession, $patient, $createdUserHospital);

            // save invoice pdf file path
            $invoiceChanneling->pdfFile()->create([
                'path' => $invoiceStorePath,
            ]);

            // Transaction
            $transaction = new Transaction;
            $transaction->patient_id = $patient->id;
            $transaction->note = $request->note;
            $transaction->type = $request->payment_method;
            $transaction->credit = $invoiceTotal;
            $transaction->debit = 0;
            $invoiceChanneling->transaction()->save($transaction);

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

    private function generatePdf($invoice, $session, $patient, $hospital)
    {
        $pdfName = $invoice->id;
        $date = Carbon::now()->toDateString();
        $filePath = "invoice-pdfs/{$date}/channeling/{$pdfName}.pdf";

        $pdf = PDF::loadView('invoices.pdf.channeling', [
            'invoice' => $invoice,
            'session' => $session,
            'patient' => $patient,
            'hospital' => $hospital,
        ])->setPaper('a6', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        return Storage::disk('public')->url($filePath);
    }
}
