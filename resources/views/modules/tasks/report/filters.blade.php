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
                    'name' => 'assigned_to',
                    'label' => 'Assignee',
                    'value' => Request::get('assigned_to') ?? [],
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
                    'name' => 'tasktype_id',
                    'label' => 'Task type',
                    'value' => Request::get('tasktype_id') ?? [],
                    'query' => new \App\Tasktype,
                    'name_field' => 'name',
                    'params' => ['multiple', 'id' => 'tasktypes'],
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
                    'query' => new \App\Client,
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
                {{--priority--}}
                <?php $options = array_merge(['Select' => "Select"], \App\Task::$priorities);?>
                @include('form.select-array',['var'=>['name'=>'priority','label'=>Lang::get('messages.Priority'), 'options'=>$options,'container_class'=>'col-md-3']])
                {{--status--}}
                <?php $options = array_merge(['Select' => "Select"], \App\Task::$statuses);?>
                @include('form.select-array',['var'=>['name'=>'status','label'=>Lang::get('messages.Status'), 'options'=>kv($options),'container_class'=>'col-md-3']])
                {{--@include('form.select-array',['var'=>['name'=>'is_test','label'=>'Is test', 'options'=>['0'=>'No','1'=>'Yes',],'container_class'=>'col-sm-3']])--}}
                <div class="clearfix"></div>
                {{--created at from--}}
                @include('form.input-text',['var'=>['name'=>'created_at_from','label'=>'Created(from)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
                {{--created at till--}}
                @include('form.input-text',['var'=>['name'=>'created_at_till','label'=>'Created(till)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
                {{--due date from--}}
                @include('form.input-text',['var'=>['name'=>'due_date_from','label'=>'Due Date(from)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
                {{--due date till--}}
                @include('form.input-text',['var'=>['name'=>'due_date_till','label'=>'Due Date(till)', 'container_class'=>'col-md-2','params'=>['class'=>'datepicker'] ]])
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