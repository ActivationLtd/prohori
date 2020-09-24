<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'users'
 * @var $mod                   Module
 * @var $user                  User Object that is being edited
 * @var $element               string 'user'
 * @var \App\User $$element
 * @var \App\User $user
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */

?>

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



{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
<div class="clearfix"></div>
@include('form.input-text',['var'=>['name'=>'email','label'=>'Email', 'container_class'=>'col-sm-3']])
{{-- show password only for editable--}}
@if($element_editable)
    @include('form.input-text',['var'=>['name'=>'password','type'=>'password','label'=>'Password', 'container_class'=>'col-sm-3','value'=>'']])
    @include('form.input-text',['var'=>['name'=>'password_confirmation','type'=>'password','label'=>'Confirm password', 'container_class'=>'col-sm-3']])
@endif
<div class="clearfix"></div>
{{--designation field--}}
@include('form.select-model',['var'=>['name'=>'designation_id','label'=>'Designation','table'=>'designations','container_class'=>'col-sm-3']])
{{--department field--}}
@include('form.select-model',['var'=>['name'=>'department_id','label'=>'Department','table'=>'departments','container_class'=>'col-sm-3']])
{{--employee id field--}}
@include('form.input-text',['var'=>['name'=>'employee_id','label'=>'Employee Id','container_class'=>'col-sm-3']])
{{--@include('form.input-text',['var'=>['name'=>'name','label'=>'User name(login name)', 'container_class'=>'col-sm-3']])--}}
<div class="clearfix"></div>
@if(user()->isSuperUser())
    @include('form.input-text',['var'=>['name'=>'email_verified_at','label'=>'Email verified at', 'container_class'=>'col-sm-3'
    ,'params'=>['id' => 'email_verified_at']]])
    @include('form.select-array',['var'=>['name'=>'is_active','label'=>'Active', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])
    <div class="clearfix"></div>
    <?php
    $var = [
        'name' => 'group_ids',
        'label' => 'Groups',
        'query' => new \App\Group,
        'container_class' => 'col-md-3',
        'params' => ['id' => 'groups'],
        'name_field' => 'title',
    ];
    ?>
    @include('form.select-model-multiple', ['var'=>$var])
    <?php
    $var = [
        'name' => 'watchers',
        'label' => 'Watchers',
        'query' => new \App\User,
        'container_class' => 'col-md-6',
    ];
    ?>
    @include('form.select-model-multiple', ['var'=>$var])

    <?php
    $var = [
        'name' => 'operating_area_ids',
        'label' => 'Operating Areas',
        'query' => new \App\Operatingarea(),
        'container_class' => 'col-md-6',
    ];
    ?>
    @include('form.select-model-multiple', ['var'=>$var])

    <div class="clearfix"></div>
    <div class="opt_6">
        {{--client_id--}}
        @include('form.select-model', ['var'=>['name'=>'client_id','label'=>Lang::get('messages.Client').'(Only Applicable for Guard and Client Users)','query'=> new \App\Client,'container_class'=>'col-md-4']])
        {{-- clientlocation_id --}}
        @include('form.select-model', ['var'=>['name'=>'clientlocation_id','label'=>Lang::get('messages.Location').'(Only Applicable for Guard and Client Users)','query'=> new \App\Clientlocation,'container_class'=>'col-md-4']])
    </div>
@endif

<div class="clearfix"></div>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a data-toggle="collapse" href="#contact">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Contact
                </a>
            </h5>
        </div>
        <div id="contact" class="panel-collapse collapse" style="margin:15px 0;">
            <div class="col-md-12">
                {{--first_name--}}
                @include('form.input-text',['var'=>['name'=>'first_name','label'=>'First name', 'container_class'=>'col-sm-3']])
                {{--last_name--}}
                @include('form.input-text',['var'=>['name'=>'last_name','label'=>'Last name', 'container_class'=>'col-sm-3']])
                {{--full_name--}}
                @include('form.input-text',['var'=>['name'=>'full_name','label'=>'Full name', 'container_class'=>'col-sm-6']])
                {{--address1--}}
                @include('form.input-text',['var'=>['name'=>'address1','label'=>'Address-1', 'container_class'=>'col-sm-6']])
                {{--address2--}}
                @include('form.input-text',['var'=>['name'=>'address2','label'=>'Address-2', 'container_class'=>'col-sm-6']])
                {{--city--}}
                @include('form.input-text',['var'=>['name'=>'city','label'=>'City', 'container_class'=>'col-sm-3']])
                {{--county--}}
                {{--@include('form.input-text',['var'=>['name'=>'county','label'=>'County', 'container_class'=>'col-sm-3']])--}}
                {{--country_id--}}
                @include('form.select-model',['var'=>['name'=>'country_id','label'=>'Country','table'=>'countries', 'container_class'=>'col-sm-3']])
                {{--zip_code--}}
                @include('form.input-text',['var'=>['name'=>'zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-3']])
                {{--phone--}}
                @include('form.input-text',['var'=>['name'=>'phone','label'=>'Phone', 'container_class'=>'col-sm-3']])
                {{--mobile--}}
                @include('form.input-text',['var'=>['name'=>'mobile','label'=>'Mobile', 'container_class'=>'col-sm-3']])
                {{--gender--}}
                @include('form.select-array',['var'=>['name'=>'gender','label'=>'Gender','options'=>[" "=>" ",'male'=>'Male','female'=>'Female'], 'container_class'=>'col-sm-3']])
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@if(user()->isSuperUser())
    <div class="clearfix"></div>
    {{--  Other info --}}
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <a data-toggle="collapse" href="#other_info">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Other info
                    </a>
                </h5>
            </div>
            <div id="other_info" class="panel-collapse collapse" style="margin:15px 0;">
                <div class="col-md-12">
                    {{--auth_token--}}
                    <div class="col-md-12 no-padding">
                        @if(isset($user) && $user->api_token != null)
                            <b>Current API token (X-Auth-Token):</b> <code class="">{{$user->api_token}}</code>
                        @endif
                        <div class="control-group">
                            <div class="controls">
                                <div class="form-group">
                                    <input class="pull-left" type="checkbox" name="api_token_generate"
                                           id="api_token_generate"
                                           value="yes"/>
                                    &nbsp;&nbsp;<b>Regenerate (Check and save)</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('form.input-text',['var'=>['name'=>'auth_token','label'=>'Auth token', 'container_class'=>'col-sm-6']])
                    {{--device_name--}}
                    @include('form.input-text',['var'=>['name'=>'device_token','label'=>'Device Token', 'container_class'=>'col-sm-3']])
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endif


@section('content-bottom')
    @parent
    @if(isset($user))
        @if($user->inGroupId(6))
            <div class="col-md-6 no-padding-l">
                @include('modules.users.assignedlocations')
            </div>
        @endif
        @if($user->inGroupId(6) || in_array($user->designation_id,['7','8','10','5','18','9','12','14','13','19','15','16','17']))
            <div class="col-md-6 no-padding-l">
                @include('modules.users.user_location_map')
            </div>
        @endif
        <div class="col-md-6 no-padding-l">
            <h4>Profile Photo (*Required Field)</h4>
            {{--<small>Upload one or more files</small>--}}
            @include('modules.base.include.uploads',['var'=>['type'=>'Profile photo','limit'=>1]])
        </div>
    @endif

    @if(isset($user) && user()->isSuperUser())
        <div class="col-md-6 no-padding">
            <h5>Permissions</h5>
            @foreach($user->getMergedPermissions() as $k=>$v)
                @if($v==1)
                    <code>{{$k}}</code><br/>
                @endif
            @endforeach
        </div>
    @endif

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
            $("input[name=first_name]").addClass('validate[required]');
            $("input[name=last_name]").addClass('validate[required]');
            $("input[name=email]").addClass('validate[required]');
            $("input[select=group_ids]").addClass('validate[required]');
            // $('input[name=due_date]').addClass('validate[required]');

        }

        function showFieldsBasedOnGroups() {
            $('.opt_6').hide();
            var group_ids = getMultiSelectAsArray('select#groups');
            console.log(group_ids);
            //showing div based on selected groups
            $.each(group_ids, function (key, value) {
                if (value == 6 || value == 7) {
                    $(".opt_6").show();
                    //$("select[name=vendor_id]").addClass('validate[required]');
                    //$("select[name=reseller_id]").removeClass('validate[required]');
                }
            });
            //clearing the value of vendor if not selected
            if (!group_ids.includes('6') && !group_ids.includes('7')) {
                $('select[name=client_id]').val(null);
                $('select[name=clientlocation_id]').val(null);
            }
            $('select#groups').change(function () {
                showFieldsBasedOnGroups();
            });
        }

        /**
         * dynamic selection of client location based on client selection
         */
        function dynamicClientLocation() {
            $('select[name=client_id]').change(function () { // change function of listbox
                var client_id = $('select[name=client_id]').select2('val');
                //clearing the data , empty the options , enable it with current options
                $("select[name=clientlocation_id]").select2("val", "").empty().attr('disabled', false);// Remove the existing options
                $.ajax({
                    type: "get",
                    datatype: 'json',
                    url: '{{route('clientlocations.list-json').'?force_all_data=true'}}',
                    data: {
                        client_id: client_id,
                    },
                    success: function (response) {
                        //console.log(response.data);
                        $.each(response.data, function (i, obj) {
                            $("select[name=clientlocation_id]").append("<option value=" + obj.id + ">" + obj.name + "</option>");
                        });
                    },
                });

            });
        }

        /**
         * Time picker function
         */
        function addDateTimePicker() {
            $('#email_verified_at,#from,#till').datetimepicker({
                format: 'YYYY-MM-DD HH:mm'
            });
           
        }
    </script>
    <script type="text/javascript">
        @if(!isset($user))
        /*******************************************************************/
        // Creating :
        // this is a place holder to write  the javascript codes
        // during creation of an element. As this stage $user or $user(module
        // name singular) is not set, also there is no id is created
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();

        @elseif(isset($user))
        /**
         * Vue implementation for patients medication requests
         */
        function userAssignedLocationVueImplementation() {
            /*******************************************************************/
            //				1. vue js to render table
            /*******************************************************************/
            var assignedLocationVue = new Vue({
                el: '#add-assigned-location-vue',
                data: {assignedLocations: []},
                methods: {
                    makeDeleteUrl: function (id) { // Function returns the POST URL for deleting the entry.
                        return '{{route('home')}}/assignedlocations/' + id;
                    },
                    makeFileEditUrl: function (id) { // Function returns the GET URL for the details page of the entry
                        return '{{route('home')}}/assignedlocations/' + id;
                    },
                },
                mounted: function () { // Initially when this vue instance is mounted do the following.
                    axios({ // 1. GET the list of items from from some API/url
                        url: "{{route('assignedlocations.list-json')}}?user_id={{$user->id}}",
                        method: 'get'
                    }).then(function (response) {
                        //console.log(response.data.data);
                        // 2. Load the whole data in vue variable.
                        assignedLocationVue.assignedLocations = response.data.data; // 2. Load the whole data in vue variable.
                        // 2. Load the whole data in vue variable.
                    }).catch(function (error) {
                        console.log(error); // 3. Log any error (Good for debugging).

                    });
                    /*******************************************************************/
                },
                updated: function () { // Trigger following when the list is updated and DOM is populated.
                    initGenericDeleteBtn(); // Enables the generic delete button in newly added row.

                }
            });
            /*******************************************************************/
            //				 frontend and Ajax hybrid validation
            /*******************************************************************/
            // 1. add validation classes/rules
            //$('form[name=assignedlocationform] input[name=client_id]').addClass('validate[required]');
            //$('form[name=assignedlocationform] input[name=clientlocation_id]').addClass('validate[required]');

            // 2. instantiate validation function with a handler function which updates the DOM upon successful operation. i.e. add a new row in a table if store is successful.
            enableValidation('assignedlocationform', storeAssignedlocationsSuccessHandler);

            // 3. specific handler function. Name should be unique
            function storeAssignedlocationsSuccessHandler(ret) {
                assignedLocationVue.assignedLocations.push(ret.data); // Push the new element into vue array.
                $('#assignedlocationform').trigger("reset"); // reset the form selection before hiding. This form will be again visible when you add the next item.
            }
        }

        userAssignedLocationVueImplementation();
        /*******************************************************************/
        // Updating :
        // this is a place holder to write  the javascript codes that will run
        // while updating an element that has been already created.
        // during update the variable $user or $user(module
        // name singular) is set, and id like other attributes of the element can be
        // accessed by calling $user->id, also $user->id
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        @endif


        /*******************************************************************/
        // Saving :
        // Saving covers both creating and updating (Similar to Eloquent model event)
        // However, it is not guaranteed $user is set. So the code here should
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
        //showFieldsBasedOnGroups(); //todo not working have to check with raihan bhai
        $("select[name=clientlocation_id]").attr('disabled', true);
        dynamicClientLocation();
        addDateTimePicker();
    </script>
@endsection
{{-- JS ends --}}