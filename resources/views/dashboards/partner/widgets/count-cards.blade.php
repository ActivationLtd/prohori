<?php
/** @var \App\Purchase $purchases */
/** @var \App\Partner $partner */

$recommendation_count = \App\Recommendurl::remember(cacheTime('long'))->where('partner_id', $partner->id)->count();
$purchase_count = \App\Purchase::remember(cacheTime('long'))->where('partner_id', $partner->id)->count(); // This is dummy data, Calculate original data.
$purchase_price = \App\Purchase::remember(cacheTime('long'))->where('partner_id', $partner->id)->sum('product_price_in_product_currency');
?>

<div class="row">
    <div class="col-md-12">
        <h5>Statistics</h5>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="small-box prohori-bg">
            <div class="inner">
                <h3>{{$recommendation_count}}</h3>
                <p>Recommended</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('recommendurls.index')}}" class="small-box-footer">
                View all <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="small-box prohori-bg">
            <div class="inner">
                {{--<h3>53<sup style="font-size: 20px">%</sup></h3>--}}
                <h3>{{$purchase_count}}</h3>
                <p>Purchases</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('purchases.index')}}" class="small-box-footer">View all <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-red prohori-bg">
            <div class="inner">
                <h3>{{symbol($partner->currency)}} {{money($purchase_price)}}</h3>
                <p>Sale amount</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">
            &nbsp;    {{--View all <i class="fa fa-arrow-circle-right"></i>--}}
            </a>
        </div>
    </div>
</div>