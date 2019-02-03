@extends('template.app-frame')
{{-- Master view file for report --}}


@section('head')
    @parent
    <style>
        .nav-tabs-custom > .tab-content {
            padding: 0;
        }
    </style>
@endsection

@section('title')
    @if(Request::has('submit') && hasPermission('reports.create'))
        <?php
        // $report_save_url = route('reports.create');
        $report_save_url = route('reports.create');
        $report_save_url .= "?title=" . Request::get('report_name');
        //         $report_save_url .= "&code=" . Route::getCurrentRoute()->getParameter('code');
        $report_save_url .= "&module_id=" . $mod->id;
        ?>
        <?php
        $generic_url = str_replace(route('home'), '', URL::full());
        $report_save_url .= "&parameters=" . urlencode($generic_url);
        ?>
        <a target="_blank" class="btn btn-default" href="{{$report_save_url}}"><i class="fa fa-save"></i>
            <small>Save this Report</small>
        </a>
        @if (Request::has('report_name'))
            <h4>{{Request::get('report_name')}}</h4>
        @endif
    @endif


@endsection



@section('js')
    @parent
    <script type="text/javascript">
        $('#right-side').addClass('stretch');
        $('#left-side').addClass('collapse-left');
    </script>
@endsection