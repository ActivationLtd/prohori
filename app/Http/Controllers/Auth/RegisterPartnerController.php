<?php

namespace App\Http\Controllers\Auth;

use App\Partner;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterPartnerController extends RegisterController
{

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register-partner');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:partners,name',
            'contact_first_name' => 'required',
            'contact_last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:5,16|confirmed',
        ]);

        if ($validator->fails()) {
            $ret = ret('fail', "Validation error(s)", ['validation_errors' => json_decode($validator->messages(), true)]);
        } else {

            $partner = new Partner;
            $partner->name = $request->get('name');
            $partner->contact_name = $request->get('contact_first_name') . " " . $request->get('contact_last_name');
            $partner->contact_email = $request->get('email');
            $partner->is_active = 1;

            if ($partner->save()) {

                $user = new User;
                $user->email = $request->get('email');
                $user->password = $request->get('password');
                $user->first_name = $request->get('contact_first_name');
                $user->last_name = $request->get('contact_last_name');
                $user->group_ids_csv = '2';
                $user->partner_id = $partner->id;

                if ($user->save()) {
                    event(new Registered($user));
                    $user->sendPartnerUserRegistrationEmailWithVerification();
                    //$user->sendEmailVerificationNotification();
                    $ret = ret('success', "Registration success. A verification email has been sent ",
                        [
                            'data' => [
                                'partner' => Partner::find($partner->id),
                                'user' => User::find($user->id)]
                        ]);
                } else {
                    $ret = ret('fail', "User could not be created");
                }
            } else {
                $ret = ret('fail', "User could not be created");
            }
        }

        $request->merge(['redirect_success' => route('login')]);
        return $this->jsonOrRedirect($ret, $validator);

    }
}
