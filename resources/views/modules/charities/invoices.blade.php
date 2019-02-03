@extends('template.app-frame')

<?php
/**
 * Variables used in this view file.
 * @var $module_name string 'superheroes'
 * @var $mod         \App\Module
 * @var $uuid        string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 * @var $invoice     \App\Invoice
 */
?>

@section('sidebar-left')
    @include('modules.base.include.sidebar-left')
@endsection

@section('title')
    <a class="btn" href="{{route('charities.show',$charity->id)}}"><i
                class="fa fa-angle-left"></i></a> {{$charity->name}} invoices
@endsection

@section('content')

    @if(user()->isSuperUser())
        @include('modules.charities.invoices-generator')
    @endif

    <b>Invoices</b><br/>

    <table id="tbl_purchases_not_invoiced" class="table module-grid table table-bordered table-striped"
           width="100%">
        <thead>
        <tr>
            <th>Invoice</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Transfer method</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <?php
            $status_css = $invoice->status === 'Paid' ? 'bg-green disabled color-palette' : '';
            ?>

            <tr>
                <td>
                    <a href="{{route('invoices.show',$invoice->id)}}" target="_blank">
                        {{ pad($invoice->id) }}
                    </a>
                </td>
                <td>{{ $invoice->created_at }}</td>
                <td>{{symbol($invoice->currency)}} {{ money($invoice->total_amount)}}</td>
                <td>{{ $invoice->transfer_method }}</td>
                <td class="{{$status_css}}">{{ $invoice->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
