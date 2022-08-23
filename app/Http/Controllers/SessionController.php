<?php

namespace App\Http\Controllers;

use App\ChannelingSession;
use App\User;
use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChannelingSessionCollection;
use App\Http\Resources\ChannelingSession as ChannelingSessionResource;

class SessionController extends Controller
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
        Gate::authorize('view session', Auth::user());

        $hospital = Auth::user()->hospital;
        $users = User::where('nurse', 1)->where('hospital_id', $hospital->id)->get();
        $doctors = User::has('doctor')->with('doctor')->where('hospital_id', $hospital->id)->get();

        return view('sessions.list')
            ->with('hospital', $hospital)
            ->with('doctors', $doctors)
            ->with('users', $users);
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
        Gate::authorize('create session', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'room_no' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctors,id',
            'nurse_id' => 'nullable',
            'week_day' => 'required|string|max:255',
            'start_at' => 'required',
            'end_at' => 'required',
            'maximum_patients' => 'required|between:0,1000',
        ]);

        $session = new ChannelingSession;

        $session->name = $request->name;
        $session->room_no = $request->room_no;
        $session->doctor_id = $request->doctor_id;
        $session->nurse_id = $request->nurse_id;
        $session->week_day = $request->week_day;
        $session->start_at = $request->start_at;
        $session->end_at = $request->end_at;
        $session->maximum_patients = $request->maximum_patients;
        $session->hospital_id = $request->user()->hospital->id;
        $session->created_user_id = $request->user()->id;

        $session->save();

        return [
            'success' => true,
            'next' => route('sessions.index'),
            'msg' => 'New session successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChannelingSession  $channelingSession
     * @return \Illuminate\Http\Response
     */
    public function show(ChannelingSession $channelingSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChannelingSession  $channelingSession
     * @return \Illuminate\Http\Response
     */
    public function edit(ChannelingSession $session)
    {
        Gate::authorize('edit session', Auth::user());

        $hospital = Auth::user()->hospital;
        $users = User::where('nurse', 1)->where('hospital_id', $hospital->id)->get();
        $doctors = User::has('doctor')->with('doctor')->where('hospital_id', $hospital->id)->get();

        return view('sessions.edit')
        ->with('doctors', $doctors)
        ->with('users', $users)
            ->with('session', $session);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChannelingSession  $channelingSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChannelingSession $session)
    {
        Gate::authorize('edit session', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'room_no' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctors,id',
            'nurse_id' => 'nullable',
            'week_day' => 'required|string|max:255',
            'start_at' => 'required',
            'end_at' => 'required',
            'maximum_patients' => 'required|between:0,1000',
        ]);

        $session->name = $request->name;
        $session->room_no = $request->room_no;
        $session->doctor_id = $request->doctor_id;
        $session->nurse_id = $request->nurse_id;
        $session->week_day = $request->week_day;
        $session->start_at = $request->start_at;
        $session->end_at = $request->end_at;
        $session->maximum_patients = $request->maximum_patients;
        $session->hospital_id = $request->user()->hospital->id;
        $session->created_user_id = $request->user()->id;

        $session->save();

        return [
            'success' => true,
            'next' => route('sessions.index'),
            'msg' => $request->name . ' session successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChannelingSession  $channelingSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChannelingSession $session)
    {
        Gate::authorize('delete session', Auth::user());
        
        $session->delete();

        return [
            'success' => true,
            'next' => route('sessions.index'),
            'msg' => 'Sessions successfully deleted!',
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
        $sessions = ChannelingSession::where('hospital_id', $hospital->id)->with(['doctor', 'nurseUser'])->get();

        return new ChannelingSessionCollection($sessions);
    }

    /**
     *  return the specified resource.
     *
     * @param  \App\ChannelingSession  $channelingSession
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(ChannelingSession $channelingSession)
    {
        return new ChannelingSessionResource($channelingSession);
    }

    /**
     * get active session for doctor
     *
     * @param  Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function doctorSessions(Doctor $doctor)
    {
        $hospital = Auth::user()->hospital;

        $sessions = ChannelingSession::where('hospital_id', $hospital->id)
        ->where('doctor_id', $doctor->id)
        ->withCount('channels')
        ->get();

        return [
            'success' => true,
            'data' => [
                'sessions' => $sessions,
            ],
        ];
    }
}
