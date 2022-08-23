<?php

namespace App\Http\Controllers\TestData;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestDataResultCategory as TestDataResultCategoryResource;
use App\Http\Resources\TestDataResultCategoryCollection;
use App\TestDataResultCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ResultCategoryController extends Controller
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
        Gate::authorize('view result category', Auth::user());

        return view('test-data.result-categories.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create result category', Auth::user());

        return view('test-data.result-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create result category', Auth::user());

        $request->validate([
            'name' => 'nullable|string|max:255',
            'types' => 'required|string|max:1024',
        ]);

        $createdUser = Auth::user();

        $typesString = implode(",", array_unique(explode(',', preg_replace('/\s*,\s*/', ',', $request->types))));

        $resultCategory = new TestDataResultCategory;
        $resultCategory->result_category = $request->name;
        $resultCategory->result_category_types = $typesString;
        $resultCategory->created_user_id = $createdUser->id;
        $resultCategory->hospital_id = $createdUser->hospital->id;
        $resultCategory->save();

        return [
            'success' => true,
            'next' => route('test-data.result-categories.index'),
            'msg' => 'New result category successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TestDataResultCategory  $resultCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TestDataResultCategory $resultCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TestDataResultCategory  $resultCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TestDataResultCategory $resultCategory)
    {
        Gate::authorize('edit result category', Auth::user());

        return view('test-data.result-categories.edit')
            ->with('resultCategory', $resultCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TestDataResultCategory  $resultCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestDataResultCategory $resultCategory)
    {
        Gate::authorize('edit result category', Auth::user());

        $request->validate([
            'name' => 'nullable|string|max:255',
            'types' => 'required|string|max:1024',
        ]);

        if (!$resultCategory->is_editable) {
            return abort('403');
        }

        $typesString = implode(",", array_unique(explode(',', preg_replace('/\s*,\s*/', ',', $request->types))));

        $resultCategory->result_category = $request->name;
        $resultCategory->result_category_types = $typesString;
        $resultCategory->save();

        return [
            'success' => true,
            'next' => route('test-data.result-categories.index'),
            'msg' => $request->name . ' result category successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TestDataResultCategory  $resultCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestDataResultCategory $resultCategory)
    {
        Gate::authorize('delete result category', Auth::user());

        $resultCategory->delete();

        return [
            'success' => true,
            'msg' => 'TestDataResultCategory successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $resultCategories = TestDataResultCategory::where([
            ['hospital_id', Auth::user()->hospital->id],
            ['is_editable', 1],
        ])->get();

        return new TestDataResultCategoryCollection($resultCategories);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(TestDataResultCategory $resultCategory)
    {
        return new TestDataResultCategoryResource($resultCategory);
    }
}
