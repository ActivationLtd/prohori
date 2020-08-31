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
        if ($user->isManagerUser()) {

            return view("dashboards.manager.index");
        }
        if ($user->isGuardUser()) {

            return view("dashboards.guard.index");
        }
        if ($user->isClientUser()) {

            return view("dashboards.client.index");
        }

        return view("dashboards.default.index");
    }
}
