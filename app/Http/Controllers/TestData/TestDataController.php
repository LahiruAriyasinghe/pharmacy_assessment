<?php

namespace App\Http\Controllers\TestData;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestData as TestDataResource;
use App\Http\Resources\TestDataCollection;
use App\TestData;
use App\TestDataCategory;
use App\TestDataResultCategory;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TestDataController extends Controller
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
        Gate::authorize('view test data', Auth::user());
        $hospital = Auth::user()->hospital;
        $units = Unit::where('hospital_id', $hospital->id)->get();
        $resultCategories = TestDataResultCategory::where('hospital_id', $hospital->id)->get();
        $categories = TestDataCategory::where('hospital_id', $hospital->id)->get();

        return view('test-data.list')
            ->with('units', $units)
            ->with('resultCategories', $resultCategories)
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create test data', Auth::user());

        $hospital = Auth::user()->hospital;
        $units = Unit::where('hospital_id', $hospital->id)->get();
        $resultCategories = TestDataResultCategory::where('hospital_id', $hospital->id)->get();
        $categories = TestDataCategory::where('hospital_id', $hospital->id)->get();

        return view('test-data.create')
            ->with('units', $units)
            ->with('resultCategories', $resultCategories)
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create test data', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'test_data_category_id' => 'nullable|exists:test_data_categories,id',
            'test_data_result_category_id' => 'exists:test_data_result_categories,id',
            'ranges' => 'nullable|array',
        ]);

        if ($request->ranges) {
            $request->validate([
                'ranges.*.gender' => 'required',
                'ranges.*.age_min' => 'required',
                'ranges.*.age_max' => 'required',
                'ranges.*.range_min' => 'required',
                'ranges.*.range_max' => 'required',
                'ranges.*.condition' => 'required',
            ]);
        }

        DB::transaction(function () use ($request) {

            $createdUser = Auth::user();

            $testData = new TestData;
            $testData->name = $request->name;
            $testData->description = $request->description;
            $testData->unit_id = $request->unit_id;
            $testData->test_data_category_id = $request->test_data_category_id;
            $testData->test_data_result_category_id = $request->test_data_result_category_id;
            $testData->created_user_id = $createdUser->id;
            $testData->hospital_id = $createdUser->hospital->id;
            $testData->save();

            if ($request->ranges) {
                foreach ($request->ranges as $range) {
                    $testData->ranges()->create([
                        'gender' => $range['gender'],
                        'age_min' => $range['age_min'],
                        'age_max' => $range['age_max'],
                        'range_min' => $range['range_min'],
                        'range_max' => $range['range_max'],
                        'condition' => $range['condition'],
                    ]);
                }
            }
        });

        return [
            'success' => true,
            'next' => route('test-datas.index'),
            'msg' => 'New test data successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TestData  $testData
     * @return \Illuminate\Http\Response
     */
    public function show(TestData $testData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TestData  $testData
     * @return \Illuminate\Http\Response
     */
    public function edit(TestData $testData)
    {
        Gate::authorize('edit test data', Auth::user());

        $hospital = Auth::user()->hospital;
        $units = Unit::where('hospital_id', $hospital->id)->get();
        $resultCategories = TestDataResultCategory::where('hospital_id', $hospital->id)->get();
        $categories = TestDataCategory::where('hospital_id', $hospital->id)->get();

        return view('test-data.edit')
            ->with('testData', $testData)
            ->with('units', $units)
            ->with('resultCategories', $resultCategories)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TestData  $testData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestData $testData)
    {
        Gate::authorize('edit test data', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'test_data_category_id' => 'nullable|exists:test_data_categories,id',
            'test_data_result_category_id' => 'exists:test_data_result_categories,id',
            'ranges' => 'nullable|array',
        ]);

        if ($request->ranges) {
            $request->validate([
                'ranges.*.gender' => 'required',
                'ranges.*.age_min' => 'required',
                'ranges.*.age_max' => 'required',
                'ranges.*.range_min' => 'required',
                'ranges.*.range_max' => 'required',
                'ranges.*.condition' => 'required',
            ]);
        }

        DB::transaction(function () use ($request, $testData) {

            $testData->name = $request->name;
            $testData->description = $request->description;
            $testData->unit_id = $request->unit_id;
            $testData->test_data_category_id = $request->test_data_category_id;
            $testData->test_data_result_category_id = $request->test_data_result_category_id;
            $testData->save();

            if ($request->ranges) {
                $testData->ranges()->delete();

                foreach ($request->ranges as $range) {
                    $testData->ranges()->create([
                        'gender' => $range['gender'],
                        'age_min' => $range['age_min'],
                        'age_max' => $range['age_max'],
                        'range_min' => $range['range_min'],
                        'range_max' => $range['range_max'],
                        'condition' => $range['condition'],
                    ]);
                }
            }
        });

        return [
            'success' => true,
            'next' => route('test-datas.index'),
            'msg' => $request->name . 'test data successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TestData  $testData
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestData $testData)
    {
        Gate::authorize('delete test data', Auth::user());

        $testData->delete();

        return [
            'success' => true,
            'msg' => 'Test data successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $testDatas = TestData::where('hospital_id', Auth::user()->hospital->id)->get();
        return new TestDataCollection($testDatas);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(TestData $testData)
    {
        return new TestDataResource($testData);
    }
}
