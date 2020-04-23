@extends('template.app-frame')

@section('content')
    @if(Auth::check())

        <div class="row">
            <div id="area-1" class="col-md-6 pull-left ">
                {{-- Widget area one --}}
                @include('dashboards.guard.widgets.count-cards')
                <div class="clearfix"></div>
                <div id="area-2" class="col-md-12 pull-left ">
                    @include('dashboards.guard.widgets.map')
                </div>
            </div>

            <div id="area-3" class="col-md-6 pull-left">
                @include('dashboards.guard.widgets.open-tasks')
                {{--@include('dashboards.guard.widgets.google-bar-chart')--}}
            </div>
            <div id="area-4" class="col-md-6 pull-left">
                {{--@include('dashboards.guard.widgets.google-bar-chart2')--}}
            </div>
        </div>
    @endif
@endsection

