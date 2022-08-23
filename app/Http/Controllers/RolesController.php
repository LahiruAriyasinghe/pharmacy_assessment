<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class RolesController extends Controller
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
        Gate::authorize('view role', Auth::user());

        $hospital = Auth::user()->hospital;
        $permissions = Permission::all();

        return view('roles.list')
            ->with('hospital', $hospital)
            ->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create role', Auth::user());

        $permissions = $this->getAllPermissionList();

        return view('roles.create')->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create role', Auth::user());

        $request->validate([
            'role_name' => 'required',
            'role_permissions' => 'required',
        ]);

        $hospital = Auth::user()->hospital;

        try {
            $role = Role::create([
                'name' => $hospital->username . '-' . $request->role_name,
                'hospital_id' => $hospital->id,
            ]);
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'msg' => 'User role already exists',
            ];
        }

        $role->syncPermissions($request->role_permissions);

        return [
            'success' => true,
            'next' => route('roles.index'),
            'msg' => 'New role successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        Gate::authorize('edit role', Auth::user());

        $permissions = $this->getAllPermissionList();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('edit role', Auth::user());

         $request->validate([
            'role_name' => 'required',
            'role_permissions' => 'required',
        ]);

        $hospital = Auth::user()->hospital;

        $role->name = $hospital->username . '-' . $request->role_name;
        $role->save();

        $role->syncPermissions($request->role_permissions);

        return [
            'success' => true,
            'next' => route('roles.index'),
            'msg' => $request->role_name . ' role successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete role', Auth::user());

        $userCount = $role->users->count();
        if ($userCount > 0) {
            // this role has a users
            // please remove or update users
            return [
                'error' => true,
                'msg' => "{$role->name} role has {$userCount} user(s). Please update their role before remove this role.",
            ];
        }

        $role->delete();

        return [
            'success' => true,
            'msg' => 'role successfully deleted!',
        ];
    }

    /**
     * listing all resource belong to hospital.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $hospital = Auth::user()->hospital;
        $roles = Role::where('hospital_id', $hospital->id)->get();

        foreach ($roles as $key => $role) {
           $roles[$key]->short_name = substr($role->name, strpos($role->name, "-") + 1);
           $roles[$key]->create = Carbon::parse($role->created_at)->toDateTimeString();
        }

        return [
            'data' => $roles,
        ];
    }


    // get formatted all permission list
    private function getAllPermissionList($role = null)
    {
        $permissions = Permission::orderBy('category', 'desc')
                        ->get();

        $orderedList = [];
        $tempCategory = null;

        foreach ($permissions as $key => $permission) {

            if (!$tempCategory) {
                $tempCategory = $permission->category;
            }

            if ($tempCategory == $permission->category) {  
                
                if(!array_key_exists($tempCategory, $orderedList)){
                    $orderedList[$tempCategory] = [];
                }
                array_push($orderedList[$tempCategory], $permission);

            }else{
                $tempCategory = $permission->category;
                $orderedList[$tempCategory] = [];
                array_push($orderedList[$tempCategory], $permission);
            }
        }

        return $orderedList;
    }

}
