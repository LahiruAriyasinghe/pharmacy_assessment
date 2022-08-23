<?php

namespace App\Http\Controllers;

use App\User;
use App\Specialty;
use App\Doctor;
use App\Log\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;

use App\Invoice\InvoiceLab;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('checkUserEmail');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view user', Auth::user());

        $hospital = Auth::user()->hospital;
        $roles = Role::where('hospital_id', $hospital->id)->get();
        $specialties = Specialty::all();

        return view('users.list')
            ->with('hospital', $hospital)
            ->with('specialties', $specialties)
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create user', Auth::user());

        $hospital = Auth::user()->hospital;
        $roles = Role::where('hospital_id', $hospital->id)->get();
        $specialties = Specialty::all();

        return view('users.create')
            ->with('hospital', $hospital)
            ->with('specialties', $specialties)
            ->with('roles', $roles);
    }

    public function checkUserEmail(Request $request)
    {       
        $user = User::where('email', $request->email)
        ->where(function ($query) use ($request) {
            if ($request->has('user_id')) {
                $query->where('id', '<>', $request->user_id);
            }
        })->first();

        if ($user) {
            echo "false";
        } else {
            echo "true";
        }

        return;
    }

    public function checkUsername(Request $request)
    {
        $user = User::where('username', $request->username)
            ->where('hospital_id', $request->hospital)
            ->where(function ($query) use ($request) {
                if ($request->has('user_id')) {
                    $query->where('id', '<>', $request->user_id);
                }
            })->withTrashed()
            ->first();

        if ($user) {
            echo "false";
        } else {
            echo "true";
        }

        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create user', Auth::user());

        $request->validate([
            'hospital' => 'required|exists:hospitals,id',
            'title' => 'required|in:Mr,Miss,Mrs,Dr',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'required|alpha_dash|min:5|max:255',
            'email' => 'nullable|email|unique:users,email|max:255',
            'contact' => 'required',
            'gender' => 'required|in:M,F,O',
            'role' => 'required|exists:roles,id',
        ]);

        // check role hospital equal to user's hospital
        $role = Role::where('hospital_id', $request->hospital)
            ->where('id', $request->role)
            ->firstOrFail();
        
        // validate username
        $username = User::where('username', $request->username)
            ->where('hospital_id', $request->hospital)->first();
        \abort_if($username, 422, 'Username already exist');

        // if user is a doctor
        if ($request->is_doctor) {
            Gate::authorize('create doctor', Auth::user());
            $request->validate([
                'specialty' => 'required|exists:specialties,id',
                'note' => 'nullable|string|max:500',
                'fee' => 'required|between:0,99999999.99',
            ]);
        }

        $user = new User;

        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->hospital_id = $request->hospital;
        $user->nurse = $request->is_nurse ? 1 : 0;
        $user->mlt = $request->is_mlt ? 1 : 0;
        $user->created_user_id = $request->user()->id;
        $user->password = Hash::make('password');
        
        $user->save();

        $user->assignRole($request->role);

        if ($request->is_doctor) {
            $doctor = new Doctor;
            $doctor->specialty_id = $request->specialty;
            $doctor->fee = $request->fee;
            $doctor->note = $request->note;
            $doctor->hospital_id = $request->hospital;
            $doctor->created_user_id = $request->user()->id;

            $user->doctor()->save($doctor);
        }

        return [
            'success' => true,
            'next' => route('users.index'),
            'msg' => 'New user successfully created!',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        Gate::authorize('edit user', Auth::user());

        $hospital = Auth::user()->hospital;
        $roles = Role::where('hospital_id', $hospital->id)->get();
        $specialties = Specialty::all();

        return view('users.edit')
            ->with('user', $user)
            ->with('doctor', $user->doctor)
            ->with('hospital', $hospital)
            ->with('specialties', $specialties)
            ->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('edit user', Auth::user());

        $request->validate([
            'hospital' => 'required|exists:hospitals,id',
            'title' => 'required|in:Mr,Miss,Mrs,Dr',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'required|alpha_dash|min:5|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'required',
            'gender' => 'required|in:M,F,O',
            'role' => 'required|exists:roles,id',
        ]);

        // check role hospital equal to user's hospital
        $role = Role::where('hospital_id', $request->hospital)
            ->where('id', $request->role)
            ->firstOrFail();

        // if user is a doctor
        if ($request->is_doctor) {
            Gate::authorize('edit doctor', Auth::user());

            $request->validate([
                'specialty' => 'required|exists:specialties,id',
                'note' => 'nullable|string|max:500',
                'fee' => 'required|between:0,99999999.99',
            ]);
        }

        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->hospital_id = $request->hospital;
        $user->nurse = $request->is_nurse ? 1 : 0;
        $user->mlt = $request->is_mlt ? 1 : 0;
        $user->created_user_id = $request->user()->id;
        $user->password = Hash::make('password');

        $user->save();

        $user->syncRoles($request->role);

        if ($request->is_doctor) {
            if ($user->doctor) {
                // update existing doctor
                $user->doctor->specialty_id = $request->specialty;
                $user->doctor->fee = $request->fee;
                $user->doctor->note = $request->note;
                $user->doctor->hospital_id = $request->hospital;
                $user->doctor->created_user_id = $request->user()->id;
    
                $user->doctor->save();
            }else{
                // create new doctor
                $doctor = new Doctor;
                $doctor->specialty_id = $request->specialty;
                $doctor->fee = $request->fee;
                $doctor->note = $request->note;
                $doctor->hospital_id = $request->hospital;
                $doctor->created_user_id = $request->user()->id;
    
                $user->doctor()->save($doctor);
            }
        }else if($user->doctor){
            // remove doctor
            $user->doctor()->delete();
        }

        return [
            'success' => true,
            'next' => route('users.index'),
            'msg' => $request->first_name . ' user successfully updated!',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete user', Auth::user());
        
        if($user->doctor){
            Gate::authorize('delete doctor', Auth::user());
            $user->doctor()->delete();
        }
        $user->delete();

        return [
            'success' => true,
            'msg' => 'user successfully deleted!',
        ];
    }

    /**
     * return all resource belong to hospital.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesIndex()
    {
        $hospital = Auth::user()->hospital;
        $users = User::with('roles')->where('hospital_id', $hospital->id)->get();

        return new UserCollection($users);
    }

    /**
     * return the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resourcesShow(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Reset password by authorized user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request, User $user)
    {
        Gate::authorize('edit user', Auth::user());
        Gate::authorize('reset user password', Auth::user());

        if (!$request->password) {
            return [
                'msg' => 'Authorized user password required',
            ];
        }

        if (!Hash::check($request->password, Auth::user()->password)) {
            // password doesn't match
            return [
                'msg' => 'Incorrect password',
            ];
        }

        // log
        $log = new ResetPassword;
        $log->user_id = $user->id;
        $log->save();

        // update password
        $user->password = Hash::make('password');
        $user->save();

        return [
            'success' => true,
            'next' => route('users.index'),
            'msg' => $user->username . ' user password successfully reset to "password"',
        ];
    }
}