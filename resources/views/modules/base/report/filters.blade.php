<form method="get">
    <div class="nav-tabs-custom">
        {{-- lists the tab titles and make the first one active --}}
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_minimize" data-toggle="tab"><i class="fa fa-minus"></i></a></li>
            <li><a href="#tab_basic" data-toggle="tab">Basic</a></li>
            <li><a href="#tab_advanced" data-toggle="tab">Advanced</a></li>
            {{-- button group for data viewing --}}
            <li class="pull-right">
                @include('modules.base.report.blocks.block-run-excel')
            </li>
        </ul>
        {{-- tab contents--}}
        <div class="tab-content">
            {{-- empty tab --}}
            <div class="tab-pane active " id="tab_minimize">{{-- empty tab --}}</div>
            {{-- tab_basic--}}
            <div class="tab-pane" id="tab_basic">
                @include('form.input-text',['var'=>['name'=>'report_name','label'=>'Report name', 'container_class'=>'col-sm-6']])

                {{--@include('form.select-array',['var'=>['name'=>'type','label'=>'Type', 'options'=>App\Report::$types,'container_class'=>'col-sm-3']])--}}
                <div class="clearfix"></div>
            </div>
            {{-- advanced --}}
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