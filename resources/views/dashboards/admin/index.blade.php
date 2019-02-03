@extends('template.app-frame')

@section('title')
    Super admin dashboard
    <small>View all Letsbab activities</small>
@endsection

@section('content')
    @if(Auth::check())
        <div class="row">
            <div id="area-1" class="col-md-6 pull-left no-padding-r">
                {{-- Widget area 1 --}}
                @include('dashboards.admin.widgets.count-cards')
                @include('dashboards.admin.widgets.recommend-vs-purchase')
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
                @include('dashboards.admin.widgets.top-brands-bar-chart')
                @include('dashboards.admin.widgets.top-charities-bar-chart')
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