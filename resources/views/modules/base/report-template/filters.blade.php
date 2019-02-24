<form method="get">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_minimize" data-toggle="tab"><i class="fa fa-minus"></i></a></li>
            <li><a href="#tab_basic" data-toggle="tab">Basic</a></li>
            <li><a href="#tab_advanced" data-toggle="tab">Advanced</a></li>
            <li class="pull-right">
                @include('modules.base.report.blocks.block-run-excel')
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active " id="tab_minimize"></div>
            <div class="tab-pane" id="tab_basic">
                @include('form.input-text',['var'=>['name'=>'report_name','label'=>'Report name', 'container_class'=>'col-sm-6']])

                <div class="clearfix"></div>
            </div>
            <div class="tab-pane" id="tab_advanced">
                @include('modules.base.report.blocks.block-sql-api-url')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

@section('js')
    @parent
    {{-- write your JS here --}}
@endsection