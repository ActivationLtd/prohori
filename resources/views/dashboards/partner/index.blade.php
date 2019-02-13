@extends('template.app-frame')

<?php
/** @var \App\Purchase $purchases */
/** @var \App\Partner $partner */
?>

@section('title')
    Partner dashboard
    <small>View all prohori activities</small>
@endsection

@section('content')
    @if(Auth::check())
        <div class="row">
            <div id="area-1" class="col-md-6 pull-left no-padding-r">
                {{-- Widget area 1 --}}
                @include('dashboards.partner.widgets.count-cards')
                @include('dashboards.partner.widgets.latest-purchases')
                <div class="clearfix"></div>
                <div id="area-2" class="col-md-6 pull-left no-padding-l">
                    {{-- Widget area 2 --}}

                </div>
                <div id="area-3" class="col-md-6 pull-left no-padding-l">
                    {{-- Widget area 3 --}}
                </div>
            </div>
            <div id="area-4" class="col-md-6 pull-left no-padding-r">
                {{-- Widget area 4 --}}
                @include('dashboards.partner.widgets.top-recommends')
                @include('dashboards.partner.widgets.top-purchases')
                <div id="area-5" class="col-md-3 pull-left no-padding-l">
                    {{-- Widget area 5 --}}

                </div>
                <div id="area-6" class="col-md-3 pull-left no-padding-l">
                    {{-- Widget area 6 --}}
                </div>
            </div>
        </div>
    @endif
@endsection