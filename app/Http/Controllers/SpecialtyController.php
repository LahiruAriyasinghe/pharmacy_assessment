<?php

namespace App\Http\Controllers;

use App\Http\Resources\Specialty as SpecialtyResource;
use App\Http\Resources\SpecialtyCollection;
use App\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SpecialtyController extends Controller
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
        Gate::authorize('view doctor', Auth::user());

        return view('specialties.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create doctor', Auth::user());

        return view('specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create doctor', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;

        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|unique:specialties,acronym,' . $createdUser->hospital->id . '|max:255',
            'acronym' => [
                'required',
                'string',
                Rule::unique('specialties')->where(function ($query) use ($request, $createdUserHospital) {
                    return $query->where('acronym', $request->acronym)
                        ->where('hospital_id', $createdUserHospital->id);
                }),
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $specialty = new Specialty;
        $specialty->name = $request->name;
        $specialty->acronym = $request->acronym;
        $specialty->description = $request->description;
        $specialty->created_user_id = $createdUser->id;
        $specialty->hospital_id = $createdUser->hospital->id;
        $specialty->save();

        return [
            'success' => true,
            'next' => route('specialties.index'),
            'msg' => 'New specialty successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function show(Specialty $specialty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialty $specialty)
    {
        Gate::authorize('edit doctor', Auth::user());

        return view('specialties.edit')
            ->with('specialty', $specialty);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialty $specialty)
    {
        Gate::authorize('edit doctor', Auth::user());

        $createdUser = Auth::user();
        $createdUserHospital = $createdUser->hospital;

        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties')->where(function ($query) use ($request, $createdUserHospital) {
                    return $query->where('acronym', $request->acronym)
                        ->where('hospital_id', $createdUserHospital->id);
                })->ignore($specialty->id),
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $specialty->name = $request->name;
        $specialty->acronym = $request->acronym;
        $specialty->description = $request->description;

        $specialty->save();

        return [
            'success' => true,
            'next' => route('specialties.index'),
            'msg' => $request->name . ' speciality successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty)
    {
        Gate::authorize('delete doctor', Auth::user());

        $userCount = $specialty->doctors->count();
        if ($userCount > 0) {
            // this specialty has doctors
            // please remove or update doctors
            return [
                'error' => true,
                'msg' => "{$specialty->name} specialty has {$userCount} doctor(s). Please update their specialty before remove this specialty.",
            ];
        }

        $specialty->forceDelete();

        return [
            'success' => true,
            'msg' => 'Specialty successfully deleted!',
        ];
    }

    /**
     * return all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $specialties = Specialty::where('hospital_id', Auth::user()->hospital->id)->get();
        return new SpecialtyCollection($specialties);
    }

    /**
     *  return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(Specialty $specialty)
    {
        return new SpecialtyResource($specialty);
    }
}
