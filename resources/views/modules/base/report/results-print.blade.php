<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
    @include('modules.base.report.init-functions')
    <link rel="stylesheet" href="{{ asset('assets/css/printreport.css') }}" type="text/css"/>
    <meta charset="UTF-8"/>
</head>
<body lang=EN-US>
<div style="width: 150px;float: right;">
    <input id="printpagebutton" type="button" value="Print this page" onclick="printpage()"/>
</div>
@if(Request::get('submit')=='Run' && count($results))
    <table class="table table-bordered table-mailbox table-condensed table-hover" id="report-table">
        <thead>
        <tr>
            <th>S/L</th>
            @foreach (arrayFromCsv(Request::get('column_aliases_csv')) as $column_alias)
                <th>{{$column_alias}}</th>
            @endforeach
            @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                <th>Total<br/> Facilities</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach ($results as $result)
            <tr>
                <td>{{$i++}}</td>
                @foreach (arrayFromCsv(Request::get('columns_to_show_csv')) as $column)
                    <td>@if(isset($result->$column))<?php echo transformRow($column,$result,$result->$column,$module_name)?>@endif</td>
                @endforeach
                @if (Request::has('group_by') && strlen(Request::get('group_by')))
                    <td>{{number_format($result->total)}}</td>
                @endif
            </tr>
        @endforeach
        {{-- Add a row in the bottom to show the total--}}
        <tr>
            @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                <td></td>
                @foreach (arrayFromCsv(Request::get('columns_to_show_csv')) as $column)
                    <td></td>
                @endforeach
                <td></td>
                {{-- if 'SQL GROUP is set then show additional row showing total counts in the last column '--}}
                @if (Request::has('group_by') && strlen(cleanCsv(Request::get('group_by'))))
                    <td><b>Total {{number_format($total)}}</b></td>
                @endif
            @endif
        </tr>
        </tbody>
    </table>
@endif
</body>

{{-- JS --}}
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden'
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print();
        //Set the print button to 'visible' again
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
    }
</script>

</html>