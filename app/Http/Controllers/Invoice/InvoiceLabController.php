<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Invoice\InvoiceLab;
use App\LabReport;
use App\Patient;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class InvoiceLabController extends Controller
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
            'reports' => 'required|array',
            'title' => 'required|in:Mr,Miss,Mrs,Dr',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'contact' => 'required',
            'age' => 'required|numeric|min:1|max:150',
            'gender' => 'required|in:M,F,O',
            'payment_method' => 'required|in:card,cash',
            'note' => 'nullable',
            'reference_report_check' => 'nullable',
        ]);

        $returnedValues = DB::transaction(function () use ($request) {
            $createdUser = Auth::user();
            $createdUserHospital = $createdUser->hospital;
            $invoiceTypeDetails = $createdUserHospital->hospitalFee->where('invoice_type_id', 3)->first();

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

            $labReports = LabReport::whereIn('id', $request->reports)->get();

            if ($request->has('reference_report_check') && $request->reference_report_check == '1') {
                $referenceLabReports = LabReport::whereIn('reference_report', $request->reports)->get();
                $labReports = $labReports->merge($referenceLabReports);
            }

            $labReportFee = $labReports->sum('fee');

            $invoiceLab = new InvoiceLab;
            $invoiceLab->patient_id = $patient->id;
            $invoiceLab->printed_at = Carbon::now()->toDateTimeString();
            $invoiceLab->issued_at = Carbon::now()->toDateTimeString();
            $invoiceLab->hospital_id = $createdUserHospital->id;
            $invoiceLab->created_user_id = $createdUser->id;
            $invoiceLab->hospital_fee = $invoiceTypeDetails->fee;
            $invoiceLab->vat = 0;
            $invoiceLab->lab_fee = $labReportFee;
            $invoiceTotal = floatval($invoiceLab->hospital_fee + $invoiceLab->vat + $labReportFee);
            $invoiceLab->total = $invoiceTotal;
            $invoiceLab->save();

            $reportList = [];

            foreach ($labReports as $report) {
                array_push($reportList, [
                    'lab_report_id' => $report->id,
                    'fee' => $report->fee,
                    'result' => $this->getLabReportResultJson($report),
                    'hospital_id' => $createdUserHospital->id,
                    'created_user_id' => $createdUser->id,
                ]);
            }

            $invoiceLab->labReports()->createMany($reportList);

            $invoiceStorePath = $this->generatePdf($invoiceLab, $patient, $createdUserHospital, $labReports);

            // save invoice pdf file path
            $invoiceLab->pdfFile()->create([
                'path' => $invoiceStorePath,
            ]);

            // Transaction
            $transaction = new Transaction;
            $transaction->patient_id = $patient->id;
            $transaction->note = $request->note;
            $transaction->type = $request->payment_method;
            $transaction->credit = $invoiceTotal;
            $transaction->debit = 0;
            $invoiceLab->transaction()->save($transaction);

            return compact('invoiceStorePath');
        });

        return [
            'success' => true,
            'next' => route('invoice'),
            'msg' => 'Transaction successful',
            'data' => [
                'invoice_pdf_url' => $returnedValues['invoiceStorePath'],
            ],
        ];
    }

    private function generatePdf($invoice, $patient, $hospital, $reports)
    {
        $pdfName = $invoice->id;
        $date = Carbon::now()->toDateString();
        $filePath = "invoice-pdfs/{$date}/lab/{$pdfName}.pdf";

        $pdf = PDF::loadView('invoices.pdf.lab', [
            'invoice' => $invoice,
            'patient' => $patient,
            'hospital' => $hospital,
            'reports' => $reports,
            'samples' => $invoice->labReports()->get(),
        ])->setPaper('a6', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        return Storage::disk('public')->url($filePath);
    }

    private function getLabReportResultJson($report)
    {
        $resultData = [];
        $testData = $report->testData;
        foreach ($testData as $data) {
            $reportTestData = $data->testData;
            Log::Info("reportTestData => ", $reportTestData->toArray());
            $singleData = [];
            $singleData['id'] = $reportTestData->id;
            $singleData['name'] = $reportTestData->name;
            $singleData['result'] = '';
            $singleData['unit_id'] = $reportTestData->unit_id;
            $singleData['unit'] = (isset($reportTestData->unit_id)) ? $reportTestData->unit->unit : '';
            $singleData['category_id'] = $reportTestData->test_data_category_id;
            $singleData['category'] = (isset($reportTestData->test_data_category_id)) ? $reportTestData->category->name : '';
            $singleData['result_category_id'] = $reportTestData->test_data_result_category_id;
            $singleData['result_category'] = $reportTestData->resultCategory->result_category;
            $resultData[] = $singleData;
        }

        $data = [
            'mlt' => '',
            'reference' => '',
            'note' => '',
            'data' => $resultData,
        ];

        return $data;
    }
}
