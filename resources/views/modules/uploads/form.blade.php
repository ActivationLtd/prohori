<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name string 'uploads'
 * @var $mod Module
 * @var $upload Upload Object that is being edited
 * @var $element string 'upload'
 * @var $element_editable boolean
 * @var $uuid string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
{{--@include('form.select-model',['var'=>['name'=>'uploadtype_id','label'=>'Type', 'table'=>'uploadtypes', 'container_class'=>'col-sm-3']])--}}
@include('form.input-text',['var'=>['name'=>'order','label'=>'Order', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'latitude','label'=>'Latitude', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'longitude','label'=>'Longitude', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'distance','label'=>'Distance in Meters', 'container_class'=>'col-sm-2']])
@include('form.select-array',['var'=>['name'=>'distance_flag_name','label'=>'Distance Flag', 'options'=>kv(\App\Upload::$upload_flags),'container_class'=>'col-md-3','editable'=>false]])


@if(isset($upload))
    <div class="clearfix"></div>
    <div class="col-md-6 no-padding-l">
        <a href="{{route('get.download', $upload->uuid)}}">
            <img src="{{ $upload->thumbSrc()}}" style="width: 100%" class="shadow"/>
        </a>
        {{$upload->name}}
        {{$upload->ext}} <b>{{FileSizeConvert(filesize($upload->absPath()))}}</b>

    </div>
@endif
<p id="demo"></p>
<div class="clearfix"></div>
@include('form.textarea',['var'=>['name'=>'desc','label'=>'Description', 'container_class'=>'col-sm-6']])
{{--@include('form.is_active')--}}
{{-- Form ends --}}
@section('content-bottom')
    @parent
    @if(isset($upload))
        <div class="col-md-6 no-padding-l">
            <h4>File</h4>
            <small></small>
            @include('modules.uploads.update_uploads',['var'=>['id'=>$upload->id]])
        </div>
    @endif
@endsection
{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        @if(!isset($$element))
        /*******************************************************************/
        // Creating :
        // this is a place holder to write  the javascript codes
        // during creation of an element. As this stage $$element or $upload(module
        // name singular) is not set, also there is no id is created
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        //get a go location when creating a new entry
        getLocation();
        @elseif(isset($$element))
        /*******************************************************************/
        // Updating :
        // this is a place holder to write  the javascript codes that will run
        // while updating an element that has been already created.
        // during update the variable $$element or $upload(module
        // name singular) is set, and id like other attributes of the element can be
        // accessed by calling $$element->id, also $upload->id
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        $('input[name=latitude]').attr('readonly', true);
        $('input[name=longitude]').attr('readonly', true);
        $('input[name=distance]').attr('readonly', true);
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


        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                $('input[name=latitude]').val("Geolocation is not supported by this browser.");
                $('input[name=longitude]').val("Geolocation is not supported by this browser.");
            }
        }
        function showPosition(position) {
            $('input[name=latitude]').val(position.coords.latitude).attr('readonly', true);
            $('input[name=longitude]').val(position.coords.longitude).attr('readonly', true);
        }

        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $('input[name=name]').addClass('validate[required]');
        }
    </script>
@endsection
{{-- JS ends --}}