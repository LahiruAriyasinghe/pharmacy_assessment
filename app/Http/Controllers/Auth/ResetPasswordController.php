<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     * route  password.reset
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        \abort_unless(Auth::check(), 404);

        return view('auth.passwords.reset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8|different:old_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            // old password didn't match
            $validator->getMessageBag()->add('old_password', 'Given password is wrong. Please enter correct password.');
            return back()->withErrors($validator)
                ->withInput();
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        $this->resetPassword($user, $request->password);

        return redirect()
            ->route('home')
            ->with('status', 'Password successfully updated!');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8|different:old_password',
        ];
    }
}
