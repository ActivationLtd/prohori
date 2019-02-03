<?php
/* change value of day from @var $current_day */
$current_day = \Carbon\Carbon::today();
/* get recommendations count of @var $current_day */
$recommendation_count = \App\Recommendurl::remember(cacheTime('short'))->whereDate('created_at', $current_day)->count();
/* get purchase count of @var $current_day  */
$purchase_count = \App\Purchase::remember(cacheTime('short'))->whereDate('created_at', $current_day)->count();
/* get registration count of @var $current_day  */
$new_users = \App\User::remember(cacheTime('short'))->whereDate('created_at', $current_day)->count();
/* get commisions sum of @var $current_day  */ 
$purchases = \App\Purchase::select(DB::raw('sum(lb_commission_in_lb_currency) as commission'))->whereDate('created_at', $current_day)->first();
/* check commisions exists or not */
if($purchases->commission){
   $lb_commissions =  round($purchases->commission,2);
}else{
    $lb_commissions =  0;
}
?>

<div class="row">
    <div class="col-md-12">
        <h5>Today's statistics</h5>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua lb-bg">
            <div class="inner">
                <h3>{{$recommendation_count}}</h3>
                <p>Recommended</p>
            </div>
            <div class="icon">
                <i class="{{\App\Module::byName('recommendurls')->icon_css}}"></i>
            </div>
            <a href="{{route('recommendurls.index')}}" class="small-box-footer">View all</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green lb-bg">
            <div class="inner">
                {{--<h3>53<sup style="font-size: 20px">%</sup></h3>--}}
                <h3>{{$purchase_count}}</h3>
                <p>Purchases</p>
            </div>
            <div class="icon">
                <i class="{{\App\Module::byName('purchases')->icon_css}}"></i>
            </div>
            <a href="{{route('purchases.index')}}" class="small-box-footer">View all</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow lb-bg">
            <div class="inner">
                <h3>{{$new_users}}</h3>
                <p>Registrations</p>
            </div>
            <div class="icon">
                <i class="{{\App\Module::byName('users')->icon_css}}"></i>
            </div>
            <a href="{{route('users.index')}}" class="small-box-footer">View all</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red lb-bg">
            <div class="inner">
                <h3>{{$lb_commissions}}</h3>
                <p>Commission</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            <a href="{{route('purchases.index')}}" class="small-box-footer">View all</a>
        </div>
    </div>
    <div class="col-md-12">
        <h5>Analytics</h5>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red lb-bg">
            <div class="inner">
                <h3>Web</h3>
                <p>Analytics</p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-line"></i>
            </div>
            <a target="_blank" href="https://marketingplatform.google.com/about/analytics/" class="small-box-footer">Go
                to site <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red lb-bg">
            <div class="inner">
                <h3>App</h3>
                <p>Analytics</p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-area"></i>
            </div>
            <a target="_blank" href="https://console.firebase.google.com/" class="small-box-footer">Go to site <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>