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
                @include('modules.base.report.cta')
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active " id="tab_minimize">
                @include('form.input-text',['var'=>['name'=>'title','label'=>'Report name', 'container_class'=>'col-sm-10']])
                @include('form.select-array',['var'=>['name'=>'rows_per_page','label'=>'Rows per page','options'=>kv([10,25,50,100]),'container_class'=>'pull-right col-md-2']])
            </div>
            <div class="tab-pane" id="tab_basic">
                <?php
                $var = [
                    'name' => 'user_id',
                    'label' => 'User',
                    'value' => Request::get('user_id') ?? [],
                    'query' => new \App\User,
                    'name_field' => 'name',
                    'params' => ['multiple', 'id' => 'users'],
                    'container_class' => 'col-sm-3'
                ];
                ?>
                {{--assigned_to--}}
                @include('form.select-model', compact('var'))
                <?php
                $var = [
                    'name' => 'clientlocationtype_id',
                    'label' => 'Location type',
                    'value' => Request::get('clientlocationtype_id') ?? [],
                    'query' => new \App\Clientlocationtype(),
                    'name_field' => 'name',
                    'params' => ['multiple', 'id' => 'clientlocationtypes'],
                    'container_class' => 'col-sm-3'
                ];
                ?>
                {{--tasktype--}}
                @include('form.select-model', compact('var'))
                <?php
                $var = [
                    'name' => 'client_id',
                    'label' => 'Client',
                    'value' => Request::get('client_id') ?? [],
                    'query' => new \App\Client(),
                    'name_field' => 'name',
                    'params' => ['multiple', 'id' => 'clients'],
                    'container_class' => 'col-sm-3'
                ];
                ?>
                {{--client--}}
                @include('form.select-model', compact('var'))

                <?php
                $var = [
                    'name' => 'clientlocation_id',
                    'label' => 'Clientlocation',
                    'value' => Request::get('clientlocation_id') ?? [],
                    'query' => new \App\Clientlocation(),
                    'name_field' => 'name',
                    'params' => ['multiple', 'id' => 'clientlocations'],
                    'container_class' => 'col-sm-3'
                ];
                ?>
                {{--client location--}}
                @include('form.select-model', compact('var'))
                <div class="clearfix"></div>

                {{--Distance--}}
                @include('form.input-text',['var'=>['name'=>'distance','label'=>'Distance', 'container_class'=>'col-md-2']])
                {{--Distance Flag--}}
                <?php $options = kv(array_merge(['Select' => "Select"], \App\Userlocation::$flags));?>
                @include('form.select-array',['var'=>['name'=>'distance_flag','label'=>Lang::get('Distance Flag'), 'options'=>$options,'container_class'=>'col-md-3']])
                {{--@include('form.select-array',['var'=>['name'=>'is_test','label'=>'Is test', 'options'=>['0'=>'No','1'=>'Yes',],'container_class'=>'col-sm-3']])--}}
                <div class="clearfix"></div>
                {{--created at from--}}
                @include('form.input-text',['var'=>['name'=>'created_at_from','label'=>'Created(from)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
                {{--created at till--}}
                @include('form.input-text',['var'=>['name'=>'created_at_till','label'=>'Created(till)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
            </div>
            <div class="tab-pane" id="tab_advanced">
                @include('modules.base.report.advanced')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

@section('js')
    @parent

@endsection