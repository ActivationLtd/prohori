@extends('template.app-frame')


@section('css')
    @parent
    <style>
        .content-header {
            padding: 0;
        }

        .content {
            padding-top: 0;
        }
    </style>
@stop

@section('content')
    @if(Auth::check())
        <div class="row">
            <div id="area-1" class="col-md-6 pull-left ">
                {{-- Widget area one --}}
                @include('dashboards.admin.widgets.count-cards')
                <div class="clearfix"></div>

                @include('dashboards.admin.widgets.map')

            </div>

            <div id="area-3" class="col-md-6 pull-left">
                @include('dashboards.admin.widgets.open-tasks')
                {{--                @include('dashboards.admin.widgets.google-bar-chart')--}}
            </div>
            <div id="area-4" class="col-md-6 pull-left">
                {{--                @include('dashboards.admin.widgets.google-bar-chart2')--}}
            </div>
        </div>
    @endif
@endsection

