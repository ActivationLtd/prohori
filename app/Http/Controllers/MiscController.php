<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use View;

class MiscController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('superuser');
    }

    // Test route for development
    public function showLinkExpiredUI()
    {
        return View::make('template.letsbab.link-expired');
    }

    public function test()
    {
        $end_date = today()->toDateString();
        $date = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        dd($date);
    }
}



