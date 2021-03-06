@section('css')
    @parent
    <style>
        .nav-tabs-custom > .tab-content {
            padding-bottom: 0
        }
    </style>
@stop

<form method="get">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_minimize" data-toggle="tab"><i class="fa fa-minus"></i></a></li>
            <li><a href="#tab_basic" data-toggle="tab">Filters</a></li>
            <li><a href="#tab_advanced" data-toggle="tab">Fields</a></li>
            <li class="pull-right">
                @include($base_dir.'.cta')
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active " id="tab_minimize">
                @include('form.input-text',['var'=>['name'=>'report_name','label'=>'Report name', 'container_class'=>'col-sm-10']])
                @include('form.select-array',['var'=>['name'=>'rows_per_page','label'=>'Rows per page','options'=>kv([10,25,50,100]),'container_class'=>'pull-right col-md-2']])

            </div>
            <div class="tab-pane" id="tab_basic">
                @include('form.input-text',['var'=>['name'=>'created_at_from','label'=>'Created(from)', 'container_class'=>'col-md-3','params'=>['class'=>'datepicker'] ]])
                @include('form.input-text',['var'=>['name'=>'created_at_till','label'=>'Created(till)', 'container_class'=>'col-md-3','params'=>['class'=>'datepicker'] ]])
            </div>
            <div class="tab-pane" id="tab_advanced">
                @include($base_dir.'.advanced')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

@section('js')
    @parent
@endsection