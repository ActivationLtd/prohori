<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'purchases'
 * @var $mod                   \App\Module
 * @var $purchase              \App\Purchase Object that is being edited
 * @var $element               string 'purchase'
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

<div class="col-md-9 no-padding">
    {{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
     app/views/spyr/modules/base/form.blade.php --}}
    {{--@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])--}}

    @include('form.select-model',['var'=>['name'=>'partner_id','label'=>'Partner(Brand)', 'table'=>'partners', 'container_class'=>'col-sm-3','editable'=>false]])
    @include('form.select-array',['var'=>['name'=>'partner_env','label'=>'Env', 'options'=>kv(\App\Partner::$statuses), 'container_class'=>'col-sm-3']])

    @include('form.select-array',['var'=>['name'=>'is_approved','label'=>'Approved?', 'options'=>['0'=>'No','1'=>'Yes'],'container_class'=>'col-sm-3']])
    {{--@include('form.plain-text',['var'=>['label'=>'Recommender', 'value'=>'test', 'container_class'=>'col-sm-6']])--}}

    @if(isset($purchase))
        <div class="clearfix"></div>
        <h5>Purchase details</h5>
        @if(strlen($purchase->product_image))
            <img src="{{$purchase->product_image}}" style="width: 250px"/>
        @endif
        <table class="table table-condensed no-border">
            <tbody>
            <tr>
                <td width="100px"><b>Purchase #</b></td>
                <td>{{pad($purchase->id,8)}}</td>
                <td><b>Recommender</b></td>
                <td>{{$purchase->user->full_name}}</td>
                <td></td>
                <td>{{$purchase->user->email}}<</td>
            </tr>
            <tr>
                <td><b>Order #</b></td>
                <td>{{$purchase->product_order_id}}</td>
                <td><b>Time</b></td>
                <td>{{$purchase->created_at}}</td>
                <td></td>
                <td>
                </td>
            </tr>
            <tr>
                <td><b>Product</b></td>
                <td>{{$purchase->product_name}}</td>
                <td><b>SKU</b></td>
                <td>{{$purchase->product_sku}}</td>
                <td><b>Price</b></td>
                <td>
                    {{symbol($purchase->product_currency)}}
                    {{money($purchase->product_price_in_product_currency)}} (in site currency)
                </td>
            </tr>
            <tr>
                <td><b>Quantity</b></td>
                <td>{{$purchase->product_quantity}}</td>
                <td><b>Product ID</b></td>
                <td>{{$purchase->product_id}}</td>
                <td><b></b></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Title</b></td>
                <td>{{$purchase->product_title}}</td>
                <td><b>Line price</b></td>
                <td>{{$purchase->product_line_price}}</td>
                <td><b>Vendor</b></td>
                <td>{{$purchase->product_vendor}}</td>
            </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <table class="table table-condensed no-border">
            <tbody>
            <tr>
                <td width="100px"><b>Product url</b></td>
                <td>
                    <a href="{{$purchase->product_url}}" target="_blank">
                        {{$purchase->product_url}}
                    </a>
                </td>
            </tr>
            <tr>
                <td><b>Checkout url</b></td>
                <td>
                    @if(strlen($purchase->checkout_url))
                        <a href="{{$purchase->checkout_url}}" target="_blank">{{$purchase->checkout_url}}</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>LB Share url</b></td>
                <td>
                    @if(strlen($purchase->product_lb_url))
                        <a href="{{$purchase->product_lb_url}}" target="_blank">{{$purchase->product_lb_url}}</a>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        <hr/>
        <h5>Commissions and shares</h5>
        <table class="table table-condensed  table-responsive">
            <tbody>
            <tr class="bg-red no-border">
                <td style="width: 20%" class="no-border"><b>Currency</b></td>
                <td style="width: 20%" class="no-border"><b>Product price</b></td>
                <td style="width: 20%" class="no-border"><b>Recommender</b></td>
                <td style="width: 20%" class="no-border"><b>Charity</b></td>
                <td style="width: 20%" class="no-border"><b>prohori</b></td>
            </tr>
            <tr>
                <td>Partner - {{$purchase->product_currency}}</td>
                <td>{{symbol($purchase->product_currency)}} {{money($purchase->product_price_in_product_currency)}}</td>
                <td> -</td>
                <td> -</td>
                <td> -</td>
            </tr>
            <tr>
                <td>Recommender - {{$purchase->user_currency}}</td>
                <td>{{symbol($purchase->user_currency)}} {{money($purchase->product_price_in_user_currency)}}</td>
                <td>{{symbol($purchase->user_currency)}} {{money($purchase->user_commission_in_user_currency)}}</td>
                <td>{{symbol($purchase->user_currency)}} {{money($purchase->charity_donation_in_user_currency)}}</td>
                <td>{{symbol($purchase->user_currency)}} {{money($purchase->lb_commission_in_user_currency)}}</td>
            </tr>
            <tr>
                <td>Charity - {{$purchase->charity_currency}}</td>
                <td>{{symbol($purchase->charity_currency)}} {{money($purchase->product_price_in_charity_currency)}}</td>
                <td> -</td>
                <td>{{symbol($purchase->charity_currency)}} {{money($purchase->charity_donation_charity_currency)}}</td>
                <td> -</td>
            </tr>
            <tr>
                <td>prohori - {{$purchase->lb_currency}}</td>
                <td>{{symbol($purchase->lb_currency)}} {{money($purchase->product_price_in_lb_currency)}}</td>
                <td>{{symbol($purchase->lb_currency)}} {{money($purchase->user_commission_in_lb_currency)}}</td>
                <td>{{symbol($purchase->lb_currency)}} {{money($purchase->charity_donation_in_lb_currency)}}</td>
                <td>{{symbol($purchase->lb_currency)}} {{money($purchase->lb_commission_in_lb_currency)}}</td>
            </tr>
            <tr style="border-top: 2px solid grey">
                <td colspan="2"><b>Invoice</b></td>
                <td>
                    @if($purchase->recommender_invoice_id)
                        <a href="{{route('invoices.show',$purchase->recommender_invoice_id)}}">{{pad($purchase->recommender_invoice_id)}}</a>
                        - {{$purchase->recommender_invoice_status}}
                    @endif

                </td>
                <td>
                    @if($purchase->charity_invoice_id)
                        <a href="{{route('invoices.show',$purchase->charity_invoice_id)}}">{{pad($purchase->charity_invoice_id)}}</a>
                        - {{$purchase->charity_invoice_status}}
                    @endif
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><b>Payment transfer</b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <hr/>
        @if(user()->isSuperUser())
            <h5>Raw data (for debugging)</h5>
            <?php Symfony\Component\VarDumper\VarDumper::dump(json_decode($purchase)); ?>
        @endif
    @endif
</div>


{{--@include('form.is_active')--}}
{{-- Form ends --}}

{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            //$("input[name=name]").addClass('validate[required]');
        }
    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $purchase(module
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
            // during update the variable $$element or $purchase(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $purchase->id
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
{{-- JS ends --}}