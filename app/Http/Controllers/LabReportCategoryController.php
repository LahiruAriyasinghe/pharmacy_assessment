<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\LabReportCategory as LabReportCategoryResource;
use App\Http\Resources\LabReportCategoryCollection;
use App\LabReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;

class LabReportCategoryController extends Controller
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
        // Gate::authorize('view test data categories', Auth::user());

        return view('labReports.categories.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('create test data categories', Auth::user());

        return view('labReports.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Gate::authorize('create test data categories', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $createdUser = Auth::user();

        $category = new LabReportCategory;
        $category->name = $request->name;
        $category->created_user_id = $createdUser->id;
        $category->hospital_id = $createdUser->hospital->id;
        $category->save();

        return [
            'success' => true,
            'next' => route('lab-reports.categories.index'),
            'msg' => 'New test data categories successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LabReportCategory  $testDataCategory
     * @return \Illuminate\Http\Response
     */
    public function show(LabReportCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LabReportCategory  $testDataCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(LabReportCategory $category)
    {
        // Gate::authorize('edit test data categories', Auth::user());

        return view('labReports.categories.edit')
            ->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LabReportCategory  $testDataCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabReportCategory $category)
    {
        // Gate::authorize('edit test data categories', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return [
            'success' => true,
            'next' => route('lab-reports.categories.index'),
            'msg' => $request->name . 'Lab report category successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LabReportCategory  $testDataCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabReportCategory $category)
    {
        // Gate::authorize('delete test data categories', Auth::user());

        $category->delete();

        return [
            'success' => true,
            'msg' => 'Lab report category successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $categories = LabReportCategory::where('hospital_id', Auth::user()->hospital->id)->get();

        return new LabReportCategoryCollection($categories);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(LabReportCategory $category)
    {
        return new LabReportCategoryResource($category);
    }
}
