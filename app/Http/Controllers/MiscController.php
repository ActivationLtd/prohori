<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use View;
use App\Mail\DailyStatus;


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
        return View::make('template.prohori.link-expired');
    }

    public function test()
    {
        $end_date = today()->toDateString();
        $date = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();

        dd($date);
    }
    public function dailyStatusEmail(){

        \Mail::to('sanjidhabib@gmail.com')->send(
            new DailyStatus()
        );
    }
}



