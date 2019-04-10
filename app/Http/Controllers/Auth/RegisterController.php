<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\IsoOutput;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use IsoOutput;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = new User($request->all());
        $validator = Validator::make($request->all(), array_merge(User::rules($user), [
            'password' => 'required|confirmed',
            'group_id' => 'required',
        ]));
        if ($validator->fails()) {
            $ret = ret('fail', "Validation error(s)", ['validation_errors' => json_decode($validator->messages(), true)]);
        } else {

            if ($user->save()) {
                event(new Registered($user));
                $user->sendRegistrationWithVerificationNotification();
                //$user->sendEmailVerificationNotification();
                $ret = ret('success', "User successfully created", ['data' => User::find($user->id)]);
            } else {
                $ret = ret('fail', "User could not be created");
            }
        }

        $request->merge(['redirect_success' => route('login')]);
        return $this->jsonOrRedirect($ret, $validator);
    }
}
