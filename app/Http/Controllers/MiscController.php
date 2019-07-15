<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use View;
use App\Mail\DailyStatus;
use App\Task;

class MiscController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct() {
        $this->middleware('superuser');
    }

    // Test route for development
    public function showLinkExpiredUI() {
        return View::make('template.prohori.link-expired');
    }

    public function test() {
        $end_date = today()->toDateString();
        $date = Carbon::createFromFormat('Y-m-d', $end_date)->addDays(1)->toDateString();
        $tasks=Task::all();
        foreach($tasks as $task)
        {
            $task->save();
        }
        dd($date);
    }

    public function dailyStatusEmail() {
        //dd(config('var.admin-cc-emails'));
        \Mail::to(config('var.admin-emails'))->cc(config('var.admin-cc-emails'))->send(
            new DailyStatus()
        );
        // $tasks=Task::where('is_active',1)->whereIn('status',['To do','In progress'])->get();
        // return View::make('emails.daily-status')->with('tasks',$tasks);
    }
    public function privacypolicy() {
        return View::make('modules.base.privacy');
    }
}



