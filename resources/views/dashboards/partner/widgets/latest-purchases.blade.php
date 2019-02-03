{{-- Original widget template : resources/views/dashboards/template/widgets/chart-area-donut.blade.php --}}
<?php
/** @var \App\Purchase $purchases */
/** @var \App\Partner $partner */
$purchases = \App\Purchase::remember(cacheTime('short'))
    ->where('partner_id', $partner->id)
    ->orderBy('created_at', 'desc')
    ->offset(0)
    ->limit(20)
    ->get();
?>


<h5 class="pull-left">Recent purchases</h5>
{{--<a href="{{route('purchases.index')}}" class="pull-right">View all</a>--}}


<table id="tbl_purchases_not_invoiced" class="table module-grid table table-bordered table-striped"
       width="100%">
    <thead>
    <tr>
        <th>Purchase</th>
        <th>Date</th>
        <th>Product</th>
        <th style="width: 60px">Price</th>
        <th>Approved</th>
        <th>Env</th>
    </tr>
    </thead>
    <tbody>
    @foreach($purchases as $purchase)
        <?php
        /** @var \App\Purchase $purchase */
        ?>
        <tr>
            <td>
                <a href="{{route('purchases.show',$purchase->id)}}" target="_blank">
                    {{ pad($purchase->id) }}
                </a>
            </td>
            <td>{{ $purchase->created_at }}</td>
            <td>{!! $purchase->product_name !!}</td>
            <td>{{symbol($purchase->partner_currency)}} {{money($purchase->product_price_in_product_currency)}}</td>
            <td>{{ $purchase->is_approved ? 'Yes':'No' }}</td>
            <td>{{ $purchase->partner_env }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
