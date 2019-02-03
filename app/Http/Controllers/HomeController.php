<?php

namespace App\Http\Controllers;

use Redirect;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard based on different user type/group.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var \App\User $user */
        $user = \Auth::user();

        if ($user->isSuperUser()) {
            return view("dashboards.admin.index");
        }
        if ($user->ofPartner()) {
            // If the brand is not valid redirect him
            if($user->partner->validateModel()->fails()) {
                setError('First fill up all the necessary information related to your brand');
                return Redirect::route('partners.edit',$user->partner_id);
            }
            return view("dashboards.partner.index")->with('partner', $user->partner);

        }
        if ($user->ofCharity()) {
            return view("dashboards.charity.index")->with('partner', $user->charity);
        }
        return view("dashboards.default.index");
    }
}
