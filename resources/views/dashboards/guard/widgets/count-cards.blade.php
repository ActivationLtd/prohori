<?php
use App\Task;
use App\User;

$user_ids=User::where('client_id',user()->client_id)->pluck('id');
$task_assigned=Task::remember(cacheTime('medium'))->whereIn('assigned_to',$user_ids)->whereIn('status',['To do','In Progress'])->count();
$task_completed=Task::remember(cacheTime('medium'))->where('assigned_to',$user_ids)->whereIn('status',['Done','Closed'])->count();
$task_inprogress=Task::remember(cacheTime('medium'))->where('assigned_to',$user_ids)->whereIn('status',['In Progress'])->count();
$task_due=Task::remember(cacheTime('medium'))->where('assigned_to',$user_ids)->whereNotIn('status',['Done','Closed'])->where('due_date','<',now())->count();
?>
<div class="row">
    <div class="col-md-12"><b>{{Lang::get('messages.Task-summary')}}</b></div>
    <div class="clearfix"></div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-grey">
            <div class="inner">
                <h3>{{$task_assigned}}</h3>
                <p>{{Lang::get('messages.Assigned')}}</p>
            </div>
            <div class="icon">
                <i class="fa fa-check-square"></i>
            </div>
            <a href={{route('home').'/tasks?status=to%20do'}} class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange-active">
            <div class="inner">
                <h3>{{$task_inprogress}}</h3>
                <p>{{Lang::get('messages.In-progess')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href={{route('home').'/tasks?status=In%20progress'}} class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$task_completed}}</h3>
                <p>{{Lang::get('messages.Completed')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href={{route('home').'/tasks?status=Done'}} class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$task_due}}</h3>
                <p>{{Lang::get('messages.Due')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href={{route('home').'/tasks'}} class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
