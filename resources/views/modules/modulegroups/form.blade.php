<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'modulegroups'
 * @var $mod                   Module
 * @var $modulegroup           Modulegroup Object that is being edited
 * @var $element               string 'modulegroup'
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

{{-- Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'title','label'=>'Title', 'container_class'=>'col-sm-3']])
@include('form.select-model',['var'=>['name'=>'parent_id','label'=>'Parent module', 'table'=>'modules', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'level','label'=>'Level', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'order','label'=>'Order', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'color_css','label'=>'Color CSS class', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'icon_css','label'=>'Icon CSS class', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'default_route','label'=>'Default route name', 'container_class'=>'col-sm-3']])
<div class="clearfix"></div>
@include('form.textarea',['var'=>['name'=>'description','params'=>['class'=>''],'label'=>'Description', 'container_class'=>'col-sm-6']])
<div class="clearfix"></div>
@include('form.is_active')

{{-- Form ends --}}

{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        @if(!isset($$element))
        /*******************************************************************/
        // Creating :
        // this is a place holder to write  the javascript codes
        // during creation of an element. As this stage $$element or $superhero(module
        // name singular) is not set, also there is no id is created
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        @elseif(isset($$element))
        /*******************************************************************/
        // Updating :
        // this is a place holder to write  the javascript codes that will run
        // while updating an element that has been already created.
        // during update the variable $$element or $superhero(module
        // name singular) is set, and id like other attributes of the element can be
        // accessed by calling $$element->id, also $superhero->id
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        @endif


        /*******************************************************************/
        // Saving :
        // Saving covers both creating and updating (Similar to Eloquent model event)
        // However, it is not guaranteed $$element is set. So the code here should
        // be functional for both case where an element is being created or already
        // created. This is a good place for writing validation
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();

        /*******************************************************************/
        // frontend and Ajax hybrid validation
        /*******************************************************************/
        addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function

        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $('input[name=name]').addClass('validate[required]');
        }
    </script>
@endsection
{{-- JS ends--}}