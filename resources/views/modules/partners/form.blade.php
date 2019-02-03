<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'partners'
 * @var $mod                   \App\Module
 * @var $partner               \App\Partner Object that is being edited
 * @var $element               string 'partner'
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>


{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
{{-- Brand Information --}}


@include('form.input-text',['var'=>['name'=>'name','label'=>'Brand/Partner name', 'container_class'=>'col-sm-6']])
@include('form.select-array',['var'=>['name'=>'status','label'=>'Status', 'options'=>kv(\App\Partner::$statuses), 'container_class'=>'col-sm-3']])
<div class="clearfix"></div>

@if(user()->isSuperUser())
    @include('form.select-model',['var'=>['name'=>'partnercategory_id','label'=>'Category', 'table'=>'partnercategories', 'container_class'=>'col-sm-3']])
    @include('form.select-array',['var'=>['name'=>'is_featured','label'=>'Featured', 'options'=>['0'=>'No','1'=>'Yes'],'container_class'=>'col-sm-3','params' => ['id' => 'is_featured']]])
    @include('form.input-text',['var'=>['name'=>'order','label'=>'Order', 'container_class'=>'col-sm-3']])
    <div class="clearfix"></div>

    @include('form.input-text',['var'=>['name'=>'signup_date','label'=>'Signed up on', 'container_class'=>'col-sm-3','params'=>['class'=>'datepicker']]])
    @include('form.input-text',['var'=>['name'=>'test_date','label'=>'Test started on', 'container_class'=>'col-sm-3','params'=>['class'=>'datepicker']]])
    @include('form.input-text',['var'=>['name'=>'go_live_date','label'=>'Go Live date', 'container_class'=>'col-sm-3','params'=>['class'=>'datepicker']]])
@endif

<div class="clearfix"></div>
{{-- Banking information --}}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a data-toggle="collapse" href="#settings">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Settings
                </a>
            </h5>
        </div>
        <div id="settings" class="panel-collapse collapse" style="margin:15px 0;">
            <div class="col-md-12">
                @if(user()->isSuperUser())
                    @include('form.input-text',['var'=>['name'=>'commission_percentage_lb','label'=>'LB(%)', 'container_class'=>'col-sm-2']])
                    @include('form.input-text',['var'=>['name'=>'commission_percentage_recommender','label'=>'Recommender(%)', 'container_class'=>'col-sm-2']])
                    @include('form.input-text',['var'=>['name'=>'commission_percentage_total','label'=>'Total(%)', 'container_class'=>'col-sm-2','editable'=>false]])
                @endif
                @include('form.input-text',['var'=>['name'=>'recommendation_expiry_in_days','label'=>'Recommendation expiry after day(s)', 'container_class'=>'col-sm-2']])
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
{{-- Website information --}}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a data-toggle="collapse" href="#website">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Website
                </a>
            </h5>
        </div>
        <div id="website" class="panel-collapse collapse" style="margin:15px 0;">
            <div class="col-md-12">
                @include('form.input-text',['var'=>['name'=>'sitecms_name','label'=>'CMS/Platform','container_class'=>'col-sm-3']])
                <div class="clearfix"></div>
                <div class="col-md-6 no-padding-l">
                    <h5>Live</h5>
                    @include('form.input-text',['var'=>['name'=>'live_url_root','label'=>'Root/Home Url']])
                    @include('form.input-text',['var'=>['name'=>'live_url_product','label'=>'Sample product details URL']])
                    @include('form.input-text',['var'=>['name'=>'live_url_order_confirmation','label'=>'Order confirmation URL']])
                    @include('form.textarea',['var'=>['name'=>'live_access','label'=>'Other access details']])
                </div>
                <div class="col-md-6 no-padding-l">
                    <h5>Stage</h5>
                    @include('form.input-text',['var'=>['name'=>'stage_url_root','label'=>'Root/Home Url']])
                    @include('form.input-text',['var'=>['name'=>'stage_url_product','label'=>'Sample product details URL']])
                    @include('form.input-text',['var'=>['name'=>'stage_url_order_confirmation','label'=>'Order confirmation URL']])
                    @include('form.textarea',['var'=>['name'=>'stage_access','label'=>'Other access details']])
                </div>
            </div>
            <div class="col-md-12">
                <h5>Other technical details</h5>
                <div class="col-md-6 no-padding-l">
                    @include('form.textarea',['var'=>['name'=>'site_file_structure','label'=>'File structure (custom site)']])
                </div>
                <div class="col-md-6 no-padding-l">
                    @include('form.textarea',['var'=>['name'=>'integration_note','label'=>'Integration note']])
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

{{-- Contact information --}}
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
                <div class="col-md-12 no-padding">
                    <h5>Brand Address</h5>
                    @include('form.input-text',['var'=>['name'=>'address1','label'=>'Address 1', 'container_class'=>'col-sm-6']])
                    @include('form.input-text',['var'=>['name'=>'address2','label'=>'Address 2', 'container_class'=>'col-sm-6']])
                    @include('form.input-text',['var'=>['name'=>'city','label'=>'City', 'container_class'=>'col-sm-3']])
                    @include('form.input-text',['var'=>['name'=>'county','label'=>'County', 'container_class'=>'col-sm-3']])
                    @include('form.input-text',['var'=>['name'=>'zip_code','label'=>'Zip code', 'container_class'=>'col-sm-3']])
                    @include('form.select-model',['var'=>['name'=>'country_id','label'=>'Country','table'=>'countries', 'container_class'=>'col-sm-3']])
                    @include('form.input-text',['var'=>['name'=>'phone','label'=>'Phone', 'container_class'=>'col-sm-3']])
                    @include('form.input-text',['var'=>['name'=>'mobile','label'=>'Mobile', 'container_class'=>'col-sm-3']])

                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 no-padding">
                    <h5>Contact</h5>
                    @include('form.input-text',['var'=>['name'=>'contact_name','label'=>'Name', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'contact_email','label'=>'Email', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'contact_phone','label'=>'Phone', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'contact_address','label'=>'Address', 'container_class'=>'col-sm-12']])
                </div>
                <div class="col-md-4">
                    <h5>Finance</h5>
                    @include('form.input-text',['var'=>['name'=>'finance_contact_name','label'=>'Name', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'finance_contact_email','label'=>'Email', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'finance_contact_phone','label'=>'Phone','container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'finance_contact_address','label'=>'Address','container_class'=>'col-sm-12']])
                </div>
                <div class="col-md-4">
                    <h5>IT</h5>
                    @include('form.input-text',['var'=>['name'=>'it_contact_name','label'=>'Name', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'it_contact_email','label'=>'Email', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'it_contact_phone','label'=>'Phone', 'container_class'=>'col-sm-12']])
                    @include('form.input-text',['var'=>['name'=>'it_contact_address','label'=>'Address', 'container_class'=>'col-sm-12']])
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


{{-- Banking information --}}
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


                @include('form.input-text',['var'=>['name'=>'legal_name','label'=>'Brand legal name', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'vat_no','label'=>'VAT No.', 'container_class'=>'col-sm-3']])
                <div class="clearfix"></div>
                @include('form.input-text',['var'=>['name'=>'bank_name','label'=>'Bank Name', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'bank_account_address','label'=>'Bank account address', 'container_class'=>'col-sm-3']])
                <div class="clearfix"></div>
                @include('form.input-text',['var'=>['name'=>'account_holder_name','label'=>'Account Holder Name', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_number','label'=>'Account Number', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_type','label'=>'Account type', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_country','label'=>'Account country', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_city','label'=>'Account city', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_state','label'=>'Account state', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_post_code','label'=>'Account post code', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_first_line','label'=>'Account first line', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'currency','label'=>'Currency', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'account_name','label'=>'Account Name', 'container_class'=>'col-sm-3']])

                {{-- Complete either of the following fields as appropriate --}}
                @include('form.input-text',['var'=>['name'=>'iban','label'=>'IBAN', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'swift','label'=>'Swift', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'sort_code','label'=>'Sort Code', 'container_class'=>'col-sm-3']])
                @include('form.input-text',['var'=>['name'=>'abartn','label'=>'Abartn', 'container_class'=>'col-sm-3']])

                <div class="clearfix"></div>
                @if(user()->isSuperUser())
                    @include('form.textarea',['var'=>['name'=>'payment_settings','label'=>'Payment settings (JSON)', 'container_class'=>'col-sm-6']])
                @endif

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
{{-- Region --}}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a data-toggle="collapse" href="#region">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Region
                </a>
            </h5>
        </div>
        <div id="region" class="panel-collapse collapse" style="margin:15px 0;">
            <div class="col-md-12" style="padding-bottom: 10px;">You can either include a list of countries for which
                this partner/brand will be active.
                Or, you can exclude a list of countries. However you can not select both at the same time.
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">

                <?php
                $var = [
                    'name' => 'included_country_ids',
                    'label' => 'Included countries',
                    'value' => (isset($partner)) ? explode(',', trim($partner->included_country_ids, ", ")) : [],
                    'query' => new \App\Country,
                    'params' => ['multiple', 'id' => 'included_country_ids'],
                    'container_class' => 'col-md-12',
                ];
                ?>
                @include('form.select-model', ['var'=>$var])
            </div>
            <div class="col-md-6">

                <?php
                $var = [
                    'name' => 'excluded_country_ids',
                    'label' => '- OR - Excluded countries',
                    'value' => (isset($partner)) ? explode(',', trim($partner->excluded_country_ids, ", ")) : [],
                    'query' => new \App\Country,
                    'params' => ['multiple', 'id' => 'excluded_country_ids'],
                    'container_class' => 'col-md-12'
                ];
                ?>
                @include('form.select-model', ['var'=>$var])
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@include('form.select-array',['var'=>['name'=>'is_published','label'=>'Published?', 'options'=>['0'=>'No','1'=>'Yes'],'container_class'=>'col-sm-3','editable' =>user()->isSuperUser()]])

@if(user()->isSuperUser())
    @include('form.is_active')
@endif

@section('content-bottom')
    @parent
    <h5>Uploads</h5>
    <div class="col-md-4 no-padding-l">
        <b>Block Logo</b>
        @include('modules.base.include.uploads',['var'=>['limit'=>1,'type'=>'Block-logo']])
    </div>
    <div class="clearfix"></div>
    <div class="featured_div">
        <div class="col-md-4 no-padding-l">
            <b>Logo</b>
            @include('modules.base.include.uploads',['var'=>['limit'=>1,'type'=>'Logo']])
        </div>
        <div class="col-md-4 no-padding-l">
            <b>Cover-horizontal</b>
            @include('modules.base.include.uploads',['var'=>['limit'=>1,'type'=>'Cover-horizontal']])
        </div>
        <div class="col-md-4 no-padding-l">
            <b>Cover-portrait</b>
            @include('modules.base.include.uploads',['var'=>['limit'=>1,'type'=>'Cover-vertical']])
        </div>
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
            // $("input[name=name],input[name=live_url_root],select[name=country_id],input[name=category_id],input[name=address1],input[name=contact_name],input[name=contact_email],input[name=contact_phone],select[name=is_featured],input[name=commission],input[name=commission_percentage_lb],input[name=commission_percentage_recommender],input[name=recommendation_expiry_in_days],input[name=recommend_expire],select[name=partnercategory_id]").addClass('validate[required]');
            // $("input[name=contact_email],input[name=finance_contact_email],input[name=it_contact_email]").addClass('validate[email]');
            // $("input[name=live_url_root]").addClass('validate[url]');
            // $("input[name=commission_percentage_lb],input[name=commission_percentage_recommender],input[name=recommendation_expiry_in_days]").addClass('validate[custom[number]]');
        }
    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $partner(module
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
            // during update the variable $$element or $partner(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $partner->id
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


        $(function () {
            var is_featured = $("#is_featured option:selected").val();
            displayFeaturedDiv(is_featured);
            $("#is_featured").change(function () {
                var is_featured = $(this).val();
                displayFeaturedDiv(is_featured);
            });
        });

        function displayFeaturedDiv(is_featured) {
            if (is_featured == "1") {
                $(".featured_div").css('display', 'block');
            } else {
                $(".featured_div").css('display', 'none');
            }
        }

    </script>
@endsection
{{-- JS ends --}}