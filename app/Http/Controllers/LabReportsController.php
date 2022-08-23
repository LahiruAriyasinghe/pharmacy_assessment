<?php

namespace App\Http\Controllers;

use App\Http\Resources\LabReport as LabReportResource;
use App\Http\Resources\LabReportCollection;
use App\LabReport;
use App\LabReportCategory;
use App\TestData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class LabReportsController extends Controller
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

        $hospital = Auth::user()->hospital;

        $testDatas = TestData::where('hospital_id', $hospital->id)->get();
        $labReportCategories = LabReportCategory::where('hospital_id', $hospital->id)->get();
        $labReports = LabReport::where('hospital_id', $hospital->id)->get();

        return view('labReports.list')
            ->with('hospital', $hospital)
            ->with('labReportCategories', $labReportCategories)
            ->with('labReports', $labReports)
            ->with('testDatas', $testDatas);
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
        Gate::authorize('create lab report', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;

        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lab_reports')->where(function ($query) use ($request, $createdUserHospital) {
                    return $query->where('acronym', $request->acronym)
                        ->where('hospital_id', $createdUserHospital->id);
                }),
            ],
            'fee' => 'required|between:0,99999999.99',
            'reference_report' => 'nullable|exists:lab_reports,id',
            'test_datas' => 'required|array',
            'lab_report_categories_id' => 'required|exists:lab_report_categories,id',
        ]);

        $returnedValues = DB::transaction(function () use ($request) {

            $createdUser = Auth::user();
            $createdUserHospital = $createdUser->hospital;

            $labReport = new LabReport;
            $labReport->name = $request->name;
            $labReport->acronym = $request->acronym;
            $labReport->fee = $request->fee;
            $labReport->reference_report = $request->reference_report;
            $labReport->lab_report_categories_id = $request->lab_report_categories_id;
            $labReport->hospital_id = $request->user()->hospital->id;
            $labReport->created_user_id = $request->user()->id;
            $labReport->save();

            foreach ($request->test_datas as $test_data) {
                $labReport->testData()->create([
                    'test_datas_id' => $test_data,
                    'hospital_id' => $createdUserHospital->id,
                    'created_user_id' => $createdUser->id,
                ]);
            }

            return compact('labReport');
        });

        return [
            'success' => true,
            'next' => route('lab-reports.index'),
            'msg' => 'New lab report successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function show(LabReport $labReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function edit(LabReport $labReport)
    {
        Gate::authorize('edit lab report', Auth::user());

        $hospital = Auth::user()->hospital;
        $testDatas = TestData::where('hospital_id', $hospital->id)->get();
        $selectedTestDatas = $labReport->testData()->pluck('test_datas_id')->toArray();
        $labReportCategories = LabReportCategory::where('hospital_id', $hospital->id)->get();
        $labReports = LabReport::where('hospital_id', $hospital->id)->get();

        return view('labReports.edit')
            ->with('report', $labReport)
            ->with('labReportCategories', $labReportCategories)
            ->with('selectedTestDatas', $selectedTestDatas)
            ->with('labReports', $labReports)
            ->with('testDatas', $testDatas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabReport $labReport)
    {
        Gate::authorize('edit lab report', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;

        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lab_reports')->where(function ($query) use ($request, $createdUserHospital) {
                    return $query->where('acronym', $request->acronym)
                        ->where('hospital_id', $createdUserHospital->id);
                })->ignore($labReport->id),
            ],
            'fee' => 'required|between:0,99999999.99',
            'reference_report' => 'nullable|exists:lab_reports,id',
            'test_datas' => 'required|array',
            'lab_report_categories_id' => 'required|exists:lab_report_categories,id',
        ]);

        $returnedValues = DB::transaction(function () use ($labReport, $request, $createdUser, $createdUserHospital) {

            $labReport->name = $request->name;
            $labReport->acronym = $request->acronym;
            $labReport->fee = $request->fee;
            $labReport->reference_report = $request->reference_report;
            $labReport->lab_report_categories_id = $request->lab_report_categories_id;
            $labReport->hospital_id = $request->user()->hospital->id;
            $labReport->created_user_id = $request->user()->id;
            $labReport->save();

            $labReport->testData()->delete();

            foreach ($request->test_datas as $test_data) {
                $labReport->testData()->create([
                    'test_datas_id' => $test_data,
                    'hospital_id' => $createdUserHospital->id,
                    'created_user_id' => $createdUser->id,
                ]);
            }
        });

        return [
            'success' => true,
            'next' => route('lab-reports.index'),
            'msg' => $request->name . ' report successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabReport $labReport)
    {
        Gate::authorize('delete lab report', Auth::user());

        $labReport->delete();

        return [
            'success' => true,
            'next' => route('lab-reports.index'),
            'msg' => 'Report successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $hospital = Auth::user()->hospital;
        $report = LabReport::where('hospital_id', $hospital->id)->get();

        return new LabReportCollection($report);
    }

    /**
     *  return the specified resource.
     *
     * @param  \App\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(LabReport $labReport)
    {
        return new LabReportResource($labReport);
    }
}
