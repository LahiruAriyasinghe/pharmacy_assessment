<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Auth::user()->hospital->patients;
        return view('patients.list', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create patient', Auth::user());
        $hospital = Auth::user()->hospital;
        return view('patients.create', [
            'hospital' => $hospital,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create patient', Auth::user());

        $attributes = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'contact' => 'required',
            'gender' => 'required|in:M,F,O',
            'age' => 'required|numeric|min:1|max:150',
            'birthday' => 'nullable',
        ]);

        $createdUser = Auth::user();

        // check patient already exists for the hospital
        $patient = Patient::where('contact', '=', $request->contact)->first();
        if ($patient !== null) {
            // patient already exists
            return [
                'success' => true,
                'next' => null,
                'msg' => 'Patient already exists!',
                'data' => [
                    'patient_id' => $patient->id,
                ],
            ];
        }

        // patient doesn't exists
        $attributes['created_user_id'] = $createdUser->id;
        $attributes['hospital_id'] = $createdUser->hospital->id;
        $patient = Patient::create($attributes->all());

        return [
            'success' => true,
            'next' => null,
            'msg' => 'New patient successfully created!',
            'data' => [
                'patient_id' => $patient->id,
            ],
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        Gate::authorize('create invoice', Auth::user());

        return [
            'success' => true,
            'msg' => null,
            'data' => [
                'patient' => $patient,
            ],
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        Gate::authorize('edit patient', Auth::user());

        return [
            'success' => true,
            'next' => 'patients.edit',
            'msg' => null,
            'data' => [
                'patient' => $patient,
            ],
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        Gate::authorize('edit patient', Auth::user());

        $attributes = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'birthday' => 'nullable',
            'email' => 'nullable|email:rfc,dns,filter',
        ]);

        $patient->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact' => $request->contact,
            'gender' => $request->gender,
            'age' => $request->age,
            'birthday' => $request->birthday,
            'email' => $request->email,
        ]);

        return [
            'success' => true,
            'next' => route('patients.list'),
            'msg' => 'patient successfully updated!',
        ];

    }

    public function destroy(Patient $patient)
    {
        Gate::authorize('delete patient', Auth::user());

        $patient->delete();
        return [
            'success' => true,
            'next' => route('patients.list'),
            'msg' => 'patient successfully deleted!',
        ];
    }
}
