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
    {{--parent_id--}}
    @include('form.select-ajax',['var'=>['label' => 'Parent task', 'name' => 'parent_id', 'table' => 'tasks', 'name_field' => 'name', 'container_class' => 'col-md-12',]])
    <div class="clearfix"></div>

    {{--name--}}
    @include('form.input-text',['var'=>['name'=>'name','label'=>'Task title', 'container_class'=>'col-md-12']])
    <div class="clearfix"></div>

    {{--tasktype_id--}}
    @include('form.select-model', ['var'=>['name'=>'tasktype_id','label'=>'Task type','query'=> new \App\Tasktype(),'container_class'=>'col-md-6']])

    {{--priority--}}
    @include('form.select-array',['var'=>['name'=>'priority','label'=>'Priority', 'options'=>\App\Task::$priorities,'container_class'=>'col-md-4']])
    {{--seq--}}
    @include('form.input-text',['var'=>['name'=>'seq','label'=>'Sequence', 'container_class'=>'col-md-2']])

    <div class="clearfix"></div>
    {{--client_id--}}
    @include('form.select-model', ['var'=>['name'=>'client_id','label'=>'Client','query'=> new \App\Client,'container_class'=>'col-md-6']])
    {{-- clientlocation_id --}}
    {{-- @include('form.select-ajax',['var'=>['label' => 'Location', 'name' => 'clientlocation_id', 'table' => 'clientlocations', 'name_field' => 'name_ext','container_class'=>'col-md-6']])--}}
    @include('form.select-model', ['var'=>['name'=>'clientlocation_id','label'=>'Location','query'=> new \App\Clientlocation,'container_class'=>'col-md-6']])
    {{--watchers--}}
    @include('form.select-model-multiple', ['var'=> ['name' => 'watchers', 'label' => 'Watchers', 'query' => new \App\User(),'container_class'=>'col-md-6']])
    <div class="clearfix"></div>
    @include('form.is_active')
</div>

<div class="col-md-6 no-padding-l">
    {{--status--}}
    @include('form.select-array',['var'=>['name'=>'status','label'=>'Status', 'options'=>kv(\App\Task::$statuses),'container_class'=>'col-md-6']])
    {{--assigned_to--}}
    @include('form.select-model', ['var'=>['name'=>'assigned_to','label'=>'Assigned to','query'=> new \App\User,'container_class'=>'col-md-6']])

    {{--assignment_id--}}
    {{--status--}}
    {{--previous_status--}}
    {{--due_date--}}
    @include('form.input-text',['var'=>['name'=>'due_date','label'=>'Due Date', 'container_class'=>'col-sm-3','params'=>['class'=>'datepicker']]])
    {{--days_open--}}
    @include('form.input-text',['var'=>['name'=>'days_open','label'=>'Days Open', 'container_class'=>'col-md-2']])
</div>
<div class="clearfix"></div>
<div class="col-md-8">
    {{--is_closed--}}
    @include('form.select-array',['var'=>['name'=>'is_closed','label'=>'Is Closed','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
    {{--closed_by--}}
    @include('form.select-model', ['var'=> ['name' => 'closed_by', 'label' => 'Closed', 'query' => new \App\User(),'container_class'=>'col-md-4']])
    {{--closing_note--}}
    <div class="clearfix"></div>
    @include('form.textarea',['var'=>['name'=>'closing_note','label'=>'Closing Notes','container_class'=>'col-md-8']])
</div>
<div class="clearfix"></div>
<div class="col-md-8">
    {{--is_resolved--}}
    @include('form.select-array',['var'=>['name'=>'is_resolved','label'=>'Is Resolved','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
    {{--resolved_by--}}
    @include('form.select-model', ['var'=> ['name' => 'resolved_by', 'label' => 'Resolved', 'query' => new \App\User(),'container_class'=>'col-md-4']])
    <div class="clearfix"></div>
    {{--resolve_note--}}
    @include('form.textarea',['var'=>['name'=>'resolve_note','label'=>'Resolve Notes','container_class'=>'col-md-8']])
</div>
<div class="clearfix"></div>
<div class="col-md-8">
    {{--is_verified--}}
    @include('form.select-array',['var'=>['name'=>'is_verified','label'=>'Is Verifed','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
    {{--verified_by--}}
    @include('form.select-model', ['var'=> ['name' => 'verified_by', 'label' => 'Verified', 'query' => new \App\User(),'container_class'=>'col-md-4']])
    <div class="clearfix"></div>
    {{--verify_note--}}
    @include('form.textarea',['var'=>['name'=>'verify_note','label'=>'Verify Notes','container_class'=>'col-md-8']])
</div>
<div class="clearfix"></div>
<div class="col-md-8">
    {{--is_flagged--}}
    @include('form.select-array',['var'=>['name'=>'is_flagged','label'=>'Is Flagged','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])
    {{--flagged_by--}}
    @include('form.select-model', ['var'=> ['name' => 'flagged_by', 'label' => 'Flaged By', 'query' => new \App\User(),'container_class'=>'col-md-4']])
    {{--flag_note--}}
    @include('form.textarea',['var'=>['name'=>'flag_note','label'=>'Flag Notes','container_class'=>'col-md-8']])
</div>
<div class="clearfix"></div>
{{--is_active--}}
<div class="col-md-8">
    {{--description--}}
    @include('form.textarea',['var'=>['name'=>'description','label'=>'Task details','container_class'=>'col-md-12']])
</div>

{{-- ******************* Form ends *********************** --}}


@section('content-bottom')
    @parent
    <div class="col-md-6 no-padding-l">
        <h4>Task files</h4>
        {{--<small>Upload one or more files</small>--}}
        @include('modules.base.include.uploads',['var'=>['type'=>'Task file','limit'=>10]])

        <h4>Evidences</h4>
        {{--<small>Upload one or more files</small>--}}
        @include('modules.base.include.uploads',['var'=>['type'=>'Evidences','limit'=>10]])

        @if(isset($task))
            <h4>Sub-tasks</h4>
            @include('modules.tasks.subtasks')
        @endif
    </div>
    <div class="col-md-6 no-padding-l">
        <h4>Messages</h4>
        {{--<small>Upload one or more files</small>--}}
        @include('modules.base.include.messages')
    </div>
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
            $('select[name=assigned_to]').addClass('validate[required]');
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
        addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function
    </script>
@endsection
