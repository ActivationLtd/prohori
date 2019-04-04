<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'assignments'
 * @var $mod                   \App\Module
 * @var $assignment             \App\Assignment Object that is being edited
 * @var $element               string 'assignment'
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
{{--assigned_to--}}
@include('form.select-model', ['var'=>['name'=>'assigned_to','label'=>'Assigned to','query'=> new \App\User,'container_class'=>'col-md-4']])
{{--assigned_by--}}
@include('form.select-model', ['var'=>['name'=>'assigned_by','label'=>'Assigned by','query'=> new \App\User,'container_class'=>'col-md-4']])
{{--assigned_for_days--}}
@include('form.input-text',['var'=>['name'=>'assigned_for_days','label'=>'Assigned For Days', 'container_class'=>'col-md-2']])
<div class="clearfix"></div>
{{--note--}}
@include('form.textarea',['var'=>['name'=>'note','label'=>'Note','container_class'=>'col-md-6']])

@if(in_array($assignment->task->status,['Closed','Done']))
    {{--is_resolved--}}
    {{--@include('form.select-array',['var'=>['name'=>'is_resolved','label'=>'Is Resolved','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])--}}
    {{--is_verified--}}
    {{--@include('form.select-array',['var'=>['name'=>'is_verified','label'=>'Is Verified','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4']])--}}
    {{--is_closed--}}
    @include('form.select-array',['var'=>['name'=>'is_closed','label'=>'Is Closed','options'=>[" "=>" ",'1'=>'Yes','0'=>'No'], 'container_class'=>'col-sm-4','value'=>$assignment->is_closed]])
@endif
<div class="clearfix"></div>
@if(isset($assignment->task->id))
    <h2>Task Information</h2>
    {{--tasktype_id--}}
    @include('form.select-model', ['var'=>['name'=>'tasktype_id','label'=>'Task type','query'=> new \App\Tasktype(),'container_class'=>'col-md-4','value'=>$assignment->task->tasktype_id]])
    {{--priority--}}
    @include('form.select-array',['var'=>['name'=>'priority','label'=>'Priority', 'options'=>\App\Task::$priorities,'container_class'=>'col-md-4','value'=>$assignment->task->priority]])
    {{--seq--}}
    @include('form.input-text',['var'=>['name'=>'seq','label'=>'Sequence', 'container_class'=>'col-md-3','value'=>$assignment->task->seq]])
    <div class="clearfix"></div>
    @include('form.input-text',['var'=>['name'=>'due_date','label'=>'Due Date', 'container_class'=>'col-sm-3','value'=>$assignment->task->due_date]])
    {{--days_open--}}
    @include('form.input-text',['var'=>['name'=>'days_open','label'=>'Days Open', 'container_class'=>'col-md-2','value'=>$assignment->task->days_open]])
    @include('form.select-array',['var'=>['name'=>'status','label'=>'Status', 'options'=>kv(\App\Task::$statuses),'container_class'=>'col-md-3','value'=>$assignment->task->status]])
    <div class="col-md-8 no-padding">
        {{--description--}}
        @include('form.textarea',['var'=>['name'=>'description','label'=>'Task details','container_class'=>'col-md-12','value'=>$assignment->task->description]])
    </div>
@endif
@include('form.is_active')
{{-- ******************* Form ends *********************** --}}

@section('content-bottom')
    @parent
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
        }
    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $assignment(module
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
            // during update the variable $$element or $assignment(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $assignment->id
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
