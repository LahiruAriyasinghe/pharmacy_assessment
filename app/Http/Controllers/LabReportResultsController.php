<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabReportResultRequest;
use App\Http\Resources\LabReportResult as LabReportResultResource;
use App\Http\Resources\LabReportResultCollection;
use App\Invoice\InvoiceLabReport;
use App\LabReport;
use App\TestDataRanges;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class LabReportResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view lab report', Auth::user());

        return view('labReports.results.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceLabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceLabReport $result)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceLabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceLabReport $result)
    {
        Gate::authorize('edit lab report', Auth::user());

        return view('labReports.results.edit')
            ->with('result', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceLabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function update(LabReportResultRequest $request, InvoiceLabReport $result)
    {
        Gate::authorize('edit lab report', Auth::user());

        $user = Auth::user();

        $returnedValues = DB::transaction(function () use ($request, $result) {
            $result->result = $this->getLabReportResultJson($request, $result);
            $result->updated_user_id = Auth::id();
            $result->status = $request->is_complete === 'true' ? 2 : 1;

            // if your is a MLT
            // then save user info in approved_user column
            // take this feeding as a approval
            if (Auth::user()->mlt) {
                $result->approved_user_id = Auth::id();
                $result->approved_at = Carbon::now();
            }

            $result->save();
        });

        return [
            'success' => true,
            'next' => route('lab-reports.results.index'),
            'msg' => 'result successfully updated!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex(Request $request)
    {
        $status = $request->query('status', 'incomplete');

        $hospital = Auth::user()->hospital;
        $labReports = InvoiceLabReport::with('labReport')->where([
            ['hospital_id', $hospital->id],
            ['status', '=', $this->getReportStatus($status)],
        ])->get();

        return new LabReportResultCollection($labReports);
    }

    /**
     *  return the specified resource.
     *
     * @param  \App\InvoiceLabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(InvoiceLabReport $result)
    {
        return new LabReportResultResource($result);
    }

    private function getLabReportResultJson($request, $currentResult)
    {
        $currentResultData = $currentResult->result->data;

        $patient = $currentResult->labInvoice->patient;

        foreach ($request->get('test_datas') as $newKey => $newResultValue) {
            foreach ($currentResultData as $currentKey => $currentDataValue) {
                if ($newKey == $currentDataValue->id) {
                    $currentResultData[$currentKey]->result = $newResultValue;

                    if ($currentDataValue->result_category === 'Numerical') {
                        // calculate ref ranges
                        $rangeData = TestDataRanges::getTestDataRangeCondition($patient, $currentDataValue, $newResultValue);
                        $preferredRangeData = TestDataRanges::getPreferredRange($patient, $currentDataValue);

                        if (!is_null($rangeData) && !is_null($preferredRangeData)) {
                            $currentResultData[$currentKey]->ranges = [
                                "range_min" => (float) $preferredRangeData->range_min,
                                "range_max" => (float) $preferredRangeData->range_max,
                                "condition" => $rangeData->condition,
                            ];
                            // Log::Info("rangeData ", $rangeData->toArray());
                        } else {
                            unset($currentResultData[$currentKey]->ranges);
                        }
                    }
                }
            }
        }

        $mlt = null;

        // if your is a MLT
        // then save user info in approved_user column
        // take this feeding as a approval
        if (Auth::user()->mlt) {
            $mlt = Auth::user()->full_name;
        }

        return [
            'mlt' => $mlt,
            'reference' => '',
            'note' => $request->note,
            'data' => $currentResultData,
        ];
    }

    /**
     * Print patient lab report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function print(Request $request, InvoiceLabReport $result) {
        Gate::authorize('print patient lab report', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;
        $invoiceLab = $result->labInvoice;
        $patient = $invoiceLab->patient;

        $reportGeneratedPath = $this->generatePdf($createdUserHospital, $result);

        return [
            'success' => true,
            'next' => null,
            'msg' => 'Report Generated successfully',
            'data' => [
                'report_url' => $reportGeneratedPath,
            ],
        ];
    }

    private function generatePdf($hospital, $result)
    {
        $pdfName = "{$result->invoice_lab_id}-{$result->id}";
        $date = Carbon::now()->toDateString();
        $filePath = "lab-results-pdfs/{$date}/{$pdfName}.pdf";

        $invoiceLab = $result->labInvoice;
        $labReport = $result->labReport;
        $patient = $invoiceLab->patient;

        // HACK : avoid memory limit exhausted issue
        ini_set('memory_limit', '64M');

        $pdf = PDF::loadView('reports.pdf.lab-test', [
            'hospital' => $hospital,
            'result' => $result,
            'invoice' => $invoiceLab,
            'labReport' => $labReport,
            'patient' => $patient,
            'reportCategory' => $labReport->category->name,
        ])->setPaper('a4', 'portrait');

        Storage::disk('public')->put($filePath, $pdf->output());

        ini_set('memory_limit', '32M');

        return Storage::disk('public')->url($filePath);
    }

    private function getReportStatus($status)
    {
        if ($status === 'completed') {
            return 2;
        }
        return 1;
    }
}
