<?php

namespace App\Http\Controllers;

use App\Models\TimeAllocated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TimeAllocatedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("print");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'time' => 'required',
            'task_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        // Transaction
        // $newtime = TimeAllocated::firstOrNew(['user_id' => Auth::id(), 'task_id' => $request->task_id]);
        $newtime = new TimeAllocated;
        $newtime->user_id = Auth::id();
        $newtime->task_id = $request->task_id;
        $newtime->hours = $request->time;
        $newtime->save();
        return response()->json(['success'=>'Record is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeAllocated  $timeAllocated
     * @return \Illuminate\Http\Response
     */
    public function show(TimeAllocated $timeAllocated)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeAllocated  $timeAllocated
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeAllocated $timeAllocated)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeAllocated  $timeAllocated
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeAllocated $timeAllocated)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeAllocated  $timeAllocated
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeAllocated $timeAllocated)
    {
        //
    }
}
