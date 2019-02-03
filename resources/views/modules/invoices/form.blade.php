<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'invoices'
 * @var $mod                   \App\Module
 * @var $invoice               \App\Invoice Object that is being edited
 * @var $element               string 'invoice'
 * @var $element_editable      boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>


{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}


@if(isset($invoice))
    <?php
    $beneficiary_type = $invoice->beneficiaryType();
    $beneficiary = $invoice->beneficiary();
    ?>
    <h5>Invoice #{{pad($invoice->id)}}</h5>
    @include('form.input-text',['var'=>['name'=>'name','label'=>'Invoice title', 'container_class'=>'col-sm-6']])
    @include('form.select-array',['var'=>['name'=>'status','label'=>'Status', 'options'=>kv(array_merge([""=>'-'],\App\Invoice::$statuses)), 'container_class'=>'col-sm-3']])
    <div class="clearfix"></div>
    @include('form.select-array',['var'=>['name'=>'transfer_method','label'=>'Transfer method', 'options'=>kv(array_merge([""=>'-'],\App\Invoice::$transfer_methods)), 'container_class'=>'col-sm-3']])

    @include('form.input-text',['var'=>['name'=>'transaction_id', 'label'=>'Transaction Id', 'container_class'=>'col-sm-3']])
    @include('form.input-text',['var'=>['name'=>'transaction_status', 'label'=>'Transaction Status', 'container_class'=>'col-sm-3']])

    <div class="col-md-9 no-padding">
        <table id="address_table" class="table table-bordered table-striped">

            <tbody>
            <tr>
                <td><b>To</b></td>
                <td>{{ $beneficiary->name }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td>{{ $invoice->address()}}</td>
            </tr>
            <tr>
                <td><b>Phone</b></td>
                <td>{{ $invoice->phone}}</td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td>{{ $invoice->mobile}}</td>
            </tr>
            </tbody>
        </table>

        <h5>Payment details</h5>
        <table id="address_table" class="table">
            <tbody>
            <tr>
                <td><b>Total</b></td>
                <td>{{symbol($invoice->currency)}} {{ money($invoice->total_amount) }}</td>
            </tr>
            <tr>
                <td><b>VAT added (VAT {{symbol($invoice->currency)}}  {{money($invoice->vat_amount)}})</b></td>
                <td>{{symbol($invoice->currency)}} {{ money($invoice->total_with_vat_amount)}}</td>
            </tr>
            <tr>
                <td><b>Tax amount</b></td>
                <td>{{symbol($invoice->currency)}} {{ money($invoice->tax_amount)}}</td>
            </tr>
            <tr>
                <td><b>Adjustment amount(+/-)</b></td>
                <td>
                    @include('form.input-text',['var'=>['name'=>'adjustment_amount', 'container_class'=>'col-sm-6']])
                </td>
            </tr>
            <tr>
                <td><b>Sub total</b></td>
                <td>{{symbol($invoice->currency)}} {{ money($invoice->subtotal)}}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
    @include('form.textarea',['var'=>['name'=>'adjustment_note', 'label'=>'Reason of adjustment', 'container_class'=>'col-sm-6']])
    @include('form.textarea',['var'=>['name'=>'details', 'label'=>'Other details', 'container_class'=>'col-sm-6']])


    @if(user()->isSuperUser())
        <h5>This invoice includes following purchases</h5>
        <?php
        $purchases = \App\Purchase::whereIn('id', explode(',', $invoice->purchase_ids))->get();
        ?>
        <ul>
            @foreach($purchases as $purchase)
                <li><a href="{{route('purchases.show',$purchase->id)}}"> {{pad($purchase->id)}}</a>
                    - {{$purchase->created_at}}
                </li>
            @endforeach
        </ul>
    @endif

    @if($invoice->status === 'Due' && $invoice->transfer_method === 'TransferWise')
        <a href="#" class="btn btn-default">Trigger transaction</a>
    @endif

@endif
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
            $("input[name=name]").addClass('validate[required]');
        }
    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $invoice(module
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
            // during update the variable $$element or $invoice(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $invoice->id
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
        //enableValidation('{{$module_name}}'); // Instantiate validation function
    </script>
@endsection
{{-- JS ends --}}