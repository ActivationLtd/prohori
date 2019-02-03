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


@section('content-top')
    @parent
    @if(isset($user))
        @if($user->isRecommender())
            <div class="btn-group" style="padding-bottom: 15px">
                <a class="btn btn-default" href="{{route('get.users-invoices',$user->id)}}">Invoices</a>
                {{--<a class="btn btn-default" href="">Invoices</a>--}}
            </div>
        @endif
    @endif
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
    @include('form.select-array',['var'=>['name'=>'email_confirmed','label'=>'Email confirmed', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])
    @include('form.input-text',['var'=>['name'=>'email_verified_at','label'=>'Email verified at', 'container_class'=>'col-sm-3']])
    @include('form.select-array',['var'=>['name'=>'is_active','label'=>'Active', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])
    <div class="clearfix"></div>
    <?php
    $var = [
        'name' => 'group_id',
        'label' => 'Group',
        'value' => (isset($user)) ? $user->groupIds() : [],
        'query' => new \App\Group,
        'name_field' => 'title',
        'params' => ['multiple', 'id' => 'groups'],
    ];
    ?>
    @include('form.select-model', ['var'=>$var])
    <div class="clearfix"></div>
    <div id="partner" class="opt_2 opt_3 opt_4">
        @include('form.select-model',['var'=>['name'=>'partner_id','label'=>'Partner(Brand)', 'table'=>'partners', 'container_class'=>'col-sm-3']])
    </div>
    <div id="charity" class="opt_5 opt_6 opt_7">
        @include('form.select-model',['var'=>['name'=>'charity_id','label'=>'Charity', 'table'=>'charities', 'container_class'=>'col-sm-3']])
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



@if(isset($user) && $user->isRecommender())
    <div class="clearfix"></div>
    {{-- Bank Account Details --}}
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <a data-toggle="collapse" href="#banking">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Banking
                    </a>
                </h5>
            </div>
            <div id="banking" class="panel-collapse collapse" style="margin:15px 0;">
                <div class="col-md-12">

                    {{--transferwise_account_id--}}
                    @include('form.input-text',['var'=>['name'=>'transferwise_account_id','label'=>'Payment gateway account ID (Transferwise)', 'container_class'=>'col-sm-6']])
                    {{--payment_settings--}}
                    @include('form.textarea',['var'=>['name'=>'payment_settings','label'=>'Payment settings (JSON)', 'container_class'=>'col-sm-6']])
                    {{--account_holder_name--}}
                    @include('form.input-text',['var'=>['name'=>'account_holder_name','label'=>'Account holder name', 'container_class'=>'col-sm-3']])
                    {{--account_number--}}
                    @include('form.input-text',['var'=>['name'=>'account_number','label'=>'Bank account name', 'container_class'=>'col-sm-3']])
                    {{--account_type--}}
                    @include('form.input-text',['var'=>['name'=>'account_type','label'=>'Account type', 'container_class'=>'col-sm-3']])
                    {{--account_country--}}
                    @include('form.select-model',['var'=>['name'=>'account_country','label'=>'Country','table'=>'countries', 'container_class'=>'col-sm-3']])
                    {{--account_city--}}
                    @include('form.input-text',['var'=>['name'=>'account_city','label'=>'City', 'container_class'=>'col-sm-3']])
                    {{--account_state--}}
                    @include('form.input-text',['var'=>['name'=>'account_state','label'=>'State', 'container_class'=>'col-sm-3']])
                    {{--account_post_code--}}
                    @include('form.input-text',['var'=>['name'=>'account_post_code','label'=>'Account post code', 'container_class'=>'col-sm-3']])
                    {{--account_first_line--}}
                    @include('form.input-text',['var'=>['name'=>'account_first_line','label'=>'Account first line', 'container_class'=>'col-sm-3']])
                    {{--sort_code--}}
                    @include('form.input-text',['var'=>['name'=>'sort_code','label'=>'Sort code', 'container_class'=>'col-sm-3']])
                    {{--abartn--}}
                    @include('form.input-text',['var'=>['name'=>'abartn','label'=>'Abartn', 'container_class'=>'col-sm-3']])
                    {{--iban--}}
                    @include('form.input-text',['var'=>['name'=>'iban','label'=>'Iban', 'container_class'=>'col-sm-3']])
                    {{--swift--}}
                    @include('form.input-text',['var'=>['name'=>'swift','label'=>'Swift', 'container_class'=>'col-sm-3']])
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    {{-- Activity summary --}}
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <a data-toggle="collapse" href="#activity">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Activity summary
                    </a>
                </h5>
            </div>
            <div id="activity" class="panel-collapse collapse" style="margin:15px 0;">
                <div class="col-md-12">
                    {{--notification_count--}}
                    @include('form.input-text',['var'=>['name'=>'notification_count','label'=>'Notification count', 'container_class'=>'col-sm-3']])
                    {{--first_login_at--}}
                    @include('form.input-text',['var'=>['name'=>'first_login_at','label'=>'First login at', 'container_class'=>'col-sm-3']])
                    {{--last_login_at--}}
                    @include('form.input-text',['var'=>['name'=>'last_login_at','label'=>'Last login at', 'container_class'=>'col-sm-3']])
                    {{--total_earnings--}}
                    @include('form.input-text',['var'=>['name'=>'total_earnings','label'=>'Total earnings', 'container_class'=>'col-sm-3']])
                    {{--total_donations--}}
                    @include('form.input-text',['var'=>['name'=>'total_donations','label'=>'Total donations', 'container_class'=>'col-sm-3']])
                    {{--recommendation_count--}}
                    @include('form.input-text',['var'=>['name'=>'recommendation_count','label'=>'Recommendation count', 'container_class'=>'col-sm-3']])
                    {{--purchase_count--}}
                    @include('form.input-text',['var'=>['name'=>'purchase_count','label'=>'Purchase count', 'container_class'=>'col-sm-3']])
                    {{--next_billing_at--}}
                    @include('form.input-text',['var'=>['name'=>'next_billing_at','label'=>'Next billing at', 'container_class'=>'col-sm-3']])
                    {{--share_code--}}
                    @include('form.input-text',['var'=>['name'=>'share_code','label'=>'Share code', 'container_class'=>'col-sm-6']])
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    @include('form.select-array',['var'=>['name'=>'gift_aid_checked','label'=>'Share gift aid', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])
@endif


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
                    {{--current_app_version--}}
                    @include('form.input-text',['var'=>['name'=>'current_app_version','label'=>'App version', 'container_class'=>'col-sm-3']])
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endif


@section('content-bottom')
    @parent
    @if(isset($user) && $user->isRecommender())
        <div class="col-md-6 no-padding-l">
            <h4>Avatar</h4>
            {{--<small>Upload one or more files</small>--}}
            @include('modules.base.include.uploads',['var'=>['type'=>'Avatar','limit'=>1]])
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
        // List of functions
        //Partner(Brand) selection should show for brand user-groups only and Charity selection should be only available for ‘Charity *’ group
        function initGroupSelection() {
            // initially hiding all the divs
            $('.opt_2,.opt_3,.opt_4,.opt_5,.opt_6,.opt_7').hide();

            //value of the selected groups
            var group_ids = getMultiSelectAsArray('select#groups');

            //showing div based on selected groups
            $.each(group_ids, function (key, value) {
                $(".opt_" + value).show();
            });
            //convert the selected groups array to csv and set the value
            $('input[name=group_ids_csv]').val(group_ids.join());
        }

        //Only one group can be selected for a user
        function disableOthergroups() {
            var group_id = $('select#groups').val();
            $('select#groups > option').attr('disabled', false);
            if (Array.isArray(group_id) && group_id.length > 0) {
                $('select#groups > option:not(:selected)').attr('disabled', true);
                console.log(group_id);
            }
        }

        /*******************************************************************/
        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $('input[name=name],input[name=email]').addClass('validate[required]');
        }

        disableOthergroups();
        initGroupSelection();
        $('select#groups').change(function () {
            disableOthergroups();
            initGroupSelection();
        });
        //make fields read-only
        $('textarea[name=payment_settings],input[name=full_name],input[name=notification_count],input[name=first_login_at],input[name=last_login_at],input[name=total_earnings],input[name=total_donations],input[name=recommendation_count],input[name=purchase_count],input[name=next_billing_at],input[name=share_code],input[name=auth_token],input[name=current_app_version],input[name=device_name]').prop('readonly', true);
    </script>
@endsection
{{-- JS ends --}}