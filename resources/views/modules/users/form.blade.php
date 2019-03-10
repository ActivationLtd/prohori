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

{{--@include('form.input-text',['var'=>['name'=>'name','label'=>'User name(login name)', 'container_class'=>'col-sm-3']])--}}

<div class="clearfix"></div>
@if(user()->isSuperUser())
    @include('form.input-text',['var'=>['name'=>'email_verified_at','label'=>'Email verified at', 'container_class'=>'col-sm-3']])
    @include('form.select-array',['var'=>['name'=>'is_active','label'=>'Active', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])
    <div class="clearfix"></div>
    <?php
    $var = [
        'name' => 'group_ids',
        'label' => 'Groups',
        'query' => new \App\Group,
        'container_class' => 'col-md-3',
        'name_field' => 'title',
    ];
    ?>
    @include('form.select-model-multiple', ['var'=>$var])

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
                @include('form.input-text',['var'=>['name'=>'county','label'=>'County', 'container_class'=>'col-sm-3']])
                {{--country_id--}}
                @include('form.select-model',['var'=>['name'=>'country_id','label'=>'Country','table'=>'countries', 'container_class'=>'col-sm-3']])
                {{--zip_code--}}
                @include('form.input-text',['var'=>['name'=>'zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-3']])
                {{--phone--}}
                @include('form.input-text',['var'=>['name'=>'phone','label'=>'Phone', 'container_class'=>'col-sm-3']])
                {{--mobile--}}
                @include('form.input-text',['var'=>['name'=>'mobile','label'=>'Mobile', 'container_class'=>'col-sm-3']])
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
                    @include('form.input-text',['var'=>['name'=>'device_name','label'=>'Device name', 'container_class'=>'col-sm-3']])
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endif


@section('content-bottom')
    @parent


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

    </script>
@endsection
{{-- JS ends --}}