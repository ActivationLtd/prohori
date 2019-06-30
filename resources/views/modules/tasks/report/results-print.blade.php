<?php
/**
 * @var $data_source                         string Table/DB view name (i.e. v_users, users)
 * @var $sql                                 string SQL query
 * @var $results                             \Illuminate\Pagination\LengthAwarePaginator Main array where rows of results are stored
 * @var $sql_count                           string SQL query
 * @var $total                               integer Total number of rows returned
 * @var $group_by                            string 'GROUP BY col1,col2'
 * @var $order_by                            string
 * @var $limit                               integer
 * @var $rows_per_page                       integer
 * @var $filters                             string
 * @var $column_aliases                      array
 * @var $columns_to_show                 array
 * @var $data_source_fields                  array
 * @var $fields                              array
 * @var $fields_csv_esc                      string
 * @var $base_dir                            string
 * @var $result_blade                        string
 */
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
    @include($base_dir.'.init-functions')
    <link rel="stylesheet" href="{{ asset('prohori/css/printreport.css') }}" type="text/css"/>
    <meta charset="UTF-8"/>
</head>
<body lang=EN-US>
<div style="width: 100%">
    <div style="float: left">
        <input id="printpagebutton" type="button" value="Print this page" onclick="printpage()" style=""/>
    </div>
    <div style="margin: 0 auto; width: 33%; text-align: center">
        <img src="{{ asset('prohori/images/logo-ev.png') }}"/>
        <div style="font-size:  12px;">
            Prohori‎<br/>
            Euro Vigil‎<br/>
        </div>
    </div>
</div>
@if(Request::get('submit')==='Run' && count($results))
    <table class="table table-bordered table-mailbox table-condensed table-hover" id="report-table">
        <thead>
        <tr>
            @foreach ($alias_columns as $col)
                <th>{{$col}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr>
                @foreach ($show_columns as $col)
                    <td>
                        @if(isset($result->$col))
                            <?php echo transformRow($col, $result, $result->$col, $data_source)?>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
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