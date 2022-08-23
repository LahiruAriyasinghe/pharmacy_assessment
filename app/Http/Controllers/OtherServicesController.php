<?php

namespace App\Http\Controllers;

use App\OtherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OtherServiceCollection;
use App\Http\Resources\OtherService as OtherServiceResource;

class OtherServicesController extends Controller
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
        Gate::authorize('view service', Auth::user());

        $hospital = Auth::user()->hospital;

        return view('otherServices.list')
            ->with('hospital', $hospital);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create service', Auth::user());

        return view('otherServices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create service', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|between:0,99999999.99',
        ]);

        $service = new OtherService;

        $service->name = $request->name;
        $service->fee = $request->fee;
        $service->hospital_id = $request->user()->hospital->id;
        $service->created_user_id = $request->user()->id;

        $service->save();

        return [
            'success' => true,
            'next' => route('other-services.index'),
            'msg' => 'New services successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherService  $otherService
     * @return \Illuminate\Http\Response
     */
    public function show(OtherService $otherService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherService  $otherService
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherService $otherService)
    {
        Gate::authorize('edit service', Auth::user());

        return view('otherServices.edit')
            ->with('service', $otherService);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherService  $otherService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherService $otherService)
    {
        Gate::authorize('edit service', Auth::user());

        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|between:0,99999999.99',
        ]);

        $otherService->name = $request->name;
        $otherService->fee = $request->fee;
        $otherService->hospital_id =  $request->user()->hospital->id;
        $otherService->created_user_id = $request->user()->id;

        $otherService->save();

        return [
            'success' => true,
            'next' => route('other-services.index'),
            'msg' => $request->name . ' services successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherService  $otherService
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherService $otherService)
    {
        Gate::authorize('delete service', Auth::user());
        
        $otherService->delete();

        return [
            'success' => true,
            'next' => route('other-services.index'),
            'msg' => 'Services successfully deleted!',
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
        $services = OtherService::where('hospital_id', $hospital->id)->get();

        return new OtherServiceCollection($services);
    }

    /**
     *  return the specified resource.
     *
     * @param  \App\OtherService  $otherService
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(OtherService $otherService)
    {
        return new OtherServiceResource($otherService);
    }
}
