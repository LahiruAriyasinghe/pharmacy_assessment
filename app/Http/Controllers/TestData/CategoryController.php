<?php

namespace App\Http\Controllers\TestData;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestDataCategory as TestDataCategoryResource;
use App\Http\Resources\TestDataCategoryCollection;
use App\TestDataCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
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
        Gate::authorize('view test data category', Auth::user());

        return view('test-data.categories.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create test data category', Auth::user());

        return view('test-data.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create test data category', Auth::user());

        $request->validate([
            'name' => 'string|max:255',
        ]);

        $createdUser = Auth::user();

        $category = new TestDataCategory;
        $category->name = $request->name;
        $category->created_user_id = $createdUser->id;
        $category->hospital_id = $createdUser->hospital->id;
        $category->save();

        return [
            'success' => true,
            'next' => route('test-data.categories.index'),
            'msg' => 'New test data category successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TestDataCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(TestDataCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TestDataCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(TestDataCategory $category)
    {
        Gate::authorize('edit test data category', Auth::user());

        return view('test-data.categories.edit')
            ->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TestDataCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestDataCategory $category)
    {
        Gate::authorize('edit test data category', Auth::user());

        $request->validate([
            'name' => 'string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return [
            'success' => true,
            'next' => route('test-data.categories.index'),
            'msg' => $request->name . ' Test data category successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TestDataCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestDataCategory $category)
    {
        Gate::authorize('delete test data category', Auth::user());

        $category->delete();

        return [
            'success' => true,
            'msg' => 'Test data category successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $testDataCategories = TestDataCategory::where('hospital_id', Auth::user()->hospital->id)->get();

        return new TestDataCategoryCollection($testDataCategories);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(TestDataCategory $category)
    {
        return new TestDataCategoryResource($category);
    }
}
