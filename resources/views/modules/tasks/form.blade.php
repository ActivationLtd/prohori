<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'tasks'
 * @var $mod                   \App\Module
 * @var $task                  \App\Task Object that is being edited
 * @var $element               string 'task'
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>
{{-- ******************* Template Section list (From top to bottom ) ********************* --}}
@section('head')
    @parent
@endsection

@section('sidebar-left')
    @parent
@endsection

@section('title')
    @parent
@endsection

@section('breadcrumb')
    @parent
@endsection

@section('content-top')
    @parent
@endsection

<?php
/**
 * This is the main form that gets submitted to the controller.
 * Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 * app/views/spyr/modules/base/form.blade.php
 */
?>
{{-- ******************* Form starts ********************* --}}

<div class="col-md-6 no-padding-l">
    {{--assigned_to--}}
    @include('form.select-model', ['var'=>['name'=>'assigned_to','label'=>Lang::get('messages.Assigned-to'),'query'=> new \App\User,'container_class'=>'']])
    {{--watchers--}}
    <?php
    $var = [
        'name' => 'watchers',
        'label' => Lang::get('messages.Watchers'),
        'query' => new \App\User,
        'container_class' => 'col-md-6',
    ];
    ?>
    @include('form.select-model-multiple', ['var'=>$var])
    {{--status--}}
    @include('form.select-array',['var'=>['name'=>'status','label'=>Lang::get('messages.Status'), 'options'=>kv(\App\Task::$statuses),'container_class'=>'col-md-6']])
</div>
<div class="clearfix"></div>
<div class="col-md-6 no-padding-l">
    {{--client_id--}}
    @include('form.select-model', ['var'=>['name'=>'client_id','label'=>Lang::get('messages.Client'),'query'=> new \App\Client,'container_class'=>'col-md-6']])
    {{-- clientlocation_id --}}
    {{-- @include('form.select-ajax',['var'=>['label' => 'Location', 'name' => 'clientlocation_id', 'table' => 'clientlocations', 'name_field' => 'name_ext','container_class'=>'col-md-6']])--}}
    @include('form.select-model', ['var'=>['name'=>'clientlocation_id','label'=>Lang::get('messages.Location'),'query'=> new \App\Clientlocation,'container_class'=>'col-md-6']])

</div>
<div class="clearfix"></div>
<div class="col-md-12 no-padding-l">
    {{--parent_id--}}
    @include('form.select-ajax',['var'=>['label' => Lang::get('messages.Parent-task'), 'name' => 'parent_id', 'table' => 'tasks', 'name_field' => 'name', 'container_class' => 'col-md-6',]])
    <div class="clearfix"></div>
    {{--tasktype_id--}}
    @include('form.select-model', ['var'=>['name'=>'tasktype_id','label'=>Lang::get('messages.Task-type'),'query'=> new \App\Tasktype(),'container_class'=>'col-md-3']])
    {{--priority--}}
    @include('form.select-array',['var'=>['name'=>'priority','label'=>Lang::get('messages.Priority'), 'options'=>\App\Task::$priorities,'container_class'=>'col-md-3']])
    {{--@include('form.input-text',['var'=>['name'=>'due_date','label'=>'Due Date', 'container_class'=>'col-sm-3','params'=>['class'=>'datepicker']]])--}}
    @include('form.input-text',['var'=>['name'=>'due_date','label'=>Lang::get('messages.Due-date'), 'container_class'=>'col-sm-2','params'=>['id'=>'due_date']]])
    @if(isset($task))
        {{--days_open--}}
        @include('form.input-text',['var'=>['name'=>'days_open','label'=>'Days Open', 'container_class'=>'col-md-1','params'=>['readonly'=>true]]])
        {{--seq--}}
        @include('form.input-text',['var'=>['name'=>'seq','label'=>'Sequence', 'container_class'=>'col-md-1','params'=>['readonly'=>true]]])
    @endif

</div>
<div class="clearfix"></div>
<div class="col-md-6 no-padding">
    {{--name--}}
    @include('form.input-text',['var'=>['name'=>'name','label'=>Lang::get('messages.Task-title'), 'container_class'=>'col-md-12']])
    {{--description--}}
    @include('form.textarea',['var'=>['name'=>'description','label'=>Lang::get('messages.Task-details'),'container_class'=>'col-md-12']])
</div>
<div class="clearfix"></div>
@if(isset($task) && in_array($task->status,['Closed','Done']))
    <div class="col-md-6 no-padding ">
        {{--is_flagged--}}
        @include('form.select-array',['var'=>['name'=>'is_flagged','label'=>'Is Flagged','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
        {{--flagged_by--}}
        @include('form.select-model', ['var'=> ['name' => 'flagged_by', 'label' => 'Flaged By', 'query' => new \App\User(),'container_class'=>'col-md-4']])
        {{--flag_note--}}
        @include('form.textarea',['var'=>['name'=>'flag_note','label'=>'Flag Notes','container_class'=>'col-md-8']])
    </div>

    <div class="col-md-6 no-padding ">
        {{--is_resolved--}}
        @include('form.select-array',['var'=>['name'=>'is_resolved','label'=>'Is Resolved','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
        {{--resolved_by--}}
        @include('form.select-model', ['var'=> ['name' => 'resolved_by', 'label' => 'Resolved By', 'query' => new \App\User(),'container_class'=>'col-md-4']])
        <div class="clearfix"></div>
        {{--resolve_note--}}
        @include('form.textarea',['var'=>['name'=>'resolve_note','label'=>'Resolve Notes','container_class'=>'col-md-8']])
    </div>
    <div class="clearfix"></div>
    {{--<div class="col-md-6 no-padding ">--}}
    {{--is_verified--}}
    {{--@include('form.select-array',['var'=>['name'=>'is_verified','label'=>'Is Verifed','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])--}}
    {{--verified_by--}}
    {{--@include('form.select-model', ['var'=> ['name' => 'verified_by', 'label' => 'Verified By', 'query' => new \App\User(),'container_class'=>'col-md-4']])--}}
    {{--<div class="clearfix"></div>--}}
    {{--verify_note--}}
    {{--@include('form.textarea',['var'=>['name'=>'verify_note','label'=>'Verify Notes','container_class'=>'col-md-8']])--}}
    {{--</div>--}}

    {{--<div class="col-md-6 no-padding ">--}}
    {{--is_closed--}}
    {{--@include('form.select-array',['var'=>['name'=>'is_closed','label'=>'Is Closed','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])--}}
    {{--closed_by--}}
    {{--@include('form.select-model', ['var'=> ['name' => 'closed_by', 'label' => 'Closed By', 'query' => new \App\User(),'container_class'=>'col-md-4']])--}}
    {{--closing_note--}}
    {{--<div class="clearfix"></div>--}}
    {{--@include('form.textarea',['var'=>['name'=>'closing_note','label'=>'Closing Notes','container_class'=>'col-md-8']])--}}
    {{--</div>--}}
@endif
<hr/>

{{-- ******************* Form ends *********************** --}}

@section('content-bottom')
    @parent
    <div class="col-md-6 no-padding-l">
        <h4>Uploads</h4>
        <b>{{Lang::get('messages.Task-files')}}</b>
        <small>Share task related files with assignee.</small>
        {{--<small>Upload one or more files</small>--}}
        @include('modules.base.include.uploads',['var'=>['type'=>'Task file','limit'=>10]])
        <b>{{Lang::get('messages.Evidences')}}</b>
        <small>For assignee to upload image as proof of the task completion.</small>
        {{--<small>Upload one or more files</small>--}}
        @include('modules.base.include.uploads',['var'=>['type'=>'Evidence','limit'=>10]])

        @if(isset($task) && count($task->subtasks))
            @include('modules.tasks.subtasks')
        @endif
        <div class="clearfix"></div>
        @if(isset($task) && count($task->assignments))
            @include('modules.tasks.taskassignments')
        @endif
    </div>
    <div class="col-md-6 no-padding">
        @if(isset($task->id))
            <h4>{{Lang::get('messages.Message')}}</h4>
            {{--<small>Upload one or more files</small>--}}
            @include('modules.base.include.messages')
        @endif
    </div>
    <div class="clearfix"></div>
@endsection


{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $("input[name=name]").addClass('validate[required]');
            $('input[name=due_date]').addClass('validate[required]');

        }

        function addDateTimePicker() {
            $('#due_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm'
            });
        }

        /**
         * function to check distance between two points
         * */
        function checkdistance(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radius of the earth in km
            var dLat = deg2rad(lat2 - lat1);  // deg2rad below
            var dLon = deg2rad(lon2 - lon1);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2)
            ;
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c * 1000; // Distance in m
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180)
        }

        $("select[name=clientlocation_id]").attr('disabled', true);
        $("select[name=client_id]").attr('disabled', true);

        /**
         * dynamic selection of client location based on client selection
         */
        function dynamicClientLocation() {
            $('select[name=client_id]').change(function () { // change function of listbox
                var id = $('select[name=client_id]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=clientlocation_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options

                console.log(id);
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('custom.client-location')}}',
                    data: {id: id},
                    success: function (response) {
                        console.log(response.data);
                        $.each(response.data, function (i, obj) {
                            $("select[name=clientlocation_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                        });
                    },
                });

            });
        }

        /**
         *  dynamic selection of client based on the assignee
         */
        function dynamicClient() {
            $('select[name=assigned_to]').change(function () { // change function of listbox
                var id = $('select[name=assigned_to]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=client_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options
                console.log(id);
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('custom.client-list')}}',
                    data: {id: id},
                    success: function (response) {
                        console.log(response.data);
                        if ((response.data)) {
                            //var jsonObject = $.parseJSON(jsonArray); //Only if not already an object
                            //
                            $.each(response.data, function (i, obj) {
                                console.log(obj);
                                $("select[name=client_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                            });
                        }

                    },
                });

            });
        }

    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $task(module
            // name singular) is not set, also there is no id is created
            // Following the convention of spyrframe you are only allowed to call functions
            /*******************************************************************/

            // your functions go here
            // function1();
            // function2();

        </script>
    @else
        <script type="text/javascript">
            /*******************************************************************/
            // Updating :
            // this is a place holder to write  the javascript codes that will run
            // while updating an element that has been already created.
            // during update the variable $$element or $task(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $task->id
            // Following the convention of spyrframe you are only allowed to call functions
            /*******************************************************************/

            // your functions go here
            // function1();
            // function2();
            navigator.geolocation.getCurrentPosition(function (location) {
                console.log(checkdistance(location.coords.latitude, location.coords.longitude,{{$task->clientlocation->latitude}},{{$task->clientlocation->longitude}}));
            });
        </script>
    @endif
    <script type="text/javascript">
        /*******************************************************************/
        // Saving :
        // Saving covers both creating and updating (Similar to Eloquent model event)
        // However, it is not guaranteed $$element is set. So the code here should
        // be functional for both case where an element is being created or already
        // created. This is a good place for writing validation
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions goe here
        // function1();
        // function2();

        /*******************************************************************/
        // frontend and Ajax hybrid validation
        /*******************************************************************/
        //addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function
        addDateTimePicker();//enabling date time picker
        dynamicClientLocation();
        dynamicClient();
    </script>
@endsection
