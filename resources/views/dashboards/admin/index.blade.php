@extends('template.app-frame')

@section('content')
    @if(Auth::check())
        <div class="row">
            <div id="area-1" class="col-md-8 pull-left no-padding-r">
                {{-- Widget area one --}}
                @include('dashboards.admin.widgets.count-cards')
                <div class="clearfix"></div>
                <div id="area-2" class="col-md-8 pull-left no-padding-l">
                    @include('dashboards.admin.widgets.tasks-created-in-last-ten-days')
                </div>

            </div>

            <div class="clearfix"></div>
            <div id="area-3" class="col-md-6 pull-left no-padding-l">
                @include('dashboards.admin.widgets.google-bar-chart')
            </div>
            <div id="area-4" class="col-md-6 pull-left no-padding-l">
                @include('dashboards.admin.widgets.google-bar-chart2')
            </div>
        </div>
    @endif
@endsection

