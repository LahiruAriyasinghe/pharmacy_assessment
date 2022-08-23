<?php

namespace App\Http\Controllers\TestData;

use App\Http\Controllers\Controller;
use App\Http\Resources\Unit as UnitResource;
use App\Http\Resources\UnitCollection;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
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
        Gate::authorize('view unit', Auth::user());

        return view('test-data.units.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create unit', Auth::user());

        return view('test-data.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create unit', Auth::user());

        $request->validate([
            'name' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $createdUser = Auth::user();

        $unit = new Unit;
        $unit->name = $request->name;
        $unit->unit = $request->unit;
        $unit->created_user_id = $createdUser->id;
        $unit->hospital_id = $createdUser->hospital->id;
        $unit->save();

        return [
            'success' => true,
            'next' => route('units.index'),
            'msg' => 'New unit successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        Gate::authorize('edit unit', Auth::user());

        return view('test-data.units.edit')
            ->with('unit', $unit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        Gate::authorize('edit unit', Auth::user());

        $request->validate([
            'name' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $unit->name = $request->name;
        $unit->unit = $request->unit;
        $unit->save();

        return [
            'success' => true,
            'next' => route('units.index'),
            'msg' => $request->name . ' unit successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        Gate::authorize('delete unit', Auth::user());

        $unit->delete();

        return [
            'success' => true,
            'msg' => 'Unit successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $units = Unit::where('hospital_id', Auth::user()->hospital->id)->get();
        return new UnitCollection($units);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(Unit $unit)
    {
        return new UnitResource($unit);
    }
}
